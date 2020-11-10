<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\EnvironmentExtension\Command;

use Exception;
use Ulrack\Command\Common\Command\InputInterface;
use Ulrack\Command\Common\Command\OutputInterface;
use Ulrack\Command\Common\Command\CommandInterface;
use Ulrack\Services\Common\ServiceFactoryInterface;
use Ulrack\EnvironmentExtension\Factory\Extension\EnvironmentFactory;

class EnvironmentListCommand implements CommandInterface
{
    /**
     * Contains the environment factory.
     *
     * @var EnvironmentFactory
     */
    private $environmentFactory;

    /**
     * Constructor.
     *
     * @param EnvironmentFactory $environmentFactory
     */
    public function __construct(EnvironmentFactory $environmentFactory)
    {
        $this->environmentFactory = $environmentFactory;
    }

    /**
     * Executes the command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function __invoke(
        InputInterface $input,
        OutputInterface $output
    ): void {
        $keys = $this->environmentFactory->getKeys();
        if (count($keys) > 0) {
            $output->outputList($keys);

            return;
        }

        throw new Exception('No available keys.');
    }
}
