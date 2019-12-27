<?php

namespace App\Http\Controllers;

use App\Models\SkillType;

class SkillTypeController extends Controller {
    public function index($lang = 1) {
        return SkillType::with(['title' => function($title) use ($lang) {
            $title->translated($lang);
        }])->get();
    }
}