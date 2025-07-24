<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoInvestigator extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'full_name',
        'email',
        'specialization',
        'phone',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}