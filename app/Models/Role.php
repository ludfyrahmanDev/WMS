<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// import filterable
use App\Models\Traits\CanOrderByRelationship;
use App\Models\Traits\Filterable;
use Illuminate\Support\Facades\DB;

class Role extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,  Filterable, CanOrderByRelationship;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'role_users';

    protected $fillable = [
        'role'
    ];

    protected $primaryKey = 'id';
}
