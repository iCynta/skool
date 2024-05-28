<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;
use App\Models\Role;

class Permission extends SpatiePermission
{
    protected $guarded = [];

    // Define relationships
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
