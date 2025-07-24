<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

   
    
    protected $fillable = [
        'user_id',
        'title',
        'principal_investigator',
        'document_path',
        'cv_paths',
        'notes',
    ];

    protected $casts = [
        'principal_investigator' => 'array',
        'cv_paths' => 'array',
    ];

    public function coInvestigators()
    {
        return $this->hasMany(CoInvestigator::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   

   
   
    public function statuses()
            {
                return $this->hasMany(DocumentStatus::class)->latest();
            }

            public function currentStatus()
            {
                return $this->hasOne(DocumentStatus::class)->latestOfMany();
            }
            // Document.php
public function reviewers()
{
    return $this->belongsToMany(User::class, 'document_reviewer');
}


}