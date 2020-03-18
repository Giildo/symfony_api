<?php

namespace Jojotique\Api\Domain\Loader;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Jojotique\Api\Application\Helper\ExceptionOutput;
use Jojotique\Api\Application\Helper\TokenException;
use Jojotique\Api\Domain\Loader\Interfaces\LoaderInterface;
use Jojotique\Api\Domain\Output\Interfaces\OutInterface;
use Jojotique\Api\Domain\Output\Output;
use Jojotique\Api\Domain\Output\Outputs;
use Jojotique\Api\Domain\Repository\Interfaces\RepositoryInterface;

class Loader implements LoaderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * Loader constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    public function load(
        string $objectName,
        ?string $id = null,
        ?array $options = []
    ): ?OutInterface {
        /** @var RepositoryInterface $repository */
        $repository = $this->entityManager->getRepository($objectName);

        if (is_null($id)) {
            return new Outputs(
                $repository->loadAll()
            );
        }

        try {
            $item = $repository->loadItemById($id);

            if (is_null($item)) {
                return new ExceptionOutput(
                    'No application with this ID.',
                    TokenException::NOT_FOUND
                );
            }

            return new Output($item);
        } catch (NonUniqueResultException $exception) {
            return new ExceptionOutput(
                'This ID has a problem! Contacts the administrator.',
                TokenException::UNIQUE_CONSTRAINT_VIOLATION
            );
        }
    }
}
