<?php

namespace App\Http\Controllers;

use App\Models\AccountService;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\AvailabilityType;
use App\Models\CertificationCategory;
use App\Models\CertificationType;
use App\Models\Country;
use App\Models\Currency;
use App\Models\EvaluationMethod;
use App\Models\Group;
use App\Models\GroupType;
use App\Models\JobTitle;
use App\Models\Language;
use App\Models\Measurement;
use App\Models\Person;
use App\Models\SkillType;
use App\Models\Text;
use App\Models\Translate;
use Illuminate\Support\Facades\DB;

class MainController extends Controller {
    public function index($id, $lang) {
        $account = Account::with(['services' => function($q) use($lang) {
            $q->with(['title' => function($query) use($lang) {
                $query->translated($lang);
            }]);
        }, 'owner'])->find($id);

        return $account;
    }

    /* Initial data
     * */
    public function initiate() {
        //Create languages
        $engText = $this->addText('English');
        $eng = Language::create([
            'title_id' => $engText->translate_id
        ]);

        $uaText = $this->addText('Ukrainian');
        $ua = Language::create([
            'title_id' => $uaText->translate_id
        ]);

        $this->addText('Англійська', $ua->id, $engText->translate_id);
        $this->addText('Українська', $ua->id, $uaText->translate_id);

        //-----------------------------
        //Create countries
        $engUkraineText = $this->addText('Ukraine', $eng->id);
        $uaUkraineText = $this->addText('Україна', $ua->id, $engUkraineText->translate_id);
        $ukraine = Country::create([
            'title_id' => $engUkraineText->translate_id,
            'flag' => 'ua'
        ]);

        //-----------------------------
        //Create account types
        $engContactText = $this->addText('Contact', $eng->id);
        $uaContactText = $this->addText('Зв\'язок', $ua->id, $engContactText->translate_id);
        $engMoneyText = $this->addText('Money', $eng->id);
        $uaMoneyText = $this->addText('Гроші', $ua->id, $engMoneyText->translate_id);
        $engPlatformText = $this->addText('Platform', $eng->id);
        $uaPlatformText = $this->addText('Платформа', $ua->id, $engPlatformText->translate_id);
        $engListingText = $this->addText('Listing', $eng->id);
        $uaListingText = $this->addText('Лістинг', $ua->id, $engListingText->translate_id);

        $engPhoneText = $this->addText('Phone', $eng->id);
        $uaPhoneText = $this->addText('Телефон', $ua->id, $engPhoneText->translate_id);
        $phone = AccountType::create([
            'title_id' => $engPhoneText->translate_id,
            'category' => $engContactText->translate_id
        ]);


        $engEmailText = $this->addText('Email', $eng->id);
        $uaEmailText = $this->addText('Електронна пошта', $ua->id, $engEmailText->translate_id);
        $email = AccountType::create([
            'title_id' => $engEmailText->translate_id,
            'category' => $engContactText->translate_id
        ]);

        $engSkypeText = $this->addText('Skype', $eng->id);
        $uaSkypeText = $this->addText('Skype', $ua->id, $engSkypeText->translate_id);
        $skype = AccountType::create([
            'title_id' => $engSkypeText->translate_id,
            'category' => $engContactText->translate_id
        ]);

        $engPaypalText = $this->addText('PayPal', $eng->id);
        $uaPaypalText = $this->addText('PayPal', $ua->id, $engPaypalText->translate_id);
        $paypal = AccountType::create([
            'title_id' => $engPaypalText->translate_id,
            'category' => $engMoneyText->translate_id
        ]);

        //---------------------------
        //Account services
        $engCallText = $this->addText('Call', $eng->id);
        $uaCallText = $this->addText('Дзвінок', $ua->id, $engCallText->translate_id);
        $call = AccountService::create([
            'title_id' => $engCallText->translate_id
        ]);

        $engSMSText = $this->addText('SMS', $eng->id);
        $uaSMSText = $this->addText('СМС', $ua->id, $engSMSText->translate_id);
        $sms = AccountService::create([
            'title_id' => $engSMSText->translate_id
        ]);

        $phone->allowedServices()->attach([$call->id, $sms->id]);

        //---------------------------
        //Currencies
        $engUSDText = $this->addText('USD', $eng->id);
        $uaUSDText = $this->addText('USD', $ua->id, $engUSDText->translate_id);
        $usd = Currency::create([
            'title_id' => $engUSDText->translate_id,
            'symbol' => '$'
        ]);

        $engUAHText = $this->addText('UAH', $eng->id);
        $uaUAHText = $this->addText('UAH', $ua->id, $engUAHText->translate_id);
        $uah = Currency::create([
            'title_id' => $engUAHText->translate_id,
            'symbol' => '₴'
        ]);
        $ukraine->currency()->attach($uah->id);

        //Group types
        $this->createGroupTypes($eng->id);
    }

