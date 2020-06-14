<?php

namespace Jojotique\Api\UI\Action;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Jojotique\Api\Application\Helper\ExceptionOutput;
use Jojotique\Api\Application\Helper\TokenException;
use Jojotique\Api\Domain\Updater\Updater;
use Jojotique\Api\UI\Responder\ApiResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiUpdateAction
{
    /**
     * @var ApiResponder
     */
    private ApiResponder $responder;
    /**
     * @var Updater
     */
    private Updater $updater;

    /**
     * ApiUpdateAction constructor.
     *
     * @param ApiResponder $responder
     * @param Updater      $updater
     */
    public function __construct(
        ApiResponder $responder,
        Updater $updater
    ) {
        $this->responder = $responder;
        $this->updater = $updater;
    }

    /**
     * @param Request    $request
     * @param string|int $id
     * @param string     $dtoName
     * @param string     $objectName
     * @param array|null $groups
     *
     * @return Response
     */
    public function update(
        Request $request,
        $id,
        string $dtoName,
        string $objectName,
        ?array $groups = []
    ): Response {
        $return = $this->updater->update($id, $request->getContent(), $dtoName, $objectName);

        if ($return instanceof ExceptionOutput) {
            switch ($return->getCodeError()) {
                case TokenException::BAD_REQUEST:
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

                default:
                    return $this->responder->response(
                        null,
                        $request,
                        Response::HTTP_NO_CONTENT,
                        [],
                        $groups
                    );
            }
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
