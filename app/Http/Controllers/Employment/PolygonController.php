<?php

namespace App\Http\Controllers\Employment;

use App\Commands\Employment\WorkProcessCmd;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;

class PolygonController extends EmploymentController
{
    



    public function test()
    {
        /*        \Schema::table('film_episodes', function ($table) {

//            $table->dropColumn('position');
//            $table->dropForeign('film_episodes_user_id_foreign');
//            $table->integer('position')->after('title')->unsigned()->nullable();
            $table->integer('importance')->unsigned()->nullable();
//            $table->foreign('user_id')->references('id')->on('auth_app_users');
        });*/

//        \Schema::table('work_orders', function ($table) {
//
//            $table->dropColumn('description');
//            $table->integer('size')->unsigned()->nullable()->after('mosaic');
//            $table->string('domain_code', 255)->nullable()->after('type');
//            $table->integer('user_id')->unsigned()->default(2);
//
//            $table->foreign('type_id')->references('id')->on('questions_types');
//            $table->foreign('user_id')->references('id')->on('auth_app_users');
//        });
//
        return \Redirect::route('employment_index_page');
    }
}
