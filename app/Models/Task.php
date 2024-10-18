<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tasks';

    protected $fillable = [
        'uuid',
        'title', 
        'description', 
        'status', 
        'due_date',
        'position',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot ()
    {
        parent::boot();
        static::creating(function(Task $task) {
            $task->uuid = Str::uuid();
            $maxPosition = Task::max('position');
            $task->position = $maxPosition ? $maxPosition + 1 : 1;
        });
    }

}
