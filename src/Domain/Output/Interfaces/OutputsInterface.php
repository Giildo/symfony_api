<?php

namespace Jojotique\Api\Domain\Output\Interfaces;

use Jojotique\Api\Domain\Model\Interfaces\ModelInterface;

interface OutputsInterface extends OutInterface
{
    /**
     * @return ModelInterface[]
     */
    public function getItems(): array;
}
