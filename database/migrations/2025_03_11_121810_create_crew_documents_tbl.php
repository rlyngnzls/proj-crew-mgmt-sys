<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrewDocumentsTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crew_documents_tbl', function (Blueprint $table) {
            $table->id();
            $table->string('crew_id');
            $table->string('code');
            $table->string('document_no');
            $table->string('document_name');
            $table->string('file_name');
            $table->date('issued_date');
            $table->date('expiry_date');
            $table->string('person_in_charge');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crew_documents_tbl');
    }
}
