<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2020 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Model;

interface Lti1p3CredentialsInterface
{
    public function getClientId(): string;

    public function getJwksUrl(): ?string;

    public function getPublicKey(): ?string;
}
