<?php

use Illuminate\Database\Seeder;

class ApiModel1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment('puppet_test')) {
            $count = 0;
            for ($count = 0; $count < 10; $count++) {
                $a = new ApiModel1();
                $a->setAttributes(['fname' => 'fn' . $count, 'lname' => 'ln' . $count, 'email' => 'email' . $count . '@mail.com', 'town' => 'town' . $count]);
                $a->save();
            }

        } else {
            factory('App\ApiModel1', 10)->create();
        }
    }
}
