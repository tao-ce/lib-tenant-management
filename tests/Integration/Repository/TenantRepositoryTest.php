<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2019 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Tests\Integration\Repository;

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Filesystem;
use OAT\Library\TenantManagement\Collection\TenantCollection;
use OAT\Library\TenantManagement\Exception\TenantNotFoundException;
use OAT\Library\TenantManagement\Factory\CustomerCollectionFactory;
use OAT\Library\TenantManagement\Model\Lti1p3CredentialsInterface;
use OAT\Library\TenantManagement\Model\TenantInterface;
use OAT\Library\TenantManagement\Repository\TenantRepository;
use PHPUnit\Framework\TestCase;

/**
 * @see tests/Resources/customers.json
 */
class TenantRepositoryTest extends TestCase
{
    /** @var TenantRepository */
    private $subject;

    protected function setUp(): void
    {
        $factory = new CustomerCollectionFactory(new Filesystem(new LocalFilesystemAdapter(__DIR__ . '/../../Resources/')));

        $this->subject = new TenantRepository($factory->createFromJsonFile('customers.json'));
    }

    public function testFindExistingTenant(): void
    {
        $tenant = $this->subject->find('1');

        $this->assertInstanceOf(TenantInterface::class, $tenant);
        $this->assertEquals('1', $tenant->getId());
    }

    public function testFindNonExistingTenant(): void
    {
        $this->expectException(TenantNotFoundException::class);
        $this->expectExceptionMessage('Tenant with id invalid not found');

        $this->subject->find('invalid');
    }

    public function testFindExistingTenantByLtiKey(): void
    {
        $tenant = $this->subject->findByLtiKey('aaa2');

        $this->assertInstanceOf(TenantInterface::class, $tenant);
        $this->assertEquals('1', $tenant->getId());
    }

    public function testFindNonExistingTenantByLtiKey(): void
    {
        $this->expectException(TenantNotFoundException::class);
        $this->expectExceptionMessage('Tenant with LTI key invalid not found');

        $this->subject->findByLtiKey('invalid');
    }

    public function testFindExistingTenantByOAuth2Key(): void
    {
        $tenant = $this->subject->findByOAuth2Key('hhh2');

        $this->assertInstanceOf(TenantInterface::class, $tenant);
        $this->assertEquals('5', $tenant->getId());
    }

    public function testFindNonExistingTenantByOAuth2Key(): void
    {
        $this->expectException(TenantNotFoundException::class);
        $this->expectExceptionMessage('Tenant with OAuth2 key invalid not found');

        $this->subject->findByOAuth2Key('invalid');
    }

    public function testFindExistingTenantByServiceUrl(): void
    {
        $tenant = $this->subject->findByServiceUrl('http://customer1.com/deliver/1');

        $this->assertInstanceOf(TenantInterface::class, $tenant);
        $this->assertEquals('2', $tenant->getId());

        $tenant = $this->subject->findByServiceUrl('https://customer3.com/api/v1/auth/launch-lti-1p3/');

        $this->assertInstanceOf(TenantInterface::class, $tenant);
        $this->assertEquals('lti1p3tool', $tenant->getId());
    }

    public function testFindNonExistingTenantByServiceUrl(): void
    {
        $this->expectException(TenantNotFoundException::class);
        $this->expectExceptionMessage('Tenant with service url invalid not found');

        $this->subject->findByServiceUrl('invalid');
    }

    public function testFindCollectionByCustomerId(): void
    {
        $customer1TenantsCollection = $this->subject->findCollectionByCustomerId('1');

        $this->assertInstanceOf(TenantCollection::class, $customer1TenantsCollection);
        $this->assertCount(3, $customer1TenantsCollection);

        foreach ($customer1TenantsCollection as $tenant) {
            $this->assertInstanceOf(TenantInterface::class, $tenant);
            $this->assertEquals('1', $tenant->getCustomerId());
        }

        $customer1DeliverTenantsCollection = $this->subject->findCollectionByCustomerId('1', 'Deliver');

        $this->assertCount(2, $customer1DeliverTenantsCollection);
        foreach ($customer1DeliverTenantsCollection as $tenant) {
            $this->assertInstanceOf(TenantInterface::class, $tenant);
            $this->assertEquals('1', $tenant->getCustomerId());
            $this->assertEquals('Deliver', $tenant->getServiceType());
        }

        $customer2ConstructTenantsCollection = $this->subject->findCollectionByCustomerId('2', 'Construct');

        $this->assertCount(1, $customer2ConstructTenantsCollection);

        $tenant = $customer2ConstructTenantsCollection->getIterator()->current();
        $this->assertInstanceOf(TenantInterface::class, $tenant);
        $this->assertEquals('2', $tenant->getCustomerId());
        $this->assertEquals('Construct', $tenant->getServiceType());
    }

    public function testFindTenantByAudience(): void
    {
        $tenant = $this->subject->findByAudience('https://customer3.com/platform');

        $this->assertInstanceOf(TenantInterface::class, $tenant);
        $this->assertEquals('https://customer3.com/platform', $tenant->getAudience());
    }

    public function testFindTenantByAudienceAndClientId(): void
    {
        $tenant = $this->subject->findByAudience('https://customer3.com/platform', 'client_id');

        $this->assertInstanceOf(TenantInterface::class, $tenant);
        $this->assertEquals('https://customer3.com/platform', $tenant->getAudience());

        $lti1p3CredentialsList = $tenant->getLti1p3Credentials();
        $this->assertCount(1, $lti1p3CredentialsList);

        foreach ($lti1p3CredentialsList as $lti1p3Credentials) {
            $this->assertInstanceOf(Lti1p3CredentialsInterface::class, $lti1p3Credentials);
            $this->assertEquals('client_id', $lti1p3Credentials->getClientId());
        }
    }

    public function testFindNotExistingTenantByAudience(): void
    {
        $this->expectException(TenantNotFoundException::class);
        $this->expectExceptionMessage("Tenant with audience 'invalid audience' not found");

        $this->subject->findByAudience('invalid audience');
    }

    public function testFindNotExistingTenantByAudienceAndClientId(): void
    {
        $this->expectException(TenantNotFoundException::class);
        $this->expectExceptionMessage("Tenant with audience 'https://customer3.com/platform' and client id 'invalid client id' not found");

        $this->subject->findByAudience('https://customer3.com/platform', 'invalid client id');
    }
}
