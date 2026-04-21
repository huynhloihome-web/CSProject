<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('san_pham_bhx', function (Blueprint $table) {
            $table->unsignedInteger('ton_kho')->default(100)->after('gia_goc');
        });

        DB::table('san_pham_bhx')->update([
            'ton_kho' => 100,
        ]);
    }

    public function down(): void
    {
        Schema::table('san_pham_bhx', function (Blueprint $table) {
            $table->dropColumn('ton_kho');
        });
    }
};
