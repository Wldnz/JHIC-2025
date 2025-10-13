<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function students()
    {
        $student = Student::all();
        return view('admin.student.index');
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
        return view('admin.student.detail', compact('student'));
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
