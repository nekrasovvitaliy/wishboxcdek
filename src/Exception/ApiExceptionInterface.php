<?php

declare(strict_types=1);

namespace WishboxCdek\Exception;

interface ApiExceptionInterface
{
    public function getStatusCode(): int;

    public function getResponse(): object;
}
