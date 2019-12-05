<?php

namespace App\Http\Controllers;

use App\Models\AccountService;
use App\Models\Account;

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
}