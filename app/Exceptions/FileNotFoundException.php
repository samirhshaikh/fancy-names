<?php

namespace App\Exceptions;

use Exception;

class FileNotFoundException extends Exception
{
    public $message = "File not found.";
}
