<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Error;

final readonly class SimplifiedResponseDto
{
    /**
     * @param list<ErrorDto1> $errors
     */
    public function __construct(
        public array $errors = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        $errors = [];
        foreach (self::collectErrors($data) as $error) {
            $errors[] = ErrorDto1::fromArray($error);
        }

        return new self(errors: $errors);
    }

    /**
     * @return list<array<string, mixed>>
     */
    private static function collectErrors(array $data): array
    {
        $errors = [];

        if (isset($data['errors']) && is_array($data['errors'])) {
            foreach ($data['errors'] as $error) {
                if (is_array($error)) {
                    $errors[] = $error;
                }
            }
        }

        if (!isset($data['requests']) || !is_array($data['requests'])) {
            return $errors;
        }

        foreach ($data['requests'] as $request) {
            if (!is_array($request) || !isset($request['errors']) || !is_array($request['errors'])) {
                continue;
            }

            foreach ($request['errors'] as $error) {
                if (is_array($error)) {
                    $errors[] = $error;
                }
            }
        }

        return $errors;
    }
}
