<?php

namespace Jojotique\Api\UI\Action;

use Jojotique\Api\Domain\Loader\Loader;
use Jojotique\Api\UI\Responder\ApiResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiListAction
{
    private ApiResponder $responder;
    private Loader $loader;

    /**
     * ListAction constructor.
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
     * @param Request $request
     * @param string  $objectName
     *
     * @return Response
     */
    public function list(Request $request, string $objectName): Response
    {
        return $this->responder->response(
            $this->loader->load($objectName),
            $request
        );
    }
}
