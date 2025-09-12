<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// import filterable
use App\Models\Traits\CanOrderByRelationship;
use App\Models\Traits\Filterable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,  Filterable, CanOrderByRelationship;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'gender',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that appends to returned entities.
     *
     * @var array
     */
    protected $appends = ['photo'];

    /**
     * The getter that return accessible URL for user photo.
     *
     * @var array
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->foto !== null) {
            return url('media/user/' . $this->id . '/' . $this->foto);
        } else {
            return url('media-example/no-image.png');
        }
    }

    public function getPhotoAttribute(){
        return '';
    }

    /**
     * Get the role that belongs to the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if user has a specific permission.
     */
    public function hasPermission($permission)
    {
        return $this->role && $this->role->hasPermission($permission);
    }

    /**
     * Check if user has any of the given permissions.
     */
    public function hasAnyPermission($permissions)
    {
        if (!$this->role) {
            return false;
        }

        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if user has all of the given permissions.
     */
    public function hasAllPermissions($permissions)
    {
        if (!$this->role) {
            return false;
        }

        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if user has company access.
     */
    public function hasCompanyAccess()
    {
        return $this->hasPermission('company.access');
    }

    /**
     * Get CVs/Companies that user can access.
     */
    public function getAccessibleCVs()
    {
        if (!$this->role || !$this->hasCompanyAccess()) {
            return collect();
        }

        $roleCVs = $this->role->cvs;
        
        // If role has no specific CV restrictions, return all CVs
        if ($roleCVs->isEmpty()) {
            return CV::all();
        }

        return $roleCVs;
    }

    /**
     * Check if user can access specific CV.
     */
    public function canAccessCV($cvId)
    {
        if (!$this->hasCompanyAccess()) {
            return false;
        }

        $accessibleCVs = $this->getAccessibleCVs();
        return $accessibleCVs->pluck('id')->contains($cvId);
    }

    /**
     * Check if user has full company access (can access all CVs).
     */
    public function hasFullCompanyAccess()
    {
        return $this->hasCompanyAccess() && $this->getCompanyAccessLevel() === 'all';
    }

    /**
     * Get user's company access level.
     * Returns: 'all', 'limited', or 'none'
     */
    public function getCompanyAccessLevel()
    {
        if (!$this->hasCompanyAccess()) {
            return 'none';
        }

        $roleCVs = $this->role->cvs ?? collect();
        
        if ($roleCVs->isEmpty()) {
            return 'all'; // Can access all CVs
        } else {
            return 'limited'; // Can only access specific CVs
        }
    }
}
