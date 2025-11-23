<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'company_id', 'criterion_id', 'score'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function criterion()
    {
        return $this->belongsTo(Criterion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
