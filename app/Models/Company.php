<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'photo',
        'pdf',
        'type',
        'favorite_rank'
    ];

    public const TYPES = ['interest', 'desired', 'current'];

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'interest' => '見学／気になる企業',
            'desired'  => '志望企業',
            'current'  => '現職',
            default    => $this->type,
        };
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function weightedScore()
    {
        return $this->evaluations->sum(function ($evaluation) {
            return $evaluation->score * $evaluation->criterion->weight;
        });
    }

    public function getTotalScoreAttribute()
    {
        return $this->evaluations->sum(function ($evaluation) {
            return $evaluation->score * ($evaluation->criterion->weight ?? 1);
        });
    }

}
