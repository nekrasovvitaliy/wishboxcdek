<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: DomainDeleteBlackListRequest
 */
final readonly class DomainDeleteBlackListRequest
{
    /**
     * @var array<int|string, mixed>
     */
    public array $domainList;

    /**
     * @var array<int|string, mixed>
     */
    public array $ipList;

    public function __construct(
        array $domainList = [],
        array $ipList = [],
    ) {
        $this->domainList = $domainList;
        $this->ipList = $ipList;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            domainList: isset($data['domain_list']) && is_array($data['domain_list']) ? $data['domain_list'] : [],
            ipList: isset($data['ip_list']) && is_array($data['ip_list']) ? $data['ip_list'] : [],
        );
    }
}
