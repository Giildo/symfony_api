<?php

namespace Jojotique\Api\Application\Helper;

use Jojotique\Api\Application\Helper\Interfaces\ExceptionOutputInterface;
use Swagger\Annotations as SWG;

class ExceptionOutput implements ExceptionOutputInterface
{
    private string $message;
    private int $codeError;
    /**
     * @SWG\Property(
     *     type="array",
     *     @SWG\Items(type="string")
     * )
     */
    private ?array $errors;

    /**
     * ExceptionOutput constructor.
     *
     * @param string     $message
     * @param int        $codeError
     * @param array|null $errors
     */
    public function __construct(
        string $message,
        int $codeError,
        ?array $errors = []
    ) {
        $this->message = $message;
        $this->codeError = $codeError;
        $this->errors = $errors;
    }

    /**
     * @inheritDoc
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     */
    public function getCodeError(): int
    {
        return $this->codeError;
    }

    /**
     * @inheritDoc
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }
}
