<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dogs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('name')->unique();
            $table->boolean('tame');
            $table->timestamps();

            /* The temporary method may be used to indicate that the table should be `temporary`. Temporary tables are only visible to the current connection's database session and are dropped automatically when the connection is closed: */
            // $table->temporary();

            /* The `char` method creates a CHAR equivalent column with of a given length */
            // $table->char('is_admin', 1);

            /* the difference between JSON and JSONB >> https://www.quora.com/Which-is-better-to-use-json-jsonb-or-string-to-store-additional-data-which-is-not-used-frequently-in-PostgreSQL-What-would-be-the-reason-for-this */
            // $table->jsonb('test_jsonb');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dogs');
    }

    ## Anonymous Migrations
    /* As you may have noticed in the example above, Laravel will automatically assign a class name to all of the migrations that you generate using the `make:migration` command. However, if you wish, you may return an anonymous class from your migration file. This is primarily useful if your application accumulates many migrations and two of them have a class name collision */
}
