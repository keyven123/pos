<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function default()
    {
        if (auth()->user()) {
            $settings = Setting::whereIn('attribute', ['trial',  'trial_end'])->get();
            $trial = $settings->where('attribute', 'trial')->first();
            $trialEnd = $settings->where('attribute', 'trial_end')->first();
            if ($trial->value == 1 && now()->format('Y-m-d') >= Carbon::parse($trialEnd->value)->format('Y-m-d')) {
                \Auth::logout();
                return redirect('/license')->withErrors(['message' => 'License expired, please contact administrator for more information.']);
            }
            return view('pages.dashboard.dashboard');
        }
        return redirect('/login');

    }
}
