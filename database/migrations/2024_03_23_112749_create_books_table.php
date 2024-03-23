<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->text('title'); // title => ['ar' =>  , 'en' =>  ]
            $table->text('description'); // description => ['ar' =>  , 'en' =>  ]
            $table->string('author');
            $table->string('path');
            $table->string('url');
            $table->string('isbn')->unique();
            // images => relation one to many with Image Model
            // tags => relation many to many with Tag Model
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
