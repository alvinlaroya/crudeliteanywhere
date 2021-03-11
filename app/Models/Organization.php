<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $table = "organizations";

    public function persons(){
        return $this->belongsToMany(Persons::class, 'organizations_persons', 'organization_id', 'persons_id'); // (pivot table, FK of this model, )
    }
}
