<?php

namespace Cenoura\Movie;

use Cenoura\Common\Library\Container\Container;
use Cenoura\Common\Library\Container\ServiceProviderInterface;

class MovieProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['movie.controller'] = function () use ($app) {
            return new MovieController(
                new MovieService()
            );
        };
    }
}
