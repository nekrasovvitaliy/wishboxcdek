<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Auth;

final readonly class OAuthToken
{
    public function __construct(
        public string $accessToken,
        public ?string $tokenType = null,
        public ?int $expiresIn = null,
        public ?string $scope = null,
        public array $extra = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            accessToken: (string) ($data['access_token'] ?? ''),
            tokenType: isset($data['token_type']) ? (string) $data['token_type'] : null,
            expiresIn: isset($data['expires_in']) ? (int) $data['expires_in'] : null,
            scope: isset($data['scope']) ? (string) $data['scope'] : null,
            extra: array_diff_key($data, array_flip(['access_token', 'token_type', 'expires_in', 'scope'])),
        );
    }
}
