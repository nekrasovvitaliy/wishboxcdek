<?php

declare(strict_types=1);

namespace Tests\Unit\Request\Location;

use PHPUnit\Framework\TestCase;
use WishboxCdek\Request\Location\GetRegionsRequest;

final class GetRegionsRequestTest extends TestCase
{
    public function test_to_array_filters_null_values(): void
    {
        $request = new GetRegionsRequest(countryCodes: 'RU', size: 100);

        self::assertSame([
            'country_codes' => 'RU',
            'size' => 100,
        ], $request->toArray());
    }
}
