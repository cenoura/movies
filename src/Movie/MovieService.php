<?php

namespace Cenoura\Movie;

use Cenoura\Common\Library\Http\Client;

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

        $responseBody = json_decode($response->getBody());

        $results = $responseBody->results;
        $totalPages = $responseBody->total_pages;

        $genreService = new GenreService();
        $genres = $genreService->getMovieGenres();

        $movies = [];

        foreach ($results as $movie) {
            $movie->genres = $this->getMovieGenresNamesArray($movie->genre_ids, $genres);
            $movies[] = MovieFactory::create($movie);
        }

        return [
            'totalPages' => $totalPages,
            'movies' => $movies
        ];
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

        $responseBody = json_decode($response->getBody());

        $results = $responseBody->results;
        $totalPages = $responseBody->total_pages;

        $genreService = new GenreService();
        $genres = $genreService->getMovieGenres();

        $movies = [];

        foreach ($results as $movie) {
            $movie->genres = $this->getMovieGenresNamesArray($movie->genre_ids, $genres);
            $movies[] = MovieFactory::create($movie);
        }

        return [
            'totalPages' => $totalPages,
            'movies' => $movies
        ];
    }

    protected function getMovieGenresNamesArray($movieGenres, $allGenres)
    {
        return array_values(array_filter($allGenres, function($id) use ($movieGenres) {
            return in_array($id, $movieGenres);
        }, ARRAY_FILTER_USE_KEY));
    }
}