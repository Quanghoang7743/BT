<?php

namespace App\Http\Controllers;

use App\Models\StudentModel;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentModel::query();

        // Optional search by name
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', '%'.$search.'%');
        }

        // Sorting by name or email
        $sort = in_array($request->get('sort'), ['name', 'email']) ? $request->get('sort') : 'name';
        $direction = $request->get('direction', 'asc') === 'desc' ? 'desc' : 'asc';
        $query->orderBy($sort, $direction);

        // Pagination
        $students = $query->paginate(10)->appends($request->except('page'));

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'major' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:students,email'],
        ]);

        StudentModel::create($validated);

        return redirect('/students')->with('success', 'Thêm sinh viên thành công.');
    }
}
