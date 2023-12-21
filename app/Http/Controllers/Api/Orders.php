<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Util\OpenAPI\Client\Validate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenAPI\Client\Model\CreateOrderSchema;

class Orders extends Controller
{
    public function store(Request $request): Response
    {
        Validate::with($request->all(), CreateOrderSchema::class);

        return $this->defaultResponse();
    }

    public function update(Request $request): Response
    {

        Validate::with($request->all(), CreateOrderSchema::class);

        return $this->defaultResponse();
    }
}
