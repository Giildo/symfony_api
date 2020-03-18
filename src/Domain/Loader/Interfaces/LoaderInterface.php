<?php

namespace Jojotique\Api\Domain\Loader\Interfaces;

use Jojotique\Api\Domain\Output\Interfaces\OutInterface;

interface LoaderInterface
{
    /**
     * The method load one item or a list.
     *
     * @param string      $objectName - Name of the object loaded
     * @param string|null $id - If load one object, id of this object
     * @param array|null  $options - Other information for the loading
     *
     * @return OutInterface|null
     */
    public function load(
        string $objectName,
        ?string $id = null,
        ?array $options = []
    ): ?OutInterface;
}
