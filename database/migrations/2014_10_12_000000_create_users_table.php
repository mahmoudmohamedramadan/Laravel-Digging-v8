<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* If you want to perform a schema operation on a database connection that is not your application's default connection, use the `connection` method */
        Schema::connection('mysql')->create('users', function (Blueprint $table) {
            $table->id();
            /* There is a `MyISAM` engine type for more info: https://stackoverflow.com/a/57182043/11019205 */
            // $table->engine = 'InnoDB';
            $table->string('name')->fulltext();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable()->invisible();
            $table->string('password');
            $table->string('locale');
            $table->rememberToken();

            /* using `softDeletes` method we can add a `deleted_at` column and, you can the default name also */
            $table->softDeletes();

            /*  using `dropSoftDeletes` method we can drop the `deleted_at` column */
            // $table->dropSoftDeletes();

            /* The `temporary` method may be used to indicate that the table should be "temporary". Temporary tables are only visible to the current connection's database session and are dropped automatically when the connection is closed */
            // $table->temporary();

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
        Schema::dropIfExists('users');
    }
}
