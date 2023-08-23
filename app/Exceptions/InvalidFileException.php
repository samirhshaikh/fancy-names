<?php

namespace App\Exceptions;

use Exception;

class InvalidFileException extends Exception
{
    public $message = "Invalid file.";
}
