<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['details', 'entity', 'reference', 'notified_by', 'notified_to', 'read_status', 'read_at'];
}
