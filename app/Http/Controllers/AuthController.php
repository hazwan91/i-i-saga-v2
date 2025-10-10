<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Models\AppointStatus;
use App\Models\Department;
use App\Models\Saga;
use App\Models\Station;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $currentYear = Carbon::now()->format('Y');
        $sagas = Saga::query()->select('id', 'year', 'name')->orderByDesc('year')->get();
        return Inertia::render('Guest/Login/Index', [
            'sagas' => $sagas,
            'currentYear' => $currentYear,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vdata = $request->merge([
            'ic' => Str::replace('-', '', $request->ic)
        ])->validate([
                    'ic' => ['bail', 'required', 'numeric', 'digits:12'],
                    'password' => ['bail', 'required', 'string'],
                    'saga' => ['bail', 'required', Rule::exists('sagas', 'id')],
                    'remember' => ['bail', 'required', 'boolean']
                ]);

        $this->ensureIsNotRateLimited();

        $userInDb = User::query()->where('ic', $vdata['ic'])->orderBy('created_at', 'desc')->first();

        if ($userInDb === null) {
            RateLimiter::hit($this->throttleKey());
            return back()->withInput()->with('fail', 'Akaun tidak wujud. Sila hubungi Jabatan Perkhidmatan Awam Negeri untuk maklumat lanjut');
        }

        if ($userInDb->type === null) {
            RateLimiter::hit($this->throttleKey());
            return back()->withInput()->with('fail', 'Akaun terdapat ralat. Sila hubungi Jabatan Perkhidmatan Awam Negeri untuk maklumat lanjut');
        }

        if (!in_array($userInDb->type, [UserType::SM2, UserType::NON_SM2])) {
            RateLimiter::hit($this->throttleKey());
            return back()->withInput()->with('fail', 'Akaun terdapat ralat. Sila hubungi Jabatan Perkhidmatan Awam Negeri untuk maklumat lanjut');
        }

        if (!$userInDb->active) {
            RateLimiter::hit($this->throttleKey());
            return back()->withInput()->with('fail', 'Akaun anda tidak diaktifkan dan tidak dibenarkan log masuk ke dalam sistem ini. Sila hubungi Jabatan Perkhidmatan Awam Negeri untuk maklumat lanjut');
        }

        if ($userInDb->type === UserType::SM2) {
            if (config('app.env') === 'production') {
                try {
                    $result = DB::connection('sm2viewlogin')->select('exec usp_ValidatePwd ?,?', [$vdata['ic'], $vdata['password']]);
                    if (count($result) === 0 || $result[0]->match !== '1') {
                        RateLimiter::hit($this->throttleKey());
                        $msg = 'Anda tidak didaftarkan dalam sistem ini. Sila hubungi Jabatan Perkhidmatan Awam Negeri untuk maklumat lanjut';
                        throw new Exception($msg);
                    }

                    $userInSm2 = DB::connection('sm2viewlogin')->table('dbo.ViewStaff_login')->where('EmployeeNewIC', $vdata['ic'])->select('EmployeeNewIC', 'EmployeeName', 'Department', 'DepartmentDesc', 'Station', 'StationDesc', 'StaffEmail', 'ReportAgent', 'ReportAgentDesc', 'ReportAgentStation', 'ReportAgentStationDesc', 'CurPostTitle', 'SchemeDesc', 'PostGrade', 'ActingPost', 'AppointStatus')->first();
                    if ($userInSm2 === null) {
                        RateLimiter::hit($this->throttleKey());
                        $msg = 'Anda tidak didaftarkan dalam sistem ini. Sila hubungi Jabatan Perkhidmatan Awam Negeri untuk maklumat lanjut';
                        throw new Exception($msg);
                    }
                } catch (Exception $e) {
                    if (strpos($e->getMessage(), 'timed out')) {
                        $msg = 'Operation timed out. Please make sure your connection is intranet and have strong signal';
                    }

                    if (!isset($msg) || $msg === '') {
                        $msg = 'Oops, Something not right. Please contact developer to debug the issue';
                    }

                    RateLimiter::hit($this->throttleKey());
                    return back()->withInput()->with('fail', $msg);
                }

                if (!Auth::loginUsingId($userInDb, $vdata['remember'])) {
                    RateLimiter::hit($this->throttleKey());
                    return back()->withInput()->with('fail', 'Log masuk gagal. Sila hubungi Majlis Sukan Negeri untuk maklumat lanjut');
                }

                $department = Department::query()->where('code', trim($userInSm2->Department))->select('id', 'name')->first();
                $station = Station::query()->where('department_id', $department->id)->where('code', trim($userInSm2->Station))->select('id', 'name')->first();
                $departmentReport = Department::query()->where('code', trim($userInSm2->ReportAgent))->select('id', 'name')->first();
                if ($departmentReport === null) {
                    $stationReport = null;
                } else {
                    $stationReport = Station::query()->where('department_id', $department->id)->where('code', trim($userInSm2->ReportAgentStation))->select('id', 'name')->first();
                }

                $userInDb->ic = trim($userInSm2->EmployeeNewIC);
                $userInDb->name = trim($userInSm2->EmployeeName);
                $userInDb->email = trim($userInSm2->StaffEmail);
                $userInDb->department_id = $department === null ? null : $department->id;
                $userInDb->department_code = trim($userInSm2->Department);
                $userInDb->department_desc = trim($userInSm2->DepartmentDesc);
                $userInDb->station_id = $station === null ? null : $station->id;
                $userInDb->station_code = trim($userInSm2->Station);
                $userInDb->station_desc = trim($userInSm2->StationDesc);
                $userInDb->report_department_code = trim($userInSm2->ReportAgent);
                $userInDb->report_department_desc = trim($userInSm2->ReportAgentDesc);
                $userInDb->report_station_code = trim($userInSm2->ReportAgentStation);
                $userInDb->report_station_desc = trim($userInSm2->ReportAgentStationDesc);
                $userInDb->jawatan = trim($userInSm2->CurPostTitle);
                $userInDb->schema = trim($userInSm2->SchemeDesc);
                $userInDb->gred = trim($userInSm2->PostGrade);
                $userInDb->acting_post = trim($userInSm2->ActingPost);
                if (trim($userInSm2->AppointStatus) === null || trim($userInSm2->AppointStatus) === '') {
                    $userInDb->appoint_status_id = null;
                } else {
                    $appointStatus = AppointStatus::query()->where('code', $userInSm2->AppointStatus)->first();
                    $userInDb->appoint_status_id = $appointStatus === null ? null : $appointStatus->id;
                }
                $userInDb->last_login = now();
                $userInDb->save();
            } else {
                if (!Auth::attempt(['ic' => $vdata['ic'], 'password' => $vdata['password']], $vdata['remember'])) {
                    RateLimiter::hit($this->throttleKey());
                    return back()->withInput()->with('fail', 'Log masuk gagal. Sila hubungi Majlis Sukan Negeri untuk maklumat lanjut');
                }

                try {
                    $userInSm2 = DB::connection('sm2viewlogin')->table('dbo.ViewStaff_login')->where('EmployeeNewIC', $vdata['ic'])->select('EmployeeNewIC', 'EmployeeName', 'Department', 'DepartmentDesc', 'Station', 'StationDesc', 'StaffEmail', 'ReportAgent', 'ReportAgentDesc', 'ReportAgentStation', 'ReportAgentStationDesc', 'CurPostTitle', 'SchemeDesc', 'PostGrade', 'ActingPost', 'AppointStatus')->first();
                } catch (Exception $e) {
                    $userInSm2 = null;
                }

                if ($userInSm2 !== null) {
                    $department = Department::query()->where('code', trim($userInSm2->Department))->select('id', 'name')->first();
                    $station = Station::query()->where('department_id', $department->id)->where('code', trim($userInSm2->Station))->select('id', 'name')->first();
                    $departmentReport = Department::query()->where('code', trim($userInSm2->ReportAgent))->select('id', 'name')->first();
                    if ($departmentReport === null) {
                        $stationReport = null;
                    } else {
                        $stationReport = Station::query()->where('department_id', $department->id)->where('code', trim($userInSm2->ReportAgentStation))->select('id', 'name')->first();
                    }

                    $userInDb->ic = trim($userInSm2->EmployeeNewIC);
                    $userInDb->name = trim($userInSm2->EmployeeName);
                    $userInDb->email = trim($userInSm2->StaffEmail);
                    $userInDb->department_id = $department === null ? null : $department->id;
                    $userInDb->department_code = trim($userInSm2->Department);
                    $userInDb->department_desc = trim($userInSm2->DepartmentDesc);
                    $userInDb->station_id = $station === null ? null : $station->id;
                    $userInDb->station_code = trim($userInSm2->Station);
                    $userInDb->station_desc = trim($userInSm2->StationDesc);
                    $userInDb->report_department_code = trim($userInSm2->ReportAgent);
                    $userInDb->report_department_desc = trim($userInSm2->ReportAgentDesc);
                    $userInDb->report_station_code = trim($userInSm2->ReportAgentStation);
                    $userInDb->report_station_desc = trim($userInSm2->ReportAgentStationDesc);
                    $userInDb->jawatan = trim($userInSm2->CurPostTitle);
                    $userInDb->schema = trim($userInSm2->SchemeDesc);
                    $userInDb->gred = trim($userInSm2->PostGrade);
                    $userInDb->acting_post = trim($userInSm2->ActingPost);
                    if (trim($userInSm2->AppointStatus) === null || trim($userInSm2->AppointStatus) === '') {
                        $userInDb->appoint_status_id = null;
                    } else {
                        $appointStatus = AppointStatus::query()->where('code', $userInSm2->AppointStatus)->first();
                        $userInDb->appoint_status_id = $appointStatus === null ? null : $appointStatus->id;
                    }
                }
                $userInDb->last_login = now();
                $userInDb->save();
            }
        } elseif ($userInDb->type === 'NON_SM2') {
            if (!Auth::attempt(['ic' => $vdata['ic'], 'password' => $vdata['password']], $vdata['remember'])) {
                RateLimiter::hit($this->throttleKey());
                return back()->withInput()->with('fail', 'Log masuk gagal. Sila hubungi Majlis Sukan Negeri untuk maklumat lanjut');
            }

            $userInDb->last_login = now();
            $userInDb->save();
        } else {
            RateLimiter::hit($this->throttleKey());
            return back()->withInput()->with('fail', 'Jenis akaun anda belum disediakan. Sila hubungi MSNS untuk maklumat lanjut');
        }

        $saga = Saga::query()->selectRaw('
            sagas.id,
            sagas.name,
            year,
            districts.id as host_district_id,
            districts.name as host_district_name,
            date_start_rs,
            date_end_rs,
            date_start_rse,
            date_end_rse,
            date_start_rtech_qualification,
            date_end_rtech_qualification,
            date_start_rtech_saga,
            date_end_rtech_saga,
            date_start_rcom,
            date_end_rcom,
            date_start_rc_qualification,
            date_end_rc_qualification,
            date_start_rc_saga,
            date_end_rc_saga
        ')
            ->join('districts', 'sagas.host_district_id', '=', 'districts.id')
            ->where('sagas.id', $vdata['saga'])
            ->first();
        if ($saga === null) {
            RateLimiter::hit($this->throttleKey());
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->with(['fail' => 'Program tidak wujud. Sila pilih program yang sah']);
        }
        session()->put('event', $saga->toArray());

        session()->regenerate();

        return to_route('auth.home.index')->with('pass', 'Selamat Datang ' . $userInDb->name . ' !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'ic' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate-limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return request()->string('ic')
            ->lower()
            ->append('|' . request()->ip())
            ->transliterate()
            ->value();
    }
}
