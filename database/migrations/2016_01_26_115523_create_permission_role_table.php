<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $connection = config('roles.connection');
        $table = config('roles.permissionsRoleTable');
        $permissionsTable = config('roles.permissionsTable');
        $rolesTable = config('roles.rolesTable');
        $tableCheck = Schema::connection($connection)->hasTable($table);

        if (!$tableCheck) {
            Schema::connection($connection)->create($table, function (Blueprint $table) use ($permissionsTable, $rolesTable): void {
                $table->increments('id')->unsigned();
                $table->integer('permission_id')->unsigned()->index();
                $table->foreign('permission_id')->references('id')->on($permissionsTable)->onDelete('cascade');
                $table->integer('role_id')->unsigned()->index();
                $table->foreign('role_id')->references('id')->on($rolesTable)->onDelete('cascade');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $connection = config('roles.connection');
        $table = config('roles.permissionsRoleTable');
        Schema::connection($connection)->dropIfExists($table);
    }
}
