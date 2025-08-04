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
        'description',
        'who_create',
        'who_update',
    ];
}
