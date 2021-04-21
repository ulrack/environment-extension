<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\EnvironmentExtension\Command;

use GrizzIt\Storage\Common\StorageInterface;
use GrizzIt\Command\Common\Command\InputInterface;
use GrizzIt\Command\Common\Command\OutputInterface;
use GrizzIt\Command\Common\Command\CommandInterface;

class EnvironmentSetCommand implements CommandInterface
{
    /**
     * Contains the service factory.
     *
     * @var StorageInterface
     */
    private $environmentStorage;

    /**
     * Constructor.
     *
     * @param StorageInterface $environmentStorage
     */
    public function __construct(StorageInterface $environmentStorage)
    {
        $this->environmentStorage = $environmentStorage;
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
        $value = $input->getParameter('value');

        $jsonValue = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $value = $jsonValue;
        }

        $this->environmentStorage->set(
            'environment.' . $input->getParameter('key'),
            $value
        );
    }
}
