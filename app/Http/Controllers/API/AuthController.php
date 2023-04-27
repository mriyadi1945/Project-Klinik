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

}
