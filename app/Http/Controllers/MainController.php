<?php

namespace App\Http\Controllers;

use App\Models\AccountService;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\AvailabilityType;
use App\Models\CertificationType;
use App\Models\Country;
use App\Models\Currency;
use App\Models\EvaluationMethod;
use App\Models\JobTitle;
use App\Models\Measurement;
use App\Models\SkillType;

class MainController extends Controller {
    public function index($id, $lang) {
        /*$service = AccountService::where('id', '=', $id)->with(['title' => function($query) use($lang) {
            $query->translated($lang);
        }])->get();
        return $service;*/

        $account = Account::with(['services' => function($q) use($lang) {
            $q->with(['title' => function($query) use($lang) {
                $query->translated($lang);
            }]);
        }, 'owner'])->find($id);

        return $account;
    }

    public function addPerson() {

    }

    public function getCountries($lang = 1) {
        return Country::extended($lang)->get();
    }

    public function getAccountTypes() {
        return AccountType::with('allowedServices')->all();
    }

    public function getCertificationTypes($lang = 1) {
        return CertificationType::extended($lang)->get();
    }

    public function getEvaluationMethods($lang = 1) {
        return EvaluationMethod::extended($lang)->get();
    }

    public function getSkillsTypes($lang = 1) {
        return SkillType::extended($lang)->get();
    }

    public function getJobTitles($lang = 1) {
        return JobTitle::extended($lang)->get();
    }

    public function getCurrencies($lang = 1) {
        return Currency::extended($lang)->get();
    }

    public function getMeasurements($lang = 1) {
        return Measurement::extended($lang)->get();
    }

    public function getAvailabilityTypes($lang = 1) {
        return AvailabilityType::extended($lang)->get();
    }
}