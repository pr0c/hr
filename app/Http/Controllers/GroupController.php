<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\JobHistory;
use App\Models\JobTitle;

class GroupController extends Controller {
    public function get($id, $lang = 1) {
        return Group::full($lang)->find($id);
    }

    public function index($lang = 1) {
        return Group::all();
    }

    public function store() {
        if(request()->isJson()) {
            $request = json_decode(request()->getContent(), true);
            if(is_null($request)) return ['error' => 'JSON error', 'request' => request()->all()];

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

            if(array_key_exists('members_history', $request)) {
                foreach($request['members_history'] as $member) {
//                    $this->addMember($group, $member);
                    $this->modifyMember($group, $member);
                }
            }

            return Group::full()->find($group->id);
        }
    }

    public function update($groupID) {
        if(request()->isJson()) {
            $request = json_decode(request()->getContent(), true);
            if(is_null($request)) return false;

            $validator = \Validator::make($request, Group::$validation);
            if($validator->fails()) {
                return $validator->errors();
            }

            try {
                $group = Group::findOrFail($groupID);
            }
            catch(Exception $ex) {
                return ['error' => $ex];
            }

            $group->fill($request);
            $group->save();

            if(array_key_exists('user_accounts', $request)) {
                $this->updateAccounts($group, $request['user_accounts']);
            }

            if(array_key_exists('remove_accounts', $request)) {
                $this->removeAccounts($group, $request['remove_accounts']);
            }

            if(array_key_exists('members_history', $request)) {
                foreach($request['members_history'] as $member) {
                    $this->modifyMember($group, $member);
                }
            }

            if(array_key_exists('remove_members', $request) && count($request['remove_members']) > 0) {
                foreach($request['remove_members'] as $memberHistory) {
                    $group->membersHistory()->detach($memberHistory);
                    JobHistory::find($memberHistory)->delete();
                }
            }
        }
    }

    protected function modifyMember($group, $member) {
        if(array_key_exists('create_title', $member) && count($member['create_title']) > 0) {
            $translate_id = null;

            if(array_key_exists('job_title_id', $member) && !empty($member['job_title_id'])) {
                $jobTitle = JobTitle::find($member['job_title_id']);

                foreach($member['create_title'][0] as $lang => $text) {
                    $this->addText($text, $lang, $jobTitle->title_id);
                }
            }
            else {
                foreach($member['create_title'][0] as $lang => $text) {
                    $title = JobTitle::create([
                        'title_id' => $this->addText($text, $lang, $translate_id)->translate_id
                    ]);

                    if(is_null($translate_id)) {
                        $translate_id = $title->load('title')->translate_id;
                        $member['job_title_id'] = $title->id;
                    }
                }
            }
        }

        if(array_key_exists('start_date', $member)) $this->formatDate($member['start_date']);
        if(array_key_exists('end_date', $member)) $this->formatDate($member['end_date']);

        if(array_key_exists('add', $member))
            $group->membersHistory()->create($member);
        else if(isset($member['id'])) {
            $newMember = JobHistory::find($member['id']);
            $newMember->fill($member);
            $newMember->save();
        }
    }
}