<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: ReverseValidateRequestSenderDto
 *
 * Отправитель
 */
final readonly class ReverseValidateRequestSenderDto
{
    public mixed $contragentType;

    /**
     * @var array<int|string, mixed> of ReverseValidateRequestPhoneDto
     */
    public array $phones;

    public function __construct(
        mixed $contragentType = null,
        array $phones = [],
    ) {
        $this->contragentType = $contragentType;
        $this->phones = $phones;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            contragentType: $data['contragent_type'] ?? null,
            phones: isset($data['phones']) && is_array($data['phones']) ? $data['phones'] : [],
        );
    }
}
