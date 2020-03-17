<?php

namespace Jojotique\Api\UI\Responder;

use Jojotique\Api\Domain\Output\Interfaces\OutInterface;
use Jojotique\Api\UI\Responder\Interfaces\ApiResponderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ApiResponder implements ApiResponderInterface
{
    private SerializerInterface $serializer;

    /**
     * ApiResponder constructor.
     *
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

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
    ): Response {
        $headers['Content-Type'] = 'application/json';

        return new Response(
            $content ? $this->serializer->serialize($content, 'json') : null,
            $status,
            $headers
        );
    }
}
