<?php
/**
 * Display
 *
 */
namespace App\Http\Controllers;

use App\Models\Hall;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;

use Auth;
Use Redirect;
/**
 * HallController for managing enrolments
 */
class HallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $userrole = "";
        if (Auth::User()->hasRole('admin'))
        {
            $data = hall::all();
            $userrole = "admin";
        }
        if (Auth::User()->hasRole('teacher'))
        {

            // old query without one to many relationship
            // $courses = Course::where('teacher_id',Auth::User()->id)->get() ;
            // advanced query without one to many through relationship
            //    dd(Teacher::where('user_id',Auth::User()->id)->first()->enrolments) ;
            $data = hall::whereIn('course_id', Teacher::where('user_id', Auth::User()->id)
                ->first()
                ->courses)
                ->get();
            $userrole = "teacher";
        }

        if (Auth::User()->hasRole('student'))
        {
            $userrole = "student";

            $data = hall::where('student_id', Student::where('user_id', Auth::User()->id)
                ->first()
                ->id)
                ->get();
        }

        $courses = Course::all()->pluck('name', 'id');
        $students_row = Student::all()->pluck('user_id', 'id');
        //   dd($students_row) ;
        $students = [];
        foreach ($students_row as $key => $value)
        {
            //     dd($student) ;
            //          $students[$student] =   User::find($student)->name   ;
            $user = User::find($value);
            // dd($user ) ;
            if ($user->hasRole('student'))
            {
                $students[$key] = $user->name;
                //      dd( $student) ;
                array_push($students, $students[$key]);
            }
            //      dd(User::find($student )) ;



        }
        //   dd($students) ;
        return Inertia::render('halls', ['data' => $data, 'userrole' => $userrole, 'courses' => $courses, 'students' => $students]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all() , ['name' => ['required'], 'course_id' => ['required'], 'student_id' => ['required'],
        //          'email' => 'required|email',
        //           'attachment' => 'mimes:pdf,ppt,pptx',
        ])
            ->validate();

        //   dd($request->all()) ;
        Hall::create($request->all());

        return redirect()
            ->back()
            ->with('message', 'Enrolment Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hall  $hall
     * @return \Illuminate\Http\Response
     */
    public function show(Hall $hall)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hall  $hall
     * @return \Illuminate\Http\Response
     */
    public function edit(Hall $hall)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hall  $hall
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hall $hall)
    {
        Validator::make($request->all() , ['name' => ['required'], 'course_id' => ['required'], 'student_id' => ['required'],
        'attachment' => !empty(!empty($request->file('attachment'))) ? 'mimes:pdf,ppt,pptx' : '', ])
            ->validate();


        $path = $filename = null;
        if (!empty($request->file('attachment')))
        {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = 'profile-photo-' . time() . '.' . $extension;
            $path = $file->storeAs('public', $filename);
        }

        if ($request->has('id'))
        {
            $hall = Hall::find($request->input('id'));
            $hall->update($request->all());
            $hall->attachment = $filename;
            $hall->save();
            return redirect()
                ->back()
                ->with('message', 'Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hall  $hall
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->has('id'))
        {
            Hall::find($request->input('id'))
                ->delete();
            return redirect()
                ->back();
        }
    }
}

