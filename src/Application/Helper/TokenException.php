<?php

namespace Jojotique\Api\Application\Helper;

use Symfony\Component\Config\Definition\Exception\Exception;

class TokenException extends Exception
{
    // General errors
    public const BAD_REQUEST = 400;
    public const UNAUTHORIZED = 401;
    public const FORBIDDEN = 403;
    public const NOT_FOUND = 404;
    public const SERVER_ERROR = 500;

    // Token errors
    public const NO_TOKEN = 1000;
    public const TOKEN_INVALID = 1001;
    public const TOKEN_EXPIRED = 1002;
    public const TOKEN_HAS_TO_BE_REFRESH = 1003;
    public const TOKEN_HAS_TO_BE_ACCESS = 1004;

    // Connection errors
    public const WRONG_CREDENTIALS = 1100;

    // ORM errors
    public const NO_CHANGEMENT = 1200;
    public const UNIQUE_CONSTRAINT_VIOLATION = 1201;

    // User errors
    public const NO_USER_WITH_THIS_UID = 1300;
    public const USER_NOT_ADMIN = 1301;
}
