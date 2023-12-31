<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    public function handle(Request $request): Response
    {
        return $this->defaultResponse();
    }

    protected function defaultResponse(): Response
    {
        return new Response(['hello' => 'world']);
    }
}
