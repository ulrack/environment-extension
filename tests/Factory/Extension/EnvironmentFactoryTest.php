<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\EnvironmentExtension\Tests\Factory\Extension;

use PHPUnit\Framework\TestCase;
use GrizzIt\Storage\Common\StorageInterface;
use Ulrack\Services\Common\ServiceFactoryInterface;
use Ulrack\Services\Exception\DefinitionNotFoundException;
use Ulrack\EnvironmentExtension\Factory\Extension\EnvironmentFactory;

/**
 * @coversDefaultClass \Ulrack\EnvironmentExtension\Factory\Extension\EnvironmentFactory
 */
class EnvironmentFactoryTest extends TestCase
{
    /**
     * @covers ::registerService
     * @covers ::getEnvironmentStorage
     * @covers ::getKeys
     * @covers ::create
     *
     * @return void
     */
    public function testComponent(): void
    {
        $serviceFactory = $this->createMock(ServiceFactoryInterface::class);
        $serviceFactory->expects(static::once())
            ->method('create')
            ->with('persistent.environment')
            ->willReturn($this->createMock(StorageInterface::class));

        $subject = new EnvironmentFactory(
            $serviceFactory,
            'environment',
            [],
            ['environment' => ['foo' => ['default' => null]]],
            (function () {
                return [];
            }),
            []
        );

        $this->assertEquals(['foo'], $subject->getKeys());
        $this->assertEquals(null, $subject->create('environment.foo'));

        $this->expectException(DefinitionNotFoundException::class);
        $subject->create('environment.bar');
    }
}
