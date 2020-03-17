<?php

namespace Jojotique\Api\Domain\Loader\Interfaces;

use Jojotique\Api\Domain\Output\Interfaces\OutInterface;

interface LoaderInterface
{
    /**
     * @param string|null $id
     * @param array|null  $options
     *
     * @return OutInterface|null
     */
    public function load(
        ?string $id = null,
        ?array $options = []
    ): ?OutInterface;
}
