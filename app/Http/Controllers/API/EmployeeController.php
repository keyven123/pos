<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PayrollList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->itemsPerPage) {
            $itemsPerPage = $request->itemsPerPage;
        }if ($request->itemsPerPage == null) {
            $itemsPerPage = 10;
        } if ($request->search) {
            return User::with('designation')->where('id', '!=', 1)
                ->where('first_name', 'like', "%$request->search%")
                ->orWhere('last_name', 'like', "%$request->search%")
                ->orWhere('email', 'like', "%$request->search%")
                ->orWhere('username', 'like', "%$request->search%")
                ->orderBy('first_name', 'ASC')
                ->paginate($itemsPerPage);
        }
        return User::with('designation')
            ->withCount(['attendances as total_working_days',
                'attendances as whole_day' => function ($q) {
                    $q->where('type', 'Whole day');
                },
                'attendances as half_day' => function ($q) {
                    $q->where('type', 'Half day');
                },
                'attendances as not_counted' => function ($q) {
                    $q->where('type', 'Not counted');
                },
            ])
            ->where('id', '!=', 1)
            ->orderBy('first_name', 'ASC')
            ->paginate($itemsPerPage);
    }

    public function showPayrollHistory(Request $request)
    {
        // dd($request->id);
        if ($request->itemsPerPage) {
            $itemsPerPage = $request->itemsPerPage;
        }if ($request->itemsPerPage == null) {
            $itemsPerPage = 10;
        }
        return PayrollList::with(['user', 'payroll'])
            ->where('user_id', $request->id)
            ->orderBy('created_at', 'DESC')
            ->paginate($itemsPerPage);
    }
}
