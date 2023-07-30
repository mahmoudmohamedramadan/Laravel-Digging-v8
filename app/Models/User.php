<?php

namespace App\Models;

use App\Scopes\GlobalScope;
use Laravel\Passport\HasApiTokens;
use Illuminate\{Notifications\Notifiable, Database\Eloquent\SoftDeletes, Foundation\Auth\User as Authenticatable, Database\Eloquent\Factories\HasFactory, Contracts\Translation\HasLocalePreference, Auth\Notifications\ResetPassword};

class User extends Authenticatable implements HasLocalePreference
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    /* use `HasLocalePreference` when you want to deal with multiple language */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'locale',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be visible for arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'email',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /* put here some columns to mutated as timestamps, by default this array contains `created_at` and `updated_at` */
    protected $dates = [
        'created_at',
    ];

    public function phoneNumbers()
    {
        return $this->hasMany(PhoneNumber::class, 'user_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function comments()
    {
        /* When you want a relationship with a specific table via another table you can use the `Through` keyword */
        // return $this->hasManyThrough(Comment::class, Post::class);
        return $this->hasManyThrough(Comment::class, Post::class, 'user_id', 'post_id', 'id', 'id');
    }

    public function department()
    {
        return $this->morphOne(Department::class, 'departmentable');
    }

    /* NOTE that in `hasOne` relationship Eloquent determines the foreign key of the relationship based on the parent model name. In this case, the `Dog` model is automatically assumed to have a `user_id` foreign key */
    public function dog()
    {
        /* `oldestOfMany` function returns the oldest/maximum one from lots of data */
        return $this->hasOne(Dog::class, 'user_id', 'id')->oldestOfMany();

        /* `latestOfMany` function returns the latest/minimum one from lots of data */
        // return $this->hasOne(Dog::class, 'user_id', 'id')->latestOfMany();

        /* `ofMany` method accepts the sortable column as its first argument and which aggregate function (min or max) to apply when querying for the related mode */
        // return $this->hasOne(Dog::class, 'user_id', 'id')->ofMany('id', 'max');

        /* You can also check more than one column and you can pass a closure as a second argument for ceching whatever you want */
        // return $this->hasOne(Dog::class, 'user_id', 'id')->ofMany([
        //     'id' => 'max',
        //     'user_id' => 'max',
        // ], function ($q) {
        //     $q->where('tame', 1);
        // });
    }

    // Get the preferred language of the currently authenticated user via `locale` column
    public function preferredLocale()
    {
        return $this->locale;
    }

    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope('Global', function ($builder) {
        //     $builder->where('id', '>', 5);
        // });

        static::addGlobalScope(new GlobalScope());
    }

    /* Mutators work the same way as accessors work, except the mutators how to setting ot getting the data */
    public function setPasswordAttribute($value)
    {
        /* NOTE that when you hash the password while creating a new user then, get here to hash the `$value` again, this will hash the hashed value so, when you try to login the `invalid credentails` will be show to you */
        $this->attributes['password'] = $value;
    }

    /* by default the first parameter is the currently authenticated user passed automatically with Laravel from `AuthServiceProvider` in `delete-user` key */
    public function checkAbility($user)
    {
        if ($user->id == auth()->id()) {
            return true;
        }

        return false;
    }

    public function notifiableMethods()
    {
        return [
            'mail',
            // 'nexmo', /* you can specify the channel to send the notification like `nexmo` to send SMS message */
        ];
    }

    /* in case you want to send a URL for resetting the password in a new Laravel version you can override the `resetUrl`in `ResetPassword` class */

    /**
     * Get the reset URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function resetUrl($notifiable)
    {
        if (ResetPassword::$createUrlCallback) {
            return call_user_func(ResetPassword::$createUrlCallback, $notifiable, $this->token);
        }

        return url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }
}
