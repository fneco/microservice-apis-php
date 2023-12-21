<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Util\OpenAPI\Client\Validate;
use App\Util\OpenAPI\Client\Validated;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenAPI\Client\Model\CreateOrderSchema;
use OpenAPI\Client\Model\GetOrderSchema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class Orders extends Controller
{
    /** @return array<int, array<string, mixed>> */
    private function getOrders()
    {
        /** @var array<int, array<string, mixed>> $orders */
        $orders = Cache::store('file')->get('$orders') ?? [];
        return $orders;
    }

    /**
     * @return array<string, mixed>
     */
    private function getOrder(string $orderId): array|null
    {
        $orders = $this->getOrders();
        foreach ($orders as $order) {
            if ($order['id'] === $orderId) {
                return $order;
            }
        }
        return null;
    }

    /**
     * @param  array<string, mixed>|\stdClass $order
     */
    private function addOrders(array|\stdClass $order): void
    {
        $orders = $this->getOrders();
        $orders[] = is_array($order) ? $order : get_object_vars($order);
        Cache::store('file')->set('$orders', $orders); // php artisan cache:clear で初期化する
    }

    /**
     * @param  array<string, mixed> $newOrder
     */
    private function replaceOrders(array $newOrder, string $orderId): void
    {
        $orders = $this->getOrders();
        foreach ($orders as $index => $order) {
            if ($order['id'] === $orderId) {
                $orders[$index] = $newOrder;
            }
        }
        Cache::store('file')->set('$orders', $orders); // php artisan cache:clear で初期化する
    }

    private function deleteOrders(string $orderId): bool
    {
        $orders = $this->getOrders();
        foreach ($orders as $index => $order) {
            if ($order['id'] === $orderId) {
                unset($orders[$index]);
                Cache::store('file')->set('$orders', $orders); // php artisan cache:clear で初期化する
                return true;
            }
        }
        return false;
    }

    private function notFoundResponse(string $orderId): Response
    {
        return new Response(
            ['detail' => "Order with ID $orderId not found"],
            Response::HTTP_NOT_FOUND
        );
    }


    /**
     * @param  \stdClass $order
     * @return  array<string, mixed>
     */
    private function addInfoToOrder(\stdClass $order): array
    {
        $order->id = Str::uuid()->toString();
        $order->created = \Carbon\Carbon::now()->toDateTimeString();
        $order->status = 'created';
        return get_object_vars($order);
        ;
    }


    public function index(Request $request): Response
    {

        $orders = $this->getOrders();
        if(count($orders) > 0) {
            foreach ($orders as $order) {
                Validate::with($order, GetOrderSchema::class);
            }
        }

        return new Response(['orders' => $orders]);
    }


    public function show(Request $request, string $orderId): Response
    {

        $order = $this->getOrder($orderId);
        if (is_null($order)) {
            return $this->notFoundResponse($orderId);
        }
        Validate::with($order, GetOrderSchema::class);
        return new Response($order);
    }

    public function store(CreateOrderRequest $request): Response
    {

        /** @var \stdClass $validated  */
        $validated = Validated::with($request->all(), CreateOrderSchema::class);
        \Log::debug(print_r($validated, true));
        $order = $this->addInfoToOrder($validated);
        Validate::with($order, GetOrderSchema::class);
        $this->addOrders($order);
        return new Response($order, Response::HTTP_CREATED);
    }

    public function update(CreateOrderRequest $request, string $orderId): Response
    {

        /** @var \stdClass $validated  */
        $validated = Validated::with($request->all(), CreateOrderSchema::class);
        $order = $this->addInfoToOrder($validated);
        $this->replaceOrders($order, $orderId);
        Validate::with($request->all(), GetOrderSchema::class);

        return $this->defaultResponse();
    }

    public function destroy(CreateOrderRequest $request, string $orderId): Response
    {

        if ($this->deleteOrders($orderId)) {
            return new Response('', Response::HTTP_NO_CONTENT);
        }
        return $this->notFoundResponse($orderId);
    }

    public function cancel(CreateOrderRequest $request, string $orderId): Response
    {
        $order = $this->getOrder($orderId);
        if (is_null($order)) {
            return $this->notFoundResponse($orderId);
        }
        $order['status'] = 'cancelled';
        Validate::with($order, GetOrderSchema::class);
        $this->replaceOrders($order, $orderId);
        return new Response($order);
    }

    public function pay(CreateOrderRequest $request, string $orderId): Response
    {
        $order = $this->getOrder($orderId);
        if (is_null($order)) {
            return $this->notFoundResponse($orderId);
        }
        $order['status'] = 'progress';
        Validate::with($order, GetOrderSchema::class);
        $this->replaceOrders($order, $orderId);
        return new Response($order);
    }
}
