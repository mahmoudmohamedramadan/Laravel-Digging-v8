<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\{Models\Dog, Http\Controllers\Controller};

class DogAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Dog::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dog = Dog::create($request->only(['user_id', 'name', 'tame']));
        $dog->name = 'test_dirty_method';

        /* The `isDirty` method determines if any of the model's attributes have been changed since the model was retrieved. You may pass a specific attribute name to the `isDirty` method to determine if a particular attribute is dirty */
        $dog->isDirty();    // true
        $dog->isDirty('name');    // true
        $dog->isDirty('tame');    // false

        /* The `isClean` will determine if an attribute has remained unchanged since the model was retrieved. This method also accepts an optional attribute argument */
        $dog->isClean();    // false
        $dog->isClean('name');    // false
        $dog->isClean('tame');    // true

        /* The `wasChanged` method determines if any attributes were changed when the model was last saved within the current request cycle */
        $dog->name = 'test_was_changed_method';
        $dog->save();

        $dog->wasChanged(); // true
        $dog->wasChanged('name'); // true
        $dog->wasChanged('tame'); // false

        $dog->name = 'change_dog_name_for_freshing_test';

        // `fresh` method will re-retrieve the model from the database
        $dog_2 = $dog->fresh();
        $dog->name; // change_dog_name_for_freshing_test
        $dog_2->name; // test_was_changed_method

        // `refresh` method reload the current model instance with fresh attributes from the database
        $dog->refresh();
        $dog->name; // test_was_changed_method

        // For more info: https://stackoverflow.com/a/27748794/11019205
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dog  $dog
     * @return \Illuminate\Http\Response
     */
    public function show(Dog $dog)
    {
        $dog->name = 'Rex';

        /* The `getOriginal` method returns an array containing the original attributes of the model regardless of any changes to the model since it was retrieved */
        $dog->name; // whatever_name
        $dog->name = 'test_get_original_method';

        $dog->getOriginal('name');  // whatever_name
        return $dog->getOriginal(); // Array of original attributes...
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dog  $dog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dog $dog)
    {
        /* Similar to the `lazy` method, the `cursor` method may be used to significantly reduce your application's memory consumption when iterating through tens of thousands of Eloquent model records, The `cursor` method will only
        execute a single database query */
        /* NOTE: Since the `cursor` method only ever holds a single Eloquent model in memory at a time, it cannot eager load relationships */

        /* Occasionally, you may need to update an existing model or create a new model if no matching model exists. Like the `firstOrCreate` method, the `updateOrCreate` method persists the model, so there's no need to manually call the save method */
        /* NOTE: If there is a dog with the passing `name` from the request `updateOrCreate` method will updates the `tame` attribute according to the second parameter but if the passing name not exists the method will merge the two parameters to insert a new model instance */
        // return $dog->cursor()->updateOrCreate($request->only(['name']), ['tame' => 1]);

        /* If you would like to perform multiple "upserts" in a single query, then you should use the `upsert` method instead. The method's first argument consists of the values to insert or update, while the second argument lists the column(s) that uniquely identify records within the associated table. The method's third and final argument is an array of the columns that should be updated if a matching record already exists in the database. The upsert method will automatically set the `created_at` and `updated_at` timestamps if timestamps are enabled on the model */
        return Dog::where('id', $dog->id)->upsert([
            ['name' => $request->get('name'), 'tame' => $request->input('tame')],
            ['name' => $request->get('name'), 'tame' => $request->input('tame')],
        ], ['id'], ['name']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dog  $dog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dog $dog)
    {
        /* You may call the `truncate` method to delete all of the model's associated database records. The truncate operation will also reset any auto-incrementing IDs on the model's associated table */
        // Dog::truncate();

        return $dog->delete();
    }
}
