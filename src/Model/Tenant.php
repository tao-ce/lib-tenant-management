<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2019 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Model;

class Tenant implements TenantInterface
{
    /** @var string */
    private $id;

    /** @var string */
    private $customerId;

    /** @var string */
    private $audience;

    /** @var string */
    private $label;

    /** @var string */
    private $serviceType;

    /** @var string[] */
    private $serviceUrls;

    /** @var Credentials[]|null */
    private $lti1p0Credentials;

    /** @var Lti1p3Credentials[]|null */
    private $lti1p3Credentials;

    /** @var Credentials[]|null */
    private $oAuth2Credentials;

    /** @var array|null */
    private $preferences;

    /** @var TestRunnerTheme|null */
    private $testRunnerTheme;

    /** @var array|null */
    private $testRunnerConfiguration;

    public function __construct(
        string $id,
        string $customerId,
        string $audience,
        string $label,
        string $serviceType,
        array $serviceUrls,
        array $lti1p0Credentials = null,
        array $lti1p3Credentials = null,
        array $oAuth2Credentials = null,
        array $preferences = null,
        TestRunnerThemeInterface $testRunnerTheme = null,
        array $testRunnerConfiguration = null
    ) {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->audience = $audience;
        $this->label = $label;
        $this->serviceType = $serviceType;
        $this->serviceUrls = $serviceUrls;
        $this->lti1p0Credentials = $lti1p0Credentials;
        $this->lti1p3Credentials = $lti1p3Credentials;
        $this->oAuth2Credentials = $oAuth2Credentials;
        $this->preferences = $preferences;
        $this->testRunnerTheme = $testRunnerTheme;
        $this->testRunnerConfiguration = $testRunnerConfiguration;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getAudience(): string
    {
        return $this->audience;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getServiceType(): string
    {
        return $this->serviceType;
    }

    public function getServiceUrls(): array
    {
        return $this->serviceUrls;
    }

    /** @return CredentialsInterface[]|null */
    public function getLti1p0Credentials(): ?array
    {
        return $this->lti1p0Credentials;
    }

    /** @return Lti1p3CredentialsInterface[]|null */
    public function getLti1p3Credentials(): ?array
    {
        return $this->lti1p3Credentials;
    }

    /** @return CredentialsInterface[]|null */
    public function getOAuth2Credentials(): ?array
    {
        return $this->oAuth2Credentials;
    }

    public function getPreferences(): ?array
    {
        return $this->preferences;
    }

    public function getTestRunnerTheme(): ?TestRunnerThemeInterface
    {
        return $this->testRunnerTheme;
    }

    public function getTestRunnerConfiguration(): ?array
    {
        return $this->testRunnerConfiguration;
    }
}
