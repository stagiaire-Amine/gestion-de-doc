<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'original_name',
        'description',
        'category',
        'path',
        'mime_type',
        'size_bytes',
        'status', // pending, approved, rejected, draft
        'is_starred',
    ];

    /**
     * Get the user that owns the document.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the formatted file size.
     */
    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->size_bytes;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return $bytes . ' byte';
        } else {
            return '0 bytes';
        }
    }

    /**
     * Get the font awesome icon class based on file type.
     */
    public function getFileIconAttribute()
    {
        if (str_contains($this->mime_type, 'pdf')) {
            return 'fa-file-pdf text-rose-500';
        } elseif (str_contains($this->mime_type, 'image')) {
            return 'fa-file-image text-emerald-500';
        } elseif (str_contains($this->mime_type, 'word') || str_contains($this->mime_type, 'document')) {
            return 'fa-file-word text-blue-500';
        } elseif (str_contains($this->mime_type, 'excel') || str_contains($this->mime_type, 'spreadsheet')) {
            return 'fa-file-excel text-emerald-600';
        } elseif (str_contains($this->mime_type, 'powerpoint') || str_contains($this->mime_type, 'presentation')) {
            return 'fa-file-powerpoint text-orange-500';
        } elseif (str_contains($this->mime_type, 'zip') || str_contains($this->mime_type, 'rar')) {
            return 'fa-file-archive text-amber-500';
        } elseif (str_contains($this->mime_type, 'text/plain')) {
            return 'fa-file-alt text-gray-500';
        }
        return 'fa-file text-gray-400';
    }

    /**
     * Get the status badge color class.
     */
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'approved' => 'green',
            'rejected' => 'red',
            'pending' => 'yellow',
            'draft' => 'gray',
            default => 'gray',
        };
    }
}
