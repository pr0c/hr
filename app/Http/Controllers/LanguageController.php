<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Person;
use App\Models\Text;
use App\Models\Translate;
use Illuminate\Database\QueryException;

class LanguageController extends Controller {
    public function index($lang = 1) {
        return Language::withTranslate($lang)->get();
    }

    public function store() {
        $newLanguages = [];
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
                            if(!empty($translate['language'])) $lang = $translate['language'];
                            else $lang = $newLanguage->id;
                            $newLanguages[] = Translate::create(array_merge($translate, ['language' => $lang, 'translate_id' => $text->id]));
                        }
                    }
                    else {
                        $text->delete();
                        $newLanguage->delete();
                    }
                }
            }
        }

        return $newLanguages;
    }

    public function delete($id) {
        return Language::findOrFail($id)->delete();
    }
}