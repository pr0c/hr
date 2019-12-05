<?php

namespace App\Traits;

trait Account {
    public function scopeExtendedAccount($query, $lang = 1) {
        return $query->with(['accounts' => function($account) use($lang) {
            $account->with(['services' => function($service) use($lang) {
                $service->with(['title' => function($title) use($lang) {
                    $title->translated($lang);
                }]);
            }]);
        }]);
    }
}