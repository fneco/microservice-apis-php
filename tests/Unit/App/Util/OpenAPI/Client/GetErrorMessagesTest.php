<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Util\OpenAPI\Client\GetErrorMessages;
use OpenAPI\Client\Model\CreateOrderSchema;
use OpenAPI\Client\Model\OrderItemSchema;

class GetErrorMessagesTest extends TestCase
{
    public function test_accepting_null(): void
    {
        $payload = null;

        $messages = GetErrorMessages::with(
            $payload,
            CreateOrderSchema::class,
        );

        $obj = new GetErrorMessages();
        $this->assertEquals([], $messages);
    }

    public function test_returning_empty_with_valid_data(): void
    {
        $payload = [
            "order" => [
                [
                    "product" => "cappuccino",
                    "size" => "medium",
                    "quantity" => 1
                ]
            ]
        ];

        $messages = GetErrorMessages::with(
            $payload,
            CreateOrderSchema::class,
        );

        $this->assertEquals([], $messages);
    }

    public function test_getting_messages_from_ModelInterface(): void
    {
        $payload = [
                "product" => null,
                "size" => "medium",
                "quantity" => 1
        ];

        $messages = GetErrorMessages::with(
            $payload,
            OrderItemSchema::class,
        );

        $this->assertEquals([
            "[OrderItemSchema] 'product' can't be null",
        ], $messages);

    }


    public function test_getting_messages_from_nested_ModelInterface(): void
    {
        $payload = [
            "order" => [
                [
                    "product" => null,
                    "size" => "medium",
                    "quantity" => 1
                ]
            ]
        ];

        $messages = GetErrorMessages::with(
            $payload,
            CreateOrderSchema::class,
        );

        $this->assertEquals([
            "[OrderItemSchema] 'product' can't be null",
        ], $messages);
    }

    public function test_getting_messages_from_multiple_ModelInterface(): void
    {
        $payload = [
            "order" => [
                [
                    "product" => null,
                    "size" => "medium",
                    "quantity" => 1
                ],
                [
                    "product" => "cappuccino",
                    "size" => null,
                    "quantity" => 2
                ]
            ]
        ];

        $messages = GetErrorMessages::with(
            $payload,
            CreateOrderSchema::class,
        );

        $this->assertEquals([
            "[OrderItemSchema] 'product' can't be null",
            "[OrderItemSchema] 'size' can't be null",
        ], $messages);
    }

}
