<?php

namespace Jojotique\Api\Domain\Loader;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Jojotique\Api\Application\Helper\ExceptionOutput;
use Jojotique\Api\Application\Helper\TokenException;
use Jojotique\Api\Domain\Output\Interfaces\OutInterface;
use Jojotique\Api\Domain\Output\Interfaces\SpecificOutInterface;
use Jojotique\Api\Domain\Output\Output;
use Jojotique\Api\Domain\Output\Outputs;
use Jojotique\Api\Domain\Repository\Interfaces\RepositoryInterface;

class Loader
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
     * @param string                    $objectName
     * @param string|null               $id
     * @param array|null                $options
     * @param SpecificOutInterface|null $specificOutput
     *
     * @return OutInterface|null
     */
    public function load(
        string $objectName,
        ?string $id = null,
        ?array $options = [],
        ?SpecificOutInterface $specificOutput = null
    ): ?OutInterface {
        /** @var RepositoryInterface $repository */
        $repository = $this->entityManager->getRepository($objectName);

        if (is_null($id)) {
            if (is_null($specificOutput)) {
                return new Outputs(
                    $repository->loadAll()
                );
            }

            $specificOutput->hydrate(
                $repository->loadAll()
            );
            return $specificOutput;
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
