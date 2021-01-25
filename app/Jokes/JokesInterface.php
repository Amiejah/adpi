<?php

namespace App\Jokes;

interface JokesInterface {
    public function getFileData();
    public function checkFile();
    public function updateFileData( $data );
}
