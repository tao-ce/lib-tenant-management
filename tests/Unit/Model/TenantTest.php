<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2019 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\TenantManagement\Tests\Unit\Model;

use OAT\Library\TenantManagement\Model\Credentials;
use OAT\Library\TenantManagement\Model\Lti1p3Credentials;
use OAT\Library\TenantManagement\Model\Tenant;
use OAT\Library\TenantManagement\Model\TestRunnerTheme;
use OAT\Library\TenantManagement\Model\TestRunnerThemeInterface;
use PHPUnit\Framework\TestCase;

class TenantTest extends TestCase
{
    /** @var Tenant */
    private $subject;

    protected function setUp(): void
    {
        $this->subject = new Tenant(
            'id',
            'customerId',
            'audience',
            'label',
            'serviceType',
            [
                'service1' => 'service 1 url',
                'service2' => 'service 2 url'
            ],
            [
                new Credentials('ltiKey', 'ltiSecret', ['role1'], 'sourceId1'),
                new Credentials('ltiKey', 'ltiSecret', ['role1'], 'sourceId1'),
            ],
            [
                new Lti1p3Credentials('clientId'),
            ],
            [
                new Credentials('oAuth2Key', 'oAuth2Secret', ['role2'], 'sourceId2'),
                new Credentials('oAuth2Key', 'oAuth2Secret', ['role2'], 'sourceId2'),
            ],
            [
                'some' => 'preference'
            ],
            new TestRunnerTheme(['platform'], ['testRunner'], ['itemRunner'], 'default'),
            ['foo' => 'bar']
        );
    }

    public function testGetId(): void
    {
        $this->assertEquals('id', $this->subject->getId());
    }

    public function testGetCustomerId(): void
    {
        $this->assertEquals('customerId', $this->subject->getCustomerId());
    }

    public function testGetLabel(): void
    {
        $this->assertEquals('label', $this->subject->getLabel());
    }

    public function testGetServiceType(): void
    {
        $this->assertEquals('serviceType', $this->subject->getServiceType());
    }

    public function testGetLti1p0Credentials(): void
    {
        $this->assertCount(2, $this->subject->getLti1p0Credentials());

        foreach ($this->subject->getLti1p0Credentials() ?? [] as $ltiCredentials) {
            $this->assertInstanceOf(Credentials::class, $ltiCredentials);
            $this->assertEquals('ltiKey', $ltiCredentials->getKey());
            $this->assertEquals('ltiSecret', $ltiCredentials->getSecret());
            $this->assertEquals(['role1'], $ltiCredentials->getRoles());
            $this->assertEquals('sourceId1', $ltiCredentials->getSourceId());
        }
    }

    public function testGetOAuth2Credentials(): void
    {
        $this->assertCount(2, $this->subject->getOAuth2Credentials());

        foreach ($this->subject->getOAuth2Credentials() ?? [] as $OAuth2Credentials) {
            $this->assertInstanceOf(Credentials::class, $OAuth2Credentials);
            $this->assertEquals('oAuth2Key', $OAuth2Credentials->getKey());
            $this->assertEquals('oAuth2Secret', $OAuth2Credentials->getSecret());
            $this->assertEquals(['role2'], $OAuth2Credentials->getRoles());
            $this->assertEquals('sourceId2', $OAuth2Credentials->getSourceId());
        }
    }

    public function testGetPreferences(): void
    {
        $this->assertEquals(['some' => 'preference'], $this->subject->getPreferences());
    }

    public function testGetTestRunnerTheme(): void
    {
        $theme = $this->subject->getTestRunnerTheme();

        $this->assertInstanceOf(TestRunnerThemeInterface::class, $theme);
        $this->assertEquals(['platform'], $theme->getPlatform());
        $this->assertEquals(['testRunner'], $theme->getTestRunner());
        $this->assertEquals(['itemRunner'], $theme->getItemRunner());
        $this->assertEquals('default', $theme->getDefault());
    }

    public function testGetTestRunnerConfiguration(): void
    {
        $config = $this->subject->getTestRunnerConfiguration();

        $this->assertIsArray($config);
        $this->assertSame(['foo' => 'bar'], $config);
    }

    public function testGetServiceUrls(): void
    {
        $this->assertEquals(
            [
                'service1' => 'service 1 url',
                'service2' => 'service 2 url'
            ],
            $this->subject->getServiceUrls()
        );
    }

    public function testGetAudience(): void
    {
        $this->assertEquals('audience', $this->subject->getAudience());
    }

    public function testGetLti1p3Credentials(): void
    {
        $this->assertCount(1, $this->subject->getLti1p3Credentials());

        foreach ($this->subject->getLti1p3Credentials() as $lti1p3Credentials) {
            $this->assertInstanceOf(Lti1p3Credentials::class, $lti1p3Credentials);
            $this->assertEquals('clientId', $lti1p3Credentials->getClientId());
            $this->assertNull($lti1p3Credentials->getJwksUrl());
            $this->assertNull($lti1p3Credentials->getPublicKey());
        }
    }
}
