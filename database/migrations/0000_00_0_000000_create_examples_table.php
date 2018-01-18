<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamplesTable extends Migration {

    public function up() {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->timestamps();
            });
        }
        
        $this->col("users", "integer", "name");
        $this->col("users", "string", "email");
        $this->col("users", "string", "password");
    }
    
    /* Añade columnas en producción sin necesitar nuevos archivos de actualización */
    private function col($tablename, $type, $column) {
        if (!Schema::hasColumn($tablename, $column)) {
            Schema::table($tablename, function (Blueprint $table) use ($type, $column) {
                $table->$type($column);
            });
        }
    }

}
