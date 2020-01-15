<?php
namespace App\Http\Controllers;

use App\Models\AccountService;
use App\Models\Person;
use App\Models\Account;
use App\Models\UserAccount;

class PersonController extends Controller {
    public function index() {
        return Person::all();
    }

    public function getPerson($id, $lang = 1) {
        return Person::extended($lang)->find($id);
    }

    public function delete($id) {
        return Person::findOrFail($id)->delete();
    }

    public function update($id) {
        if(request()->isJson()) {
            $request = json_decode(request()->getContent(), true);

            $validator = \Validator::make($request, Person::$validation);

            if($validator->fails()) {
                return $validator->errors();
            }

            $person = Person::find($id);
            if(is_null($person)) return ['error' => '401', 'data' => $id];

            $person->fill($person);
            if(!empty($person->birth_date)) {
                $person->birth_date = date('Y-m-d', strtotime($person->birth_date));
            }
            $person->save();

            if(array_key_exists('user_accounts', $request)) {
                $this->updateAccounts($person, $request['user_accounts']);
            }

            if(array_key_exists('remove_accounts', $request) && count($request['remove_accounts']) > 0) {
                /*for($i = 0; $i < count($request['remove_accounts']); $i++) {
                    $oldAccount = Account::find($request['remove_accounts']);
                    if(!is_null($oldAccount)) {
                        if($oldAccount->owner()->id == $person->id) $oldAccount->delete();
                        else $person->accounts()->detach($request['remove_accounts'][$i]);
                    }
                }*/
                $this->removeAccounts($person, $request['remove_accounts']);
            }
        }
    }

    public function store() {
        if(request()->isJson()) {
            $request = json_decode(request()->getContent(), true);

            $validator = \Validator::make($request, Person::$validation);

            if($validator->fails()) {
                return $validator->errors();
            }

            $person = new Person();
            $person->fill($request);

            if(!empty($person->birth_date)) $this->formatDate($person->birth_date);
            $person->save();

            if(array_key_exists('user_accounts', $request)) {
                $this->addAccounts($person, $request['user_accounts']);
            }

            if(array_key_exists('certifications', $request)) {
                $person->certifications()->create($request['certifications']);
            }

            return Person::extended()->find($person->id);
        }

        return false;
    }

    public function changeFacePic($id, $file_id) {
        $file = File::find($file_id);
        $person = Person::find($id);
        
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
                $person->ownAccounts()->save($account);
            }
        }

        $person['accounts'] = $person->accounts;
        return $person;
    }

}