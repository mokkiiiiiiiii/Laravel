<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUserIdInUsersAndPostsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::statement('ALTER TABLE posts MODIFY id INT(11) UNSIGNED AUTO_INCREMENT');

        DB::statement('ALTER TABLE users MODIFY id INT(11) UNSIGNED AUTO_INCREMENT');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {



        // users テーブルの id カラムを元に戻す
        DB::statement('ALTER TABLE users MODIFY id INT(10) UNSIGNED AUTO_INCREMENT');

        // posts テーブルの id カラムを元に戻す
        DB::statement('ALTER TABLE posts MODIFY id INT(10) UNSIGNED AUTO_INCREMENT');

        

    }
}
