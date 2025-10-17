<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'meal_name',
        'calories',
    ];
    public function meals() {
         return $this->hasMany(Meal::class);
    }
}
