<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: DomainAddBlackListRequest
 */
final readonly class DomainAddBlackListRequest
{
    /**
     * @var array<int|string, mixed>
     */
    public array $domainList;

    public function __construct(
        array $domainList = [],
    ) {
        $this->domainList = $domainList;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            domainList: isset($data['domain_list']) && is_array($data['domain_list']) ? $data['domain_list'] : [],
        );
    }
}
