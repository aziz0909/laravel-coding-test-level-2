<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    use UUID;

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
