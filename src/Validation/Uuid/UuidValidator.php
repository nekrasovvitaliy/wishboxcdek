<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Uuid;

use WishboxCdek\Exception\InvalidUuidException;

final class UuidValidator
{
    public function validate(string $uuid, string $field = 'uuid'): void
    {
        if (preg_match('/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[1-5][0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}$/', $uuid) === 1) {
            return;
        }

        throw new InvalidUuidException(sprintf('%s must be a valid UUID.', $field));
    }
}