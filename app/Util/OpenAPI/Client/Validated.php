<?php

namespace App\Util\OpenAPI\Client;

use OpenAPI\Client\ObjectSerializer;

class Validated
{
    /**
     * Get error messages from JSON with OpenAPI Generator Model Class
     *
     * @param string   $class         class name is passed as a string
     * @param mixed    $data          object or primitive to be deserialized
     *
     * @return scalar|object|array<string, mixed>|null
     */
    public static function with(mixed $data, string $class)
    {
        $deserialized = ObjectSerializer::deserialize(
            $data,
            $class
        );
        $messages = GetErrorMessages::from($deserialized);
        if(count($messages) > 0) {
            throw new \Exception(join('|', $messages));
        }
        $serialized = ObjectSerializer::sanitizeForSerialization($deserialized);
        return $serialized;
    }
}
