<?php

namespace Jojotique\Api\UI\Action;

use Jojotique\Api\Domain\Loader\Loader;
use Jojotique\Api\Domain\Output\Interfaces\OutputsInterface;
use Jojotique\Api\Domain\Output\Interfaces\SpecificOutInterface;
use Jojotique\Api\UI\Responder\ApiResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiListAction
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
     * @param Request               $request
     * @param string                $objectName
     * @param array|null            $groups
     * @param OutputsInterface|null $specificOutput
     *
     * @return Response
     */
    public function list(
        Request $request,
        string $objectName,
        ?array $groups = [],
        ?SpecificOutInterface $specificOutput = null
    ): Response {
        return $this->responder->response(
            $this->loader->load($objectName, null, [], $specificOutput),
            $request,
            Response::HTTP_OK,
            [],
            $groups,
        );
    }
}
