<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory;
    //  we should tell this model is uses soft delete
    use SoftDeletes;

    // we can also mentioned the feilds for mass assignment
    // but now we are inserting all the info
    protected $guarded = [];

    // --------------
    //  Route Model Binding
    public function getRouteKeyName()
    {
        return 'uuid';

    }

    // user of the note just like any other property
    public function user()
    {
        // calling the User.php as a copy
        return $this->belongsTo(User::class);
    }
}
