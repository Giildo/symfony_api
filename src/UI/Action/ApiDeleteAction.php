<?php

namespace Jojotique\Api\UI\Action;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Jojotique\Api\Application\Helper\ExceptionOutput;
use Jojotique\Api\Domain\Deleter\Deleter;
use Jojotique\Api\UI\Responder\ApiResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiDeleteAction
{
    /**
     * @var ApiResponder
     */
    private ApiResponder $responder;
    /**
     * @var Deleter
     */
    private Deleter $deleter;

    /**
     * ApiDeleteAction constructor.
     *
     * @param ApiResponder $responder
     * @param Deleter      $deleter
     */
    public function __construct(
        ApiResponder $responder,
        Deleter $deleter
    ) {
        $this->responder = $responder;
        $this->deleter = $deleter;
    }

    /**
     * @param Request    $request
     * @param string|int $id
     *
     * @return Response
     * @throws NonUniqueResultException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(
        Request $request,
        $id
    ): Response {
        $return = $this->deleter->delete($id);

        if ($return instanceof ExceptionOutput) {
            return $this->responder->response($return, $request, Response::HTTP_NOT_FOUND);
        }

        return $this->responder->response($return, $request, Response::HTTP_NO_CONTENT);
    }
}
