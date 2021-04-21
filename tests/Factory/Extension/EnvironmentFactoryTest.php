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
     * @covers ::create
     *
     * @return void
     */
    public function testComponent(): void
    {
        $storage = $this->createMock(StorageInterface::class);

        $create = function (string $key) use ($storage) {
            if ($key === 'persistent.environment') {
                return $storage;
            }
        };

        $subject = new EnvironmentFactory();

        $storage->expects(static::once())
            ->method('has')
            ->with('environment.foo')
            ->willReturn(false);

        $storage->expects(static::once())
            ->method('set')
            ->with('environment.foo', true);

        $storage->expects(static::once())
            ->method('get')
            ->with('environment.foo')
            ->willReturn(true);

        $this->assertEquals(
            true,
            $subject->create('environment.foo', ['default' => true], $create)
        );
    }
}
