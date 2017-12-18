<?php

namespace Cenoura\Movie;

use Cenoura\Support\BasePresenter;

class MoviePresenter extends BasePresenter
{
    public function __construct(Movie $movie)
    {
        parent::__construct($movie);
    }

    public function getReleaseDate()
    {
        if (!$this->subject->getReleaseDate()) {
            return 'N/A';
        }

        return $this->subject->getReleaseDate()->format('F dS Y');
    }

    public function getImagePath()
    {
        return $this->subject->getPosterPath() ?: $this->subject->getBackdropPath();
    }

    public function getImageUrl()
    {
        if (!$this->getImagePath()) {
            return '/assets/images/no_image.jpg';
        }

        return 'http://image.tmdb.org/t/p/w185' . $this->getImagePath();
    }

    public function getGenres()
    {
        return implode(', ', $this->subject->getGenres());
    }

    public function getUrl()
    {
        return './?controller=movie&action=getOne&id=' . $this->subject->getId();
    }
}