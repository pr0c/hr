<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;

class EvaluationController extends Controller {
    public function index() {
        return Evaluation::all();
    }
}