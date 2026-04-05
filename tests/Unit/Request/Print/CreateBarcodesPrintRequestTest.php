<?php

declare(strict_types=1);

namespace Tests\Unit\Request\Print;

use PHPUnit\Framework\TestCase;
use WishboxCdek\Enum\PrintFormat;
use WishboxCdek\Enum\Language;
use WishboxCdek\Request\Print\CreateBarcodesPrintRequest;
use WishboxCdek\Request\Print\PrintOrderReferenceDto;

final class CreateBarcodesPrintRequestTest extends TestCase
{
    public function test_to_array_serializes_documented_payload_shape(): void
    {
        $request = new CreateBarcodesPrintRequest(
            orders: [
                new PrintOrderReferenceDto(),
            ],
            copyCount: 1,
            format: PrintFormat::A6,
            lang: Language::RUS,
        );

        self::assertSame([
            'orders' => [
                [
                    'order_uuid' => null,
                    'cdek_number' => null,
                ],
            ],
            'copy_count' => 1,
            'format' => 'A6',
            'lang' => 'rus',
        ], $request->toArray());
    }

    public function test_to_array_defaults_format_to_a4(): void
    {
        $request = new CreateBarcodesPrintRequest(
            orders: [
                new PrintOrderReferenceDto(),
            ],
        );

        self::assertSame('A4', $request->toArray()['format']);
        self::assertArrayNotHasKey('lang', $request->toArray());
    }

    public function test_to_array_serializes_order_identifiers_when_present(): void
    {
        $request = new CreateBarcodesPrintRequest(
            orders: [
                new PrintOrderReferenceDto(orderUuid: 'order-uuid', cdekNumber: '1000014101'),
            ],
            lang: Language::ENG,
        );

        self::assertSame([
            'orders' => [
                [
                    'order_uuid' => 'order-uuid',
                    'cdek_number' => '1000014101',
                ],
            ],
            'format' => 'A4',
            'lang' => 'eng',
        ], $request->toArray());
    }
}



