<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PayrollRequest;
use App\Http\Services\UpdateOrCreateService;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\PayrollList;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    private $updateOrCreateService;
    public function __construct(UpdateOrCreateService $updateOrCreateService)
    {
        $this->updateOrCreateService = $updateOrCreateService;
    }
    public function index(Request $request)
    {
        if ($request->itemsPerPage) {
            $itemsPerPage = $request->itemsPerPage;
        }if ($request->itemsPerPage == null) {
            $itemsPerPage = 10;
        } if ($request->search) {
            return Payroll::where('description', 'like', "%$request->search%")
                ->orderBy('created_at', 'DESC')
                ->paginate($itemsPerPage);
        }
        return Payroll::orderBy('created_at', 'DESC')
            ->paginate($itemsPerPage);
    }

    public function store(PayrollRequest $request)
    {
        $start = Carbon::parse($request->payroll_start);
        $end = Carbon::parse($request->payroll_end)->endOfDay();
        $employees = Attendance::leftJoin('users', 'attendances.user_id', '=', 'users.id')
            ->whereBetween('attendances.created_at', [$start, $end])
            ->where('user_id', '!=', 1)->where('is_claimed', 0)
            ->select('users.id', 'users.first_name', 'users.last_name', 'users.rate', DB::raw('COUNT(attendances.id) as total_working_days'),
                DB::raw("COUNT(CASE WHEN attendances.type = 'Whole day' THEN attendances.type END) as whole_day"),
                DB::raw("COUNT(CASE WHEN attendances.type = 'Half day' THEN attendances.type END) as half_day"),
                DB::raw("COUNT(CASE WHEN attendances.type = 'Not counted' THEN attendances.type END) as not_counted")
            )
            ->groupBy('users.id', 'users.first_name', 'users.last_name', 'users.rate')
            ->get();

        DB::beginTransaction();
        try {
            $payroll = $this->updateOrCreateService->create($request->validated(), '\App\Models\Payroll', 'Payroll');
            foreach ($employees as $employee) {
                PayrollList::create([
                    'user_id' => $employee->id,
                    'payroll_id' => $payroll['data']['id'],
                    'amount' => (floatval($employee->rate))*(floatval($employee->whole_day) + (floatval($employee->half_day/2))),
                ]);
                Attendance::whereBetween('created_at', [$start, $end])->update(['is_claimed' => 1]);
            }
            $payroll_list = PayrollList::where('payroll_id', $payroll['data']['id'])->first();
            if ($payroll_list) {
                $total_amount = PayrollList::where('payroll_id', $payroll['data']['id'])->sum('amount');
                Payroll::where('id', $payroll['data']['id'])->update(['amount' => $total_amount]);
            } else {
                Payroll::findOrFail($payroll['data']['payroll_id'])->delete();
            }
            DB::commit();
            return $payroll;
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'alert_type' => 'failed',
                'message' => 'There are no existing payroll on these dates.',
                'test' => $th->getMessage(),
                'success' => false
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
