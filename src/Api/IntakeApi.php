<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\Intake\CreateIntakeRequest;
use WishboxCdek\Request\Intake\GetAvailableIntakeDaysRequest;
use WishboxCdek\Response\Async\AsyncResponse;
use WishboxCdek\Response\Intake\IntakeAvailableDaysResponse;
use WishboxCdek\Response\Order\OrderIntakeDto;
use WishboxCdek\Validation\Uuid\UuidValidator;

final class IntakeApi
{
    private readonly UuidValidator $uuidValidator;

    public function __construct(private readonly CdekClient $client)
    {
        $this->uuidValidator = new UuidValidator();
    }

    public function getAvailableDays(GetAvailableIntakeDaysRequest $request): IntakeAvailableDaysResponse
    {
        return IntakeAvailableDaysResponse::fromArray(
            $this->client->request('POST', '/v2/intakes/availableDays', [], $request->toArray())
        );
    }

    public function create(CreateIntakeRequest $request): AsyncResponse
    {
        return AsyncResponse::fromArray(
            $this->client->request('POST', '/v2/intakes', [], $request->toArray())
        );
    }

    public function getByUuid(string $uuid): OrderIntakeDto
    {
        $this->uuidValidator->validate($uuid);

        return OrderIntakeDto::fromArray(
            $this->client->request('GET', '/v2/intakes/' . $uuid, [], null, [], true, false)
        );
    }

    public function delete(string $uuid): AsyncResponse
    {
        $this->uuidValidator->validate($uuid);

        return AsyncResponse::fromArray(
            $this->client->request('DELETE', '/v2/intakes/' . $uuid)
        );
    }
}
