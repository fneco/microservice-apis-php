<?php

namespace App\Util\OpenAPI\Client;

use OpenAPI\Client\Model\ModelInterface;
use OpenAPI\Client\ObjectSerializer;

class GetErrorMessages
{
    /**
     * Get error messages from JSON with OpenAPI Generator Model Class
     *
     * @param string   $class         class name is passed as a string
     * @param mixed    $data          object or primitive to be deserialized
     *
     * @return array<int, string>
     */
    public static function with(mixed $data, string $class): array
    {
        $deserialized = ObjectSerializer::deserialize(
            $data,
            $class
        );
        return static::from($deserialized);
    }


    /**
     * @param array<int, string> $messages
     *
     * @return array<int, string>
     */
    public static function from(mixed $models, array $messages = []): array
    {
        if($models instanceof ModelInterface) {

            $currentModelName = $models->getModelName();
            $currentMessages = array_merge(
                $messages,
                array_map(
                    fn($message) => "[$currentModelName] $message",
                    $models->listInvalidProperties(),
                )
            );
            $values = GetErrorMessages::getValues($models);
            return array_merge(
                $currentMessages,
                array_reduce(
                    $values,
                    function ($carry, $value) {
                        return array_merge(
                            $carry,
                            GetErrorMessages::from($value)
                        );
                    },
                    []
                )
            );
        }
        if(is_array($models)) {
            return array_reduce($models, function ($carry, $model) {
                return array_merge($carry, GetErrorMessages::from($model));
            }, $messages);
        }
        return $messages;
    }



    /**
     * @return array<int, mixed>
     */
    private static function getValues(ModelInterface $model): array
    {
        return array_reduce(
            $model->getters(),
            function ($carry, string $getter) use ($model) {
                if (method_exists($model, $getter)) {
                    // @phpstan-ignore-next-line
                    $carry[] = call_user_func([ $model, $getter ]);
                }
                return $carry;
            },
            []
        );
    }
}
