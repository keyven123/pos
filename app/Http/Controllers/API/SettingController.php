<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Http\Services\UpdateOrCreateService;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $updateOrCreateService;

    public function __construct(UpdateOrCreateService $updateOrCreateService)
    {
        $this->updateOrCreateService = $updateOrCreateService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::where('id', '!=', 1)->get();
        
        return [
            'app_name'     => $settings->where('attribute', 'app_name')->first(),
            'trial'        => $settings->where('attribute', 'trial')->first(),
            'trial_end'    => $settings->where('attribute', 'trial_end')->first(),
            'start_of_day' => $settings->where('attribute', 'start_of_day')->first(),
            'end_of_day'   => $settings->where('attribute', 'end_of_day')->first(),
            'half_day'     => $settings->where('attribute', 'half_day')->first(),
            'whole_day'    => $settings->where('attribute', 'whole_day')->first(),
            'logo'         => $settings->where('attribute', 'logo')->first(),
            'banner'       => $settings->where('attribute', 'banner')->first()
        ];
    }

    public function store(Request $request)
    {
        if ($request->file('image')) {
            $settings = Setting::findOrFail($request->id);
            $file = $request->file('image');
            $destinationPath = public_path().'/images/logo/';
            if ($request->id == 8) {
                $fileName = 'logo.png';
                $data = [
                    'value' => '/images/logo/logo.png'
                ];
            }
            if ($request->id == 9) {
                $fileName = 'banner.png';
                $data = [
                    'value' => '/images/logo/banner.png'
                ];
            } 
            
            $response =  $this->updateOrCreateService->update($data, '\App\Models\Setting', 'Setting', $request->id);
            if ($response['success']) {
                $path = public_path()."/".$settings->value;
                if(\File::exists(str_replace("\\", '/', $path))){
                    unlink(str_replace("\\", '/', $path));
                }
            }
            $file->move($destinationPath,$fileName);
        
            return $response;

        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => "Image is required.",
                    'alert_type' => 'failed',
                ], 422
            );
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\SettingRequest  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(SettingRequest $request, Setting $setting)
    {
        $data = $request->validated();
        
        $update = $setting->update(['value' => $data['value']]);

        if ($update)  {
            return [
                'success' => true,
                'message' => "Settings updated successfully",
                'alert_type' => 'success',
            ];
        } else {
            return [
                'success' => false,
                'message' => "Settings updated failed",
                'alert_type' => 'error',
            ];
        }
    }
}
