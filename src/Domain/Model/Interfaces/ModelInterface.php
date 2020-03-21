<?php

namespace Jojotique\Api\Domain\Model\Interfaces;

use Jojotique\Api\Domain\DTO\Interfaces\DTOInterface;

interface ModelInterface
{
    /**
     * Hydrates the model.
     *
     * @param DTOInterface $dto
     *
     * @return ModelInterface
     */
    public function hydrate(DTOInterface $dto): self;

    /**
     * Updates the model.
     *
     * @param DTOInterface $dto
     *
     * @return bool - Returns if has update
     */
    public function update(DTOInterface $dto): bool;
}
