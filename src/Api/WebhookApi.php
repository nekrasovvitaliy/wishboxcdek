<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Dto\OpenApi\ResponseDto;
use WishboxCdek\Dto\OpenApi\ResponseDtoWebhookDto;
use WishboxCdek\Dto\OpenApi\ResponseDtoWebhookResponseDto;
use WishboxCdek\Dto\OpenApi\WebhookDto;
use WishboxCdek\Request\Webhook\CreateWebhookRequestDto;
use WishboxCdek\Validation\Uuid\UuidValidator;

final class WebhookApi
{
    private readonly UuidValidator $uuidValidator;

    public function __construct(private readonly CdekClient $client)
    {
        $this->uuidValidator = new UuidValidator();
    }

    /**
     * @return list<WebhookDto>
     */
    public function getAll(): array
    {
        return $this->client->requestMapped(
            'GET',
            '/v2/webhooks',
            [
                200 => static fn ($response): array => array_map(
                    static fn (array $webhook): WebhookDto => WebhookDto::fromArray($webhook),
                    $response->data,
                ),
            ],
        );
    }

    public function create(CreateWebhookRequestDto $request): ResponseDtoWebhookResponseDto
    {
        return $this->client->requestMapped(
            'POST',
            '/v2/webhooks',
            [
                200 => ResponseDtoWebhookResponseDto::class,
                400 => ResponseDto::class,
            ],
            [],
            $request->toArray()
        );
    }

    public function getById(string $uuid): ResponseDtoWebhookDto
    {
        $this->uuidValidator->validate($uuid);

        return $this->client->requestMapped(
            'GET',
            '/v2/webhooks/' . $uuid,
            [
                200 => ResponseDtoWebhookDto::class,
                400 => ResponseDto::class,
            ]
        );
    }

    public function deleteById(string $uuid): ResponseDtoWebhookResponseDto
    {
        $this->uuidValidator->validate($uuid);

        return $this->client->requestMapped(
            'DELETE',
            '/v2/webhooks/' . $uuid,
            [
                200 => ResponseDtoWebhookResponseDto::class,
                400 => ResponseDto::class,
            ]
        );
    }
}
