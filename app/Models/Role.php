<?php
namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Role extends SpatieRole
{
    use HasFactory;
    protected $guarded = [];

    // Define relationships
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
