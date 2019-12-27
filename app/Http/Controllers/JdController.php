<?php

namespace App\Http\Controllers;

use App\Models\Jd;

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
        }
    }
}