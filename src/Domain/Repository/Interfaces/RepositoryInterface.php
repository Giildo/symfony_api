<?php

namespace Jojotique\Api\Domain\Repository\Interfaces;

use Jojotique\Api\Domain\Model\Interfaces\ModelInterface;

interface RepositoryInterface
{
    /**
     * Load a list of the item.
     *
     * @return ModelInterface[]|null
     */
    public function loadAll(): ?array;
}
