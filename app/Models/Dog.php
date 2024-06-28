<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\{Model, Factories\HasFactory};

class Dog extends Model
{
    /* There is a great feature of Eloquent here; if you echo an Eloquent results collection, it'll be automatically converted into JSON using `__toString` magic method */
    use HasFactory, Prunable;

    protected $guarded = [];

    /* NOTE: In `belongsTo` relationship Eloquent determines the foreign key name by examining the name of the relationship method and suffixing the method name with `_id` So, in this case, Eloquent assumes that the `Dog` model has a `user_id` column */
    public function user()
    {
        // in `belongsTo` we add the foreign key of the related table in this model like `user_id`
        return $this->belongsTo(User::class, 'user_id', 'id', 'dog');
    }

    /* When marking models as `Prunable`, you may also define a `pruning` method on the model. This method can be useful for deleting any additional resources associated with the model, such as stored files, before the model is permanently removed from the database, The `prunable` method tells Laravel which models to choose for pruning each time the pruning job runs >> `php artisan model:prun --model=\App\Models\Dog` */
    public function prunable()
    {
        /* run prunable according to specific condition */
        return static::where('id', '>', 0);
    }

    /**
     * Prepare the model for pruning.
     *
     * @return void
     */
    protected function pruning()
    {
        dd('pruning');
    }
}
