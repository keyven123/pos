<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class LicenseController extends Controller
{
    public function index()
    {
        return view('pages.license.license');
    }
    
    public function store()
    {
        $request = request()->validate([
            'username' => 'required',
            'password' => 'required',
            'license' => 'required'
        ]);

        $data = \DB::transaction(function () use ($request) {
            resolve('filesystem')->forgetDisk('file_host');
                    app()['config']->set('filesystems.disks.file_host.host', 'files.000webhost.com');
                    app()['config']->set('filesystems.disks.file_host.username', $request['username']);
                    app()['config']->set('filesystems.disks.file_host.password', $request['password']);
                    app()['config']->set('filesystems.disks.file_host.root', '/Licensor');
    
            $disk = Storage::disk('file_host');
            
            Storage::disk('local_file')->put('/licensekey.csv', $disk->get('/licensekey.csv'));
    
            $key = [];
    
            if (($open = fopen(public_path() . "/files/licensekey.csv", "r")) !== FALSE) {
    
                while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                    $key[] = $data[0];
                }
    
                fclose($open);
            }
    
            return $key;
            
        });

        if (in_array($request['license'], $data)) {

            $license    = Setting::where('attribute', 'license')->first();
            $trial      = Setting::where('attribute', 'trial')->first();
            $trial_end  = Setting::where('attribute', 'trial_end')->first();
            $license    = $license->update(['value' => $request['license']]);
            $trial      = $trial->update(['value' => '1']);
            $trial_end  = $trial_end->update(['value' => now()->addYear(1)->format('Y-m-d')]);
        }

        return redirect('/login');
    }

}
