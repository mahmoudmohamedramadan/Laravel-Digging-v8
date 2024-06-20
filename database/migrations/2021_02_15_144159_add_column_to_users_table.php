<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* To create a new database table, the `Schema::create` method is used (--create option) and to update an existing table, we can use the `Schema::table` method method is used (--table option), NOTE that you can change the arrangment of the migration files via change the timestamp before the migration name, NOTE also you can this file using snake case or using whitespaces like so "add column to users table" */
        Schema::table('users', function (Blueprint $table) {
            /* you can specify from where you must start counting using `from` method */
            // $table->integer('test_integer_number')->from(1000);

            // $table->string('details')->nullable()->before('deleted_at');

            /* if you want to use `change` method, you must run `composer require doctrine/dbal` */
            // $table->string('details', 100)->after('morrrph_id')->change();

            /* or you can use `after` method like so */
            // $table->after('morrrph_id', function ($afterColumn) {
            //     $afterColumn->string('details', 100);
            // });

            // $table->text('details')->before('morrrph_id');
            // $table->text('details')->first('morrrph_id');
            // $table->text('details')->nullable();
            // $table->text('details')->default('bla');
            // $table->text('details')->primary();
            // $table->text('details')->index();

            /* you can specify a default value for the `timestamp` while creating ONLY */
            // $table->timestamp('test_timestamp')->useCurrent();
            /* you can also specify a default value for `timestamp` while updating ONLY */
            // $table->timestamp('test_update_timestamp')->useCurrentOnUpdate();

            /* when you specify the foreign key with constraints you can not delete the parent data without deleting the child data at the first so, we can use `onDelete` method and pass the `cascade` attribute and then will delete the child data then the parent data, while `restrict` will not let you delete the parent model until you remove all the related child model */
            // $table->foreignId('foreign_id')->constrained()->onDelete('cascade');
            // $table->foreignId('foreign_id')->constrained()->cascadeOnDelete();
            // $table->foreignId('foreign_id')->constrained()->onDelete('restrict');

            /* or you can pass the model name that you want to make a foreign key from it using `foreignIdFor` */
            // $table->foreignIdFor(\App\Models\ModelName::class)->constrained()->onDelete('cascade');

            /* you can also change the column name using `renameColumn` */
            // $table->renameColumn('from', 'to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
