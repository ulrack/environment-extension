<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\EnvironmentExtension\Command;

use GrizzIt\Command\Common\Command\InputInterface;
use GrizzIt\Command\Common\Command\OutputInterface;
use GrizzIt\Command\Common\Command\CommandInterface;
use GrizzIt\Services\Common\Factory\ServiceFactoryInterface;

class EnvironmentGetCommand implements CommandInterface
{
    /**
     * Contains the service factory.
     *
     * @var ServiceFactoryInterface
     */
    private $serviceFactory;

    /**
     * Constructor.
     *
     * @param ServiceFactoryInterface $serviceFactory
     */
    public function __construct(ServiceFactoryInterface $serviceFactory)
    {
        $this->serviceFactory = $serviceFactory;
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
        $output->writeLine(
            json_encode(
                $this->serviceFactory->create(
                    'environment.' . $input->getParameter('key')
                )
            )
        );
    }
}
