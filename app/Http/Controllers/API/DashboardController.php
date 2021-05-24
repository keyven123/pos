<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CartHistory;
use App\Models\Ingredient;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getAllData()
    {
        try {
            $now = Carbon::now();
            $startOfLastMonth = $now->copy()->startOfMonth()->subMonths(1);
            $startOfMonth = $now->copy()->startOfMonth();
            $endOfMonth = $now->copy()->endOfMonth();

            $startOfYesterday = $now->copy()->startOfDay()->subDays(1);
            $startOfDay = $now->copy()->startOfDay();
            $endOfDay = $now->copy()->endOfDay();

            $order = DB::table('orders')->select(DB::raw('COUNT(id) as order_count'), DB::raw('SUM(amount) as today_earnings'))
                ->where('status', 1)
                ->whereBetween('created_at', [$startOfDay, $endOfDay])->first();
            $total = DB::table('cart_histories')
                ->where('status', 1)
                ->select(DB::raw('SUM(quantity) as product_sold'), DB::raw('SUM(price*quantity) as total_earnings'))
                ->first();

            $order_yesterday = DB::table('orders')->where('status', 1)->select(DB::raw('COUNT(id) as order_count'), DB::raw('SUM(amount) as today_earnings'))
                ->whereBetween('created_at', [$startOfYesterday, $startOfDay])->first();
            $total_last_month = DB::table('cart_histories')->where('status', 1)->select(DB::raw('SUM(quantity) as product_sold'), DB::raw('SUM(price*quantity) as total_earnings'))
                ->whereBetween('created_at', [$startOfLastMonth, $startOfMonth])->first();
            $total_this_month = DB::table('cart_histories')->where('status', 1)->select(DB::raw('SUM(quantity) as product_sold'), DB::raw('SUM(price*quantity) as total_earnings'))
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->first();

            return response()->json(compact('order', 'total', 'order_yesterday', 'total_last_month', 'total_this_month'));

        } catch (\Throwable $th) {
            return response()->json(
                [
                'message' => $th->getMessage()
                ]
            );
        }
    }

    public function getChartData(Request $request)
    {
        try {
            $startDate = Carbon::now();
            switch ($request->date) {
            case '30 Days':
                $filter = $startDate->subday(30);
                $groupBy = "%m-%d";
                break;
            case 'Monthly':
                $filter = $startDate->startOfYear();
                $groupBy = "%M";
                break;
            default:
                $filter = $startDate->subYears(10);
                $groupBy = "%Y";
            }
            $data = DB::table('cart_histories')
                ->where('status', 1)
                ->where('created_at', '>=', $filter)
                ->select(
                    DB::raw("DATE_FORMAT(created_at, '$groupBy') as date"),
                    DB::raw('SUM(price*quantity) as amount'),
                    DB::raw('COUNT(quantity) as quantity')
                )
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get();
            if ($request->type == 'Gross') {
                $chart_data = array(array('Date', 'Sales'));
                $total = DB::table('cart_histories')->where('status', 1)->select(DB::raw('SUM(price*quantity) as data'))->first();
                foreach ($data as $in) {
                    array_push($chart_data, [$in->date, floatval($in->amount)]);
                }
            } else if ($request->type == 'Orders') {
                $sold = DB::table('orders')
                    ->where('status', 1)
                    ->where('created_at', '>=', $filter)
                    ->select(
                        DB::raw("DATE_FORMAT(created_at, '$groupBy') as date"),
                        DB::raw('COUNT(id) as count_order')
                    )
                    ->groupBy('date')
                    ->orderBy('date', 'ASC')
                    ->get();;
                $chart_data = array(array('Date', 'Orders'));
                $total = DB::table('orders')->where('status', 1)->select(DB::raw('COUNT(id) as data'))->first();
                foreach ($sold as $in) {
                    array_push($chart_data, [$in->date, intval($in->count_order)]);
                }
            } else {
                $chart_data = array(array('Date', 'Product Sold'));
                $total = DB::table('cart_histories')->where('status', 1)->select(DB::raw('SUM(quantity) as data'))->first();
                foreach ($data as $in) {
                    array_push($chart_data, [$in->date, intval($in->quantity)]);
                }
            }
            return response()->json(compact('chart_data', 'total'));
        } catch (\Throwable $th) {
            return response()->json(
                [
                'message' => $th->getMessage()
                ]
            );
        }
    }
    public function filterBy(Request $request)
    {
        try {
            $now = Carbon::now();
            switch ($request->date) {
            case 'Today':
                $start = $now->copy()->startOfDay();
                $end = $now->copy()->endOfDay();
                break;
            case 'This Week':
                $start = $now->copy()->startOfWeek();
                $end = $now->copy()->endOfWeek();
                break;
            case 'This Month':
                $start = $now->copy()->startOfMonth();
                $end = $now->copy()->endOfMonth();
                break;
            case 'Last Month':
                $start = $now->copy()->startOfMonth()->subMonths(1);
                $end = $now->copy()->startOfMonth();
                break;
            default:
                $start = $now->copy()->startOfYear();
                $end = $now->copy()->endOfYear();
            }

            if ($request->type == 'Item') {
                $cart_histories = DB::table('cart_histories as ch')
                    ->where('ch.status', 1)
                    ->whereBetween('ch.created_at', [$start, $end])
                    ->leftJoin('products as p', 'p.id', '=', 'ch.product_id')
                    ->select('p.name as name', DB::raw('SUM(ch.price*ch.quantity) as total_sales'))
                    ->groupBy('name')
                    ->orderBy('total_sales', 'ASC')
                    ->get();
            } else if ($request->type == 'Category') {
                $cart_histories = DB::table('cart_histories as ch')
                    ->where('ch.status', 1)
                    ->whereBetween('ch.created_at', [$start, $end])
                    ->leftJoin('products as p', 'p.id', '=', 'ch.product_id')
                    ->leftJoin('categories as c', 'c.id', '=', 'p.category_id')
                    ->select('c.name as name', DB::raw('SUM(ch.price*ch.quantity) as total_sales'))
                    ->groupBy('name')
                    ->orderBy('total_sales', 'ASC')
                    ->get();
            } else {
                $cart_histories = DB::table('cart_histories as ch')
                    ->where('ch.status', 1)
                    ->whereBetween('ch.created_at', [$start, $end])
                    ->leftJoin('users as u', 'u.id', '=', 'ch.user_id')
                    ->select(DB::raw("CONCAT(u.first_name,' ',u.last_name) AS name"), DB::raw('SUM(ch.price*ch.quantity) as total_sales'))
                    ->groupBy('name')
                    ->orderBy('total_sales', 'ASC')
                    ->get();
            }
            $total2 = DB::table('cart_histories')->where('status', 1)->whereBetween('created_at', [$start, $end])->select(DB::raw('SUM(price*quantity) as data'))->first();

            $chart_data2 = array(array($request->type, 'Total'));
            foreach ($cart_histories as $in) {
                array_push($chart_data2, [$in->name, intval($in->total_sales)]);
            }

            return response()->json(compact('chart_data2', 'total2'));
        } catch (\Throwable $th) {
            return response()->json(
                [
                'message' => $th->getMessage()
                ]
            );
        }
    }
    public function getTableCarts(Request $request)
    {
        if ($request->itemsPerPage) {
            $itemsPerPage = $request->itemsPerPage;
        }if ($request->itemsPerPage == null) {
            $itemsPerPage = 10;
        } if ($request->search) {
            return DB::table('cart_histories as ch')
                ->where('ch.ref_no', 'like', "%$request->search%")
                ->leftjoin('products as p', 'p.id', '=', 'ch.product_id')
                ->select('ch.*', DB::raw('SUM(ch.quantity*ch.price)', 'p.name as product_name', 'v.name as variant_name'))
                ->orderBy('ch.created_at', 'DESC')
                ->paginate($itemsPerPage);
        }
        return CartHistory::with(['variant' => function ($q) {
            $q->select('id', 'variation_name');
        }])
            ->leftJoin('products as p', 'p.id', '=', 'cart_histories.product_id')
            ->select(
                'cart_histories.id', 'cart_histories.variant_id', 'cart_histories.ref_no', 'cart_histories.price', 'cart_histories.quantity', 'cart_histories.created_at',
                DB::raw('SUM(cart_histories.quantity*cart_histories.price) as total'), 
                'p.name as product_name',
            )
            ->groupBy('cart_histories.id', 'cart_histories.variant_id', 'cart_histories.ref_no', 'cart_histories.price', 'cart_histories.quantity', 'cart_histories.created_at', 'product_name')
            ->orderBy('cart_histories.created_at', 'DESC')
            ->paginate($itemsPerPage);
    }
    public function getAllInventory(Request $request)
    {
        if ($request->itemsPerPage) {
            $itemsPerPage = $request->itemsPerPage;
        }if ($request->itemsPerPage == null) {
            $itemsPerPage = 10;
        }
        return Ingredient::withSum('inventories', 'quantity')
            ->withSum('consumed_stocks', 'quantity')
            ->orderBy('name', 'ASC')
            ->paginate($itemsPerPage);
        
    }
    public function getAllSparkLine()
    {
        $now = Carbon::now();
        $startOfDay = $now->copy()->startOfDay()->subday(20);
        $endOfDay = $now->copy()->endOfDay();
        $startOfWeek = $now->copy()->startOfWeek()->subWeek(20);
        $daily = DB::table('orders')->where('status', 1)
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->select(DB::raw('SUM(amount) as amount'), DB::raw('COUNT(id) as count'), DB::raw("DATE_FORMAT(created_at, '%d') as date"))
            ->groupBy('date')->get();
        $daily_orders = array(0);
        $daily_earnings = array(0);
        foreach ($daily as $day) {
            array_push($daily_orders, intval($day->count));
            array_push($daily_earnings, intval($day->amount));
        }

        $weekly = DB::table('cart_histories')->where('status', 1)
            ->whereBetween('created_at', [$startOfWeek, $endOfDay])
            ->select(DB::raw('SUM(price*quantity) as amount'), DB::raw('SUM(quantity) as quantity'), DB::raw("DATE_FORMAT(created_at, '%U') as date"))
            ->groupBy('date')->get();
        $weekly_quantity = array(0);
        $weekly_earnings = array(0);
        foreach ($weekly as $week) {
            array_push($weekly_quantity, intval($week->quantity));
            array_push($weekly_earnings, intval($week->amount));
        }
        
        return response()->json(compact('daily_orders', 'daily_earnings', 'weekly_earnings', 'weekly_quantity'));
    }
}
