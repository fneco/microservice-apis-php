<?php

namespace App\Http\Controllers\Api;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use OpenAPI\Client\Model\OrderItemSchema;

class OrdersRules implements DataAwareRule, ValidationRule
{
    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];


    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var array<int,mixed> $orders */
        $orders = $this->data['order'];
        $callable = fn(array $args) => new OrderItemSchema($args);
        // @phpstan-ignore-next-line
        $order = array_map($callable, $orders);
        $invalidProperties = array_merge_recursive(...array_map(
            fn($item) => $item->listInvalidProperties(),
            $order
        ));
        \Log::debug(print_r(['this.data' => $this->data['order'], $invalidProperties], true));
        if (count($invalidProperties) > 0) {
            $errorMessage = join(' [OpenAPI Error]: ', $invalidProperties);
            $fail("[OpenAPI Error]: $errorMessage");
        }
    }

}
