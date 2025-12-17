<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2019 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Tests\Unit\Model;

use OAT\Library\TenantManagement\Model\Customer;
use OAT\Library\TenantManagement\Model\Credentials;
use OAT\Library\TenantManagement\Model\Tenant;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    /** @var Customer */
    private $subject;

    protected function setUp(): void
    {
        $tenant1= new Tenant(
            'tenantId1',
            'customerId',
            'audience1',
            'Tenant label 1',
            'serviceType',
            ['serviceUrl'],
            [new Credentials('ltiKey', 'ltiSecret', ['role'], 'sourceId')],
            [new Credentials('oAuth2Key', 'oAuth2Secret', ['role'], 'sourceId')]
        );

        $tenant2= new Tenant(
            'tenantId2',
            'customerId',
            'audience2',
            'Tenant label 2',
            'serviceType',
            ['serviceUrl'],
            [new Credentials('ltiKey', 'ltiSecret', ['role'], 'sourceId')],
            [new Credentials('oAuth2Key', 'oAuth2Secret', ['role'], 'sourceId')]
        );

        $this->subject = new Customer('customerId', 'Customer label', [$tenant1, $tenant2]);
    }

    public function testGetId(): void
    {
        $this->assertEquals('customerId', $this->subject->getId());
    }

    public function testGetLabel(): void
    {
        $this->assertEquals('Customer label', $this->subject->getLabel());
    }

    public function testGetTenants(): void
    {
        $this->assertCount(2, $this->subject->getTenants());

        foreach ($this->subject->getTenants() as $tenant) {
            $this->assertInstanceOf(Tenant::class, $tenant);
            $this->assertEquals('customerId', $tenant->getCustomerId());
        }
    }
}
