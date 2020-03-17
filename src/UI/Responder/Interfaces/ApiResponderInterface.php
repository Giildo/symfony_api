<?php

namespace Jojotique\Api\UI\Responder\Interfaces;

use Jojotique\Api\Domain\Output\Interfaces\OutInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface ApiResponderInterface
{
    /**
     * @param OutInterface|null $content
     * @param Request|null      $request
     * @param int|null          $status
     * @param array|null        $headers
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