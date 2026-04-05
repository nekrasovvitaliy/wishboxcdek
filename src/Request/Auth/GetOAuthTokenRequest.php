<?php

declare(strict_types=1);

namespace WishboxCdek\Request\Auth;

use WishboxCdek\Request\RequestData;

final readonly class GetOAuthTokenRequest extends RequestData
{
    public function __construct(
        public ?string $account = null,
        public ?string $password = null,
        public string $grantType = 'client_credentials'
    ) {
    }

    public function toArray(): array
    {
        return $this->filterNulls([
            'grant_type' => $this->grantType,
            'client_id' => $this->account,
            'client_secret' => $this->password,
        ]);
    }
}
