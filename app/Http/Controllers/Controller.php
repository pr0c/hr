<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Account;
use App\Models\AccountService;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function addAccounts($entity, $accounts) {
        foreach($accounts as $account) {
            if(!$account['account']) continue;
            else $account = $account['account'];

            if(empty($account['owner_id']) && !Account::isExist($account['identifier'])) {
                $validator = \Validator::make($account, Account::$validation);
                if($validator->fails()) {
                    return $validator->errors();
                }

                $newAccount = $entity->ownAccounts()->create($account);

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

                $entity->userAccounts()->create([
                    'account_id' => $accountID
                ]);
            }

            if($account['services'] && empty($account['id'])) {
                $services = AccountService::find(array_pluck($account['services'], 'pivot.service_id'));
                foreach($services as $service) {
                    $newAccount->services()->attach($service);
                }
            }
        }
    }
}
