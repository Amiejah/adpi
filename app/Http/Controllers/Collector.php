<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Collector extends Controller
{
    /**
     * Download Collection of data to a json file
     *
     * @return void
     */
    public function setCollection (Request $response) {

        // We only need this once as the data is then stored in a separate JSON file.
        if ( ! Storage::disk('local')->exists(config('api.file_name')) ) {

            $response = Http::withHeaders(['accept' => 'application/json'])
                ->get(config('api.base_url'))
                ->json();

            Storage::disk('local')->put(config('api.file_name'), json_encode($response));

        }

        return view('welcome');
    }
}
