<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterion extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'weight'];

    // Criterion は複数の Evaluation を持つ
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    // 作成者の User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
