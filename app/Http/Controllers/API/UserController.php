<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Services\UpdateOrCreateService;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
            return User::with('designation')
                ->where('first_name', 'like', "%$request->search%")
                ->orWhere('last_name', 'like', "%$request->search%")
                ->orWhere('email', 'like', "%$request->search%")
                ->orWhere('username', 'like', "%$request->search%")
                ->orderBy('first_name', 'ASC')
                ->paginate($itemsPerPage);
        }

        return User::with('designation')
            ->orderBy('first_name', 'ASC')
            ->paginate($itemsPerPage);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $response = $this->updateOrCreateService->create($request->validated(), '\App\Models\User', 'User');
        $user = User::where(['username' => $request->username, 'email' => $request->email])->first();
        $user->assignRole($request->designation_id);
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
        return $this->updateOrCreateService->delete($id, '\App\Models\User', 'User');
    }
}
