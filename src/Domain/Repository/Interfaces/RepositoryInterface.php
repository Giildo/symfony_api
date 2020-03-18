<?php

namespace Jojotique\Api\Domain\Repository\Interfaces;

use Doctrine\ORM\NonUniqueResultException;
use Jojotique\Api\Domain\Model\Interfaces\ModelInterface;

interface RepositoryInterface
{
    /**
     * Load a list of the item.
     *
     * @return ModelInterface[]|null
     */
    public function loadAll(): ?array;

    /**
     * @param string $id
     *
     * @return ModelInterface|null
     * @throws
     */
    public function loadItemById(string $id): ?ModelInterface;
}
