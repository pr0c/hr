<?php

namespace App\Http\Controllers;

use App\Models\Text;
use App\Models\Translate;
use App\Models\Language;

class TextController extends Controller {
    public function store() {
        if(request()->isJson()) {
            $json = json_decode(request()->getContent(), true);
            foreach($json['texts'] as $text) {
                $newText = Text::create();
                if(!$newText->id) continue;
                foreach($text['translates'] as $translate) {
                    Translate::create(array_merge($translate, ['translate_id' => $newText->id]));
                }
            }
        }
    }
}