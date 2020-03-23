<?php

namespace Jojotique\Api\UI\Action;

use Doctrine\ORM\NonUniqueResultException;
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

    /**
     * @param Request        $request
     * @param string         $dtoName
     * @param string         $objectName
     * @param ModelInterface $item
     * @param array|null     $associations
     *
     * @return Response
     * @throws NonUniqueResultException
     */
    public function create(
        Request $request,
        string $dtoName,
        string $objectName,
        ModelInterface $item,
        ?array $associations = []
    ): Response {
        $return = $this->saver->save($request->getContent(), $dtoName, $objectName, $item, $associations);

        if ($return instanceof ExceptionOutput) {
            return $this->responder->response($return, $request, Response::HTTP_BAD_REQUEST);
        }

        return $this->responder->response($return, $request, Response::HTTP_CREATED);
    }
}
