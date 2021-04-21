<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\EnvironmentExtension\Tests\Command;

use Exception;
use PHPUnit\Framework\TestCase;
use GrizzIt\Command\Common\Command\InputInterface;
use GrizzIt\Command\Common\Command\OutputInterface;
use GrizzIt\Configuration\Common\RegistryInterface;
use Ulrack\EnvironmentExtension\Command\EnvironmentListCommand;

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
        $registry = $this->createMock(RegistryInterface::class);
        $output = $this->createMock(OutputInterface::class);
        $subject = new EnvironmentListCommand($registry);

        $registry->expects(static::once())
            ->method('toArray')
            ->willReturn([
                'services' => [
                    [
                        'environment' => [
                            'foo' => true
                        ]
                    ],
                    [
                        'environment' => [
                            'bar' => true
                        ]
                    ]
                ]
            ]);

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
        $registry = $this->createMock(RegistryInterface::class);
        $subject = new EnvironmentListCommand($registry);

        $registry->expects(static::once())
            ->method('toArray')
            ->willReturn([
                'services' => []
            ]);

        $this->expectException(Exception::class);
        $subject->__invoke(
            $this->createMock(InputInterface::class),
            $this->createMock(OutputInterface::class)
        );
    }
}
