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
        /* To create a new database table, the `Schema::create` method is used (--create option) and to update an existing table, we can use the `Schema::table` method method used (--table option)  */
        /* NOTE: You can change the arrangement of the migration files by changing the timestamp before the migration name also, you can create a new migration like the current file */
        Schema::table('users', function (Blueprint $table) {
            // You can specify from where you must start counting using `from` method
            // $table->integer('test_integer_number')->from(1000);

            // $table->string('details')->nullable()->before('deleted_at');

            // If you want to use `change` method, you must run `composer require doctrine/dbal`
            // $table->string('details', 100)->after('morrrph_id')->change();

            // Also, you can use `after` method like so
            // $table->after('morrrph_id', function ($afterColumn) {
            //     $afterColumn->string('details', 100);
            // });

            // $table->text('details')->before('morrrph_id');
            // $table->text('details')->first('morrrph_id');
            // $table->text('details')->nullable();
            // $table->text('details')->default('bla');
            // $table->text('details')->primary();
            // $table->text('details')->index();

            // You can specify a default value for the `timestamp` while creating only
            // $table->timestamp('test_timestamp')->useCurrent();
            // You can also specify a default value for `timestamp` while updating only
            // $table->timestamp('test_update_timestamp')->useCurrentOnUpdate();

            /* When you specify the foreign key with constraints you can not delete the parent without deleting the child so, we can use the `onDelete` method and pass the `cascade` attribute then when you delete the parent its children will be removed automatically, while `restrict` will not let you delete the parent model until you remove all the related child model at the first */
            // $table->foreignId('foreign_id')->constrained()->onDelete('cascade');
            // $table->foreignId('foreign_id')->constrained()->cascadeOnDelete();
            // $table->foreignId('foreign_id')->constrained()->onDelete('restrict');

            // You can pass the model name also using the `foreignIdFor` method
            // $table->foreignIdFor(\App\Models\ModelName::class)->constrained()->onDelete('cascade');

            // You can also change the column name using `renameColumn`
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
