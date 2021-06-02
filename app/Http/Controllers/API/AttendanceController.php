<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\UpdateOrCreateService;
use App\Models\Attendance;
use App\Models\TotalUserTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    private $updateOrCreateService;
    public function __construct(UpdateOrCreateService $updateOrCreateService)
    {
        $this->updateOrCreateService = $updateOrCreateService;
    }
    public function getFirstAndLastRecord(Request $request) 
    {
        if ($request->id) {
            $id = $request->id;
        } else {
            $id = auth()->user()->id;
        }
        $first = Attendance::where('user_id', $id)
            ->select(DB::raw("DATE_FORMAT(time_in, '%Y') as date"))->orderBy('date', 'ASC')->first();
        $last = Attendance::where('user_id', $id)
            ->select(DB::raw("DATE_FORMAT(time_in, '%Y') as date"))->orderBy('date', 'DESC')->first();
        return response()->json(compact('first', 'last'));
    }

    public function index(Request $request)
    {
        try {
            // dd($request->all());
            if ($request->startOfMonth) {
                $start = new Carbon($request->startOfMonth);
                $startOfMonth = $start->copy()->startofMonth()->startOfDay();
                $endOfMonth = $startOfMonth->copy()->endOfMonth();
                // dd($startOfMonth, $endOfMonth);
                // $date = substr($request->startOfMonth, 0, 7);
                // $startOfMonth = new Carbon($date."-"."01 "."00:00:00");
                // $pass_date = strtotime(substr($request->startOfMonth, 0, 9));
                // dd($pass_date);
                // $total_days = cal_days_in_month(CAL_GREGORIAN, date('m', $pass_date), date('Y', $pass_date));
                // $endOfMonth = new Carbon($date."-".$total_days." "."23:59:59");
            } else {
                $startDate = Carbon::now();
                $startOfMonth = $startDate->copy()->startOfMonth();
                $endOfMonth = $startDate->copy()->endOfMonth();
            }

            if (!$request->id) {
                $request->id = auth()->user()->id;
            }

            $attendance =  Attendance::where('user_id', $request->id)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->select('*', DB::raw("DATE_FORMAT(time_in, '%d') as formatted_time_in"))
            ->get();
            $array = array();
            foreach ($attendance as $att) {
                array_push($array, [
                    'id' => $att->id,
                    'is_present' => ($att->time_in ? true : false),
                    'date' => intval($att->formatted_time_in),
                    'is_approved' => $att->is_approved,
                    'time_in' => $att->time_in,
                    'time_out' => $att->time_out,
                    'type' => $att->type
                ]);
            }
            return $array;
        } catch (\Throwable $th) {
            return response()->json([
                'alert_type' => 'error',
                'message' => $th->getMessage(),
                'success' => false
            ]);
        }
    }

    public function getTodayAttendance(Request $request)
    {
        // dd($request->all());
        $now = Carbon::now()->format('Y-m-d');
        return Attendance::where('user_id', $request->id)->where('created_at', 'like', "%$now%")->first();
        
    }

    public function store(Request $request)
    {
        $request = [
            'user_id' => $request->id,
            'time_in' => Carbon::now()->format('Y-m-d H:i:s'),
        ];
        // dd($request);
        return $this->updateOrCreateService->create($request, '\App\Models\Attendance', 'Attendance');
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        try {
            $user = Attendance::where('user_id', $request->id)->latest()->first();
            $time_in = Carbon::parse($user->time_in);
            $time_out = Carbon::parse();
            // $total_duration = $time_out->diffForHumans($time_in); // 10 Hrs after
            $total_duration = $time_out->diff($time_in)->format('%H'); // 10
            if ($total_duration >= 4 && $total_duration < 8) {
                $type = "Half day";
            } else if ($total_duration < 4) {
                $type = "Not counted";
            } else {
                $type = "Whole day";
            }
            $data = [
                'time_out' => Carbon::now()->format('Y-m-d H:i:s'),
                'type' => $type
            ];
            $data = $this->updateOrCreateService->update($data, '\App\Models\Attendance', 'Attendance', $user->id);
            // dd($total_duration, $type, $data);
            if ($data['success'] == true) {
                TotalUserTime::create([
                    'user_id' => $request->id,
                    'hours' => $total_duration
                ]);
            }
            return $data;
        } catch (\Throwable $th) {
            return response()->json([
                'alert_type' => 'error',
                'message' => 'Failed to update time-out',
                'error' => $th->getMessage(),
                'success' => false
            ]);
        }

    }

    public function resetTimeOut(Request $request, $id)
    {
        $user = Attendance::where('user_id', $request->id)->latest()->first();
        $request = [
            'time_out' => null,
            'type' => null
        ];
        return $this->updateOrCreateService->update($request, '\App\Models\Attendance', 'Attendance', $user->id);
        // Attendance::where('user_id', $request['id'])->latest()->first()->update(['time_out' => null]);
    }

    public function historyTable(Request $request)
    {
        if ($request->itemsPerPage) {
            $itemsPerPage = $request->itemsPerPage;
        } if ($request->itemsPerPage == null) {
            $itemsPerPage = 10;
        } if ($request->id == null) {
            $id = auth()->user()->id;
        } if ($request->id) {
            $id = $request->id;
        }
        return Attendance::with('total_hour')
            ->where('user_id', $id)
            ->orderBy('created_at', 'DESC')
            ->paginate($itemsPerPage);
    }

    public function getAttendanceSummary(Request $request)
    {
        return Attendance::where('user_id', $request->id)
            ->select(DB::raw('COUNT(id) as total_working_days'),
                DB::raw("COUNT(CASE WHEN type = 'Whole day' Then type END) as whole_day"),
                DB::raw("COUNT(CASE WHEN type = 'Half day' Then type END) as half_day"),
                DB::raw("COUNT(CASE WHEN type = 'Not counted' Then type END) as not_counted")
            )->first();
    }

    public function filterAttendances(Request $request)
    {
        // dd($request->all());
        try {
            if ($request->startOfMonth) {
                $start = new Carbon($request->startOfMonth);
                $startOfMonth = $start->copy()->startofMonth()->startOfDay();
                $endOfMonth = $startOfMonth->copy()->endOfMonth();
            } else {
                $startDate = Carbon::now();
                $startOfMonth = $startDate->copy()->startOfMonth();
                $endOfMonth = $startDate->copy()->endOfMonth();
            }

            if (!$request->id) {
                $request->id = auth()->user()->id;
            }

            if ($request->itemsPerPage) {
                $itemsPerPage = $request->itemsPerPage;
            }
            
            if ($request->itemsPerPage == null) {
                $itemsPerPage = 10;
            }

            $attendance =  Attendance::where('user_id', $request->id)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->select('*', DB::raw("DATE_FORMAT(time_in, '%d') as formatted_time_in"))
            ->paginate($itemsPerPage);
            return $attendance;
        } catch (\Throwable $th) {
            return response()->json([
                'alert_type' => 'error',
                'message' => $th->getMessage(),
                'success' => false
            ]);
        }
    }
}
