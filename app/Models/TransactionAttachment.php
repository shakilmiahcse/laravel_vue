<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionAttachment extends Model
{
protected $fillable = [
    'transaction_id', 'file_path', 'original_name',
    'mime_type', 'file_type', 'uploaded_by', 'organization_id'
];

public function transaction()
{
    return $this->belongsTo(Transaction::class);
}

public function uploader()
{
    return $this->belongsTo(User::class, 'uploaded_by');
}

}
