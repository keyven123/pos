<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Services\UpdateOrCreateService;
use App\Models\Attendance;
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
    public function index()
    {
        // dd(Carbon::now()->daysInMonth);
        // return Attendance::where('user_id', auth()->user()->id)
        //     ->select('*', DB::raw("DATE_FORMAT(time_in, '%Y-%m-%d') as formatted_time_in"), DB::raw("DATE_FORMAT(time_out, '%Y-%m-%d') as formatted_time_out"))
        //     ->get();
        $startDate = Carbon::now();
        $startOfMonth = $startDate->copy()->startOfMonth();
        $endOfMonth = $startDate->copy()->endOfMonth();
        $attendance =  Attendance::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->select('*', DB::raw("DATE_FORMAT(time_in, '%d') as formatted_time_in"))
            ->get();
        $array = array();
        foreach ($attendance as $att) {
            array_push($array, [
                'is_present' => ($att->time_in ? true : false),
                'date' => intval($att->formatted_time_in)
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
        $request = [
            'time_out' => Carbon::now()->format('Y-m-d H:i:s'),
        ];
        $id = Attendance::where('user_id', auth()->user()->id)->latest()->first();
        return $this->updateOrCreateService->update($request, '\App\Models\Attendance', 'Attendance', $id->id);
    }

    public function destroy($id)
    {
        //
    }
}
