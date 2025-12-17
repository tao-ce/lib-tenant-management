<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2019 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Tests\Unit\Collection;

use OAT\Library\TenantManagement\Collection\TenantCollection;
use OAT\Library\TenantManagement\Exception\TenantNotFoundException;
use OAT\Library\TenantManagement\Model\Tenant;
use OAT\Library\TenantManagement\Model\TenantInterface;
use PHPUnit\Framework\TestCase;

class TenantCollectionTest extends TestCase
{
    public function testConstructionAndCountAndRetrievalSuccess(): void
    {
        $subject = new TenantCollection([
            new Tenant('1', '1', 'audience1', 'label', 'serviceType', ['serviceUrl']),
            new Tenant('2', '1', 'audience2', 'label', 'serviceType', ['serviceUrl']),
        ]);

        $this->assertCount(2, $subject);

        foreach ($subject as $tenant) {
            $this->assertInstanceOf(TenantInterface::class, $tenant);
        }
    }

    public function testAddAndCheckAndRetrievalSuccess(): void
    {
        $subject = new TenantCollection();
        $tenant = new Tenant('1', '1', 'audience1', 'label', 'serviceType', ['serviceUrl']);

        $subject->add($tenant);

        $this->assertTrue($subject->has('1'));

        $this->assertSame($tenant, $subject->get('1'));
    }

    public function testCheckAndRetrievalFailure(): void
    {
        $this->expectException(TenantNotFoundException::class);
        $this->expectExceptionMessage('Tenant with id invalid not found');

        $subject = new TenantCollection();

        $this->assertFalse($subject->has('invalid'));

        $subject->get('invalid');
    }
}
