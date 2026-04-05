<?php

declare(strict_types=1);

namespace Tests\Unit\Request\Intake;

use PHPUnit\Framework\TestCase;
use WishboxCdek\Request\Intake\GetAvailableIntakeDaysRequest;
use WishboxCdek\Request\Intake\IntakeAvailableDaysLocationDto;

final class GetAvailableIntakeDaysRequestTest extends TestCase
{
    public function test_to_array_serializes_documented_payload_shape(): void
    {
        $request = new GetAvailableIntakeDaysRequest(
            fromLocation: new IntakeAvailableDaysLocationDto(
                code: 44,
                city: 'Moscow',
                countryCode: 'RU',
                postalCode: '101000',
                address: 'Red Square, 1',
            ),
            date: '2026-04-18',
        );

        self::assertSame([
            'from_location' => [
                'code' => 44,
                'city' => 'Moscow',
                'country_code' => 'RU',
                'postal_code' => '101000',
                'address' => 'Red Square, 1',
            ],
            'date' => '2026-04-18',
        ], $request->toArray());
    }

    public function test_to_array_omits_optional_date_when_not_provided(): void
    {
        $request = new GetAvailableIntakeDaysRequest(
            fromLocation: new IntakeAvailableDaysLocationDto(code: 44),
        );

        self::assertSame([
            'from_location' => [
                'code' => 44,
            ],
        ], $request->toArray());
    }
}
