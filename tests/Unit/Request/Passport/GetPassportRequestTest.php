<?php

declare(strict_types=1);

namespace Tests\Unit\Request\Passport;

use PHPUnit\Framework\TestCase;
use WishboxCdek\Enum\PassportClient;
use WishboxCdek\Request\Passport\GetPassportRequest;

final class GetPassportRequestTest extends TestCase
{
    public function test_to_array_serializes_query_parameters(): void
    {
        $request = new GetPassportRequest(
            cdekNumber: '1000014101',
            orderUuid: '72753031-e66b-4146-ab8c-52179ef4020a',
            client: PassportClient::SENDER,
        );

        self::assertSame([
            'cdek_number' => '1000014101',
            'order_uuid' => '72753031-e66b-4146-ab8c-52179ef4020a',
            'client' => 'SENDER',
        ], $request->toArray());
    }

    public function test_to_array_omits_null_values(): void
    {
        $request = new GetPassportRequest(orderUuid: '72753031-e66b-4146-ab8c-52179ef4020a');

        self::assertSame([
            'order_uuid' => '72753031-e66b-4146-ab8c-52179ef4020a',
        ], $request->toArray());
    }
}
