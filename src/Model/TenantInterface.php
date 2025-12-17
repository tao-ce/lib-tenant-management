<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2019 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Model;

interface TenantInterface
{
    public function getId(): string;

    public function getCustomerId(): string;

    public function getLabel(): string;

    public function getAudience(): string;

    public function getServiceType(): string;

    public function getServiceUrls(): array;

    /** @return CredentialsInterface[]|null */
    public function getLti1p0Credentials(): ?array;

    /** @return Lti1p3CredentialsInterface[]|null */
    public function getLti1p3Credentials(): ?array;

    /** @return CredentialsInterface[]|null */
    public function getOAuth2Credentials(): ?array;

    public function getPreferences(): ?array;

    public function getTestRunnerTheme(): ?TestRunnerThemeInterface;

    public function getTestRunnerConfiguration(): ?array;
}
