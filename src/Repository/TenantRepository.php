<?php declare(strict_types=1);

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2019 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License
namespace OAT\Library\TenantManagement\Repository;

use OAT\Library\TenantManagement\Collection\CustomerCollection;
use OAT\Library\TenantManagement\Collection\TenantCollection;
use OAT\Library\TenantManagement\Exception\NotFoundExceptionInterface;
use OAT\Library\TenantManagement\Exception\TenantNotFoundException;
use OAT\Library\TenantManagement\Model\TenantInterface;

class TenantRepository
{
    /** @var CustomerCollection */
    private $customers;

    public function __construct(CustomerCollection $customers)
    {
        $this->customers = $customers;
    }

    /**
     * @throws NotFoundExceptionInterface
     */
    public function find(string $tenantId): TenantInterface
    {
        foreach ($this->customers as $customer) {
            foreach ($customer->getTenants() as $tenant) {
                if ($tenant->getId() === $tenantId) {
                    return $tenant;
                }
            }
        }

        throw new TenantNotFoundException(sprintf('Tenant with id %s not found', $tenantId));
    }

    /**
     * @throws NotFoundExceptionInterface
     */
    public function findByLtiKey(string $ltiKey): TenantInterface
    {
        foreach ($this->customers as $customer) {
            foreach ($customer->getTenants() as $tenant) {
                foreach ($tenant->getLti1p0Credentials() ?? [] as $credentials) {
                    if ($credentials->getKey() === $ltiKey) {
                        return $tenant;
                    }
                }
            }
        }

        throw new TenantNotFoundException(sprintf('Tenant with LTI key %s not found', $ltiKey));
    }

    /**
     * @throws NotFoundExceptionInterface
     */
    public function findByOAuth2Key(string $oAuth2Key): TenantInterface
    {
        foreach ($this->customers as $customer) {
            foreach ($customer->getTenants() as $tenant) {
                foreach ($tenant->getOAuth2Credentials() ?? [] as $credentials) {
                    if ($credentials->getKey() === $oAuth2Key) {
                        return $tenant;
                    }
                }
            }
        }

        throw new TenantNotFoundException(sprintf('Tenant with OAuth2 key %s not found', $oAuth2Key));
    }

    /**
     * @throws NotFoundExceptionInterface
     */
    public function findByServiceUrl(string $serviceUrl): TenantInterface
    {
        foreach ($this->customers as $customer) {
            foreach ($customer->getTenants() as $tenant) {
                if (in_array($serviceUrl, $tenant->getServiceUrls())) {
                    return $tenant;
                }
            }
        }

        throw new TenantNotFoundException(sprintf('Tenant with service url %s not found', $serviceUrl));
    }

    /**
     * @throws NotFoundExceptionInterface
     */
    public function findByAudience(string $audience, string $clientId = null): TenantInterface
    {
        foreach ($this->customers as $customer) {
            foreach ($customer->getTenants() as $tenant) {
                if ($tenant->getAudience() === $audience) {
                    if (null === $clientId) {
                        return $tenant;
                    }

                    foreach ($tenant->getLti1p3Credentials() ?? [] as $credentials) {
                        if ($credentials->getClientId() === $clientId) {
                            return $tenant;
                        }
                    }
                }
            }
        }

        if (null === $clientId) {
            $message = sprintf("Tenant with audience '%s' not found", $audience);
        } else {
            $message = sprintf("Tenant with audience '%s' and client id '%s' not found", $audience, $clientId);
        }

        throw new TenantNotFoundException($message);
    }

    /**
     * @throws NotFoundExceptionInterface
     */
    public function findCollectionByCustomerId(string $customerId, string $serviceType = null): TenantCollection
    {
        $customer = $this->customers->get($customerId);

        if (null === $serviceType) {
            return new TenantCollection($customer->getTenants());
        }

        $collection = new TenantCollection();
        foreach ($customer->getTenants() as $tenant) {
            if ($tenant->getServiceType() === $serviceType) {
                $collection->add($tenant);
            }
        }

        return $collection;
    }
}
