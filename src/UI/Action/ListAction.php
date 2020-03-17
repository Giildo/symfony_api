<?php

namespace Jojotique\Api\UI\Action;

use Jojotique\Api\Domain\Loader\Interfaces\LoaderInterface;
use Jojotique\Api\UI\Responder\Interfaces\ResponderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListAction
{
    private ResponderInterface $responder;
    private LoaderInterface $loader;

    /**
     * ListAction constructor.
     *
     * @param ResponderInterface $responder
     * @param LoaderInterface    $loader
     */
    public function __construct(
        ResponderInterface $responder,
        LoaderInterface $loader
    ) {
        $this->responder = $responder;
        $this->loader = $loader;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function list(Request $request): Response
    {
        return $this->responder->response(
            $this->loader->load(),
            $request
        );
    }
}
