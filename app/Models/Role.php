<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;
use App\Models\User;

class Role extends SpatieRole
{
    protected $guarded = [];

    // Define relationships
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
