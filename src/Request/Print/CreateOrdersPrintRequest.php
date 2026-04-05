<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Print;

use WishboxCdek\Enum\Language;
use WishboxCdek\Enum\PrintFormat;
use WishboxCdek\Request\RequestData;

final readonly class CreateOrdersPrintRequest extends RequestData
{
    /**
     * @param list<PrintOrderReferenceDto> $orders
     */
    public function __construct(
        public array $orders,
        public ?int $copyCount = null,
        public PrintFormat $format = PrintFormat::A4,
        public ?Language $lang = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->normalizeArray([
            'orders' => $this->orders,
            'copy_count' => $this->copyCount,
            'format' => $this->format->value,
            'lang' => $this->lang?->value,
        ]);
    }
}
