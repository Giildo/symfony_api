<?php

namespace Jojotique\Api\Domain\Loader;

use Jojotique\Api\Domain\Loader\Interfaces\LoaderInterface;
use Jojotique\Api\Domain\Output\Interfaces\OutInterface;
use Jojotique\Api\Domain\Output\Outputs;

class Loader implements LoaderInterface
{
    /**
     * Loader constructor.
     */
    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function load(
        ?string $id = null,
        ?array $options = []
    ): ?OutInterface {
        return new Outputs([]);
    }
}
