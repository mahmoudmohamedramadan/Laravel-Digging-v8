<?php

namespace App\Models;

use App\Http\Collections\DepartmentCollection;
use Illuminate\Database\Eloquent\{Model, Factories\HasFactory};

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // `appends` property used to append an accessor with the returned data
    protected $appends = [
        'full_info'
    ];

    public function getFullInfoAttribute()
    {
        return "{$this->departmentable_type} {$this->departmentable_id}";
    }

    public function departmentable()
    {
        return $this->morphTo();
    }

    /* The below relationship used in `ManyToMany` polymorphic and, this means that a `user` belongs to many `deprtments` and the `department` belongs to many models */
    /* NOTE: The `morphedByMany` must be in the child model and then define `morphToMany` relationship in the parent model */
    // public function user()
    // {
    //     return $this->morphedByMany(User::class, 'departmentable');
    // }

    /* The `newCollection` is a method in a `Model` class that allows you to create your own collection method */
    public function newCollection(array $models = [])
    {
        return new DepartmentCollection($models);
    }
}
