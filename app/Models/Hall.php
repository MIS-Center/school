<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;

    protected $fillable = ['id','name','course_id','student_id','first','mid','final'];

    /**
     * Course
     *
     * @return void
     */
    public function course()
    {
        return $this->hasOne(Course::class);
    }


    /**
     * Student
     *
     * @return void
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }

}
