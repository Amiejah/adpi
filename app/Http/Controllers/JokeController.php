<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJokeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Jokes\JokesInterface;

class JokeController extends Controller
{
    private $jokes;

    public function __construct(JokesInterface $jokes) {
        $this->jokes = $jokes;
    }

    /**
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->jokes->checkFile()) {
            $response = $this->jokes->checkFile();
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
        return 'testing';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJokeRequest $request)
    {
        $collections = $this->jokes->getFileData();

        $collections->push([
            'id' => rand(1, 200),
            'punchline' => $request->input('punchline'),
            'setup' => $request->input('setup'),
            'type' => 'programming',
        ]);

        $this->jokes->updateFileData( $collections );

        return response()->json($this->jokes->getFileData());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $collections = $this->jokes->getFileData();
        $item = collect($collections)->where('id', $id)->first();
        return response()->json( $item );
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
    public function update(StoreJokeRequest $request, $id)
    {
        $collections = $this->jokes->getFileData();
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

}
