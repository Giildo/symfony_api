<?php

namespace Jojotique\Api\Domain\Output\Interfaces;

use Jojotique\Api\Domain\Model\Interfaces\ModelInterface;

interface OutputInterface extends OutInterface
{
    /**
     * @return ModelInterface|null
     */
    public function getItem(): ?ModelInterface;
}