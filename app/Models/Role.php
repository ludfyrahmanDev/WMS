<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\CanOrderByRelationship;
use App\Models\Traits\Filterable;
class Role extends Model
{
    use HasFactory, Filterable, CanOrderByRelationship;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the users that belong to this role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the permissions that belong to this role.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    /**
     * Get the CVs/Companies that this role can access.
     */
    public function cvs()
    {
        return $this->belongsToMany(CV::class, 'role_cv', 'role_id', 'cv_id');
    }

    /**
     * Check if role has a specific permission.
     */
    public function hasPermission($permission)
    {
        return $this->permissions()->where('name', $permission)->exists();
    }

    /**
     * Assign permission to role.
     */
    public function assignPermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
        }
        
        if ($permission) {
            $this->permissions()->syncWithoutDetaching([$permission->id]);
        }
    }

    /**
     * Remove permission from role.
     */
    public function removePermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->first();
        }
        
        if ($permission) {
            $this->permissions()->detach($permission->id);
        }
    }
}
