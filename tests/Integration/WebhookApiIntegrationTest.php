<?php

declare(strict_types=1);

namespace Tests\Integration;

use WishboxCdek\Dto\OpenApi\ResponseDtoWebhookResponseDto;
use WishboxCdek\Request\Webhook\CreateWebhookRequestDto;

final class WebhookApiIntegrationTest extends CdekIntegrationTestCase
{
    public function test_create_webhook_returns_typed_response(): void
    {
        $client = $this->createClient();
        $webhookUuid = null;

        try {
            $response = $client->webhooks()
                ->create(new CreateWebhookRequestDto(
                    type: 'ORDER_STATUS',
                    url: 'https://example.com/cdek-webhook-test-' . bin2hex(random_bytes(8)),
                ));

            self::assertInstanceOf(ResponseDtoWebhookResponseDto::class, $response);
            self::assertNotNull($response->entity);
            self::assertNotSame('', $response->entity?->uuid ?? '');

            $webhookUuid = $response->entity?->uuid;
        } finally {
            if ($webhookUuid !== null && $webhookUuid !== '') {
                $client->webhooks()
                    ->deleteById($webhookUuid);
            }
        }
    }
}
