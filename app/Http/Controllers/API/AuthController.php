<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

Use App\Models\User;

use Session;
use Validator;
use JWTAuth;

class AuthController extends BaseController
{

    public function __construct()
    {
        $this->response = new BaseController;
    }

    public function getToken(Request $request)
    {
        try {
            $rules = [
                'x-username' => 'required',
                'x-password' => 'required'
            ];
            $validator = Validator::make([
                'x-username'=>$request->header('x-username'),
                'x-password'=>$request->header('x-password')
            ], $rules);
            if($validator->fails()){
                return $this->response->sendError($validator->errors()->first(), '', 201);
            }
            $credentials = array(
                'username'=>$request->header('x-username'),
                'password'=>$request->header('x-password'),
            );
            $token = JWTAuth::attempt($credentials);
            if($token){
                $user = User::where('username', $request->header('x-username'))->first();
                $response = array('token'=>$token);
                $metadata = array('message'=>'oke', 'code'=>Response::HTTP_OK);
                return $this->response->sendResponse($response, $metadata);
            }
            else{
                return $this->response->sendError('invalid username or password', '', 201);
            }
        }
        catch(\RuntimeException $e) 
        {
            return $this->response->sendError($e->getMessage(), '', 500);
        }
    }

    public function create(Request $request)
    {
        try {
            $rules = [
                // 'x-username' => 'required',
                // 'x-token' => 'required',
                'username' => 'required',
                'password' => 'required',
                'nama' => 'required',
                'email' => 'required',
                'hakakses' => 'required',
                'kdklinik' => 'required',
                'kdcabang' => 'required',
            ];
            $validator = Validator::make([
                // 'x-username'=>$request->header('x-username'),
                // 'x-token'=>$request->header('x-token'),
                'username'=>$request->username,
                'password'=>$request->password,
                'nama'=>$request->nama,
                'email'=>$request->email,
                'hakakses'=>$request->hakakses,
                'kdklinik'=>$request->kdklinik,
                'kdcabang'=>$request->kdcabang,
            ], $rules);

            if($validator->fails()){
                return $this->response->sendError($validator->errors()->first(), '', 201);
            }
            // $userTest = JWTAuth::setToken($request->header('x-token'))->toUser();

            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'username' => $request->username,
                'hakakses' => $request->hakakses,
                'kdklinik' => $request->kdklinik,
                'kdcabang' => $request->kdcabang,
            ]);
            if ($user) {
                $metadata = array('message'=>'Success', 'code'=>Response::HTTP_OK);
                return $this->response->sendResponse('', $metadata);
            }

        }
        catch(\RuntimeException $e) 
        {
            return $this->response->sendError($e->getMessage(), '', 500);
        }
        catch(\Exception $e){    
            return $this->response->sendError($e->getMessage(), '', 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $rules = [
                'x-username' => 'required',
                'x-token' => 'required',
                'username' => 'required',
                'password' => 'required',
                'nama' => 'required',
                'hakakses' => 'required',
                'kdklinik' => 'required',
                'kdcabang' => 'required',
            ];
            $validator = Validator::make([
                'x-username'=>$request->header('x-username'),
                'x-token'=>$request->header('x-token'),
                'username'=>$request->username,
                'password'=>$request->password,
                'nama'=>$request->nama,
                'hakakses'=>$request->hakakses,
                'kdklinik'=>$request->kdklinik,
                'kdcabang'=>$request->kdcabang,
            ], $rules);

            if($validator->fails()){
                return $this->response->sendError($validator->errors()->first(), '', 201);
            }
            $user = JWTAuth::setToken($request->header('x-token'))->toUser();

            $user->name = $request->nama;
            $user->password = Hash::make($request->password);
            $user->username = $request->username;
            $user->hakakses = $request->hakakses;
            $user->kdklinik = $request->kdklinik;
            $user->kdcabang = $request->kdcabang;

            if ($user->save()) {
                $metadata = array('message'=>'Success', 'code'=>Response::HTTP_OK);
                return $this->response->sendResponse('', $metadata);
            }

        }
        catch(\RuntimeException $e) 
        {
            return $this->response->sendError($e->getMessage(), '', 500);
        }
        catch(\Exception $e){    
            return $this->response->sendError($e->getMessage(), '', 500);
        }
    }

    public function read(Request $request)
    {
        try {
            $rules = [
                // 'x-username' => 'required',
                'x-token' => 'required',
            ];
            $validator = Validator::make([
                // 'x-username'=>$request->header('x-username'),
                'x-token'=>$request->header('x-token'),
            ], $rules);

            if($validator->fails()){
                return $this->response->sendError($validator->errors()->first(), '', 201);
            }
            $user = JWTAuth::setToken($request->header('x-token'))->toUser();

            if ($user->save()) {
                $metadata = array('message'=>'Success', 'code'=>Response::HTTP_OK);
                return $this->response->sendResponse($user, $metadata);
            }

        }
        catch(\RuntimeException $e) 
        {
            return $this->response->sendError($e->getMessage(), '', 500);
        }
        catch(\Exception $e){    
            return $this->response->sendError($e->getMessage(), '', 500);
        }
    }

}
