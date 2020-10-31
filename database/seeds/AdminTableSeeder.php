<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Admin::class)->times(10)->create();

        $user = \App\Models\Admin::find(1);
        $user->username = 'admin';
        $user->password = bcrypt('admin');
        $user->save();
    }
}
