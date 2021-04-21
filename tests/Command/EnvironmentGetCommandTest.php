<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\EnvironmentExtension\Tests\Command;

use PHPUnit\Framework\TestCase;
use GrizzIt\Command\Common\Command\InputInterface;
use GrizzIt\Command\Common\Command\OutputInterface;
use GrizzIt\Services\Common\Factory\ServiceFactoryInterface;
use Ulrack\EnvironmentExtension\Command\EnvironmentGetCommand;

/**
 * @coversDefaultClass \Ulrack\EnvironmentExtension\Command\EnvironmentGetCommand
 */
class EnvironmentGetCommandTest extends TestCase
{
    /**
     * @covers ::__invoke
     * @covers ::__construct
     *
     * @return void
     */
    public function testInvoke(): void
    {
        $serviceFactory = $this->createMock(ServiceFactoryInterface::class);
        $input = $this->createMock(InputInterface::class);
        $output = $this->createMock(OutputInterface::class);
        $subject = new EnvironmentGetCommand($serviceFactory);

        $input->expects(static::once())
            ->method('getParameter')
            ->with('key')
            ->willReturn('foo');

        $serviceFactory->expects(static::once())
            ->method('create')
            ->with('environment.foo')
            ->willReturn('bar');

        $output->expects(static::once())
            ->method('writeLine')
            ->with('"bar"');

        $subject->__invoke(
            $input,
            $output
        );
    }
}
