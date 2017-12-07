<?php

use Illuminate\Database\Seeder;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\UserGroup::create(['name' => 'Admin', 'descr' => 'Группа администратора, с полными провами']);
        App\Models\UserGroup::create(['name' => 'Moderator', 'descr' => 'Группа модераторов, с ограниченным кол-вом прав']);
    }
}
