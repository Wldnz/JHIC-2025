<?php

namespace App\Http\Controllers\Admin;

use App\AlertType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStudentRequest;
use App\Http\Requests\Admin\UpdateStudentRequest;
use App\Models\Achievement;
use App\Models\Major;
use App\Models\Portfolio;
use App\Models\Student;
use App\Utilities\AlertDataGenerator;
use DB;
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

        $resultStats = DB::table(DB::raw("DUAL"))
            ->select([
                DB::raw("(SELECT COUNT(*) FROM students) AS students"),
                DB::raw("(SELECT COUNT(*) FROM portfolios) AS portfolios"),
                DB::raw("(SELECT COUNT(*) FROM achievements) AS achievements"),
            ])
            ->first();
        $students = Student::query();

        $stats = [
            'total' => $resultStats->students,
            'total Portofolio' => $resultStats->portfolios,
            'total Prestasi' => $resultStats->achievements,
        ];

        if($search){
            $students = $students
                ->where('name', 'like', '%'.$search.'%')
                ->orWhere('nis', 'like', '%'.$search.'%');
        }

        if($search_major){
            $students = $students->where('major_short_name', '=', $search_major);
        }

        if($search_class){
            $students = $students->where('class', '=', $search_class);
        }

        $total = $search || $search_major || $search_class ? $students->count() : $stats['total'];
        $students = $students->limit($this->maxPage)
            ->offset(($page - 1) * $this->maxPage)
            ->get();

        return view('admin.student.index', compact('students', 'stats','page', 'max', 'total'));
    }

    public function createStudent()
    {
        $majors = Major::all();
        return view('admin.student.create', compact('majors'));
    }

    public function storeStudent(StoreStudentRequest $request)
    {
        $validated = $request->validated();

        $major = Major::find($validated['major_id']);
        if (!$major) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menambahkan siswa",
                "Jurusan dengan ID {$validated['major_id']} tidak ditemukan",
                $request->session(),
            );
            return back()->withInput($validated);
        }

        $student = Student::create([
            'nis' => $validated['nis'],
            'name' => $validated['name'],
            'class' => $validated['class'],
            'major_id' => $major->id,
            'major_long_name' => $major->long_name,
            'major_short_name' => $major->short_name,
            'gender' => $validated['gender'],
            'birthdate' => $validated['birth_date'],
        ]);

        if ($student) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil menambahkan siswa",
                "Siswa dengan NIS {$student->nis} berhasil ditambahkan",
                $request->session(),
            );
            return redirect()->route('admin.students');
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menambahkan siswa",
                "Siswa dengan NIS {$student->nis} gagal ditambahkan",
                $request->session(),
            );
            return back()->withInput($validated);
        }
    }

    public function detailStudent(Student $student)
    {
        $majors = Major::all();
        return view('admin.student.detail', compact('student', 'majors'));
    }

    public function updateStudent(UpdateStudentRequest $request, Student $student)
    {
        $validated = $request->validated();

        $major = Major::find($validated['major_id']);
        if (!$major) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal mengupdate siswa",
                "Jurusan dengan ID {$validated['major_id']} tidak ditemukan",
                $request->session(),
            );
            return back()->withInput($validated);
        }

        $isUpdated = $student->update([
            'name' => $validated['name'],
            'class' => $validated['class'],
            'major_id' => $major->id,
            'major_long_name' => $major->long_name,
            'major_short_name' => $major->short_name,
            'gender' => $validated['gender'],
            'birthdate' => $validated['birth_date'],
        ]);

        if ($isUpdated) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil mengupdate siswa",
                "Siswa dengan NIS {$student->nis} berhasil diupdate",
                $request->session(),
            );
            return redirect()->route('admin.students');
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal mengupdate siswa",
                "Siswa dengan NIS {$student->nis} gagal diupdate",
                $request->session(),
            );
            return back()->withInput($validated);
        }
    }

    public function deleteStudent(Request $request, Student $student)
    {
        $isDeleted = $student->delete();

        if ($isDeleted) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil menghapus siswa",
                "Siswa dengan NIS {$student->nis} berhasil dihapus",
                $request->session(),
            );
            return redirect()->route('admin.students');
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menghapus siswa",
                "Siswa dengan NIS {$student->nis} gagal dihapus",
                $request->session(),
            );
        }
        return back();
    }
}
