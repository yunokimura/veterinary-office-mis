<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pet_info', function (Blueprint $table) {
            $table->unsignedBigInteger('pet_id')->primary();
            $table->foreign('pet_id')->references('pet_id')->on('pets')->onDelete('cascade');
            $table->string('is_neutered')->nullable();
            $table->string('is_crossbreed')->nullable();
            $table->string('estimated_age')->nullable();
            $table->string('pet_weight')->nullable();
            $table->json('training')->nullable();
            $table->json('insurance')->nullable();
            $table->json('behavior')->nullable();
            $table->json('likes')->nullable();
            $table->json('dislikes')->nullable();
            $table->json('diet')->nullable();
            $table->json('allergy')->nullable();
            $table->timestamps();
        });

        \DB::table('pet_info')->insertUsing(
            ['pet_id', 'is_neutered', 'is_crossbreed', 'estimated_age', 'pet_weight', 'training', 'insurance', 'behavior', 'likes', 'dislikes', 'diet', 'allergy', 'created_at', 'updated_at'],
            \DB::table('pets')->select(
                'pet_id',
                'is_neutered',
                'is_crossbreed',
                'estimated_age',
                'pet_weight',
                'training',
                'insurance',
                'behavior',
                'likes',
                'dislikes',
                'diet',
                'allergy',
                \DB::raw('NOW()'),
                \DB::raw('NOW()')
            )->whereNotNull('pet_id')
        );

        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn([
                'is_neutered',
                'is_crossbreed',
                'estimated_age',
                'pet_weight',
                'training',
                'insurance',
                'behavior',
                'likes',
                'dislikes',
                'diet',
                'allergy',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->string('is_neutered')->nullable()->after('pet_image');
            $table->string('is_crossbreed')->nullable()->after('is_neutered');
            $table->string('estimated_age')->nullable()->after('is_crossbreed');
            $table->string('pet_weight')->nullable()->after('estimated_age');
            $table->json('training')->nullable()->after('body_mark_details');
            $table->json('insurance')->nullable()->after('training');
            $table->json('behavior')->nullable()->after('insurance');
            $table->json('likes')->nullable()->after('behavior');
            $table->json('dislikes')->nullable()->after('likes');
            $table->json('diet')->nullable()->after('dislikes');
            $table->json('allergy')->nullable()->after('diet');
        });

        Schema::dropIfExists('pet_info');
    }
};
