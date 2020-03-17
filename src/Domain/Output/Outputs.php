<?php

namespace Jojotique\Api\Domain\Output;

use Jojotique\Api\Domain\Model\Interfaces\ModelInterface;
use Jojotique\Api\Domain\Output\Interfaces\OutputsInterface;

class Outputs implements OutputsInterface
{
    /**
     * @var ModelInterface[]
     */
    private array $items;

    /**
     * Outputs constructor.
     *
     * @param ModelInterface[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @inheritDoc
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
