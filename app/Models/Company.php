<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'photo', 'pdf'];

    // Company は複数の Evaluation を持つ
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
