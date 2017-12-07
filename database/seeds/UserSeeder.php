<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $group = App\Models\UserGroup::where('name', 'Admin')->first();

        App\User::create([   'group_id' => $group->id,
                             'name' => 'Администратор',
                             'email' => 'admin@admin.com',
                             'password' => bcrypt('qwerty')
                           ]);
    }
}
