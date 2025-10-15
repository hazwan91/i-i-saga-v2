<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Zone;
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
        $districts = District::query()
            ->when(request()->query('carian'), function ($query) {
                $query->where('districts.name', 'like', '%' . request()->query('carian') . '%');
            })
            ->when(request()->query('zon'), function ($query) {
                if (request()->query('zon') === 'tiada') {
                    $query->whereNull('zone_id');
                } else {
                    $query->where('zone_id', '=', request()->query('zon'));
                }
            })
            ->select('districts.id', 'districts.zone_id', 'districts.name', 'zones.name as zone_name', 'zones.color as zone_color')
            ->leftJoin('zones', 'districts.zone_id', '=', 'zones.id')
            ->orderBy('zones.name', 'asc')
            ->paginate(request()->query('per_page') ?? 10, ['*'], 'laman')
            ->withQueryString();

        $groupDistricts = $districts->getCollection()->groupBy(function ($district) {
            return $district->zone?->name;
        });

        $zones = Zone::select('id', 'name')->withCount('districts')->get();
        $unassignedDistrictCount = District::whereNull('zone_id')->count();

        // Append a fake "zone" record for them
        if ($unassignedDistrictCount > 0) {
            $zones->prepend((object) [
                'id' => 'tiada',
                'name' => 'Tiada Zon',
                'districts_count' => $unassignedDistrictCount,
            ]);
        }

        return Inertia::render('Auth/District/Index', compact('districts', 'groupDistricts', 'zones'));
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
            'zone_id' => ['bail', 'nullable', 'integer', Rule::exists('zones', 'id')],
            'name' => ['bail', 'required', 'string', 'max:255', Rule::unique('zones')],
        ]);

        DB::beginTransaction();
        try {
            $district = new District;
            $district->zone_id = $vdata['zone_id'];
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
            'zone_id' => ['bail', 'nullable', 'integer', Rule::exists('zones', 'id')],
            'name' => ['bail', 'required', 'string', 'max:255', Rule::unique('zones')->ignore($district->id)],
        ]);

        DB::beginTransaction();
        try {
            $district->zone_id = $vdata['zone_id'];
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
