<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jd extends Model {
    protected $fillable = [
        'job_title_id',
        'text_id',
        'title_id',
        'owner_id',
        'owner_type'
    ];
    public $timestamps = false;

    public static $validation = [];

    public function scopeExtended($query, $lang = 1) {
        return $query->with(
            [
                'jobTitle' => function($jobTitle) use ($lang) {
                    $jobTitle->translated($lang);
                },
                'text' => function($text) use ($lang) {
                    $text->translated($lang);
                },
                'title' => function($title) use ($lang) {
                    $title->translated($lang);
                },
                'owner',
                'skills' => function($skill) use ($lang) {
                    $skill->with(['type' => function($skillType) use($lang) {
                        $skillType->with(['title' => function($skillTypeTitle) use($lang) {
                            $skillTypeTitle->translated($lang);
                        }]);
                    }]);
                },
                'duties' => function($duty) use ($lang) {
                    $duty->with(['title' => function($dutyTitle) use ($lang) {
                        $dutyTitle->translated($lang);
                    }]);
                },
                'physicals' => function($physical) use($lang) {
                    $physical->with(['title' => function($physicalTitle) use ($lang) {
                        $physicalTitle->translated($lang);
                    }]);
                },
                'mbtis' => function($mbti) use ($lang) {
                    $mbti->extended($lang);
                },
                'benefits' => function($benefit) use($lang) {
                    $benefit->with(
                        [
                            'benefit' => function($benefitTitle) use($lang) {
                                $benefitTitle->translated($lang);
                            },
                            'type' => function($benefitType) use($lang) {
                                $benefitType->with(['title' => function($benefitTypeTitle) use($lang) {
                                    $benefitTypeTitle->translated($lang);
                                }]);
                            }
                        ]
                    );
                },
                'availabilities' => function($availabilities) use ($lang) {
                    $availabilities->with(
                        [
                            'places',
                            'title' => function($title) use ($lang) {
                                $title->translated($lang);
                            }
                        ]
                    );
                }
            ]
        );
    }

    public function jobTitle() {
        return $this->hasMany(Translate::class, 'translate_id', 'job_title_id');
    }

    public function text() {
        return $this->hasMany(Translate::class, 'translate_id', 'text_id');
    }

    public function title() {
        return $this->hasMany(Translate::class, 'translate_id', 'title_id');
    }

    public function owner() {
        return $this->morphTo('owner');
    }

    public function skills() {
        return $this->belongsToMany(Skill::class, 'jd_skills', 'skill_id', 'jd_id');
    }

    public function duties() {
        return $this->belongsToMany(Duty::class, 'jd_duties', 'duty_id', 'jd_id');
    }

    public function physicals() {
        return $this->belongsToMany(Measurement::class, 'jd_physical', 'physical_type', 'jd_id');
    }

    public function mbtis() {
        return $this->belongsToMany(Mbti::class, 'jd_mbti', 'mbti_type', 'jd_id');
    }

    public function benefits() {
        return $this->belongsToMany(Benefit::class, 'jd_benefits', 'benefit', 'jd_id')->withPivot([
            'week_days', 'frequency', 'availability', 'private'
        ]);
    }

    public function availabilities() {
        return $this->belongsToMany(AvailabilityType::class, 'jd_availabilities', 'type', 'jd_id');
    }

    public function certifications() {
        return $this->morphMany(Certification::class, 'owner');
    }
}