<?php

namespace App\Traits;

trait Account {
    public function scopeExtendedAccount($query, $lang = 1) {
        return $query->with(
            [
                'services' => function($service) use($lang) {
                    $service->with(['title' => function($title) use($lang) {
                        $title->translated($lang);
                    }]);
                },
                'provider'
            ]);
    }

    public function scopeWithUserAccounts($query, $lang = 1) {
        return $query->with(['userAccounts' => function($q) use($lang) {
            return $q->with(['account' => function($account) use($lang) {
                return $account->extendedAccount($lang);
            }]);
        }]);
    }
}