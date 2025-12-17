<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2020 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Tests\Unit\Model;

use OAT\Library\TenantManagement\Model\Lti1p3Credentials;
use PHPUnit\Framework\TestCase;

class Lti1p3CredentialsTest extends TestCase
{
    /** @var Lti1p3Credentials */
    private $subject;

    protected function setUp(): void
    {
        $this->subject = new Lti1p3Credentials('clientId', 'jwksUrl', 'public key content');
    }

    public function testGetClientId(): void
    {
        $this->assertEquals('clientId', $this->subject->getClientId());
    }

    public function testGetJwksUrl(): void
    {
        $this->assertEquals('jwksUrl', $this->subject->getJwksUrl());
    }

    public function testGetPublicKey(): void
    {
        $this->assertEquals('public key content', $this->subject->getPublicKey());
    }

    public function testDefaultNullableValues(): void
    {
        $subject = new Lti1p3Credentials('clientId');

        $this->assertNull($subject->getPublicKey());
        $this->assertNull($subject->getJwksUrl());
    }
}
