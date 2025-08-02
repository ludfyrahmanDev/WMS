<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cv;

class Tax extends Model
{
    use HasFactory, Filterable;

    protected $table = 'tax';

    protected $fillable = [
        'cv_id',
        'percentage'
    ];

    public function cv()
    {
        return $this->belongsTo(Cv::class, 'cv_id');
    }
}
