<?php

namespace Jojotique\Api\Application\Helper\Interfaces;

use Jojotique\Api\Domain\Output\Interfaces\OutInterface;

interface ExceptionOutputInterface extends OutInterface
{
    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @return int
     */
    public function getCodeError(): int;

    /**
     * @return array|null
     */
    public function getErrors(): ?array;
}
