<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\Setting::firstOrCreate([
            'type'  => 'string',
            'var'   => 'perpage',
            'value' => 9
        ]);

        App\Models\Setting::firstOrCreate([
            'type'  => 'string',
            'var'   => 'phone_number',
            'value' => '+7 (495) <span class="mod-bold">139-60-71</span>'
        ]);

        App\Models\Setting::firstOrCreate([
            'type'  => 'string',
            'var'   => 'email_support',
            'value' => 'test@example.com'
        ]);

        App\Models\Setting::firstOrCreate([
            'type'  => 'string',
            'var'   => 'email_order',
            'value' => 'zakaz@gardenka.ru'
        ]);

        App\Models\Setting::firstOrCreate([
            'type'  => 'string',
            'var'   => 'address',
            'value' => 'г. Москва, 92 км. МКАД (внешняя сторона), ТК "Садовод в Тайнинском", линия Д, пав. 27.'
        ]);

        App\Models\Setting::firstOrCreate([
            'type'  => 'array',
            'var'   => 'schedule',
            'value' => '{"start_workday":"9:00","end_workday":"19:00","start_weekend":"10:00","end_weekend":"17:00"}'
        ]);
    }
}
