<?php

namespace App\Http\Controllers;

use App\Models\Translate;

class TranslateController extends Controller {
    public function delete($id) {
        return Translate::findOrFail($id)->delete();
    }
}