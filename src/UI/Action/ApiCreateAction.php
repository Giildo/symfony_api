<?php

namespace Jojotique\Api\UI\Action;

use Jojotique\Api\Application\Helper\ExceptionOutput;
use Jojotique\Api\Domain\Model\Interfaces\ModelInterface;
use Jojotique\Api\Domain\Saver\Saver;
use Jojotique\Api\UI\Responder\ApiResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiCreateAction
{
    private ApiResponder $responder;
    private Saver $saver;

    /**
     * ApiCreateAction constructor.
     *
     * @param ApiResponder $responder
     * @param Saver        $saver
     */
    public function __construct(
        ApiResponder $responder,
        Saver $saver
    ) {
        $this->responder = $responder;
        $this->saver = $saver;
    }

    public function create(
        Request $request,
        string $dtoName,
        string $objectName,
        ModelInterface $item
    ): Response {
        $return = $this->saver->save($request->getContent(), $dtoName, $objectName, $item);

        if ($return instanceof ExceptionOutput) {
            return $this->responder->response($return, $request, Response::HTTP_BAD_REQUEST);
        }

        return $this->responder->response($return, $request, Response::HTTP_CREATED);
    }
}
