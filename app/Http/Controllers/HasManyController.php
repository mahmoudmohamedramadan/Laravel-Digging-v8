<?php

namespace App\Http\Controllers;

use App\Models\{Product, Category};

class HasManyController extends Controller
{
    public function index()
    {
        // `modelKeys` method used to get all primary key in the `products` table
        // $product = Product::all()->modelKeys();

        $product = Product::first();
        $category = Category::first();

        // `attach` method used to set into the pivot table values from `$product` and `$category`
        // return $product->categories()->attach($category);

        // `detach` method used to remove values from pivot table with `$product` and `$category`
        // return $product->categories()->detach($category);

        // `toggle` method will attach the given `id` if it was not attached yet and vice versa
        // return $product->categories()->toggle($category);

        /* `updateExistingPivot` method pass the `$product` as first parameter and attribute which you want to update as second one, NOTE that laravel search in id of which you passed as first parameter in the pivot table then execute function, here will find the record which `product_id` equals `1` then will update `category_id` */
        return $product->categories()->updateExistingPivot($product, [
            'category_id' => 2000
        ]);

        // `sync` method will remove all data in the pivot table and put the data of `$product` and `$category`
        return $product->categories()->sync($category);

        // `syncWithoutDetaching` method will add the given `$category` without removing any existing record
        // return $product->categories()->syncWithoutDetaching($category);
    }
}
