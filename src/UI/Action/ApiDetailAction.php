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
    private ApiResponder $responder;
    /**
     * @var Loader
     */
    private Loader $loader;

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
     *
     * @return Response
     */
    public function detail(
        Request $request,
        $id,
        string $objectName
    ): Response {
        return $this->responder->response(
            $this->loader->load($objectName, $id),
            $request
        );
    }
}
