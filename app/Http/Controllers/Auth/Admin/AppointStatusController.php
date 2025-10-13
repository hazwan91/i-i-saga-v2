<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppointStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AppointStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointStatuses = AppointStatus::query()
            ->when(request()->query('carian'), function ($query) {
                $query->where('code', 'like', '%' . request()->query('carian') . '%')
                    ->orWhere('name', 'like', '%' . request()->query('carian') . '%');
            })
            ->select('id', 'code', 'name')
            ->paginate(request()->query('per_page'), ['*'], 'page')
            ->withQueryString();
        return Inertia::render('Auth/AppointStatus/Index', compact('appointStatuses'));
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
            'code' => ['bail', 'required', 'integer', Rule::unique('appoint_statuses')],
            'name' => ['bail', 'required', 'string', 'max:255', Rule::unique('appoint_statuses')],
        ]);

        DB::beginTransaction();
        try {
            $appointStatus = new AppointStatus;
            $appointStatus->code = $vdata['code'];
            $appointStatus->name = $vdata['name'];
            $appointStatus->save();
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
    public function show(AppointStatus $appointStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppointStatus $appointStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AppointStatus $appointStatus)
    {
        $vdata = $request->validate([
            'code' => ['bail', 'required', 'integer', Rule::unique('appoint_statuses')->ignore($appointStatus->id)],
            'name' => ['bail', 'required', 'string', 'max:255', Rule::unique('appoint_statuses')->ignore($appointStatus->id)],
        ]);

        DB::beginTransaction();
        try {
            $appointStatus->code = $vdata['code'];
            $appointStatus->name = $vdata['name'];
            $appointStatus->save();
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
    public function destroy(AppointStatus $appointStatus)
    {
        DB::beginTransaction();
        try {
            $appointStatus->delete();
            DB::commit();

            return back()->with('pass', 'Data berjaya dipadam.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('fail', 'Terdapat masalah semasa memadam data. Sila cuba lagi.');
        }
    }
}
