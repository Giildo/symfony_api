<?php

namespace Jojotique\Api\Domain\Saver;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Jojotique\Api\Application\Helper\ModelUpdateHelper;
use Jojotique\Api\Domain\DTO\Interfaces\DTOInterface;
use Jojotique\Api\Domain\Model\Interfaces\ModelInterface;
use Jojotique\Api\Domain\Output\Interfaces\OutInterface;
use Jojotique\Api\Domain\Output\Output;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Saver extends ModelUpdateHelper
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private EntityManagerInterface $entityManager;

    /**
     * ApplicationSaver constructor.
     *
     * @param SerializerInterface    $serializer
     * @param ValidatorInterface     $validator
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }

    public function save(
        string $credentials,
        string $dtoName,
        string $objectName,
        ModelInterface $item
    ): OutInterface {
        /** @var DTOInterface $itemDTO */
        $itemDTO = $this->serializer->deserialize($credentials, $dtoName, 'json');

        // DTO validation
        $errors = $this->validator->validate($itemDTO);
        if (count($errors) > 0) {
            return $this->hasErrors($errors);
        }

        // Item construction
        $item = $item->hydrate($itemDTO);

        try {
            $this->entityManager->getRepository($objectName)
                                ->saveItem($item);
        } catch (UniqueConstraintViolationException $exception) {
            return $this->uniqueConstraintViolation('This name is already taken.');
        }

        return new Output($item);
    }
}
