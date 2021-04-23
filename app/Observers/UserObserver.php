<?php

namespace App\Observers;

use App\Models\Role;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

class UserObserver
{

    public function roleAttached(User $user, $role, $team)
    {

        \Log::info('roleSynced : ' . json_encode($user)   );


        if( $user->hasRole('student') ){
            \Log::info('student : ' . json_encode($user)   );
            $student = Student::firstOrCreate(['user_id' =>$user->id]);
        }

        if( $user->hasRole('teacher') ){
            \Log::info('teacher : ' . json_encode($user)   );
            $teacher = Teacher::firstOrCreate(['user_id' =>$user->id]);
        }
    }

    public function roleDettached(User $user, $changes, $team)
    {

        //
    }

    public function roleSynced(User $user, $changes, $team)
    {
        \Log::info('roleSynced : ' . json_encode($changes)   );
        \Log::info('roleSynced : ' . json_encode($changes)   );


        if( $user->hasRole('student') ){
            \Log::info('student : ' . json_encode($changes)   );
            $student = Student::firstOrCreate(['user_id' =>$user->id]);
        }

        if( $user->hasRole('teacher') ){
            \Log::info('teacher : ' . json_encode($changes)   );
            $teacher = Teacher::firstOrCreate(['user_id' =>$user->id]);
        }
        // if( !empty($changes['attached'][0]) && empty($changes['detached'][0]) && count($changes['attached'])==1 ){

        //     \Log::info('assign role is : ' .  Role::find($changes['attached'][0])  );

        // }elseif(   !empty($changes['detached'][0]) && empty($changes['attached'][0])  && count($changes['detached'])==1  ){
        //     \Log::info('DeAssign role is : ' .  Role::find($changes['detached'][0])  );
        // }
        // Teacher::Create([
        //     'email'=> json_encode($changes) ,
        //     'salary'=>8,
        //     'user_id'=>$user->id
        // ]) ;

        //
    }

}
