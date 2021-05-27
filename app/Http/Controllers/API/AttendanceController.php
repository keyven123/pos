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
    public function getFirstAndLastRecord(Request $request) {
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
        if ($request->startOfMonth) {
            $date = substr($request->startOfMonth, 0, 7);
            $startOfMonth = new Carbon($date."-"."01 "."00:00:00");
            $pass_date = strtotime(substr($request->startOfMonth, 0, 9));
            $total_days = cal_days_in_month(CAL_GREGORIAN, date('m', $pass_date), date('Y', $pass_date));
            $endOfMonth = new Carbon($date."-".$total_days." "."23:59:59");
        } else {
            $startDate = Carbon::now();
            $startOfMonth = $startDate->copy()->startOfMonth();
            $endOfMonth = $startDate->copy()->endOfMonth();
        }
        $attendance =  Attendance::where('user_id', auth()->user()->id)
        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
        ->select('*', DB::raw("DATE_FORMAT(time_in, '%d') as formatted_time_in"))
        ->get();
        $array = array();
        foreach ($attendance as $att) {
            array_push($array, [
                'is_present' => ($att->time_in ? true : false),
                'date' => intval($att->formatted_time_in),
                'is_approved' => $att->is_approved,
                'time_in' => $att->time_in,
                'time_out' => $att->time_out,
                'type' => $att->type
            ]);
        }
        return $array;
    }

    public function getTodayAttendance()
    {
        $now = Carbon::now()->format('Y-m-d');
        return Attendance::where('created_at', 'like', "%$now%")->first();
        
    }

    public function store(Request $request)
    {
        $request = [
            'user_id' => auth()->user()->id,
            'time_in' => Carbon::now()->format('Y-m-d H:i:s'),
        ];
        return $this->updateOrCreateService->create($request, '\App\Models\Attendance', 'Attendance');
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $user = Attendance::where('user_id', auth()->user()->id)->latest()->first();
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
            $request = [
                'time_out' => Carbon::now()->format('Y-m-d H:i:s'),
                'type' => $type
            ];
            $data = $this->updateOrCreateService->update($request, '\App\Models\Attendance', 'Attendance', $user->id);
            // dd($total_duration, $type, $data);
            if ($data['success'] == true) {
                TotalUserTime::create([
                    'user_id' => auth()->user()->id,
                    'hours' => $total_duration
                ]);
            }
            return $data;
        } catch (\Throwable $th) {
            return response()->json([
                'alert_type' => 'error',
                'message' => 'Failed to update time-out',
                'success' => false
            ]);
        }

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
}
