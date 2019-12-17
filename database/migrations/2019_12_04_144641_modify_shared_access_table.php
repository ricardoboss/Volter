<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySharedAccessTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shared_access', function (Blueprint $table): void {
            $table->dropColumn('user_id');
        });

        Schema::table('shared_access', function (Blueprint $table): void {
            $table->string('password_id', 36)->change();

            $table->string('model_type')->default(User::class)->after('password_id');
            $table->unsignedBigInteger('model_id')->default(0)->after('model_type');

            $table->string('key')->unique()->change();
            $table->boolean('can_edit')->default(false)->change();

            $table->primary(['password_id', 'model_id', 'model_type']);

            $table->foreign('password_id')->references('id')->on('passwords')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shared_access', function (Blueprint $table): void {
            $table->dropForeign(['password_id']);

            $table->dropPrimary(['password_id', 'model_id', 'model_type']);

            $table->dropColumn('model_id');
            $table->dropColumn('model_type');
            $table->dropColumn('password_id');
        });

        Schema::table('shared_access', function (Blueprint $table): void {
            $table->unsignedBigInteger('password_id')->first();
            $table->unsignedBigInteger('user_id')->after('password_id');
        });
    }
}
