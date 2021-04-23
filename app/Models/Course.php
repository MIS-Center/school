<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Course
 */
class Course extends Model
{
    use HasFactory;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name ', 'desc','teacher_id'];

    /**
     * Teacher
     *
     * @return void
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the comments for the blog post.
     */
    public function halls()
    {
        return $this->hasMany(Hall::class);
    }


}
