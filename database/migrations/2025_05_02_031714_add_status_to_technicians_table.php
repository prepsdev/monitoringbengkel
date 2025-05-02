<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('technicians', function (Blueprint $table) {
            $table->string('status')->default('Aktif'); // Default status is "Aktif"
        });
    }

    public function down()
    {
        Schema::table('technicians', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
