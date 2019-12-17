<?php
namespace App\Http\Controllers;

use App\Models\AccountService;
use App\Models\Person;
use App\Models\Account;
use App\Models\UserAccount;

class PersonController extends Controller {
    public function getPerson($id, $lang = 1) {
        return Person::withUserAccounts($lang)->find($id);
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

            if(array_key_exists('user_accounts', $request)) {
                /*foreach($request['user_accounts'] as $account) {
                    if(!$account['account']) continue;
                    else $account = $account['account'];

                    if(empty($account['owner_id']) && !Account::isExist($account['identifier'])) {
                        $validator = \Validator::make($account, Account::$validation);
                        if($validator->fails()) {
                            return $validator->errors();
                        }

                        $newAccount = $person->ownAccounts()->create($account);

                        UserAccount::create([
                            'account_id' => $newAccount->id,
                            'user_id' => $newAccount->owner_id,
                            'user_type' => $newAccount->owner_type
                        ]);
                    }
                    else {
                        if(empty($account['id'])) {
                            $validator = \Validator::make($account, Account::$validation);
                            if($validator->fails()) {
                                return $validator->errors();
                            }
                            $newAccount = Account::create($account);
                            $accountID = $newAccount->id;
                        }
                        else $accountID = $account['id'];

                        $person->userAccounts()->create([
                            'account_id' => $accountID
                        ]);
                    }

                    if($account['services'] && empty($account['id'])) {
                        $services = AccountService::find(array_pluck($account['services'], 'pivot.service_id'));
                        foreach($services as $service) {
                            $newAccount->services()->attach($service);
                        }
                    }
                }*/
                $this->addAccounts($person, $request['user_accounts']);
            }

            return Person::withUserAccounts()->find($person->id);
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