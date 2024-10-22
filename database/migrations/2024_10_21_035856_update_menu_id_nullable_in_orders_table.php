<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMenuIdNullableInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Mengubah kolom menu_id agar bisa bernilai null
            $table->dropForeign(['menu_id']); // Hapus foreign key constraint
            $table->unsignedBigInteger('menu_id')->nullable()->change(); // Ubah kolom menu_id menjadi nullable
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('set null'); // Tambahkan kembali foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['menu_id']); // Hapus foreign key constraint
            $table->unsignedBigInteger('menu_id')->nullable(false)->change(); // Kembalikan kolom menu_id menjadi tidak nullable
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade'); // Kembalikan pengaturan awal foreign key constraint
        });
    }
}

