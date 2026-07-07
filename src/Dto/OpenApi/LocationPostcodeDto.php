<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: LocationPostcodeDto
 *
 * Транспорт почтового индекса
 */
final readonly class LocationPostcodeDto
{
    public ?string $postcode;

    public ?string $cityUuid;

    public ?string $cityCode;

    public function __construct(
        ?string $postcode = null,
        ?string $cityUuid = null,
        ?string $cityCode = null,
    ) {
        $this->postcode = $postcode;
        $this->cityUuid = $cityUuid;
        $this->cityCode = $cityCode;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            postcode: isset($data['postcode']) ? (string) $data['postcode'] : null,
            cityUuid: isset($data['cityUuid']) ? (string) $data['cityUuid'] : null,
            cityCode: isset($data['cityCode']) ? (string) $data['cityCode'] : null,
        );
    }
}
