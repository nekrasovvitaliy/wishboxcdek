<?php

declare(strict_types=1);

namespace WishboxCdek\Api;

use WishboxCdek\CdekClient;
use WishboxCdek\Request\Intake\CreateIntakeRequest;
use WishboxCdek\Request\Intake\GetAvailableIntakeDaysRequest;
use WishboxCdek\Response\Async\AsyncResponse;
use WishboxCdek\Response\Error\SimplifiedResponseDto1;
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
        return $this->client->requestMapped(
            'POST',
            '/v2/intakes/availableDays',
            [
                200 => IntakeAvailableDaysResponse::class,
                400 => SimplifiedResponseDto1::class,
            ],
            [],
            $request->toArray()
        );
    }

    public function create(CreateIntakeRequest $request): AsyncResponse
    {
        return $this->client->requestMapped(
            'POST',
            '/v2/intakes',
            [
                202 => AsyncResponse::class,
                400 => SimplifiedResponseDto1::class,
            ],
            [],
            $request->toArray()
        );
    }

    public function getByUuid(string $uuid): OrderIntakeDto
    {
        $this->uuidValidator->validate($uuid);

        return $this->client->requestMapped(
            'GET',
            '/v2/intakes/' . $uuid,
            [
                200 => OrderIntakeDto::class,
                400 => SimplifiedResponseDto1::class,
            ],
            [],
            null,
            [],
            true,
            false
        );
    }

    public function delete(string $uuid): AsyncResponse
    {
        $this->uuidValidator->validate($uuid);

        return $this->client->requestMapped(
            'DELETE',
            '/v2/intakes/' . $uuid,
            [
                200 => AsyncResponse::class,
                400 => SimplifiedResponseDto1::class,
            ]
        );
    }
}
