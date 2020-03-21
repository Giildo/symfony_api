<?php

namespace Jojotique\Api\Domain\Deleter;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Jojotique\Api\Application\Helper\ExceptionOutput;
use Jojotique\Api\Application\Helper\Interfaces\ExceptionOutputInterface;
use Jojotique\Api\Application\Helper\TokenException;
use Jojotique\Api\Domain\Model\Interfaces\ModelInterface;
use Jojotique\Api\Domain\Repository\Interfaces\RepositoryInterface;

class Deleter
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * Deleter constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string|int $id
     * @param string     $objectName
     *
     * @return ExceptionOutputInterface|null
     * @throws NonUniqueResultException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(
        $id,
        string $objectName
    ): ?ExceptionOutputInterface {
        /** @var RepositoryInterface $repository */
        $repository = $this->entityManager->getRepository($objectName);
        /** @var ModelInterface $item */
        $item = $repository->loadItemById($id);

        if (is_null($item)) {
            return new ExceptionOutput(
                'No user with this directory ID.',
                TokenException::NOT_FOUND
            );
        }

        $repository->deleteItem($item);

        return null;
    }
}
