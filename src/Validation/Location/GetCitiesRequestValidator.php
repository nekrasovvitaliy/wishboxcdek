<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Location;

use WishboxCdek\Exception\LocationValidationException;
use WishboxCdek\Request\Location\GetCitiesRequest;
use WishboxCdek\Validation\Uuid\UuidValidator;

final class GetCitiesRequestValidator
{
    public function __construct(
        private readonly UuidValidator $uuidValidator = new UuidValidator(),
    ) {
    }

    public function validate(GetCitiesRequest $request): void
    {
        $errors = [];

        if ($request->countryCodes !== null) {
            $countryCodes = array_filter(
                array_map('trim', explode(',', $request->countryCodes)),
                static fn (string $code): bool => $code !== '',
            );

            if ($countryCodes === []) {
                $errors[] = 'countryCodes must contain at least one ISO 3166-1 alpha-2 code.';
            }

            foreach ($countryCodes as $code) {
                if (preg_match('/^[A-Z]{2}$/', $code) !== 1) {
                    $errors[] = sprintf('countryCodes contains invalid country code "%s".', $code);
                }
            }
        }

        if ($request->city !== null && trim($request->city) === '') {
            $errors[] = 'city must not be blank.';
        }

        if ($request->kladrRegionCode !== null && trim($request->kladrRegionCode) === '') {
            $errors[] = 'kladrRegionCode must not be blank.';
        }

        if ($request->kladrCode !== null && trim($request->kladrCode) === '') {
            $errors[] = 'kladrCode must not be blank.';
        }

        if ($request->page !== null && $request->page < 0) {
            $errors[] = 'page must be greater than or equal to 0.';
        }

        if ($request->size !== null && $request->size < 0) {
            $errors[] = 'size must be greater than or equal to 0.';
        }

        foreach ([
            'fiasRegionGuid' => $request->fiasRegionGuid,
            'fiasGuid' => $request->fiasGuid,
        ] as $field => $value) {
            if ($value === null || trim($value) === '') {
                continue;
            }

            try {
                $this->uuidValidator->validate($value, $field);
            } catch (\Throwable $exception) {
                $errors[] = $exception->getMessage();
            }
        }

        if ($errors !== []) {
            throw new LocationValidationException($errors);
        }
    }
}
