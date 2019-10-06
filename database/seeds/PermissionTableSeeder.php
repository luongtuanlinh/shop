<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i = 8; $i < 20; $i++){
            $permission_roles[] = [
                "role_id" => 1,
                "permission_id" => $i,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ];
        }

        DB::table("permission_roles")->insert($permission_roles);
    }
}
