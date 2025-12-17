<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2019 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Model;

class Credentials implements CredentialsInterface
{
    /** @var string */
    private $key;

    /** @var string */
    private $secret;

    /** @var string[] */
    private $roles;

    /** @var string|null */
    private $sourceId;

    public function __construct(string $key, string $secret, array $roles, string $sourceId = null)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->roles = $roles;
        $this->sourceId = $sourceId;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getSourceId(): ?string
    {
        return $this->sourceId;
    }
}
