<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: GetPrealertResponseDtoPackageInfoDto
 *
 * Упаковки заказа, по которым получена информация о расхождениях (появляется после закрытия преалерта)
 */
final readonly class GetPrealertResponseDtoPackageInfoDto
{
    public ?string $packageId;

    public mixed $number;

    public mixed $status;

    public function __construct(
        ?string $packageId = null,
        mixed $number = null,
        mixed $status = null,
    ) {
        $this->packageId = $packageId;
        $this->number = $number;
        $this->status = $status;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            packageId: isset($data['package_id']) ? (string) $data['package_id'] : null,
            number: $data['number'] ?? null,
            status: $data['status'] ?? null,
        );
    }
}
