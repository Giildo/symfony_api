<?php

namespace Jojotique\Api\Domain\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Jojotique\Api\Domain\Model\Interfaces\ModelInterface;
use Jojotique\Api\Domain\Repository\Interfaces\RepositoryInterface;

class ApiRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        string $entityClass
    ) {
        parent::__construct($registry, $entityClass);
    }

    /**
     * Save an item.
     *
     * @param ModelInterface $model
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveItem(ModelInterface $model): void
    {
        $this->_em->persist($model);
        $this->_em->flush();
    }

    /**
     * Delete an item.
     *
     * @param ModelInterface $model
     *
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function deleteItem(ModelInterface $model): void
    {
        $this->_em->remove($model);
        $this->_em->flush();
    }

    // TODO: Refactoring des méthodes load pour les créer ici
}
