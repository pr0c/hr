<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\Evaluation;
use App\Models\EvaluationJobSuitability;
use App\Models\EvaluationSalary;
use App\Models\JobTitle;
use App\Models\Place;
use App\Models\Skill;
use App\Models\SkillType;

class EvaluationController extends Controller {
    public function index() {
        return Evaluation::all();
    }

    public function get($id, $lang = 1) {
        return Evaluation::where('id', '=', $id)->extended($lang)->get();
    }

    public function store($personId) {
        if(request()->isJson()) {
            $request = json_decode(request()->getContent(), true);
            if(is_null($request)) return ['error' => request()->all()];

            $request['person'] = $personId;

            //Salary
            if(array_key_exists('salaries', $request) && count($request['salaries']) > 0) {
                $salary = $request['salaries'];
                if(!empty($salary['last_currency']['id'])) $salary['last_currency'] = $salary['last_currency']['id'];
                else unset($salary['last_currency']);
                if(!empty($salary['new_currency']['id'])) $salary['new_currency'] = $salary['new_currency']['id'];
                else unset($salary['new_currency']);

                $newSalary = EvaluationSalary::create($salary);
                if(!empty($newSalary->id)) $request['salary'] = $newSalary->id;
            }

            //Create evaluation
            $evaluation = Evaluation::create($request);

            //Create the rest parts of evaluation
            //Skills
            /*if(array_key_exists('skills', $request) && count($request['skills']) > 0) {
                foreach($request['skills'] as $skill) {
                    if(!empty($skill['title'])) {
                        if(!empty($skill['skill_type'])) $translate_id = $skill['type']['title']['translate_id'];
                        else {
                            $translate_id = null;
                        }

                        $newTranslate = $this->createTranslates($skill['title'], $translate_id);
                        if(is_null($translate_id)) {
                            $skillType = SkillType::create([
                                'title_id' => $newTranslate
                            ]);

                            $skill['skill_type'] = $skillType->id;
                        }
                    }

                    $newSkill = Skill::create($skill);
                    if($newSkill->id) $evaluation->skills()->attach($newSkill->id);
                }
            }*/
            if(array_key_exists('skills', $request) && count($request['skills']) > 0) {
                $this->attachSkills($evaluation, $request['skills']);
            }

            //MBTI
            if(array_key_exists('mbtis', $request) && count($request['mbtis']) > 0) {
                /*foreach($request['mbtis'] as $mbti) {
                    $possibility = !empty($mbti['pivot']['possibility']) ? $mbti['pivot']['possibility'] : 0;
                    if(!empty($mbti['pivot']['mbti_type'])) $evaluation->mbtis()->attach($mbti['pivot']['mbti_type'], ['possibility' => $mbti['pivot']['possibility']]);
                }*/
                $this->attachMbti($evaluation, $request['mbtis']);
            }

            //Physical
            if(array_key_exists('physical', $request) && count($request['physical']) > 0) {
                /*foreach($request['physical'] as $physical) {
                    if(empty($physical['pivot']['amount'])) continue;
                    if(!empty($physical['pivot']['measurement'])) $evaluation->physical()->attach($physical['pivot']['measurement'], ['amount' => $physical['pivot']['amount']]);
                }*/
                $this->attachPhysical($evaluation, $request['physical']);
            }

            //Job suitability
            if(array_key_exists('job_suitability', $request) && count($request['physical']) > 0) {
                foreach($request['job_suitability'] as $job) {
                    if(!empty($job['create_title'])) {
                        if(!empty($job['job_title_id'])) $translate_id = $job['job_title_id'];
                        else $translate_id = null;

                        $newTranslate = $this->createTranslates($job['create_title'], $translate_id);
                        if(is_null($translate_id)) {
                            $job['job_title_id'] = JobTitle::create(['title_id' => $newTranslate]);
                        }
                    }
                    EvaluationJobSuitability::create($job);
                }
            }

            //Availabilities
            if(array_key_exists('availabilities', $request) && count($request['availabilities']) > 0) {
                /*foreach($request['availabilities'] as $availability) {
                    if(!empty($availability['place_list']) && !empty($availability['place_list']['places'])) {
                        $places = Place::create($availability['place_list'])->id;
                        $availability['places'] = $places->id;
                    }
                    else continue;

                    $newAvailability = Availability::create($availability);
                    $evaluation->availabilities()->attach($newAvailability->id);
                }*/
                $this->attachAvailabilities($evaluation, $request['availabilities']);
            }
        }
    }
}
