<?php
namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Account;
use App\Models\UserAccount;

class PersonController extends Controller {
    public function getPerson($id, $lang = 1) {
        return Person::extendedAccount($lang)->find($id);
    }

    public function delete($id) {
        return Person::findOrFail($id)->delete();
    }

    public function store() {
        if(request()->isJson()) {
            $request = json_decode(request()->getContent(), true);

            $validator = \Validator::make($request, [
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
            $person->fill($request);

            if (!empty($person->birth_date)) {
                $person->birth_date = date('Y-m-d', strtotime($person->birth_date));
            }
            $person->save();

            if(array_key_exists('accounts', $request)) {
                foreach($request['accounts'] as $account) {
                    if(empty($account['owner_id'])) {
                        $newAccount = $person->accounts()->create($account);
                        UserAccount::create([
                            'account_id' => $newAccount->id,
                            'user_id' => $newAccount->owner_id,
                            'user_type' => $newAccount->owner_type
                        ]);
                    }
                    else {
                        $newAccount = Account::fill($account)->save();
                        UserAccount::create([
                            'account_id' => $newAccount->id,
                            'user_id' => $person->id,
                            'user_type' => Person::class
                        ]);
                    }
                }
            }
            //TODO return person with full information
            return $person->withUserAccounts();
        }

        return false;
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