<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'category',
        'level',
        'description',
        'icon'
    ];
    protected function casts(): array
    {
        return [
            'level' => 'integer',
        ];
    }
}