<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
//use App\Models\Role;

class Permission extends SpatiePermission
{
    protected $guarded = [];

    // Define relationships
    public function roles():BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
