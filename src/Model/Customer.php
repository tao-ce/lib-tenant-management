<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2019 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Model;

class Customer implements CustomerInterface
{
    /** @var string */
    private $id;

    /** @var string */
    private $label;

    /** @var Tenant[] */
    private $tenants;

    public function __construct(string $id, string $label, array $tenants)
    {
        $this->id = $id;
        $this->label = $label;
        $this->tenants = $tenants;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    /** @return TenantInterface[] */
    public function getTenants(): array
    {
        return $this->tenants;
    }
}
