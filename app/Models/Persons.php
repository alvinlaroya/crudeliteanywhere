<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Persons extends Model
{
    use HasFactory;

    protected $table = "persons";

    public function organizations(){
        return $this->belongsToMany(Organization::class, 'organizations_persons', 'persons_id', 'organization_id'); // (pivot table, FK of this model, )
    }

    public function increementPersonCount($orgId) {
        DB::table('organizations')
        ->where('id', $orgId)
        ->update([
            'person_count' => DB::raw('person_count + 1')
        ]);
    }

    public function decrementPersonCount($orgId) {
        DB::table('organizations')
        ->where('id', $orgId)
        ->update([
            'person_count' => DB::raw('person_count - 1')
        ]);
    }
}
