<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Major;
use App\Models\Portfolio;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    protected $maxPage = 10;

    
    public function students(Request $request)
    {
        $search = $request->get('search', '');
        $search_major = $request->get('search_major', '');
        $search_class = $request->get('search_class', '');
        $page =  $request->get('page', 1);
        $max = $this->maxPage;

        $initiliazeStudents = Student::all();
        $initiliazePortfolios = Portfolio::all();
        $initiliazeAchievements = Achievement::all();
        $students = Student::select();

        $stats = [
            'total' => $initiliazeStudents->count(),
            'total Portofolio' => $initiliazePortfolios->count(),
            'total Prestasi' => $initiliazeAchievements->count()
        ];

        if($search){
            $students = $students->where('name', '=', $search)
                ->orWhere('name', 'like', '%'.$search.'%')
                ->orWhere('nis', 'like', '%'.$search.'%')
                ->orWhere('nis', 'like', '%'.$search.'%');
        }

        if($search_major){
            $students = $students->where('major_short_name', '=', $search_major);
        }

        if($search_class){
            $students = $students->where('class', '=', $search_class);
        }

        $total = $students->get()->count();
        $students = $students->limit($this->maxPage)
        ->offset(($page - 1) * $this->maxPage)
            ->get();

        return view('admin.student.index', compact('students', 'stats','page', 'max', 'total'));
    }

    public function createStudent()
    {
        return view('admin.student.create');
    }

    public function storeStudent(Request $request)
    {
        return back();
    }

    public function detailStudent(Student $student)
    {
        $majors = Major::all();
        return view('admin.student.detail', compact('student', 'majors'));
    }

    public function updateStudent(Request $request, Student $student)
    {
        return back();
    }

    public function deleteStudent(Student $student)
    {
        return back();
    }
}
