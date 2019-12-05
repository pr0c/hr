<?php

namespace App\Traits;

trait Translate {
    public function getTranslate($textId, $lang) {
        $text = \App\Models\Translate::where('translate_id', '=', $textId)->where('language', '=', $lang)->get();

        return $text;
    }

    public function scopeTranslated($query, $lang = 1) {
        return $query->where('language', '=', $lang);
    }
}