<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $districts = District::query()
        //     ->when(request()->query('carian'), function ($query) {
        //         $query->where('name', 'like', '%' . request()->query('carian') . '%');
        //     })
        //     ->with('zone:id,name')
        //     ->select('id', 'zone_id', 'name')
        //     ->orderBy('zone.name', 'asc')
        //     ->paginate(request()->query('per_page'), ['*'], 'laman')
        //     ->withQueryString();

        $districts = District::query()
            ->when(request()->query('carian'), function ($query) {
                $query->where('districts.name', 'like', '%' . request()->query('carian') . '%');
            })
            ->leftJoin('zones', 'districts.zone_id', '=', 'zones.id')
            ->select('districts.id', 'districts.zone_id', 'districts.name', 'zones.name as zone_name', 'zones.color as zone_color')
            ->orderBy('zones.name', 'asc')
            ->paginate(request()->query('per_page') ?? 10, ['*'], 'laman')
            ->withQueryString();

        $groupDistricts = $districts->getCollection()->groupBy(function ($district) {
            return $district->zone?->name;
        });

        return Inertia::render('Auth/District/Index', compact('districts', 'groupDistricts'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(District $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(District $district)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, District $district)
    {
        $vdata = $request->validate([
            'color' => ['bail', 'required', 'string', 'max:255'],
            'name' => ['bail', 'required', 'string', 'max:255', Rule::unique('zones')->ignore($district->id)],
        ]);

        DB::beginTransaction();
        try {
            $district->color = $vdata['color'];
            $district->name = $vdata['name'];
            $district->save();
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
    public function destroy(District $district)
    {
        DB::beginTransaction();
        try {
            $district->delete();
            DB::commit();

            return back()->with('pass', 'Data berjaya dipadam.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('fail', 'Terdapat masalah semasa memadam data. Sila cuba lagi.');
        }
    }
}
