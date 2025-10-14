<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zones = Zone::query()
            ->when(request()->query('carian'), function ($query) {
                $query->where('name', 'like', '%' . request()->query('carian') . '%');
            })
            ->select('id', 'color', 'name')
            ->paginate(request()->query('per_page'), ['*'], 'page')
            ->withQueryString();
        return Inertia::render('Auth/Zone/Index', compact('zones'));
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
            'color' => ['bail', 'required', 'string', 'max:255'],
            'name' => ['bail', 'required', 'string', 'max:255', Rule::unique('zones')],
        ]);

        DB::beginTransaction();
        try {
            $zone = new Zone;
            $zone->color = $vdata['color'];
            $zone->name = $vdata['name'];
            $zone->save();
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
    public function show(Zone $zone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zone $zone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zone $zone)
    {
        $vdata = $request->validate([
            'color' => ['bail', 'required', 'string', 'max:255'],
            'name' => ['bail', 'required', 'string', 'max:255', Rule::unique('zones')->ignore($zone->id)],
        ]);

        DB::beginTransaction();
        try {
            $zone->color = $vdata['color'];
            $zone->name = $vdata['name'];
            $zone->save();
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
    public function destroy(Zone $zone)
    {
        DB::beginTransaction();
        try {
            $zone->delete();
            DB::commit();

            return back()->with('pass', 'Data berjaya dipadam.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('fail', 'Terdapat masalah semasa memadam data. Sila cuba lagi.');
        }
    }

    public function listZones()
    {
        $zones = Zone::select('id', 'name')->get();
        return back()->with([
            'data' => [
                'zones' => $zones
            ]
        ]);
    }
}
