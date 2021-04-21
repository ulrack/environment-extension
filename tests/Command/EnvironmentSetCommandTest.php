<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\EnvironmentExtension\Tests\Command;

use PHPUnit\Framework\TestCase;
use GrizzIt\Storage\Common\StorageInterface;
use GrizzIt\Command\Common\Command\InputInterface;
use GrizzIt\Command\Common\Command\OutputInterface;
use Ulrack\EnvironmentExtension\Command\EnvironmentSetCommand;

/**
 * @coversDefaultClass \Ulrack\EnvironmentExtension\Command\EnvironmentSetCommand
 */
class EnvironmentSetCommandTest extends TestCase
{
    /**
     * @covers ::__invoke
     * @covers ::__construct
     *
     * @return void
     */
    public function testInvoke(): void
    {
        $storage = $this->createMock(StorageInterface::class);
        $input = $this->createMock(InputInterface::class);
        $subject = new EnvironmentSetCommand($storage);

        $input->expects(static::exactly(2))
            ->method('getParameter')
            ->withConsecutive(['value'], ['key'])
            ->willReturnOnConsecutiveCalls('bar', 'foo');

        $storage->expects(static::once())
            ->method('set')
            ->with('environment.foo', 'bar');

        $subject->__invoke(
            $input,
            $this->createMock(OutputInterface::class)
        );
    }

    /**
     * @covers ::__invoke
     * @covers ::__construct
     *
     * @return void
     */
    public function testInvokeJson(): void
    {
        $storage = $this->createMock(StorageInterface::class);
        $input = $this->createMock(InputInterface::class);
        $subject = new EnvironmentSetCommand($storage);

        $input->expects(static::exactly(2))
            ->method('getParameter')
            ->withConsecutive(['value'], ['key'])
            ->willReturnOnConsecutiveCalls('{"foo":"bar"}', 'foo');

        $storage->expects(static::once())
            ->method('set')
            ->with('environment.foo', ['foo' => 'bar']);

        $subject->__invoke(
            $input,
            $this->createMock(OutputInterface::class)
        );
    }
}
