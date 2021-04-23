<?php
/**
 * Modles
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Teacher
 */
class Teacher extends Model
{
    use HasFactory;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'salary','user_id'];

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

    /**
     * Get all of the enrolments for the project.
     */
    public function enrolments()
    {
        return $this->hasManyThrough(Hall::class, Course::class);
    }

}
