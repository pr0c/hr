<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Account;

class GroupController extends Controller {
    public function get($id, $lang = 1) {

    }

    public function store() {
        if(request()->isJson()) {
            $request = json_decode(request()->getContent(), true);
            if(is_null($request)) return false;

            $validator = \Validator::make($request, Group::$validation);
            if($validator->fails()) {
                return $validator->errors();
            }

            $group = Group::create($request);

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
                $this->addAccounts($group, $request['user_accounts']);
            }
        }
    }
}