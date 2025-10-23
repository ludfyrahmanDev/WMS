<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CV extends Model
{
    use HasFactory, Filterable;

    protected $table = 'cv';

    protected $fillable = [
        'name',
        'npwp',
        'address',
        'description',
        'who_create',
        'who_update',
    ];

    /**
     * Get the roles that can access this CV.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_cv', 'cv_id', 'role_id');
    }

    /**
     * Get all spending records for this CV.
     */
    public function spending()
    {
        return $this->hasMany(Spending::class, 'cv_id', 'id');
    }

    /**
     * Get all vehicle service records for this CV.
     */
    public function vehicleServices()
    {
        return $this->hasMany(VehicleService::class, 'cv_id', 'id');
    }

    /**
     * Get all selling records for this CV.
     */
    public function selling()
    {
        return $this->hasMany(Selling::class, 'cv_id', 'id');
    }
}
