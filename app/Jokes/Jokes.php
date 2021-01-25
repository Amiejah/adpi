<?php

namespace App\Jokes;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Jokes implements JokesInterface {


    public function getFileData() {
        $file = Storage::get(config('api.file_name'));
        $decoded_file = json_decode( $file );
        $collections = new Collection();
        foreach($decoded_file as $item) {
            $collections->push((object) [
                'id' => $item->id,
                'punchline'=> $item->punchline,
                'setup'=> $item->setup,
                'type'=> $item->type,
            ]);
        }

        return $collections;
    }


    public function checkFile() {
        if ( ! Storage::disk('local')->exists(config('api.file_name')) ) {
            $response = Http::withHeaders(['accept' => 'application/json'])
                ->get(config('api.base_url'))
                ->json();

            Storage::disk('local')->put(config('api.file_name'), json_encode($response));

            return Storage::get(config('api.file_name'));
        }
        return Storage::get(config('api.file_name'));
    }

    public function updateFileData( $data ) {
        return Storage::disk('local')->put(config('api.file_name'), json_encode($data));
    }

}
