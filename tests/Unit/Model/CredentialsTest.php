<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2019 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Tests\Unit\Model;

use OAT\Library\TenantManagement\Model\Credentials;
use PHPUnit\Framework\TestCase;

class CredentialsTest extends TestCase
{
    /** @var Credentials */
    private $subject;

    protected function setUp(): void
    {
        $this->subject = new Credentials('key', 'secret', ['role1', 'role2'], 'sourceId1');
    }

    public function testGetKey(): void
    {
        $this->assertEquals('key', $this->subject->getKey());
    }

    public function testGetSecret(): void
    {
        $this->assertEquals('secret', $this->subject->getSecret());
    }

    public function testGetRoles(): void
    {
        $this->assertEquals(['role1', 'role2'], $this->subject->getRoles());
    }

    public function testGetSourceId(): void
    {
        $this->assertEquals('sourceId1', $this->subject->getSourceId());
    }
}
