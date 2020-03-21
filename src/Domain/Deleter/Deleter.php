<?php

namespace Jojotique\Api\Domain\Deleter;

use App\Domain\Deleter\Interfaces\DeleterInterface;
use Jojotique\Api\Application\Helper\ExceptionOutput;
use Jojotique\Api\Application\Helper\Interfaces\ExceptionOutputInterface;
use Jojotique\Api\Application\Helper\TokenException;
use Jojotique\Api\Domain\Repository\Interfaces\RepositoryInterface;

class Deleter implements DeleterInterface
{
    /**
     * @var RepositoryInterface
     */
    private RepositoryInterface $repository;

    /**
     * Deleter constructor.
     *
     * @param RepositoryInterface $repository
     */
    public function __construct(
        RepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function delete($id): ?ExceptionOutputInterface
    {
        $item = $this->repository->loadItemById($id);

        if (is_null($item)) {
            return new ExceptionOutput(
                'No user with this directory ID.',
                TokenException::NOT_FOUND
            );
        }

        $this->repository->deleteItem($item);

        return null;
    }
}
