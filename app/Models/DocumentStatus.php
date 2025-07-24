<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentStatus extends Model
{
    protected $fillable = [
        'document_id',
        'status',
        'message',
        'admin_id',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}