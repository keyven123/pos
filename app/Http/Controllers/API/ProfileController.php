<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Services\UpdateOrCreateService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
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
        return User::with('designation')->where('id', auth()->user()->id)->first();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->file('profile_image')) {
            $file = $request->file('profile_image');
            $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $fileName = strtotime('now').'.'.$extension;
            $destinationPath = public_path().'/images/user';
            $file->move($destinationPath,$fileName);
            $data = [
                'image' => 'images/user/'.$fileName
            ];
            
            $response =  $this->updateOrCreateService->update($data, '\App\Models\User', 'User', $request->id);
            
            $user = auth()->user();
            if ($response['success'] && $user->image  && !strpos($user->image, 'images/profile')) {
                $path = public_path()."/".$user->image;
                if(File::exists(str_replace("\\", '/', $path))){
                    unlink(str_replace("\\", '/', $path));
                }
            }
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => "Image is required.",
                    'alert_type' => 'failed',
                ], 422
            );
        }

        return $response;
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
    public function update(UserRequest $request, $id)
    {
        try {
            if ($request->password == null) {
                $data = $request->all();
                $data = \array_diff_key($data, ['password' => null]);
            } else {
                $data = $request->validated();
            }
            $response =  $this->updateOrCreateService->update($data, '\App\Models\User', 'User', $id);
            if ($request->password !== null) {
                $user = $response['data'];
                $user = User::findOrfail($user->id);
                $user->update(['password' => bcrypt($data['password'])]);
            }
            return $response;
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'alert_type' => 'error'
            ]);
        }
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
