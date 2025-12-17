<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2020 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Model;

class Lti1p3Credentials implements Lti1p3CredentialsInterface
{
    /** @var string */
    private $clientId;

    /** @var string|null */
    private $jwksUrl;

    /** @var string|null */
    private $publicKey;

    public function __construct(string $clientId, string $jwksUrl = null, string $publicKey = null)
    {
        $this->clientId = $clientId;
        $this->jwksUrl = $jwksUrl;
        $this->publicKey = $publicKey;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getJwksUrl(): ?string
    {
        return $this->jwksUrl;
    }

    public function getPublicKey(): ?string
    {
        return $this->publicKey;
    }
}
