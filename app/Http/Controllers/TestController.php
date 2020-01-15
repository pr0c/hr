<?php

namespace App\Http\Controllers;

use App\Jobs\Job;
use App\Models\AccountService;
use App\Models\AccountType;
use App\Models\Availability;
use App\Models\AvailabilityType;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Evaluation;
use App\Models\EvaluationJobSuitability;
use App\Models\EvaluationMethod;
use App\Models\EvaluationSalary;
use App\Models\Group;
use App\Models\JobTitle;
use App\Models\Language;
use App\Models\Mbti;
use App\Models\Measurement;
use App\Models\Place;
use App\Models\Skill;
use App\Models\SkillType;
use App\Models\Text;
use App\Models\Translate;

class TestController extends Controller {
    public function testEvaluation() {
        $testData = [
            'moment' => '1990-11-15',
            'evaluator' => 27,
            'method' => $this->testMethod()->id,
            'person' => 4,
            'public_notes' => 'Test public notes',
            'private_notes' => 'nfdgnpeojfe',
            'salary' => $this->testSalary()->id
        ];

        $evaluation = Evaluation::create($testData);

        $skill = $this->testSkill();
        $evaluation->skills()->attach(4);

        $mbti = $this->testMbti();
        $evaluation->mbtis()->attach($mbti->id);

        $physical = $this->testMeasurement();
        $evaluation->physical()->attach($physical->id, [
            'amount' => 175
        ]);

        $availability = $this->testAvailability();
        $evaluation->availabilities()->attach($availability->id);

        $this->testJobSuitability($evaluation->id);

        return Evaluation::where('id', '=', $evaluation->id)->extended()->get();
    }

    public function testMethod() {
        return EvaluationMethod::create(['title_id' => $this->addText('Fight')->translate_id]);
    }

    public function testSkill() {
        $testData = [
            'skill_type' => $this->testSkillType()->id,
            'years_exp' => 1,
            'hours_exp' => 15,
            'ability' => 4
        ];

        return Skill::create($testData);
    }

    public function testSkillType() {
        $testData = [
            'title_id' => $this->addText('PHP')->translate_id
        ];

        return SkillType::create($testData);
    }

    public function testMbti() {
        $testData = [
            'code' => 'ENJF',
            'role_id' => $this->addText('TestRole')->translate_id,
            'verb_id' => $this->addText('TestVerb')->translate_id
        ];

        return Mbti::create($testData);
    }

    public function testMeasurement() {
        $testData = [
            'title_id' => $this->addText('Weight')->translate_id
        ];

        return Measurement::create($testData);
    }

    public function testSalary() {
        $testData = [
            'last_currency' => $this->testCurrency()->id,
            'perspective' => 1,
            'last_hours' => 15,
            'last_salary' => 1800,
            'last_extras' => 250
        ];

        return EvaluationSalary::create($testData);
    }

    public function testCurrency() {
        $testData = [
            'title_id' => $this->addText('UAH')->translate_id,
            'symbol' => '&'
        ];

        return Currency::create($testData);
    }

    public function testJobSuitability($evaluation_id) {
        $testData = [
            'evaluation_id' => $evaluation_id,
            'job_title_id' => $this->testJobTitle()->id,
            'years_exp' => 5,
            'hour_salary' => 1500,
            'currency' => 7,
            'ability' => 500
        ];

        return EvaluationJobSuitability::create($testData);
    }

    public function testJobTitle($title = "Test Work", $lang = 1) {
        $testData = [
            'title_id' => $this->addText($title, $lang)->translate_id
        ];

        return JobTitle::create($testData);
    }

    public function testAvailability() {
        $testData = [
            'min' => 10,
            'max' => 15,
            'type' => $this->testAvailabilityType()->id,
            'places' =>$this->testPlaces()->id
        ];

        return Availability::create($testData);
    }

    public function testPlaces($places = 'Lviv, Tokyo, Kyiv') {
        $testData = [
            'places' => $places
        ];

        return Place::create($testData);
    }

    public function testAvailabilityType($type = 'Test', $lang = 1) {
        $testData = [
            'title_id' => $this->addText($type, $lang)->translate_id
        ];

        return AvailabilityType::create($testData);
    }

    public function testCountry($name = 'Ukraine', $lang = 1) {
        return Country::create([
            'title_id' => $this->addText($name, $lang)->translate_id
        ]);
    }

    public function testLanguage($title = 'English') {
        return Language::create([
            'title_id' => $this->addText($title)->translate_id
        ]);
    }

    public function testGroup() {
        $this->testLanguage();

        $data = [
            'short_name' => 'Dutchstar',
            'full_name' => 'Dutchstar',
            'email' => 'admin@dutchstar.com',
            'phone' => '77777777',
            'address' => 'addr 33',
            'city' => 'Lviv',
            'country' => $this->testCountry()->id,
            'vat' => '32423423',
            'reg_number' => 95837402432,
            'website' => 'dutchstar.com'
        ];

        $group = Group::create($data);

        $type = $this->testAccountType();
        $type->allowedServices()->attach(AccountService::create([
            'title_id' => $this->addText('SMS')->translate_id
        ])->id);
        $type->allowedServices()->attach(AccountService::create([
            'title_id' => $this->addText('Call')->translate_id
        ])->id);

        $accounts = [
            [
                'type' => $type->id,
                'identifier' => '46984705'
            ]
        ];
        $this->addAccounts($group, $accounts);

        $group->membersHistory()->create([
            'person_id' => 1
        ]);

        return Group::find($group->id)->extended();
    }

    public function testAccountType($type = 'Phone') {
        return AccountType::create([
            'title_id' => $this->addText($type)
        ]);
    }

    /*private function addText($text, $lang = 1) {
        $newText = Text::create();
        if(!$newText->id) return ['error' => $newText];
        $newTranslate = Translate::create(
            [
                'text' => $text,
                'language' => $lang,
                'translate_id' => $newText->id
            ]
        );

        if(!$newTranslate->id) return ['error' => $newTranslate];
        return $newTranslate;
    }*/
}