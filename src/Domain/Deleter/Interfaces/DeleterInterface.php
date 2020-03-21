<?php

namespace App\Domain\Deleter\Interfaces;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Jojotique\Api\Application\Helper\Interfaces\ExceptionOutputInterface;

interface DeleterInterface
{
    /**
     * @param string|int $id
     *
     * @return ExceptionOutputInterface|null
     *
     * @throws NonUniqueResultException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete($id): ?ExceptionOutputInterface;
}
