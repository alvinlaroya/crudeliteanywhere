<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = "people";

    public function organizations(){
        return $this->belongsToMany(Organization::class); // (pivot table, FK of this model, )
    }
}
