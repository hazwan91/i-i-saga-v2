<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\DepartmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class DepartmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departmentTypes = DepartmentType::query()
            ->when(request()->query('carian'), function ($query) {
                $query->where('code', 'like', '%' . request()->query('carian') . '%')
                    ->orWhere('name', 'like', '%' . request()->query('carian') . '%');
            })
            ->select('id', 'code', 'name')
            ->withCount('departments')
            ->withCount('stations')
            ->paginate(request()->query('per_page'), ['*'], 'laman')
            ->withQueryString();
        return Inertia::render('Auth/DepartmentType/Index', compact('departmentTypes'));
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
            'code' => ['bail', 'required', 'string', 'max:10', Rule::unique('department_types')],
            'name' => ['bail', 'required', 'string', 'max:255', Rule::unique('department_types')],
        ]);

        DB::beginTransaction();
        try {
            $departmentType = new DepartmentType;
            $departmentType->code = $vdata['code'];
            $departmentType->name = $vdata['name'];
            $departmentType->save();
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
    public function show(DepartmentType $departmentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DepartmentType $departmentType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DepartmentType $departmentType)
    {
        $vdata = $request->validate([
            'code' => ['bail', 'required', 'string', 'max:10', Rule::unique('department_types')->ignore($departmentType->id)],
            'name' => ['bail', 'required', 'string', 'max:255', Rule::unique('department_types')->ignore($departmentType->id)],
        ]);

        DB::beginTransaction();
        try {
            $departmentType->code = $vdata['code'];
            $departmentType->name = $vdata['name'];
            $departmentType->save();
            DB::commit();
            return back()->with('pass', 'Data berjaya disimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('fail', 'Terdapat masalah semasa menyimpan data. Sila cuba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DepartmentType $departmentType)
    {
        DB::beginTransaction();
        try {
            $departmentType->delete();
            DB::commit();

            return back()->with('pass', 'Data berjaya dipadam.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('fail', 'Terdapat masalah semasa memadam data. Sila cuba lagi.');
        }
    }
}
