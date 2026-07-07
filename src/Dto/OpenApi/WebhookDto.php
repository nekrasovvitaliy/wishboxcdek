<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: WebhookDto
 *
 * Вебхук
 */
final readonly class WebhookDto
{
    public ?string $uuid;

    public mixed $type;

    public mixed $url;

    public function __construct(
        ?string $uuid = null,
        mixed $type = null,
        mixed $url = null,
    ) {
        $this->uuid = $uuid;
        $this->type = $type;
        $this->url = $url;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: isset($data['uuid']) ? (string) $data['uuid'] : null,
            type: $data['type'] ?? null,
            url: $data['url'] ?? null,
        );
    }
}
