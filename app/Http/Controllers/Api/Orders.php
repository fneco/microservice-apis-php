<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Util\OpenAPI\Client\Validate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenAPI\Client\Model\CreateOrderSchema;

class Orders extends Controller
{
    public function store(CreateOrderRequest $request): Response
    {
        Validate::with($request->all(), CreateOrderSchema::class);

        return $this->defaultResponse();
    }

    public function update(CreateOrderRequest $request): Response
    {

        Validate::with($request->all(), CreateOrderSchema::class);

        return $this->defaultResponse();
    }
}
