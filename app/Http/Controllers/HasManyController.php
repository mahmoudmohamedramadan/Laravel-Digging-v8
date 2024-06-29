<?php

namespace App\Http\Controllers;

use App\Models\{Product, Category};

class HasManyController extends Controller
{
    public function index()
    {
        // The `modelKeys` method used to get all primary key in the `products` table
        // $product = Product::all()->modelKeys();

        $product = Product::first();
        $category = Category::first();

        // `The attach` method used to set into the pivot table values from `$product` and `$category`
        // return $product->categories()->attach($category);

        // The `detach` method used to remove values from pivot table with `$product` and `$category`
        // return $product->categories()->detach($category);

        // The `toggle` method will attach the given `id` if it was not attached yet and vice versa
        // return $product->categories()->toggle($category);

        /* The `updateExistingPivot` method accepts the intermediate record foreign key as the first parameter and the attributes that you want to update as a second one */
        return $product->categories()->updateExistingPivot($category->id, [
            // The intermediate table attributes that you want to update
        ]);

        /* The `sync` method will remove all data in the pivot table then insert the data of `$product` and `$category` */
        return $product->categories()->sync($category);

        /* The `syncWithoutDetaching` method will add the given `$category` without removing any existing record */
        // return $product->categories()->syncWithoutDetaching($category);
    }
}