    public function createGroupTypes($lang = 1) {
        $categories = [
            'Business',
            'Non-profit',
            'Government',
            'Department',
            'Folder',
            'Event',
            'Personal'
        ];
        $categories_ids = [];

        foreach($categories as $category) {
            $categories_ids[] = $this->addText($category, $lang)->translate_id;
        }

        $types = [
            [
                'Cooperative (Board & Members & Dividend)',
                'Corporation (Limited company)',
                'Limited partnership',
                'General partnership',
                'Sole proprietor (Individual entrepreneur)'
            ],
            [
                'Foundation (Board-only)',
                'Association (Board & Members)'
            ],
            [
                'National government',
                'Local government'
            ],
            [
                'Functional department',
                'Customer department',
                'Geographic department',
                'Process department',
                'Divisional department (Business sector)',
                'Product department'
            ],
            [
                'Team',
                'Contact list'
            ],
            [
                'Project (Work group)',
                'Task (Task group)',
                'Meeting (Attendance)'
            ],
            [
                'Couple',
                'Family',
                'Community',
                'Common-interest group'
            ]
        ];

        for($i = 0; $i < count($types); $i++) {
            foreach($types[$i] as $type) {
                $new_type = GroupType::create([
                    'title_id' => $this->addText($type, $lang)->translate_id,
                    'category' => $categories_ids[$i]
                ]);
            }
        }
    }

    public function getCountriesExtended($lang = 1) {
        return Country::extended($lang)->get();
    }

    public function getCountries($lang = 1) {
        return Country::with(['title' => function($title) use ($lang) {
            $title->translated($lang);
        }])->get();
    }

    public function getAccountTypes($lang = 1) {
        return AccountType::extended($lang)->get()->groupBy('category');
    }

    public function getAccountTypeServices($type, $lang = 1) {
        $account_types = AccountType::where('id', '=', $type)->with(['allowedServices' => function($service) use ($lang) {
            $service->with(['title' => function($title) use ($lang) {
                $title->translated($lang);
            }]);
        }])->get();

        $allowed_services = array_get($account_types->toArray(), '0.allowed_services');
        $services = [];
        foreach($allowed_services as $service) {
            $services[] = [
                "id" => $service['id'],
                "text" => $service['title'][0]['text'],
                "title_id" => $service['title'][0]['translate_id']
            ];
        }
        return $services;
    }

    public function getCertificationTypes($lang = 1) {
        /*$types = CertificationType::with(['title' => function($title) use ($lang) {
            $title->translated($lang);
        }])->get();*/
        return CertificationType::full($lang)->get()->groupBy('category');
    }

    public function getEvaluationMethods($lang = 1) {
        return EvaluationMethod::extended($lang)->get();
    }

    public function getSkillsTypes($lang = 1) {
        return SkillType::extended($lang)->get();
    }

    public function getJobTitles($lang = 1) {
        return JobTitle::extended($lang)->get();
    }

    public function getCurrencies($lang = 1) {
        return Currency::extended($lang)->get();
    }

    public function getMeasurements($lang = 1) {
        return Measurement::extended($lang)->get();
    }

    public function getAvailabilityTypes($lang = 1) {
        return AvailabilityType::extended($lang)->get();
    }

    public function getTranslates($translate_id) {
        return Translate::where('translate_id', '=', $translate_id)->get();
    }

