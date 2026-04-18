<?php

declare(strict_types=1);

namespace WishboxCdek\Response\Auth;

use WishboxCdek\Exception\CdekException;

final readonly class OAuthToken
{
    public function __construct(
        public string $accessToken,
        public string $tokenType,
        public int $expiresIn,
        public string $scope,
        public string $jti,
        public array $extra = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        $accessToken = self::requireNonEmptyString($data, 'access_token');
        $tokenType = self::requireNonEmptyString($data, 'token_type');
        $scope = self::requireNonEmptyString($data, 'scope');
        $jti = self::requireNonEmptyString($data, 'jti');

        if (!isset($data['expires_in']) || !is_int($data['expires_in']) && !ctype_digit((string) $data['expires_in'])) {
            throw new CdekException('CDEK OAuth response does not contain a valid expires_in.');
        }

        return new self(
            accessToken: $accessToken,
            tokenType: $tokenType,
            expiresIn: (int) $data['expires_in'],
            scope: $scope,
            jti: $jti,
            extra: array_diff_key($data, array_flip(['access_token', 'token_type', 'expires_in', 'scope', 'jti'])),
        );
    }

    private static function requireNonEmptyString(array $data, string $key): string
    {
        if (!isset($data[$key])) {
            throw new CdekException(sprintf('CDEK OAuth response does not contain %s.', $key));
        }

        $value = trim((string) $data[$key]);

        if ($value === '') {
            throw new CdekException(sprintf('CDEK OAuth response contains an empty %s.', $key));
        }

        return $value;
    }
}
