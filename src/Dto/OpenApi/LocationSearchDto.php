<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: LocationSearchDto
 */
final readonly class LocationSearchDto
{
    /**
     * @var array<int|string, mixed>
     */
    public array $cityUuids;

    public ?string $cityCode;

    public ?string $cityName;

    /**
     * @var array<int|string, mixed>
     */
    public array $countryCodes;

    public ?string $country;

    public ?string $regionCode;

    public ?string $region;

    public ?string $subRegion;

    public ?string $postcode;

    public ?string $address;

    public ?string $fiasGuid;

    public ?int $size;

    public ?int $page;

    public ?float $paymentLimit;

    public ?bool $creationPermitIgnore;

    public ?bool $showPostcodes;

    public function __construct(
        array $cityUuids = [],
        ?string $cityCode = null,
        ?string $cityName = null,
        array $countryCodes = [],
        ?string $country = null,
        ?string $regionCode = null,
        ?string $region = null,
        ?string $subRegion = null,
        ?string $postcode = null,
        ?string $address = null,
        ?string $fiasGuid = null,
        ?int $size = null,
        ?int $page = null,
        ?float $paymentLimit = null,
        ?bool $creationPermitIgnore = null,
        ?bool $showPostcodes = null,
    ) {
        $this->cityUuids = $cityUuids;
        $this->cityCode = $cityCode;
        $this->cityName = $cityName;
        $this->countryCodes = $countryCodes;
        $this->country = $country;
        $this->regionCode = $regionCode;
        $this->region = $region;
        $this->subRegion = $subRegion;
        $this->postcode = $postcode;
        $this->address = $address;
        $this->fiasGuid = $fiasGuid;
        $this->size = $size;
        $this->page = $page;
        $this->paymentLimit = $paymentLimit;
        $this->creationPermitIgnore = $creationPermitIgnore;
        $this->showPostcodes = $showPostcodes;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            cityUuids: isset($data['cityUuids']) && is_array($data['cityUuids']) ? $data['cityUuids'] : [],
            cityCode: isset($data['cityCode']) ? (string) $data['cityCode'] : null,
            cityName: isset($data['cityName']) ? (string) $data['cityName'] : null,
            countryCodes: isset($data['countryCodes']) && is_array($data['countryCodes']) ? $data['countryCodes'] : [],
            country: isset($data['country']) ? (string) $data['country'] : null,
            regionCode: isset($data['regionCode']) ? (string) $data['regionCode'] : null,
            region: isset($data['region']) ? (string) $data['region'] : null,
            subRegion: isset($data['subRegion']) ? (string) $data['subRegion'] : null,
            postcode: isset($data['postcode']) ? (string) $data['postcode'] : null,
            address: isset($data['address']) ? (string) $data['address'] : null,
            fiasGuid: isset($data['fiasGuid']) ? (string) $data['fiasGuid'] : null,
            size: isset($data['size']) ? (int) $data['size'] : null,
            page: isset($data['page']) ? (int) $data['page'] : null,
            paymentLimit: isset($data['paymentLimit']) ? (float) $data['paymentLimit'] : null,
            creationPermitIgnore: isset($data['creationPermitIgnore']) ? (bool) $data['creationPermitIgnore'] : null,
            showPostcodes: isset($data['showPostcodes']) ? (bool) $data['showPostcodes'] : null,
        );
    }
}
