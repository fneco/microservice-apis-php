<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrdersRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Orders extends Controller
{
    public function store(OrdersRequest $request): ResponseFactory|Response
    {

        $request->validated();

        return $this->defaultResponse();
    }

    public function update(OrdersRequest $request): ResponseFactory|Response
    {
        $request->validated();

        return $this->defaultResponse();
    }
}
