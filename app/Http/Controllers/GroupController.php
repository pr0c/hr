<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\JobHistory;
use App\Models\JobTitle;
use Doctrine\DBAL\Schema\Table;
use Illuminate\Support\Facades\DB;

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
                try {
                    $this->addAccounts($group, $request['user_accounts']);
                }
                catch(\Exception $ex) {
                    return ['error' => $ex];
                }
            }

            if(array_key_exists('members_history', $request) && count($request['members_history']) > 0) {
                foreach($request['members_history'] as $member) {
//                    $this->addMember($group, $member);
                    $this->modifyMember($group, $member);
                }
            }

            return ['id' => $group->id];
        }
        else return request()->all();
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

            $group->fill($request)->save();

            if(array_key_exists('user_accounts', $request)) {
                $this->updateAccounts($group, $request['user_accounts']);
            }

            if(array_key_exists('remove_accounts', $request) && count($request['remove_accounts']) > 0) {
                $this->removeAccounts($group, $request['remove_accounts']);
            }

            if(array_key_exists('members_history', $request)) {
                foreach($request['members_history'] as $member) {
                    $this->modifyMember($group, $member);
                }
            }

            if(array_key_exists('remove_members', $request) && count($request['remove_members']) > 0) {
                foreach($request['remove_members'] as $memberHistory) {
                    $group->membersHistory()->where('id', $memberHistory)->delete();
                }
            }

            return ['true'];
        }
    }

    public function find($filter, $lang = 1) {
        $cat_name = '';
        if($lang == 1) $cat_name = 'Groups';
        else if($lang == 2) $cat_name = 'Групи';
//        $groups = Group::extended($lang)->where('full_name', 'like', '%' . $filter . '%')->skip(0)->take(15)->get();
        $groups = Group::select('id', 'full_name AS title')->where('full_name', 'like', '%' . $filter . '%')->skip(0)->take(15)->get();
        $groups->map(function($group) use($cat_name) {
            $group['title'] = [
                [
                    'text' => $group['title']
                ]
            ];
            $group['category_info'] = [
                [
                    'text' => $cat_name
                ]
            ];

            return $group;
        });

        return [
            "2" => $groups
        ];
    }

    public function getDepartments($id, $lang = 1) {
        $departments = Group::select('id', 'full_name AS title')
            ->where('owner_id', $id)
            ->where('owner_type', 'App\\Models\\Group')->get();

        if($lang == 1) $cat = 'Departments';
        else if($lang == 2) $cat = 'Відділи';

        $departments->map(function($department) use($cat) {
            $department['title'] = [
                [
                    'text' => $department['title']
                ]
            ];
            $department['category_info'] = [
                [
                    'text' => $cat
                ]
            ];

            return $department;
        });

        return [
            "1" => $departments
        ];
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