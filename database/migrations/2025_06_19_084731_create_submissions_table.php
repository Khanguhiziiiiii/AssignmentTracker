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
         Schema::create('submissions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('assignment_id')->constrained()->onDelete('cascade');
        $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
        $table->string('file_path')->nullable(); // path to uploaded file
        $table->text('comments')->nullable();    // optional comment field
        $table->decimal('grade', 5, 2)->nullable(); // e.g. 89.50
        $table->timestamps();

        $table->unique(['assignment_id', 'student_id']); // one submission per student per assignment
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submissions');
    }
};
