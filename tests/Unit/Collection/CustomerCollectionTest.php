<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2019 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Tests\Unit\Collection;

use OAT\Library\TenantManagement\Collection\CustomerCollection;
use OAT\Library\TenantManagement\Exception\CustomerNotFoundException;
use OAT\Library\TenantManagement\Model\Customer;
use OAT\Library\TenantManagement\Model\CustomerInterface;
use PHPUnit\Framework\TestCase;

class CustomerCollectionTest extends TestCase
{
    public function testConstructionAndCountAndRetrievalSuccess(): void
    {
        $subject = new CustomerCollection([
            new Customer('1', 'label', []),
            new Customer('2', 'label', [])
        ]);

        $this->assertCount(2, $subject);

        foreach ($subject as $customer) {
            $this->assertInstanceOf(CustomerInterface::class, $customer);
        }
    }

    public function testAddAndCheckAndRetrievalSuccess(): void
    {
        $subject = new CustomerCollection();
        $customer = new Customer('1', 'label', []);

        $subject->add($customer);

        $this->assertTrue($subject->has('1'));

        $this->assertSame($customer, $subject->get('1'));
    }

    public function testCheckAndRetrievalFailure(): void
    {
        $this->expectException(CustomerNotFoundException::class);
        $this->expectExceptionMessage('Customer with id invalid not found');

        $subject = new CustomerCollection();

        $this->assertFalse($subject->has('invalid'));

        $subject->get('invalid');
    }
}
