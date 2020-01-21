<?php

namespace App\Http\Controllers;

use App\Models\SkillType;

class SkillTypeController extends Controller {
    public function index($lang = 1) {
        return SkillType::with(['title' => function($title) use ($lang) {
            $title->translated($lang);
        }])->get();
    }

    public function find($filter, $lang = 1) {
        return SkillType::extended($lang)->whereHas('title', function($q) use($lang, $filter) {
            $q->where('text', 'LIKE', '%' . $filter . '%');
            $q->where('language', $lang);
        })->skip(0)->take(15)->get()->groupBy('category');
    }
}