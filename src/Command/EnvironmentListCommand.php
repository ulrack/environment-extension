<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\EnvironmentExtension\Command;

use Exception;
use GrizzIt\Command\Common\Command\InputInterface;
use GrizzIt\Command\Common\Command\OutputInterface;
use GrizzIt\Configuration\Common\RegistryInterface;
use GrizzIt\Command\Common\Command\CommandInterface;

class EnvironmentListCommand implements CommandInterface
{
    /**
     * Contains the databases service factory.
     *
     * @var RegistryInterface
     */
    private $configRegistry;

    /**
     * Constructor.
     *
     * @param RegistryInterface $serviceRegsitry
     */
    public function __construct(RegistryInterface $configRegistry)
    {
        $this->configRegistry = $configRegistry;
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
        $keys = array_keys(
            array_merge(
                ...array_column(
                    $this->configRegistry->toArray()['services'],
                    'environment'
                )
            )
        );

        if (count($keys) > 0) {
            $output->outputList($keys);

            return;
        }

        throw new Exception('No available keys.');
    }
}
