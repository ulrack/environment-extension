<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\EnvironmentExtension\Tests\Command;

use Exception;
use PHPUnit\Framework\TestCase;
use Ulrack\Command\Common\Command\InputInterface;
use Ulrack\Command\Common\Command\OutputInterface;
use Ulrack\EnvironmentExtension\Command\EnvironmentListCommand;
use Ulrack\EnvironmentExtension\Factory\Extension\EnvironmentFactory;

/**
 * @coversDefaultClass \Ulrack\EnvironmentExtension\Command\EnvironmentListCommand
 */
class EnvironmentListCommandTest extends TestCase
{
    /**
     * @covers ::__invoke
     * @covers ::__construct
     *
     * @return void
     */
    public function testInvoke(): void
    {
        $serviceFactory = $this->createMock(EnvironmentFactory::class);
        $output = $this->createMock(OutputInterface::class);
        $subject = new EnvironmentListCommand($serviceFactory);
        $serviceFactory->expects(static::once())
            ->method('getKeys')
            ->willReturn(['foo', 'bar']);

        $output->expects(static::once())
            ->method('outputList')
            ->with(['foo', 'bar']);

        $subject->__invoke(
            $this->createMock(InputInterface::class),
            $output
        );
    }

    /**
     * @covers ::__invoke
     * @covers ::__construct
     *
     * @return void
     */
    public function testInvokeNoKeys(): void
    {
        $serviceFactory = $this->createMock(EnvironmentFactory::class);
        $subject = new EnvironmentListCommand($serviceFactory);
        $serviceFactory->expects(static::once())
            ->method('getKeys')
            ->willReturn([]);

        $this->expectException(Exception::class);
        $subject->__invoke(
            $this->createMock(InputInterface::class),
            $this->createMock(OutputInterface::class)
        );
    }
}
