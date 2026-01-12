<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidate_answers', function (Blueprint $table) {
             $table->foreignId('category_id')
                ->after('candidate_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candidate_answers', function (Blueprint $table) {
             $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
