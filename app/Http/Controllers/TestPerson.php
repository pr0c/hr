<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Certification;
use App\Models\CertificationCategory;
use App\Models\CertificationType;
use App\Models\Country;
use App\Models\Person;

class TestPerson extends Controller {
    public function runStore() {
        $testData = [
            'first_name' => 'Test',
            'middle_name' => 'fon',
            'last_name' => 'Person',
            'gender' => 1,
            'birth_date' => '1945-05-06',
            'birth_place' => 'Lviv',
            'hometown' => 'Kyiv',
            'country' => $this->testCountry()->id,
            'photos' => [
                [
                    'file' => [
                        'id' => 3
                    ]
                ]
            ],
            'certifications' => [
                [
                    'category' => 1
                ]
            ]
        ];

        $person = Person::create($testData);

        foreach($testData['photos'] as $photo) {
            if(empty($photo['file']['id'])) continue;

            $attachment = $person->photos()->create([
                'file_id' => $photo['file']['id']
            ]);

            if(is_null($person->face_pic)) {
                $person->face_pic = $attachment->id;
                $person->save();
            }
            else if($person->face_pic == $photo['id']) {
                $person->face_pic = $attachment['id'];
                $person->save();
            }
        }

        foreach($testData['certifications'] as $certification) {
            $cert = new Certification($certification);
            $person->certifications()->save($cert);
            if(array_key_exists('attachments', $certification) && count($certification['attachments']) > 0) {
                foreach($certification['attachments'] as $attachment) {
                    if(empty($attachment['file']['id'])) continue;

                    $certAttachment = $newCert->attachments()->create([
                        'file_id' => $attachment['file']['id']
                    ]);
                }
            }

            if(array_key_exists('categories', $certification)) {
                foreach ($certification['categories'] as $category) {
                    if (empty($category['id'])) continue;
                    $newCert->categories()->attach($category['id']);
                }
            }
        }

        return Person::extended()->find($person->id);
    }

    public function testCountry($title = 'Ukraine', $lang = 1, $currency = 2) {
        $testData = [
            'title_id' => $this->addText($title, $lang)->translate_id
        ];

        return Country::create($testData);
    }

    public function testCert() {
        $cert = Certification::create([
            'category' => $this->testCertType()->id,
            'owner_id' => 8,
            'owner_type' => 'App\Models\Person'
        ]);
        $cert->categories()->attach($this->testCertCategory()->id);

        return $cert;
    }

    public function testCertType($text = 'Driver\'s license', $lang = 1) {
        return CertificationType::create([
            'title_id' => $this->addText($text, $lang)->translate_id
        ]);
    }

    public function testCertCategory($text = 'A', $lang = 1) {
        return CertificationCategory::create([
            'title_id' => $this->addText($text, $lang)
        ]);
    }
}