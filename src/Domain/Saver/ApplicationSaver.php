<?php

namespace App\Domain\Saver;

use App\Domain\DTO\Interfaces\DTOInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Jojotique\Api\Application\Helper\ExceptionOutput;
use Jojotique\Api\Application\Helper\Interfaces\ExceptionOutputInterface;
use Jojotique\Api\Application\Helper\TokenException;
use Jojotique\Api\Domain\Model\Interfaces\ModelInterface;
use Jojotique\Api\Domain\Output\Interfaces\OutInterface;
use Jojotique\Api\Domain\Output\Output;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApplicationSaver
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

    /**
     * Sends an error message if an error is detected in the DTO.
     *
     * @param ConstraintViolationListInterface $errors
     *
     * @return ExceptionOutputInterface
     */
    protected function hasErrors(ConstraintViolationListInterface $errors): ExceptionOutputInterface
    {
        return new ExceptionOutput(
            'The request contains syntax errors. Please check the information provided.',
            TokenException::BAD_REQUEST,
            $errors->getIterator()->getArrayCopy()
        );
    }

    /**
     * Envoie un message si l'item n'est pas trouvé avec l'ID.
     *
     * @param string|null $itemName
     *
     * @return ExceptionOutputInterface
     */
    protected function noItemWithThisId(
        ?string $itemName = 'item'
    ): ExceptionOutputInterface {
        return new ExceptionOutput(
            "No {$itemName} with this ID.",
            TokenException::NOT_FOUND
        );
    }

    /**
     * Envoie un message d'erreur s'il n'y pas de changement.
     *
     * @return ExceptionOutputInterface
     */
    protected function hasNoChangement(): ExceptionOutputInterface
    {
        return new ExceptionOutput('', TokenException::NO_CHANGEMENT);
    }

    /**
     * Envoie un message d'erreur si au moins une contrainte d'unicité a été violée.
     *
     * @param string|null $errorText
     *
     * @return ExceptionOutputInterface
     */
    protected function uniqueConstraintViolation(
        ?string $errorText = ''
    ): ExceptionOutputInterface {
        return new ExceptionOutput(
            $errorText,
            TokenException::UNIQUE_CONSTRAINT_VIOLATION
        );
    }
}
