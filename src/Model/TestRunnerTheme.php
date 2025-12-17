<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2019 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Model;

class TestRunnerTheme implements TestRunnerThemeInterface
{
    /** @var array */
    private $platform;

    /** @var array */
    private $testRunner;

    /** @var array */
    private $itemRunner;

    /** @var string */
    private $default;

    public function __construct(array $platform, array $testRunner, array $itemRunner, string $default)
    {
        $this->platform = $platform;
        $this->testRunner = $testRunner;
        $this->itemRunner = $itemRunner;
        $this->default = $default;
    }

    public function getPlatform(): array
    {
        return $this->platform;
    }

    public function getTestRunner(): array
    {
        return $this->testRunner;
    }

    public function getItemRunner(): array
    {
        return $this->itemRunner;
    }

    public function getDefault(): string
    {
        return $this->default;
    }
}
