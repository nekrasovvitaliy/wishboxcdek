<?php

declare(strict_types=1);

namespace WishboxCdek\Enum;

enum PassportClient: string
{
    case SENDER = 'SENDER';
    case RECEIVER = 'RECEIVER';
    case ALL = 'ALL';
}
