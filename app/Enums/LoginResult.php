<?php

namespace App\Enums;

class LoginResult
{
    public const SUCCESS = 0;
    public const INVALID_PASSWORD = -1;
    public const INVALID_USER = -2;
    public const LOCKED_OUT = -3;
}