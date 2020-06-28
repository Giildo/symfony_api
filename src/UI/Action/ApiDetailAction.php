<?php

namespace Jojotique\Api\UI\Action;

use Jojotique\Api\Domain\Loader\Loader;
use Jojotique\Api\UI\Responder\ApiResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiDetailAction
{
    /**
     * @var ApiResponder
     */
    protected ApiResponder $responder;
    /**
     * @var Loader
     */
    protected Loader $loader;

    /**
     * ApiDetailAction constructor.
     *
     * @param ApiResponder $responder
     * @param Loader       $loader
     */
    public function __construct(
        ApiResponder $responder,
        Loader $loader
    ) {
        $this->responder = $responder;
        $this->loader = $loader;
    }

    /**
     * @param Request    $request
     * @param string|int $id
     * @param string     $objectName
     * @param array|null $groups
     *
     * @return Response
     */
    public function detail(
        Request $request,
        $id,
        string $objectName,
        ?array $groups = []
    ): Response {
        return $this->responder->response(
            $this->loader->load($objectName, $id),
            $request,
            Response::HTTP_OK,
            [],
            $groups
        );
    }
}
