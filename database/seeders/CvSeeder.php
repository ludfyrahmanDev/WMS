<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
// use cv model
use App\Models\CV;

class CvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     */
    public function run(): void
    {
        CV::destroy(CV::all()->pluck('id')->toArray()); // Clear existing CVs
        $datas = [
            [
                'name' => 'Perusahaan 1',
                'description' => 'This is a description for Perusahaan 1.',
                'who_create' => 'admin',
                'who_update' => 'admin',
            ],
            [
                'name' => 'Perusahaan 2',
                'description' => 'This is a description for Perusahaan 2.',
                'who_create' => 'admin',
                'who_update' => 'admin',
            ],
            [
                'name' => 'Perusahaan 3',
                'description' => null, // nullable description
                'who_create' => 'admin',
                'who_update' => 'admin',
            ],
        ];

        // Insert the CV data
        foreach ($datas as $data) {
            CV::create($data);
        }
    }
}
