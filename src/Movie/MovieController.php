<?php

namespace Cenoura\Movie;

class MovieController
{
    /**
     * @var MovieService
     */
    protected $service;

    public function __construct(MovieService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $this->listUpcoming();
    }

    public function listUpcoming()
    {
        try {
            $page = (int) filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS);

            if (empty($page)) {
                $page = 1;
            }

            $action = 'listUpcoming';

            $result = $this->service->getUpcomingMovies($page);

            $result['movies'] = $this->mapMovieCollectionToPresenter($result['movies']);

            require APP_VIEWS_DIR . 'MovieList.php';
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function search()
    {
        try {
            $query = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
            $page = (int) filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS);

            if (empty($query)) {
                throw new \Exception('Please provide a query search.');
            }

            if (empty($page)) {
                $page = 1;
            }

            $action = 'search';

            $result = $this->service->searchMovies($query, $page);

            $result['movies'] = $this->mapMovieCollectionToPresenter($result['movies']);

            require APP_VIEWS_DIR . 'MovieList.php';
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getOne()
    {
        try {
            $id = (int)filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

            if (empty($id)) {
                throw new \Exception('Please inform movie id');
            }

            $movie = new MoviePresenter($this->service->getMovie($id));

            require APP_VIEWS_DIR . 'Movie.php';
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function mapMovieCollectionToPresenter(array $movies)
    {
        return array_map(function($movie) {
            return new MoviePresenter($movie);
        }, $movies);
    }
}