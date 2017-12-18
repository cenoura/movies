<?php

namespace Cenoura\Movie;

use Cenoura\Common\Library\Http\Client;
use Cenoura\Common\Library\Http\Response;

class MovieService
{
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function getUpcomingMovies($page = 1)
    {
        $response = $this->httpClient->get(
            TMDB_API_URL . '/movie/upcoming',
            [
                'api_key' => TMDB_API_KEY,
                'page' => $page
            ]);

        if (!$response->isSuccessful()) {
            throw new \Exception('Error getting information from API');
        }

        return $this->getMovieCollectionFromResponse($response);
    }

    public function getMovie($id)
    {
        $response = $this->httpClient->get(
            TMDB_API_URL . '/movie/' . $id,
            [
                'api_key' => TMDB_API_KEY,
            ]
        );

        if (!$response->isSuccessful()) {
            throw new \Exception('Error getting information from API');
        }

        $movie = json_decode($response->getBody());

        $movie->genres = array_map(function($genre) {
            return $genre->name;
        }, $movie->genres);

        return MovieFactory::create($movie);
    }

    public function searchMovies($query, $page)
    {
        $response = $this->httpClient->get(
            TMDB_API_URL . '/search/movie',
            [
                'api_key' => TMDB_API_KEY,
                'query' => $query,
                'page' => $page
            ]
        );

        if (!$response->isSuccessful()) {
            throw new \Exception('Error getting information from API');
        }

        return $this->getMovieCollectionFromResponse($response);
    }

    protected function getMovieGenresNamesArray($movieGenres, $allGenres)
    {
        return array_values(array_filter($allGenres, function($id) use ($movieGenres) {
            return in_array($id, $movieGenres);
        }, ARRAY_FILTER_USE_KEY));
    }

    protected function getMovieCollectionFromResponse(Response $response)
    {
        $responseBody = json_decode($response->getBody());

        $genreService = new GenreService();
        $genres = $genreService->getMovieGenres();

        $movies = array_map(function($movie) use ($genres) {
            $movie->genres = $this->getMovieGenresNamesArray($movie->genre_ids, $genres);
            return MovieFactory::create($movie);
        }, $responseBody->results ?? []);

        return [
            'totalPages' => $responseBody->total_pages,
            'movies' => $movies
        ];
    }
}