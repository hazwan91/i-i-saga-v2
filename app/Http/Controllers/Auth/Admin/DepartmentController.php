<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departmentTypes = Department::query()
            ->when(request()->query('carian'), function ($query) {
                $query->where('code', 'like', '%' . request()->query('carian') . '%')
                    ->orWhere('name', 'like', '%' . request()->query('carian') . '%');
            })
            ->select('id', 'department_type_id', 'code', 'name', 'reporting_code', 'hod_title', 'address')
            ->with('departmentType:id,code,name')
            ->withCount('stations')
            ->paginate(request()->query('per_page'), ['*'], 'laman')
            ->withQueryString();
        return Inertia::render('Auth/Department/Index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vdata = $request->validate([
            'code' => ['bail', 'required', 'string', 'max:10', Rule::unique('departments')],
            'name' => ['bail', 'required', 'string', 'max:255', Rule::unique('departments')],
            'reporting_code' => ['bail', 'required', 'string', 'max:255', Rule::unique('departments')],
            'hod_title' => ['bail', 'required', 'string', 'max:255', Rule::unique('departments')],
            'address' => ['bail', 'required', 'string', 'max:255', Rule::unique('departments')],
        ]);

        DB::beginTransaction();
        try {
            $department = new Department;
            $department->code = $vdata['code'];
            $department->name = $vdata['name'];
            $department->reporting_code = $vdata['reporting_code'];
            $department->hod_title = $vdata['hod_title'];
            $department->address = $vdata['address'];
            $department->save();
            DB::commit();
            return back()->with('pass', 'Data berjaya disimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('fail', 'Terdapat masalah semasa menyimpan data. Sila cuba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        //
    }
}
