<?php

namespace Cenoura\Movie;

class MovieFactory
{
    /**
     * @param \stdClass $data
     *
     * @return Movie
     */
    public static function create(\stdClass $data)
    {
        $movie = (new Movie($data->id, $data->original_title))
            ->setGenres($data->genres)
            ->setBackdropPath($data->backdrop_path)
            ->setPosterPath($data->poster_path)
            ->setOverview($data->overview);

        if ($data->release_date) {
            $movie->setReleaseDate(\DateTime::createFromFormat('Y-m-d', $data->release_date));
        }

        return $movie;
    }
}