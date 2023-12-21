<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Util\OpenAPI\Client\Validate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenAPI\Client\Model\CreateOrderSchema;
use OpenAPI\Client\Model\GetOrderSchema;

class Orders extends Controller
{
    /** @var array<string, mixed> */
    private array $orders;

    public function __construct()
    {
        $this->orders = [
          "id" => "ff0f1355-e821-4178-9567-550dec27a373",
          "status" => "delivered",
          "created" => "2023/12/21",
          "order" => [
                [
                   "product" => "cappuccino",
                   "size" => "medium",
                   "quantity" => 1
                ]
             ]
        ];

    }

    public function index(Request $request): Response
    {

        Validate::with($this->orders, GetOrderSchema::class);

        return new Response($this->orders);
    }


    public function store(CreateOrderRequest $request): Response
    {
        Validate::with($request->all(), CreateOrderSchema::class);
        Validate::with($this->orders, GetOrderSchema::class);

        return new Response($this->orders);
    }

    public function update(CreateOrderRequest $request): Response
    {

        Validate::with($request->all(), CreateOrderSchema::class);

        return $this->defaultResponse();
    }
}
