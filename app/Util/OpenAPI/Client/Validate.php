<?php

namespace App\Util\OpenAPI\Client;

class Validate
{
    public static function with(mixed $data, string $class): void
    {
        $messages = GetErrorMessages::with($data, $class);
        if(count($messages) > 0) {
            // TODO: error handling
            throw new \Exception(join('|', $messages));
        }
    }
}
