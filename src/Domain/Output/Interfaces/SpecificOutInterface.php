<?php

namespace Jojotique\Api\Domain\Output\Interfaces;

use Jojotique\Api\Domain\Model\Interfaces\ModelInterface;

interface SpecificOutInterface extends OutInterface
{
    /**
     * @param ModelInterface|ModelInterface[] $item
     */
    public function hydrate($item): void;
}