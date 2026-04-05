<?php

declare(strict_types=1);

namespace Tests\Unit\Request\Registry;

use PHPUnit\Framework\TestCase;
use WishboxCdek\Request\Registry\GetRegistriesRequest;

final class GetRegistriesRequestTest extends TestCase
{
    public function test_to_array_serializes_required_date_query(): void
    {
        $request = new GetRegistriesRequest('2024-05-21');

        self::assertSame([
            'date' => '2024-05-21',
        ], $request->toArray());
    }
}
