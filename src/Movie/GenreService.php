<?php

namespace Cenoura\Movie;

use Cenoura\Common\Library\Http\Client;

class GenreService
{
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function getMovieGenres()
    {
        $response = $this->httpClient->get(
            TMDB_API_URL . '/genre/movie/list',
            [
                'api_key' => TMDB_API_KEY
            ]
        );

        if (!$response->isSuccessful()) {
            throw new \Exception('Error getting information from API');
        }

        $results = json_decode($response->getBody())->genres;

        $genres = [];

        foreach ($results as $genre) {
            $genres[$genre->id] = $genre->name;
        }

        return $genres;
    }
}