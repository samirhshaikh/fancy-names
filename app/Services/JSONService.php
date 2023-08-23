<?php

namespace App\Services;

use App\Exceptions\FileNotFoundException;
use App\Exceptions\InvalidFileException;
use Illuminate\Support\Facades\File;

class JSONService
{
    /**
     * @param string $fileName
     * @return mixed
     * @throws FileNotFoundException
     * @throws InvalidFileException
     */
    public function read(string $fileName): mixed
    {
        if (empty($fileName)) {
            throw new InvalidFileException();
        }

        $fullFilePath = public_path($fileName);
        if (File::exists($fullFilePath)) {
            return json_decode(File::get($fullFilePath), true);
        } else {
            throw new FileNotFoundException();
        }
    }
}
