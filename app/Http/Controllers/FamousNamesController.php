<?php

namespace App\Http\Controllers;

use App\Exceptions\FileNotFoundException;
use App\Exceptions\InvalidFileException;
use App\Services\JSONService;
use Illuminate\Support\Arr;

class FamousNamesController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $response = [];

        try {
            $jsonReader = new JSONService();

            $response["famous_names"] = Arr::get($jsonReader->read("famous-names.json"), 'famousNames', []);
        } catch (FileNotFoundException $e) {
            $response["error"] = $e->getMessage();
        } catch (InvalidFileException $e) {
            $response["error"] = $e->getMessage();
        }

        return view('home', $response);
    }
}
