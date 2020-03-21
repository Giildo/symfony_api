<?php

namespace Jojotique\Api\Domain\Output;

use Jojotique\Api\Domain\Model\Interfaces\ModelInterface;
use Jojotique\Api\Domain\Output\Interfaces\OutputInterface;

class Output implements OutputInterface
{
    /**
     * @var ModelInterface|null
     */
    private ?ModelInterface $item;

    /**
     * Output constructor.
     *
     * @param ModelInterface|null $item
     */
    public function __construct(?ModelInterface $item)
    {
        $this->item = $item;
    }

    /**
     * @return ModelInterface|null
     */
    public function getItem(): ?ModelInterface
    {
        return $this->item;
    }
}
