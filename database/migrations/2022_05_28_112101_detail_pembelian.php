<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DetailPembelian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pembelian', function (Blueprint $table) {
            $table->string('id_det_beli')->primary();
            $table->decimal('jml_beli', 15,2);
            $table->double('harga_beli',15);
            $table->string('id_barang');
            $table->foreign('id_barang')->references('id_barang')->on('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->string('id_beli')->nullable();
            $table->foreign('id_beli')->references('id_beli')->on('pembelian')->onUpdate('cascade')->onDelete('cascade');
            
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
        Schema::dropIfExists('detail_pembelian');
    }
}
