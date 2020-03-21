<?php

namespace Jojotique\Api\Domain\Repository\Interfaces;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
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
     * Load an item with the ID.
     *
     * @param string|int $id
     *
     * @return ModelInterface|null
     * @throws NonUniqueResultException
     */
    public function loadItemById($id): ?ModelInterface;

    /**
     * Save an item.
     *
     * @param ModelInterface $model
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveItem(ModelInterface $model): void;

    /**
     * Delete an item.
     *
     * @param ModelInterface $model
     *
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function deleteItem(ModelInterface $model): void;
}
