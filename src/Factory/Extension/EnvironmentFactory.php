<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\EnvironmentExtension\Factory\Extension;

use GrizzIt\Storage\Common\StorageInterface;
use GrizzIt\Services\Common\Factory\ServiceFactoryExtensionInterface;

class EnvironmentFactory implements ServiceFactoryExtensionInterface
{
    /**
     * Contains the already resolved environment variables.
     *
     * @var array
     */
    private array $environmentVariables = [];

    /**
     * Contains the environment storage.
     *
     * @var StorageInterface
     */
    private ?StorageInterface $environmentStorage = null;

    /**
     * Converts a service key and definition to an instance.
     *
     * @param string $key
     * @param mixed $definition
     * @param callable $create
     *
     * @return mixed
     */
    public function create(
        string $key,
        mixed $definition,
        callable $create
    ): mixed {
        if (!isset($this->environmentVariables[$key])) {
            if (is_null($this->environmentStorage)) {
                $this->environmentStorage = $create(
                    'persistent.environment'
                );
            }

            if (!$this->environmentStorage->has($key)) {
                $this->environmentStorage->set(
                    $key,
                    $definition['default'] ?? null
                );
            }

            $this->environmentVariables[$key] = $this->environmentStorage->get(
                $key
            );
        }

        return $this->environmentVariables[$key];
    }
}
