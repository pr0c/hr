<?php

namespace App\Http\Controllers;

use App\Models\Jd;
use App\Models\Mbti;
use App\Models\Skill;

class JdController extends Controller {
    public function index() {
        return Jd::all();
    }

    public function store() {
        if(request()->isJson()) {
            $request = json_decode(request()->getContent(), true);

            if(is_null($request)) return ['error' => 'JSON error', 'request' => request()->all()];

            $validator = \Validator::make($request, Jd::$validation);
            if($validator->fails()) {
                return ['error' => $validator->errors()];
            }

            $jd = Jd::create($request);

            if(array_key_exists('skills', $request) && count($request['skills']) > 0) {
                $this->attachSkills($jd, $request['skills']);
            }

            if(array_key_exists('mbtis', $request) && count($request['mbtis']) > 0) {
                $this->attachMbti($jd, $request['mbtis']);
            }

            if(array_key_exists('availabilities', $request) && count($request['availabilities']) > 0) {
                $this->attachAvailabilities($jd, $request['availabilities']);
            }

            if(array_key_exists('physicals', $request) && count($request['physicals']) > 0) {
                $this->attachPhysical($jd, $request['physicals']);
            }

            if(array_key_exists('benefits', $request) && count($request['benefits'])) {
                $jd->benefits()->create($request['benefits']);
            }
        }
    }

    public function update($jdID) {
        if(request()->isJson()) {
            $request = json_decode(request()->getContent(), true);

            if(is_null($request)) return ['error' => 'JSON error', 'request' => request()->all()];

            $jd = Jd::find($jdID);
            $jd->fill($request);
            $jd->save();

            if(array_key_exists('skills', $request) && count($request['skills']) > 0) {
                $this->attachSkills($jd, $request['skills']);
            }

            if(array_key_exists('mbtis', $request) && count($request['mbtis']) > 0) {
                $this->attachMbti($jd, $request['mbtis']);
            }

            if(array_key_exists('availabilities', $request) && count($request['availabilities']) > 0) {
                $this->attachAvailabilities($jd, $request['availabilities']);
            }

            if(array_key_exists('physicals', $request) && count($request['physicals']) > 0) {
                $this->attachPhysical($jd, $request['physicals']);
            }

            if(array_key_exists('benefits', $request) && count($request['benefits'])) {
                $jd->benefits()->create($request['benefits']);
            }

            //Remove
            if(array_key_exists('removeSkills', $request) && count($request['removeSkills']) > 0) {
                foreach($request['removeSkills'] as $skill) {
                    $jd->skills()->detach($skill);
                    Skill::find($skill)->delete();
                }
            }

            if(array_key_exists('removeMbtis', $request) && count($request['removeMbtis']) > 0) {
                foreach($request['removeMbtis'] as $mbti) {
                    $jd->mbtis()->detach($mbti);
                    Mbti::find($mbti)->delete();
                }
            }

            if(array_key_exists('removeAvailabilities', $request) && count($request['removeAvailabilities']) > 0) {
                foreach($request['removeAvailabilities'] as $availability) {
                    $jd->availabilities()->detach($availability);
                }
            }

            if(array_key_exists('removeBenefits', $request) && count($request['removeBenefits']) > 0) {
                foreach($request['removeBenefits'] as $benefit) {
                    $jd->benefits()->detach($benefit);
                }
            }
        }
    }
}