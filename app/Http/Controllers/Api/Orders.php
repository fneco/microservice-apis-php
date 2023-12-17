<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use function PHPUnit\Framework\throwException;

class Orders extends Controller
{
    public function store(Request $request): ResponseFactory|Response
    {

        $request->validate($this->getRules());

        return $this->defaultResponse();
    }

    public function update(Request $request): ResponseFactory|Response
    {

        $request->validate($this->getRules());

        return $this->defaultResponse();
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function getRules()
    {
        return [
                'order' => ['required', new OrdersRules()]
            ];
    }
}
