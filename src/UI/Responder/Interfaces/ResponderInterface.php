<?php

namespace Jojotique\Api\UI\Responder\Interfaces;

use Jojotique\Api\Domain\Output\Interfaces\OutInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface ResponderInterface
{
    /**
     * @param OutInterface|null $content - Default format fot output object
     * @param Request|null      $request - Request for caching
     * @param int|null          $status - Response status code
     * @param array|null        $headers - Response headers
     *
     * @return Response
     */
    public function response(
        ?OutInterface $content = null,
        ?Request $request = null,
        ?int $status = 200,
        ?array $headers = []
    ): Response;
}
