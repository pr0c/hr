<?php

namespace App\Http\Controllers;

use App\Models\Text;
use App\Models\Translate;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Account;
use App\Models\AccountService;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function updateAccounts($entity, $accounts) {
        $forAdd = [];

        foreach($accounts as $account) {
            if(!$account['account']) continue; //continue if account information is empty
            else {
                if(empty($account['account_id'])) { //if account doesn't exist - add to array and skip
                    $forAdd[] = $account;
                    continue;
                }

                $account = Account::find($account['account_id']);
                $accountData = $account['account'];
                $account->fill($accountData)->save();

                if(array_key_exists('services', $accountData)) {
                    $account->services()->detach();
                    foreach($accountData['services'] as $service) {
                        $account->services()->attach($service['id']);
                    }
                }
            }
        }

        if(count($forAdd) > 0) $this->addAccounts($entity, $forAdd); //create skipped accounts and attach to entity
    }

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

    protected function removeAccounts($entity, $accounts) {
        for($i = 0; $i < count($accounts); $i++) {
            $oldAccount = Account::find($accounts[$i]);
            if(!is_null($oldAccount)) {
                if($oldAccount->owner()->id == $entity->id) $oldAccount->delete();
                else $entity->accounts()->detach($accounts[$i]);
            }
        }
    }

    protected function formatDate(&$date) {
        if (!empty($date)) {
            $date = date('Y-m-d', strtotime($date));
        }
    }

    protected function attachSkills(&$entity, $skills) {
        foreach($skills as $skill) {
            if(!empty($skill['title'])) {
                if(!empty($skill['skill_type'])) $translate_id = $skill['type']['title']['translate_id'];
                else {
                    $translate_id = null;
                }

                $newTranslate = $this->createTranslates($skill['title'], $translate_id);
                if(is_null($translate_id)) {
                    $skillType = SkillType::create([
                        'title_id' => $newTranslate
                    ]);

                    $skill['skill_type'] = $skillType->id;
                }
            }

            $newSkill = Skill::create($skill);
            if($newSkill->id) $entity->skills()->attach($newSkill->id);
        }
    }

    protected function attachMbti(&$entity, $mbtis) {
        foreach($mbtis as $mbti) {
            $possibility = !empty($mbti['pivot']['possibility']) ? $mbti['pivot']['possibility'] : 0;
            if(!empty($mbti['pivot']['mbti_type'])) $entity->mbtis()->attach($mbti['pivot']['mbti_type'], ['possibility' => $mbti['pivot']['possibility']]);
        }
    }

    protected function attachAvailabilities(&$entity, $availabilities) {
        foreach($availabilities as $availability) {
            if(!empty($availability['place_list']) && !empty($availability['place_list']['places'])) {
                $places = Place::create($availability['place_list'])->id;
                $availability['places'] = $places->id;
            }
            else continue;

            $newAvailability = Availability::create($availability);
            $entity->availabilities()->attach($newAvailability->id);
        }
    }

    protected function attachPhysical(&$entity, $physicals) {
        foreach($physicals as $physical) {
            if(empty($physical['pivot']['amount'])) continue;
            if(!empty($physical['pivot']['measurement'])) $entity->physical()->attach($physical['pivot']['measurement'], ['amount' => $physical['pivot']['amount']]);
        }
    }

    protected function addText($text, $lang = 1, $textID = null) {
        if(is_null($textID)) {
            $newText = Text::create();
            if (!$newText->id) return ['error' => $newText];
            else $textID = $newText->id;
        }

        $newTranslate = Translate::create(
            [
                'text' => $text,
                'language' => $lang,
                'translate_id' => $textID
            ]
        );

        if(!$newTranslate->id) return ['error' => $newTranslate];
        return $newTranslate;
    }

    protected function createTranslates($texts, $translate_id = null) {
        $i = 0;
        foreach($texts as $lang => $text) {
            if($i == 0 && is_null($translate_id)) $translate_id = $this->addText($text, $lang)->translate_id;
            else $this->addText($text, $lang, $translate_id);
            $i++;
        }

        return $translate_id;
    }
}
