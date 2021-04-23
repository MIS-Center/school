<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Hash ;
use DB;
use App\Models\User;
use App\Models\Hall;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Student;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // student seeder
        $s1 = User::firstOrCreate([
            'name' => "stu1",
            'email' => 'stu1@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $s1->attachRole('student');

        $s2 = User::firstOrCreate([
            'name' => "stu2",
            'email' => 'stu2@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $s2->attachRole('student');

        $s3 = User::firstOrCreate([
            'name' => "stu3",
            'email' => 'stu3@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $s3->attachRole('student');

        // teacher seeder
        $t1 = User::firstOrCreate([
            'name' => "teach1",
            'email' => 'teach1@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $t1->attachRole('teacher');

        $t2 = User::firstOrCreate([
            'name' => "teach2",
            'email' => 'teach2@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $t2->attachRole('teacher');

        // course seeder
        $c1 = Course::firstOrCreate([
            'name' => "first course",
            'desc' => 'very first course',
            'teacher_id' => Teacher::where('user_id',$t1->id)->first()->id ,
        ]);

        $c2 = Course::firstOrCreate([
            'name' => "second course",
            'desc' => 'very second course',
            'teacher_id' => Teacher::where('user_id',$t2->id)->first()->id ,
        ]);

        // hall seeder
        $h1 = Hall::firstOrCreate([
            'name' => "first enrolment",
            'student_id' => Student::where('user_id',$s1->id)->first()->id ,
            'course_id' => $c1->id,
        ]);

        $h1 = Hall::firstOrCreate([
            'name' => "second enrolment",
            'student_id' => Student::where('user_id',$s2->id)->first()->id ,
            'course_id' => $c1->id,
        ]);


        $h3 = Hall::firstOrCreate([
            'name' => "third enrolment",
            'student_id' => Student::where('user_id',$s3->id)->first()->id ,
            'course_id' => $c2->id,
        ]);

    }
}
