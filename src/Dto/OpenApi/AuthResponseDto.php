<?php

declare(strict_types=1);

namespace WishboxCdek\Dto\OpenApi;

/**
 * OpenAPI schema: AuthResponseDto
 *
 * 200 OK
 */
final readonly class AuthResponseDto
{
    public ?string $accessToken;

    public ?string $tokenType;

    public ?int $expiresIn;

    public ?string $scope;

    public ?string $jti;

    public function __construct(
        ?string $accessToken = null,
        ?string $tokenType = null,
        ?int $expiresIn = null,
        ?string $scope = null,
        ?string $jti = null,
    ) {
        $this->accessToken = $accessToken;
        $this->tokenType = $tokenType;
        $this->expiresIn = $expiresIn;
        $this->scope = $scope;
        $this->jti = $jti;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            accessToken: isset($data['access_token']) ? (string) $data['access_token'] : null,
            tokenType: isset($data['token_type']) ? (string) $data['token_type'] : null,
            expiresIn: isset($data['expires_in']) ? (int) $data['expires_in'] : null,
            scope: isset($data['scope']) ? (string) $data['scope'] : null,
            jti: isset($data['jti']) ? (string) $data['jti'] : null,
        );
    }
}
