<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
<<<<<<< HEAD
use Illuminate\Support\Facades\Schema;
=======
use Illuminate\Support\Facades\{
    DB,
    Schema
};
>>>>>>> 2c04c23 (Init commit)

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->char('name', 191)->unique();
            $table->text('description');
            $table->timestamps();
        });
<<<<<<< HEAD
=======

        $this->initPermissionsTable();
>>>>>>> 2c04c23 (Init commit)
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
<<<<<<< HEAD
=======

    private function initPermissionsTable()
    {
        $data = [
            [
                'name' => 'full-granted',
                'description' => 'The user can attend both admin panel and api docs pages',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'api-mobile-granted',
                'description' => 'The user can attend only mobile api docs page',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        
        DB::table('permissions')->insert($data);
    }
>>>>>>> 2c04c23 (Init commit)
}
