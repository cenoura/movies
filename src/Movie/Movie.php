<?php

namespace Cenoura\Movie;

class Movie
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $originalTitle;

    /**
     * @var array
     */
    protected $genres;

    /**
     * @var string|null
     */
    protected $posterPath;

    /**
     * @var string|null
     */
    protected $backdropPath;

    /**
     * @var string
     */
    protected $overview;

    /**
     * @var \DateTime|null
     */
    protected $releaseDate;

    public function __construct($id, $originalTitle)
    {
        $this
            ->setId($id)
            ->setOriginalTitle($originalTitle);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Movie
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalTitle()
    {
        return $this->originalTitle;
    }

    /**
     * @param string $originalTitle
     *
     * @return Movie
     */
    public function setOriginalTitle($originalTitle)
    {
        $this->originalTitle = $originalTitle;

        return $this;
    }

    /**
     * @return array
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * @param array $genres
     *
     * @return Movie
     */
    public function setGenres($genres)
    {
        $this->genres = $genres;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPosterPath()
    {
        return $this->posterPath;
    }

    /**
     * @param null|string $posterPath
     *
     * @return Movie
     */
    public function setPosterPath($posterPath)
    {
        $this->posterPath = $posterPath;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getBackdropPath()
    {
        return $this->backdropPath;
    }

    /**
     * @param null|string $backdropPath
     *
     * @return Movie
     */
    public function setBackdropPath($backdropPath)
    {
        $this->backdropPath = $backdropPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getOverview()
    {
        return $this->overview;
    }

    /**
     * @param string $overview
     *
     * @return Movie
     */
    public function setOverview($overview)
    {
        $this->overview = $overview;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param \DateTime|null $releaseDate
     *
     * @return Movie
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }
}