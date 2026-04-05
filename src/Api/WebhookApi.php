<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\Webhook\CreateWebhookRequest;
use WishboxCdek\Request\Webhook\GetWebhooksRequest;

final class WebhookApi
{
    public function __construct(private readonly CdekClient $client)
    {
    }

    public function getAll(?GetWebhooksRequest $request = null): array
    {
        return $this->client->request('GET', '/v2/webhooks', ($request ?? new GetWebhooksRequest())->toArray());
    }

    public function create(CreateWebhookRequest $request): array
    {
        return $this->client->request('POST', '/v2/webhooks', [], $request->toArray());
    }

    public function getById(string $uuid): array
    {
        return $this->client->request('GET', '/v2/webhooks/' . $uuid);
    }

    public function deleteById(string $uuid): array
    {
        return $this->client->request('DELETE', '/v2/webhooks/' . $uuid);
    }
}
