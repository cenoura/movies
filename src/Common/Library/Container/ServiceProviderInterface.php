<?php

namespace Cenoura\Common\Library\Container;

interface ServiceProviderInterface
{
    public function register(Container $container);
}