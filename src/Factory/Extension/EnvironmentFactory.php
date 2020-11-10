<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\EnvironmentExtension\Factory\Extension;

use GrizzIt\Storage\Common\StorageInterface;
use Ulrack\Services\Exception\DefinitionNotFoundException;
use Ulrack\Services\Common\AbstractServiceFactoryExtension;

class EnvironmentFactory extends AbstractServiceFactoryExtension
{
    /**
     * Contains the already resolved environment variables.
     *
     * @var array
     */
    private $environmentVariables = [];

    /**
     * Contains the environment storage.
     *
     * @var StorageInterface
     */
    private $environmentStorage;

    /**
     * Register a value to a service key.
     *
     * @param string $serviceKey
     * @param mixed $value
     *
     * @return void
     */
    public function registerService(string $serviceKey, $value): void
    {
        $this->environmentVariables[$serviceKey] = $value;
    }

    /**
     * Retrieves the environment storage.
     *
     * @return StorageInterface
     */
    private function getEnvironmentStorage(): StorageInterface
    {
        if (is_null($this->environmentStorage)) {
            $this->environmentStorage = $this->superCreate(
                'persistent.environment'
            );
        }

        return $this->environmentStorage;
    }

    /**
     * Retrieves a list of all environment keys.
     *
     * @return array
     */
    public function getKeys(): array
    {
        return array_keys($this->getServices()[$this->getKey()] ?? []);
    }

    /**
     * Invoke the invocation and return the result.
     *
     * @param string $serviceKey
     *
     * @return mixed
     *
     * @throws DefinitionNotFoundException When the definition can not be found.
     */
    public function create(string $serviceKey)
    {
        $serviceKey = $this->preCreate(
            $serviceKey,
            $this->getParameters()
        )['serviceKey'];

        $internalKey = preg_replace(
            sprintf('/^%s\\./', preg_quote($this->getKey())),
            '',
            $serviceKey,
            1
        );

        if (!isset($this->environmentVariables[$internalKey])) {
            $services = $this->getServices()[$this->getKey()];
            if (!isset($services[$internalKey])) {
                throw new DefinitionNotFoundException($serviceKey);
            }

            $storage = $this->getEnvironmentStorage();
            if (!$storage->has($internalKey)) {
                $storage->set(
                    $internalKey,
                    $services[$internalKey]['default'] ?? null
                );
            }

            $this->registerService(
                $internalKey,
                $storage->get($internalKey)
            );
        }

        return $this->postCreate(
            $serviceKey,
            $this->environmentVariables[$internalKey],
            $this->getParameters()
        )['return'];
    }
}
