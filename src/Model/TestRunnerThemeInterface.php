<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2019 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Model;

interface TestRunnerThemeInterface
{
    public function getPlatform(): array;

    public function getTestRunner(): array;

    public function getItemRunner(): array;

    public function getDefault(): string;
}
