<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
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
        //
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
