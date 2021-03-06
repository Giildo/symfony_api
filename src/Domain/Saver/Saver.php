<?php

namespace Jojotique\Api\Domain\Saver;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Jojotique\Api\Application\Helper\ModelUpdateHelper;
use Jojotique\Api\Domain\DTO\Interfaces\DTOInterface;
use Jojotique\Api\Domain\Model\Interfaces\ModelInterface;
use Jojotique\Api\Domain\Output\Interfaces\OutInterface;
use Jojotique\Api\Domain\Output\Interfaces\SpecificOutInterface;
use Jojotique\Api\Domain\Output\Output;
use Jojotique\Api\Domain\Repository\Interfaces\RepositoryInterface;
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

    /**
     * @param string               $credentials
     * @param string               $dtoName
     * @param string               $objectName
     * @param ModelInterface       $item
     * @param SpecificOutInterface $output
     * @param array|null           $associations
     * @param array|null           $options
     *
     * @return OutInterface
     */
    public function save(
        string $credentials,
        string $dtoName,
        string $objectName,
        ModelInterface $item,
        SpecificOutInterface $output,
        ?array $associations = [],
        ?array $options = []
    ): OutInterface {
        /** @var DTOInterface $itemDTO */
        $itemDTO = $this->serializer->deserialize($credentials, $dtoName, 'json');

        // DTO validation
        $errors = $this->validator->validate($itemDTO);
        if (count($errors) > 0) {
            return $this->hasErrors($errors);
        }

        if (!empty($associations)) {
            foreach ($associations as $association) {
                $itemsLinked = [];

                /** @var RepositoryInterface $repository */
                $repository = $this->entityManager->getRepository($association['objectName']);
                foreach ($itemDTO->{$association['name']} as $value) {
                    $itemLinked = array_key_exists('loadItemBy', $options)
                        ? $repository->{$options['loadItemBy']}($value)
                        : $repository->loadItemById($value);

                    if (is_null($itemLinked)) {
                        return $this->noItemAssociatedWithThisId($value, $association['name']);
                    }

                    $itemsLinked[] = $itemLinked;
                }

                $itemDTO->{$association['name']} = $itemsLinked;
            }
        }

        // Item construction
        $item = $item->hydrate($itemDTO);

        try {
            $this->entityManager->getRepository($objectName)
                                ->saveItem($item);
        } catch (UniqueConstraintViolationException $exception) {
            return $this->uniqueConstraintViolation('This name is already taken.');
        }

        $output->hydrate($item);
        return $output;
    }
}
