<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Factories\HasFactory};

class Product extends Model
{
    use HasFactory;

    /* By default eloquent loads relationships using `lazy loading`, this means When accessing Eloquent relationships as properties, the related models are "lazy loaded". This means the relationship data is not actually loaded until you first access the property */

    // $products = \App\Models\Product::get();
    // foreach ($products as $product) {
    //     foreach ($product->categories() as $category) {
    //         // do something here...
    //     }
    // }

    /* So if you are loading the model instance and you know that you will working with it's relationship, it will be recommended to work with `eager-load` like this... */

    /* The `eager loading` means that you alleviate the number of queries, so let's imagine that we have 25 books and every book has an author so to retrieves all books we will use 1 query for this and to retrieves every author for each book we will use 25 quires so the total of quires will be 26 (N+1) */
    // $data = \App\Models\Product::with('categories')->get();

    public function categories()
    {
        /* `withTimestamps` used with the`belongsToMany` relationship not with the `hasMany` and it will show the timestamps of the pivot table and the `withPivot` will return the pivot table data of the specific product, via `as` method you can change the intermediate table name NOTE that also the default name of the intermediate table name is `pivot` */
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id')
            ->as('category_product_pivot_tabel')
            ->withTimestamps()
            ->withPivot('product_id')
            ->wherePivot('id', '>', 0)
            ->wherePivotNotNull('created_at');

        /* If you would like to define a custom model to represent the intermediate table of your many-to-many relationship, you may call the using method when defining the relationship. Custom pivot models give you the opportunity to define additional methods on the pivot model. */
        // return $this->belongsToMany(Category::class)->using(CusomtPivotTable::class);
    }

    /* NOTE that always we add the id of child table in the parent table as `{parentTableSingularName}_{id} */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
