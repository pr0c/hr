<?php

namespace App\Http\Controllers;

use App\Models\AccountType;

class AccountTypeController extends Controller {
    public function index($lang = 1) {
        return AccountType::with(['allowedServices' => function($service) use ($lang) {
            $service->with(['title' => function($title) use ($lang) {
                $title->translated($lang);
            }]);
        }])->get();
    }
}