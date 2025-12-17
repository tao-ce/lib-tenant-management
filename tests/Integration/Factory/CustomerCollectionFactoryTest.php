<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2019 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Tests\Integration\Factory;

use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemOperator;
use OAT\Library\TenantManagement\Collection\CustomerCollection;
use OAT\Library\TenantManagement\Factory\CustomerCollectionFactory;
use OAT\Library\TenantManagement\Model\Customer;
use PHPUnit\Framework\TestCase;

class CustomerCollectionFactoryTest extends TestCase
{
    /** @var FilesystemOperator */
    private $filesystem;

    /** @var CustomerCollectionFactory */
    private $subject;

    protected function setUp(): void
    {
        $this->filesystem = new Filesystem(new LocalFilesystemAdapter(__DIR__ . '/../../Resources/'));

        $this->subject = new CustomerCollectionFactory($this->filesystem);
    }

    public function testCreateFromJsonFile(): void
    {
        $collection = $this->subject->createFromJsonFile('customers.json');

        $this->assertInstanceOf(CustomerCollection::class, $collection);
        $this->assertCount(3, $collection);

        foreach ($collection as $customer) {
            $this->assertInstanceOf(Customer::class, $customer);
        }
    }
}
