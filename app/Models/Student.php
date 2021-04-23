<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'notes','user_id'];

    /**
     * User
     *
     * @return void
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get the comments for the blog post.
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

}
