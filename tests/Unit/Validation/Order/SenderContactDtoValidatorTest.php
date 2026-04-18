<?php

declare(strict_types=1);

namespace Tests\Unit\Validation\Order;

use PHPUnit\Framework\TestCase;
use WishboxCdek\Request\Order\PhoneDto;
use WishboxCdek\Request\Order\SenderContactDto;
use WishboxCdek\Validation\Order\SenderContactDtoValidator;

final class SenderContactDtoValidatorTest extends TestCase
{
    public function test_validate_requires_name(): void
    {
        $validator = new SenderContactDtoValidator();

        self::assertSame(
            ['sender.name is required.'],
            $validator->validate(new SenderContactDto(
                name: '   ',
                phones: [new PhoneDto(number: '+79990000001')],
            )),
        );
    }

    public function test_validate_requires_phone_number(): void
    {
        $validator = new SenderContactDtoValidator();

        self::assertSame(
            ['sender.phones[0].number is required.'],
            $validator->validate(new SenderContactDto(
                name: 'Sender',
                phones: [new PhoneDto(number: '   ')],
            )),
        );
    }

    public function test_validate_returns_no_errors_for_valid_sender(): void
    {
        $validator = new SenderContactDtoValidator();

        self::assertSame(
            [],
            $validator->validate(new SenderContactDto(
                name: 'Sender',
                phones: [new PhoneDto(number: '+79990000001')],
            )),
        );
    }
}
