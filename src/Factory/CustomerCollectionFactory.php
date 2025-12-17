<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2019 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Factory;

use League\Flysystem\FilesystemOperator;
use League\Flysystem\UnableToReadFile;
use OAT\Library\TenantManagement\Collection\CustomerCollection;
use OAT\Library\TenantManagement\Model\Customer;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CustomerCollectionFactory
{
    /** @var FilesystemOperator */
    private $customersStorage;

    /** @var Serializer */
    private $serializer;

    public function __construct(FilesystemOperator $customersStorage)
    {
        $this->customersStorage = $customersStorage;
        $this->serializer = $this->buildSerializer();
    }

    /**
     * @throws UnableToReadFile
     * @throws ExceptionInterface
     */
    public function createFromJsonFile(string $jsonFilePath): CustomerCollection
    {
        $collection = new CustomerCollection();
        $data = $this->customersStorage->read($jsonFilePath);

        foreach ($this->serializer->deserialize($data, Customer::class . '[]', 'json') as $customer) {
            $collection->add($customer);
        }

        return $collection;
    }

    private function buildSerializer(): Serializer
    {
        return new Serializer(
            [
                new ObjectNormalizer(null, null, null, new PhpDocExtractor()),
                new ArrayDenormalizer()
            ],
            [
                new JsonEncoder()
            ]
        );
    }
}
