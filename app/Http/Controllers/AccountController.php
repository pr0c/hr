<?php

namespace App\Http\Controllers;

use App\Models\Account;

class AccountController extends Controller {
    public function getAccount($id) {
        return Account::find($id);
    }

    public function store() {
        $validator = \Validator::make(request()->all(), [
            'type' => 'required|numeric',
            'identifier' => 'required|unique:accounts',
            'provider' => 'numeric'
        ]);

        if($validator->fails()) {
            return $validator->errors();
        }

        $account = new Account();
        $account->fill(request()->all());
        $account->save();

        return $account;
    }
}