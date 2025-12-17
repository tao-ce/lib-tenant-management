<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2019 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Collection;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use OAT\Library\TenantManagement\Exception\TenantNotFoundException;
use OAT\Library\TenantManagement\Model\TenantInterface;

class TenantCollection implements Countable, IteratorAggregate
{
    /** @var TenantInterface[] */
    private $tenants = [];

    public function __construct(array $tenants = [])
    {
        foreach ($tenants as $tenant) {
            $this->add($tenant);
        }
    }

    public function add(TenantInterface $tenant): self
    {
        $this->tenants[$tenant->getId()] = $tenant;

        return $this;
    }

    /** @throws TenantNotFoundException */
    public function get(string $tenantId): TenantInterface
    {
        if (!$this->has($tenantId)) {
            throw new TenantNotFoundException(sprintf('Tenant with id %s not found', $tenantId));
        }

        return $this->tenants[$tenantId];
    }

    public function has(string $tenantId): bool
    {
        return array_key_exists($tenantId, $this->tenants);
    }

    /** @return TenantInterface[] */
    public function all(): array
    {
        return array_values($this->tenants);
    }

    public function count(): int
    {
        return $this->getIterator()->count();
    }

    /**
     * @return TenantInterface[]|ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->all());
    }
}
