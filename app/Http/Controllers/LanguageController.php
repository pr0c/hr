<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Person;
use App\Models\Text;
use App\Models\Translate;
use Illuminate\Database\QueryException;

class LanguageController extends Controller {
    public function store() {
        if(request()->isJson()) {
            $request = json_decode(request()->getContent(), true);
            if($request['languages']) {
                foreach($request['languages'] as $language) {
                    $text = Text::create();
                    if(!$text->id) continue;

                    try {
                        $newLanguage = Language::create(['title_id' => $text->id]);
                    } catch(QueryException $exception) {
                        $text->delete();
                        return $exception;
                    }

                    if(count($language['translates']) > 0) {
                        foreach($language['translates'] as $translate) {
                            Translate::create(array_merge($translate, ['language' => $newLanguage->id, 'translate_id' => $text->id]));
                        }
                    }
                    else {
                        $text->delete();
                        $newLanguage->delete();
                    }
                }
            }
        }
    }
}