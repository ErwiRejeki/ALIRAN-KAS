<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Kas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kas', function (Blueprint $table) {
            $table->string('kas_id')->primary();
            $table->date('kas_tgl')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('kas_type')->default('transaksi');
            $table->string('kas_ket')->nullable();
            $table->string('kas_id_value')->nullable();
            $table->double('kas_debet',15)->default(0);
            $table->double('kas_kredit',15)->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'))->nullable();
            $table->softDeletes('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kas');
    }
}
