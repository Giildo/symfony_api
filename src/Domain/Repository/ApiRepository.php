<?php

namespace Jojotique\Api\Domain\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Jojotique\Api\Domain\Model\Interfaces\ModelInterface;
use Jojotique\Api\Domain\Repository\Interfaces\RepositoryInterface;

abstract class ApiRepository extends ServiceEntityRepository implements RepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        string $entityClass
    ) {
        parent::__construct($registry, $entityClass);
    }

    /**
     * @inheritDoc
     */
    public function saveItem(ModelInterface $model): void
    {
        $this->_em->persist($model);
        $this->_em->flush();
    }

    /**
     * @inheritDoc
     */
    public function deleteItem(ModelInterface $model): void
    {
        $this->_em->remove($model);
        $this->_em->flush();
    }

    // TODO: Refactoring des méthodes load pour les créer ici
}
