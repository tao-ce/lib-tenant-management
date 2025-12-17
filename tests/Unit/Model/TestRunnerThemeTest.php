<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2019 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Tests\Unit\Model;

use OAT\Library\TenantManagement\Model\Credentials;
use OAT\Library\TenantManagement\Model\TestRunnerTheme;
use PHPUnit\Framework\TestCase;

class TestRunnerThemeTest extends TestCase
{
    /** @var TestRunnerTheme */
    private $subject;

    protected function setUp(): void
    {
        $this->subject = new TestRunnerTheme(['platform'], ['testRunner'], ['itemRunner'], 'default');
    }

    public function testGetPlatform(): void
    {
        $this->assertEquals(['platform'], $this->subject->getPlatform());
    }

    public function testGetTestRunner(): void
    {
        $this->assertEquals(['testRunner'], $this->subject->getTestRunner());
    }

    public function testGetItemRunner(): void
    {
        $this->assertEquals(['itemRunner'], $this->subject->getItemRunner());
    }

    public function testGetDefault(): void
    {
        $this->assertEquals('default', $this->subject->getDefault());
    }
}
