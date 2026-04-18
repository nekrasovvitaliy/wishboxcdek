<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Order;

use InvalidArgumentException;
use WishboxCdek\Request\RequestData;

final readonly class GetOrderByNumberRequest extends RequestData
{
    public function __construct(
        public ?string $cdekNumber = null,
        public ?string $imNumber = null
    ) {
        $hasCdekNumber = $this->cdekNumber !== null && trim($this->cdekNumber) !== '';
        $hasImNumber = $this->imNumber !== null && trim($this->imNumber) !== '';

        if ($hasCdekNumber === $hasImNumber) {
            throw new InvalidArgumentException(
                'GetOrderByNumberRequest expects exactly one of cdekNumber or imNumber to be provided.'
            );
        }
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'cdek_number' => $this->cdekNumber,
            'im_number' => $this->imNumber,
        ]);
    }
}
