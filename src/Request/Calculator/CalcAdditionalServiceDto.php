<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Calculator;

use WishboxCdek\Request\RequestData;

final readonly class CalcAdditionalServiceDto extends RequestData
{
    public function __construct(
        public string $code,
        public string|int|float|bool|null $parameter = null,
    ) {
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'code' => $this->code,
            'parameter' => $this->parameter,
        ]);
    }
}
