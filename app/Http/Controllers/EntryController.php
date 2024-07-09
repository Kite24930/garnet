<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EntryController extends Controller
{
    //

    public function show() {
        $data = [];
        return view('entry.entry', $data);
    }

    public function store(Request $request) {

    }
}
