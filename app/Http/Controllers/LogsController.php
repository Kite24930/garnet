<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function show() {
        $data = [];
        return view('logs.logs', $data);
    }

    public function view($log) {
        $data = [];
        return view('logs.logs-view', $data);
    }

    public function edit($log) {
        $data = [];
        return view('logs.logs-edit', $data);
    }

    public function update(Request $request) {

    }
}
