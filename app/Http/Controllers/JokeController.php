<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class JokeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->checkCreateFile()) {
            $response = $this->checkCreateFile();
            return json_decode($response);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $collections = $this->fetchCollection();
        $collections->push([
            'id' => rand(1, 200),
            'punchline' => $request->input('punchline'),
            'setup' => $request->input('setup'),
            'type' => 'programming',
        ]);

        Storage::disk('local')->put(config('api.file_name'), json_encode($collections));

        return response()->json($collections);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $collections = $this->fetchCollection();
        return response()->json(collect($collections)->where('id', $id)->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $collections = $this->fetchCollection();

        foreach($collections as $item) {
            if ( $item->id == $id ) {
                $item->punchline = $request->input('punchline');
                $item->setup = $request->input('setup');
            }
        }

        Storage::disk('local')->put(config('api.file_name'), json_encode($collections));

        return response()->json($collections);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * JSON file is used instead of the db
     *
     * @return boolean
     */
    private function checkCreateFile() {
        if ( ! Storage::disk('local')->exists(config('api.file_name')) ) {
            $response = Http::withHeaders(['accept' => 'application/json'])
                ->get(config('api.base_url'))
                ->json();

            Storage::disk('local')->put(config('api.file_name'), json_encode($response));

            return Storage::get(config('api.file_name'));
        }

        return Storage::get(config('api.file_name'));

    }

    /**
     * Collects the data and returns is as a collection.
     *
     */
    private function fetchCollection() {
        $file = Storage::get(config('api.file_name'));
        $data = json_decode($file);
        $collections = new Collection();

        foreach($data as $item) {
            $collections->push((object)[
                'id' => $item->id,
                'punchline'=> $item->punchline,
                'setup'=> $item->setup,
                'type'=> $item->type,
            ]);
        }

        return $collections;
    }

    private function writeCollectionTofile() {

    }
}
