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
use OAT\Library\TenantManagement\Exception\CustomerNotFoundException;
use OAT\Library\TenantManagement\Model\CustomerInterface;

class CustomerCollection implements Countable, IteratorAggregate
{
    /** @var CustomerInterface[] */
    private $customers = [];

    public function __construct(array $customers = [])
    {
        foreach ($customers as $customer) {
            $this->add($customer);
        }
    }

    public function add(CustomerInterface $customer): self
    {
        $this->customers[$customer->getId()] = $customer;

        return $this;
    }

    /** @throws CustomerNotFoundException */
    public function get(string $customerId): CustomerInterface
    {
        if (!$this->has($customerId)) {
            throw new CustomerNotFoundException(sprintf('Customer with id %s not found', $customerId));
        }

        return $this->customers[$customerId];
    }

    public function has(string $customerId): bool
    {
        return array_key_exists($customerId, $this->customers);
    }

    /** @return CustomerInterface[] */
    public function all(): array
    {
        return array_values($this->customers);
    }

    public function count(): int
    {
        return $this->getIterator()->count();
    }

    /**
     * @return CustomerInterface[]|ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->all());
    }
}