    public function addTranslates($translate_id = null) {
        if(request()->isJson()) {
            $request = json_decode(request()->getContent(), true);

            if(is_null($request)) return ['error' => 'JSON error', 'request' => request()->all()];

            if(is_null($translate_id)) {
                $text = Text::create();
                $translate_id = $text->id;
            }

            foreach($request['texts'] as $translate) {
                $new_translate = Translate::create(array_merge($translate, ['translate_id' => $translate_id]));
            }

            return $translate_id;
        }
        else return ['error' => 'JSON error', 'request' => request()->all()];
    }

    public function updateTranslates($translate_id) {
        if(request()->isJson()) {
            $request = json_decode(request()->getContent(), true);

            if(is_null($request)) return ['error' => 'JSON error', 'request' => request()->all()];

            foreach($request['texts'] as $translate) {
                if(!isset($translate['id'])) continue;
                Translate::find($translate['id'])->fill($translate)->save();
            }
        }
        else return ['error' => 'JSON error', 'request' => request()->all()];
    }

    public function getGroupTypes($lang = 1) {
        return GroupType::extended($lang)->get()->groupBy('category');
    }

    public function findPerson($filter, $lang = 1) {
        $cat_name = '';
        if($lang == 1) $cat_name = 'Persons';
        else if($lang == 2) $cat_name = 'Особи';
        $persons = Person::select('id', DB::raw("CONCAT(`first_name`, ' ', `last_name`) AS title"))->where(DB::raw("CONCAT(`first_name`, ' ', `middle_name`, ' ', `last_name`)"), 'like', '%' . $filter . '%')->skip(0)->take(15)->get();
        $persons->map(function($person) use($cat_name) {
            $person['title'] = [
                [
                    'text' => $person['title']
                ]
            ];
            $person['category_info'] = [
                [
                    'text' => $cat_name
                ]
            ];
            $person['class_type'] = Person::class;

            return $person;
        });

        return [
            "1" => $persons
        ];
    }

    public function findGroup($filter, $lang = 1) {
        $cat_name = '';
        if($lang == 1) $cat_name = 'Groups';
        else if($lang == 2) $cat_name = 'Групи';
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
            $group['class_type'] = Group::class;

            return $group;
        });

        return [
            "2" => $groups
        ];
    }

    public function findEntity($filter, $lang = 1) {
        $persons = $this->findPerson($filter, $lang);
        $groups = $this->findGroup($filter, $lang);

        return
            [
                "1" => array_values($persons)[0],
                "2" => array_values($groups)[0]
            ];
    }

    public function findJobTitle($filter, $lang = 1) {
        /*DB::setFetchMode(\PDO::FETCH_ASSOC);
        $job_titles = DB::table('translates')
            ->join('job_titles', 'translates.translate_id', '=', 'job_titles.title_id')
            ->select('job_titles.id', 'translates.text AS title')
            ->where('translates.text', 'like', '%' . $filter . '%')
            ->where('translates.language', $lang)
            ->skip(0)->take(20)->get();

        if($lang == 1) $cat = 'Roles';
        else if($lang == 2) $cat = 'Посади';

        $job_titles = array_map(function($jobTitle) use ($cat) {
            $jobTitle['title'] = [
                [
                    'text' => $jobTitle['title']
                ]
            ];
            $jobTitle['category_info'] = [
                [
                    'text' => $cat
                ]
            ];

            return $jobTitle;
        }, $job_titles);

        return [
            "1" => $job_titles
        ];*/
        return DB::table('translates')
            ->join('job_titles', 'translates.translate_id', '=', 'job_titles.title_id')
            ->select('job_titles.id', 'translates.text AS title', 'job_titles.title_id')
            ->where('translates.text', 'like', '%' . $filter . '%')
            ->skip(0)->take(20)->get();
    }

    public function getCertificationCategories($typeId, $lang = 1) {
        return DB::table('certification_allowed_categories')
            ->join('certification_categories', 'certification_allowed_categories.category', '=', 'certification_categories.id')
            ->join('translates', function($join) use($lang) {
                $join->on('translates.translate_id', '=', 'certification_categories.title_id');
                $join->where('translates.language', '=', $lang);
            })
            ->where('certification_allowed_categories.type', $typeId)
            ->select('certification_categories.id', 'translates.text')->get();
    }
}