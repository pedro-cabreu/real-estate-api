<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\User;
use Dotenv\Validator;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user){
        
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->paginate('10');

        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if(!$request->has('password') || !$request->get('password')){
            
            $message = new ApiMessages('The password is required.');

            return response()->json($message->getMessage(), 401);
        }

        FacadesValidator::make($data, [
            
            'phone' => 'required',
            'mobile_phhone' => 'required'
        ])->validate();

        try {
            
            $data['password'] = bcrypt($data['password']);

            $users = $this->user->create($data);
            $users->profile()->create(
                [
                    'phone' => $data['phone'],
                    'mobile_phone' => $data['mobile_phone']
                ]
            );

            return response()->json([
                'data' => [
                    'msg' => 'User registered successfully!'
                ]
            
            ], 200);

        } catch (\Exception $e) {
            
            $message = new ApiMessages($e->getMessage());

            return response()->json($e->getMessage(), 401);
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
        try {
            
            $user = $this->user->with('profile')->findOrFail($id);
            $user->profile->social_networks = unserialize($user->profile->social_networks);

            return response()->json([

                'data' =>  $user
            ], 200);

        } catch (\Exception $e) {
            
            $message = new ApiMessages($e->getMessage());

            return response()->json($e->getMessage(), 401);
        }
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
        $data = $request->all();

        if($request->has('password') && $request->get('password')){
            
            $data['password'] = bcrypt($data['password']);
        
        } else{
            
            unset($data['password']);
        }

        FacadesValidator::make($data, [
            
            'profile.phone' => 'required',
            'profile.mobile_phhone' => 'required'
        ])->validate();

        try {
            $profile = $data['profile'];
            $profile['social_networks'] = serialize($profile['social_networks']);

            $user = $this->user->findOrFail($id);
            $user->update($data);

            $user->profile()->update($profile);

            return response()->json([
                'data' => [
                    'msg' => 'User updated successfully!'
                ]
            
            ], 200);

        } catch (\Exception $e) {
            
            $message = new ApiMessages($e->getMessage());

            return response()->json($e->getMessage(), 401);
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
        
        try {
            
            $user = $this->user->findOrFail($id);
            $user->delete();

            return response()->json([
                'data' => [
                    'msg' => 'User deleted successfully!'
                ]
            
            ], 200);

        } catch (\Exception $e) {
            
            $message = new ApiMessages($e->getMessage());

            return response()->json($e->getMessage(), 401);
        }
    }
}
