<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Race;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class RaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $races = Race::query()
            ->when(request()->query('carian'), function ($query) {
                $query->where('name', 'like', '%' . request()->query('carian') . '%');
            })
            ->select('id', 'name')
            ->paginate(request()->query('per_page'), ['*'], 'page')
            ->withQueryString();
        return Inertia::render('Auth/Race/Index', compact('races'));
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
            'name' => ['bail', 'required', 'string', 'max:255', Rule::unique('races')]
        ]);

        DB::beginTransaction();
        try {
            $race = new Race;
            $race->name = $vdata['name'];
            $race->save();
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
    public function show(Race $race)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Race $race)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Race $race)
    {
        $vdata = $request->validate([
            'name' => ['bail', 'required', 'string', 'max:255', Rule::unique('races')->ignore($race->id)]
        ]);

        DB::beginTransaction();
        try {
            $race->name = $vdata['name'];
            $race->save();
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
    public function destroy(Race $race)
    {
        DB::beginTransaction();
        try {
            $race->delete();
            DB::commit();

            return back()->with('pass', 'Data berjaya dipadam.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('fail', 'Terdapat masalah semasa memadam data. Sila cuba lagi.');
        }
    }
}
