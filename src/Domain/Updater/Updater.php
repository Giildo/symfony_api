<?php

namespace Jojotique\Api\Domain\Updater;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Jojotique\Api\Application\Helper\ModelUpdateHelper;
use Jojotique\Api\Domain\DTO\Interfaces\DTOInterface;
use Jojotique\Api\Domain\Model\Interfaces\ModelInterface;
use Jojotique\Api\Domain\Output\Interfaces\OutInterface;
use Jojotique\Api\Domain\Output\Output;
use Jojotique\Api\Domain\Repository\Interfaces\RepositoryInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Updater extends ModelUpdateHelper
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * Update constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface    $serializer
     * @param ValidatorInterface     $validator
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @param string|int $id
     * @param string     $credentials
     * @param string     $dtoName
     * @param string     $objectName
     *
     * @return OutInterface
     * @throws NonUniqueResultException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(
        $id,
        string $credentials,
        string $dtoName,
        string $objectName
    ) {
        /** @var RepositoryInterface $repository */
        $repository = $this->entityManager->getRepository($objectName);
        /** @var ModelInterface $item */
        $item = $repository->loadItemById($id);

        if (is_null($item)) {
            return $this->noItemWithThisId();
        }

        /** @var DTOInterface $itemDTO */
        $itemDTO = $this->serializer->deserialize(
            $credentials,
            $dtoName,
            'json'
        );

        $errors = $this->validator->validate($itemDTO);
        if (count($errors) > 0) {
            return $this->hasErrors($errors);
        }

        $return = $item->update($itemDTO);
        if (!$return) {
            return $this->hasNoUpdate();
        }

        try {
            $repository->saveItem($item);
        } catch (UniqueConstraintViolationException $exception) {
            return $this->uniqueConstraintViolation('This name is already taken.');
        }

        return new Output($item);
    }
}
