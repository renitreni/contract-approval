<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficialCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('official_cases', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->integer('company_id')->nullable();
            $table->date('suspension_date')->nullable();
            $table->date('lifted_date')->nullable();
            $table->integer('days_suspended')->nullable();
            $table->integer('employer_id')->nullable();
            $table->string('case_officer')->nullable();
            $table->string('worker_id')->nullable();
            $table->string('atnsia_no')->nullable();
            $table->integer('complaint_id')->nullable();
            $table->text('complaint')->nullable();
            $table->text('remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('official_cases');
    }
}
