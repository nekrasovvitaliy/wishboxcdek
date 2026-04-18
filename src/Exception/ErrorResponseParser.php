<?php

declare(strict_types=1);

namespace WishboxCdek\Exception;

use WishboxCdek\Response\Error\CdekMessage;

final class ErrorResponseParser
{
    /**
     * @return list<CdekMessage>
     */
    public static function extractErrors(array $response): array
    {
        $messages = self::extractMessages($response, 'errors');

        if ($messages !== []) {
            return $messages;
        }

        $oauthError = self::extractOAuthError($response);

        return $oauthError === null ? [] : [$oauthError];
    }

    /**
     * @return list<CdekMessage>
     */
    public static function extractWarnings(array $response): array
    {
        return self::extractMessages($response, 'warnings');
    }

    /**
     * @return list<string>
     */
    public static function extractRequestStates(array $response): array
    {
        $states = [];

        if (!isset($response['requests']) || !is_array($response['requests'])) {
            return $states;
        }

        foreach ($response['requests'] as $request) {
            if (!is_array($request)) {
                continue;
            }

            $state = $request['state'] ?? null;

            if (is_string($state) && $state !== '') {
                $states[] = $state;
            }
        }

        return $states;
    }

    public static function hasBusinessErrors(array $response): bool
    {
        if (!isset($response['requests']) || !is_array($response['requests'])) {
            return false;
        }

        return array_any(
            $response['requests'],
            static function (mixed $request): bool {
                if (!is_array($request)) {
                    return false;
                }

                if (isset($request['errors']) && is_array($request['errors']) && $request['errors'] !== []) {
                    return true;
                }

                return ($request['state'] ?? null) === 'INVALID';
            }
        );
    }

    /**
     * @param list<CdekMessage> $errors
     */
    public static function extractMessage(array $response, array $errors = []): string
    {
        $message = $response['message'] ?? null;

        if (is_string($message) && $message !== '') {
            return $message;
        }

        $errorDescription = $response['error_description'] ?? null;

        if (is_string($errorDescription) && $errorDescription !== '') {
            return $errorDescription;
        }

        $error = $response['error'] ?? null;

        if (is_string($error) && $error !== '') {
            return $error;
        }

        foreach ($errors as $error) {
            if ($error->message !== null && $error->message !== '') {
                return $error->message;
            }
        }

        return 'CDEK request failed.';
    }

    /**
     * @return list<CdekMessage>
     */
    private static function extractMessages(array $response, string $key): array
    {
        $messages = [];

        foreach (self::collectMessageRows($response, $key) as $row) {
            $messages[] = CdekMessage::fromArray($row);
        }

        return $messages;
    }

    private static function extractOAuthError(array $response): ?CdekMessage
    {
        $error = $response['error'] ?? null;
        $description = $response['error_description'] ?? null;

        if (!is_string($error) || $error === '') {
            return null;
        }

        return new CdekMessage(
            code: $error,
            message: is_string($description) && $description !== '' ? $description : $error,
        );
    }

    /**
     * @return list<array>
     */
    private static function collectMessageRows(array $response, string $key): array
    {
        $rows = [];

        if (isset($response[$key]) && is_array($response[$key])) {
            foreach ($response[$key] as $message) {
                if (is_array($message)) {
                    $rows[] = $message;
                }
            }
        }

        if (!isset($response['requests']) || !is_array($response['requests'])) {
            return $rows;
        }

        foreach ($response['requests'] as $request) {
            if (!is_array($request) || !isset($request[$key]) || !is_array($request[$key])) {
                continue;
            }

            foreach ($request[$key] as $message) {
                if (is_array($message)) {
                    $rows[] = $message;
                }
            }
        }

        return $rows;
    }
}
