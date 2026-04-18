<?php

declare(strict_types=1);

namespace WishboxCdek\Validation\Order;

use WishboxCdek\Request\Order\SenderContactDto;

final class SenderContactDtoValidator
{
    /**
     * @return list<string>
     */
    public function validate(SenderContactDto $sender): array
    {
        $errors = [];

        if (trim($sender->name) === '') {
            $errors[] = 'sender.name is required.';
        }

        if ($sender->phones === []) {
            $errors[] = 'sender.phones must not be empty.';
        }

        foreach ($sender->phones as $index => $phone) {
            if (trim($phone->number) === '') {
                $errors[] = sprintf('sender.phones[%d].number is required.', $index);
            }
        }

        return $errors;
    }
}
