<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: CheckInfoDto
 *
 * Информация о чеке
 */
final readonly class CheckInfoDto
{
    public ?string $orderUuid;

    public mixed $cdekNumber;

    public ?string $date;

    public mixed $fiscalStorageNumber;

    public mixed $documentNumber;

    public mixed $fiscalSign;

    public mixed $type;

    /**
     * @var array<int|string, mixed> of PaymentInfoDto
     */
    public array $paymentInfo;

    public mixed $shiftNo;

    public function __construct(
        ?string $orderUuid = null,
        mixed $cdekNumber = null,
        ?string $date = null,
        mixed $fiscalStorageNumber = null,
        mixed $documentNumber = null,
        mixed $fiscalSign = null,
        mixed $type = null,
        array $paymentInfo = [],
        mixed $shiftNo = null,
    ) {
        $this->orderUuid = $orderUuid;
        $this->cdekNumber = $cdekNumber;
        $this->date = $date;
        $this->fiscalStorageNumber = $fiscalStorageNumber;
        $this->documentNumber = $documentNumber;
        $this->fiscalSign = $fiscalSign;
        $this->type = $type;
        $this->paymentInfo = $paymentInfo;
        $this->shiftNo = $shiftNo;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            orderUuid: isset($data['order_uuid']) ? (string) $data['order_uuid'] : null,
            cdekNumber: $data['cdek_number'] ?? null,
            date: isset($data['date']) ? (string) $data['date'] : null,
            fiscalStorageNumber: $data['fiscal_storage_number'] ?? null,
            documentNumber: $data['document_number'] ?? null,
            fiscalSign: $data['fiscal_sign'] ?? null,
            type: $data['type'] ?? null,
            paymentInfo: isset($data['payment_info']) && is_array($data['payment_info']) ? $data['payment_info'] : [],
            shiftNo: $data['shift_no'] ?? null,
        );
    }
}
