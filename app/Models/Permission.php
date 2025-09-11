<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Filterable;
use App\Models\Traits\CanOrderByRelationship;

class Permission extends Model
{
    use HasFactory, Filterable, CanOrderByRelationship;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'group'
    ];

    /**
     * Get the roles that have this permission.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}
