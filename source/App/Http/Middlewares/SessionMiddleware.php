<?php

namespace source\App\Http\Middlewares;

use CoffeeCode\Router\Router;

class SessionMiddleware {
    public function handle(Router $router): bool
    {
        dd('M-Auth');
    }
}