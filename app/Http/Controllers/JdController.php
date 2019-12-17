<?php

namespace App\Http\Controllers;

class JdController extends Controller {
    public function index() {
        return Jd::all();
    }
}