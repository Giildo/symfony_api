<?php

namespace Jojotique\Api\Application\Helper;

use Jojotique\Api\Application\Helper\Interfaces\ExceptionOutputInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ModelUpdateHelper
{

    /**
     * Sends an error message if an error is detected in the DTO.
     *
     * @param ConstraintViolationListInterface $errors
     *
     * @return ExceptionOutputInterface
     */
    protected function hasErrors(ConstraintViolationListInterface $errors): ExceptionOutputInterface
    {
        $messages = [];

        /** @var ConstraintViolation $error */
        foreach ($errors->getIterator()->getArrayCopy() as $error) {
            $messages[] = [
                'field'   => $error->getPropertyPath(),
                'message' => $error->getMessage(),
            ];
        }
        return new ExceptionOutput(
            'The request contains syntax errors. Please check the information provided.',
            TokenException::BAD_REQUEST,
            $messages
        );
    }

    /**
     * Envoie un message si l'item n'est pas trouvé avec l'ID.
     *
     * @return ExceptionOutputInterface
     */
    protected function noItemWithThisId(): ExceptionOutputInterface {
        return new ExceptionOutput(
            "No item with this ID.",
            TokenException::NOT_FOUND
        );
    }

    /**
     * Envoie un message d'erreur s'il n'y pas de changement.
     *
     * @return ExceptionOutputInterface
     */
    protected function hasNoUpdate(): ExceptionOutputInterface
    {
        return new ExceptionOutput(
            '',
            TokenException::NO_CHANGEMENT
        );
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
