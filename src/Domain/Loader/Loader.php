<?php

namespace Jojotique\Api\Domain\Loader;

use Doctrine\ORM\EntityManagerInterface;
use Jojotique\Api\Domain\Loader\Interfaces\LoaderInterface;
use Jojotique\Api\Domain\Output\Interfaces\OutInterface;
use Jojotique\Api\Domain\Output\Outputs;

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
        return new Outputs(
            $this->entityManager->getRepository($objectName)
                                ->loadAll()
        );
    }
}
