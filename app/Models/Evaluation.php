<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model {
    protected $fillable = [
        'moment', 'evaluator', 'method', 'person', 'public_notes', 'private_notes', 'attachments', 'salary'
    ];
    protected $table = 'evaluations';
    public $timestamps = false;
    public static $validation = [
        'moment' => 'date',
        'method' => 'numeric',
        'person' => 'required|numeric'
    ];

    public function person() {
        return $this->hasOne(Person::class, 'id', 'person');
    }

    public function evaluator() {
        return $this->hasOne(Person::class, 'id', 'evaluator');
    }

    public function attachments() {
        return $this->hasMany(Attachment::class, 'attachment_id', 'attachments');
    }

    public function method() {
        return $this->hasOne(EvaluationMethod::class, 'id', 'method');
    }

    public function skills() {
        return $this->belongsToMany(Skill::class, 'evaluation_skills', 'evaluation_id', 'skill_id');
    }

    public function mbtis() {
        return $this->belongsToMany(Mbti::class, 'evaluation_mbti', 'evaluation_id', 'mbti_type');
    }

    public function physical() {
        return $this->belongsToMany(Measurement::class, 'evaluation_physicals', 'evaluatin_id', 'physical_type');
    }

    public function salaries() {
        return $this->hasMany(EvaluationSalary::class, 'id', 'salary');
    }

    public function job_suitability() {
        return $this->hasMany(EvaluationJobSuitability::class, 'evaluation_id', 'id');
    }

    public function availabilities() {
        return $this->belongsToMany(Availability::class, 'evaluation_availabilities', 'type', 'evaluation_id');
    }

    public function scopeExtended($query, $lang = 1) {
        return $query->with([
            'person',
            'evaluator',
            'attachments' => function($attachment) {
                $attachment->with('file');
            },
            'method' => function($method) use ($lang) {
                $method->with(['title' => function($methodTitle) use ($lang) {
                    $methodTitle->translated($lang);
                }]);
            },
            'skills' => function($skill) use ($lang) {
                $skill->extended($lang);
            },
            'mbtis' => function($mbti) use ($lang) {
                $mbti->extended($lang);
            },
            'physical' => function($physical) use ($lang) {
                $physical->with(['title' => function($measurementTitle) use ($lang) {
                    $measurementTitle->translated($lang);
                }]);
            },
            'salaries' => function($salary) use ($lang) {
                $salary->with([
                    'last_currency' => function($last_currency) use ($lang) {
                        $last_currency->with(['title' => function($currencyTitle) use ($lang) {
                            $currencyTitle->translated($lang);
                        }]);
                    },
                    'new_currency' => function($new_currency) use ($lang) {
                        $new_currency->with(['title' => function($currencyTitle) use ($lang) {
                            $currencyTitle->translated($lang);
                        }]);
                    }
                ]);
            },
            'job_suitability' => function($job_suitability) use ($lang) {
                $job_suitability->with(
                    [
                        'job_title' => function($job_title) use ($lang) {
                            $job_title->with(['title' => function($jobTitle) use ($lang) {
                                $jobTitle->translated($lang);
                            }]);
                        },
                        'currency' => function($currency) use ($lang) {
                            $currency->with(['title' => function($currencyTitle) use ($lang) {
                                $currencyTitle->translated($lang);
                            }]);
                        }
                    ]
                );
            },
            'availabilities' => function($availability) use ($lang) {
                $availability->with(
                    [
                        'places',
                        'title' => function($title) use ($lang) {
                            $title->translated($lang);
                        }
                    ]
                );
            }
        ]);
    }
}