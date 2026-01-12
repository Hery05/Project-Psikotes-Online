<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {

            // tambahkan kolom options jika belum ada
            if (!Schema::hasColumn('questions', 'options')) {
                $table->json('options')->nullable()->after('question_image');
            }

            // hapus kolom lama jika ada
            foreach (['option_a','option_b','option_c','option_d','option_e'] as $col) {
                if (Schema::hasColumn('questions', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }

    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {

            $table->string('option_a')->nullable();
            $table->string('option_b')->nullable();
            $table->string('option_c')->nullable();
            $table->string('option_d')->nullable();
            $table->string('option_e')->nullable();

            $table->dropColumn('options');
        });
    }
};

