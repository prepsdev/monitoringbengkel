<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('works', function (Blueprint $table) {
            $table->text('job_desc')->nullable();
            $table->text('note')->nullable();
        });
    }

    public function down()
    {
        Schema::table('works', function (Blueprint $table) {
            $table->dropColumn(['job_desc', 'note']);
        });
    }
};
