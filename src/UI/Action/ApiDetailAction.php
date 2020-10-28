<?php

namespace Jojotique\Api\UI\Action;

use Jojotique\Api\Application\Helper\ExceptionOutput;
use Jojotique\Api\Application\Helper\TokenException;
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
        $return = $this->loader->load($objectName, $id);

        if ($return instanceof ExceptionOutput) {
            switch ($return->getCodeError()) {
                case TokenException::UNIQUE_CONSTRAINT_VIOLATION:
                    return $this->responder->response(
                        $return,
                        $request,
                        Response::HTTP_BAD_REQUEST,
                        [],
                        $groups
                    );

                case TokenException::NOT_FOUND:
                    return $this->responder->response(
                        $return,
                        $request,
                        Response::HTTP_NOT_FOUND,
                        [],
                        $groups
                    );
            }
        }

        if ($return instanceof ExceptionOutput) {
            return $this->responder->response(
                $return,
                $request,
                Response::HTTP_BAD_REQUEST,
            );
        }

        return $this->responder->response(
            $return,
            $request,
            Response::HTTP_OK,
            [],
            $groups
        );
    }
}
