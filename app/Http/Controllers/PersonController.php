<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Account;

class PersonController extends Controller {
    public function getPerson($id, $lang = 1) {
        return Person::extendedAccount($lang)->find($id);
    }

    public function store() {
        $validator = \Validator::make(request()->all(), [
            'first_name' => 'required|alpha',
            'middle_name' => 'alpha',
            'last_name' => 'required|alpha',
            'gender' => 'numeric',
            'birth_date' => 'date',
            'face_pic' => 'numeric'
        ]);

        if($validator->fails()) {
            return $validator->errors();
        }

        $person = new Person();
        $person->fill(request()->all());
        if (!empty($person->birth_date)) {
            $person->birth_date = date('Y-m-d', strtotime($person->birth_date));
        }
        $person->save();

        if(request()->has('accounts')) {
            $person->accounts()->createMany(request()->input('accounts'));
        }

        return $person;
    }

    public function ownAccount() {
        if(request()->has(['person_id', 'account_id'])) {
            $personID = request()->input('person_id');
            $accountID = request()->input('account_id');
        }
        else return false;

        $person = Person::find($personID);
        if($person) {
            $account = Account::find($accountID);
            if($account) {
                $person->accounts()->save($account);
            }
        }

        $person['accounts'] = $person->accounts;
        return $person;
    }

}