<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
Use App\Models\Antriansoal;

use Session;
use Validator;
use JWTAuth;

class AntreanController extends BaseController
{
    public function __construct()
    {
        $this->response = new BaseController;
    }
    public function create(Request $request)
    {
        try {
            $rules = [
                'x-username' => 'required',
                'x-token' => 'required',
                'namapoli' => 'required',
                'kodepoli' => 'required',
                'tglpriksa' => 'required',
                'nomorkartu' => 'required',
                'nik' => 'required',
                'keluhan' => 'required',
            ];
            $validator = Validator::make([
                'x-username'=>$request->header('x-username'),
                'x-token'=>$request->header('x-token'),
                'namapoli'=>$request->namapoli,
                'kodepoli'=>$request->kodepoli,
                'tglpriksa'=>$request->tglpriksa,
                'nomorkartu'=>$request->nomorkartu,
                'nik'=>$request->nik,
                'keluhan'=>$request->keluhan,
            ], $rules);

            if($validator->fails()){
                return $this->response->sendError($validator->errors()->first(), '', 201);
            }
            $user = JWTAuth::setToken($request->header('x-token'))->toUser();

            $antrean = Antriansoal::all();
            $number = (!empty($antrean)) ? count($antrean) : 0 ;

            $nomorantrean = 'A'.$number+1;
            $angkaantrean = $number+1;
            $norm = sprintf("%04s", $number+1);
            $namapoli = $request->namapoli;
            $kodepoli = $request->kodepoli;
            $tglpriksa = $request->tglpriksa;
            $nomorkartu = $request->nomorkartu;
            $nik = $request->nik;
            $keluhan = $request->keluhan;
            $statusdipanggil = 0;
            $int = $number+1;
            
            $createAntrean = Antriansoal::create([
                'nomorantrean' => $nomorantrean,
                'angkaantrean' => $angkaantrean,
                'norm' => $norm,
                'namapoli' => $namapoli,
                'kodepoli' => $kodepoli,
                'tglpriksa' => $tglpriksa,
                'nomorkartu' => $nomorkartu,
                'nik' => $nik,
                'keluhan' => $keluhan,
                'statusdipanggil' => $statusdipanggil,
                'int' => $int,
            ]);

            if($createAntrean){
                $response = $createAntrean;
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
        catch(\Exception $e){    
            return $this->response->sendError($e->getMessage(), '', 500);
        }
    }
    public function statusAntrean(Request $request)
    {
        try {
            $rules = [
                'x-username' => 'required',
                'x-token' => 'required',
                'kode_poli' => 'required',
                'tanggalperiksa' => 'required',
            ];
            $validator = Validator::make([
                'x-username'=>$request->header('x-username'),
                'x-token'=>$request->header('x-token'),
                'kode_poli'=>$request->kode_poli,
                'tanggalperiksa'=>$request->tanggalperiksa,
            ], $rules);

            if($validator->fails()){
                return $this->response->sendError($validator->errors()->first(), '', 201);
            }

            $user = JWTAuth::setToken($request->header('x-token'))->toUser();

            $all = Antriansoal::all();
            $antrean = Antriansoal::where('statusdipanggil',0)->get();
            if($data = Antriansoal::where('kodepoli',$request->kode_poli)->where('tglpriksa',$request->tanggalperiksa)->first()){
                $response = array(
                    "namapoli" => $data->namapoli,
                    "totalantrean" => count($all),
                    "sisaantrean" => count($antrean),
                    "antreanpanggil" => $data->nomorantrean,
                    "keterangan" => ""
                );
                $metadata = array('message'=>'oke', 'code'=>Response::HTTP_OK);
                return $this->response->sendResponse($response, $metadata);
            }
            else{
                return $this->response->sendError('invalid query or parameter', '', 201);
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
    public function getAntrean(Request $request)
    {
        try {
            $rules = [
                'x-username' => 'required',
                'x-token' => 'required',
                'nomorkartu' => 'required',
                'nik' => 'required',
                'kodepoli' => 'required',
                'tanggalperiksa' => 'required',
                'keluhan' => 'required',
            ];
            $validator = Validator::make([
                'x-username'=>$request->header('x-username'),
                'x-token'=>$request->header('x-token'),
                'nomorkartu'=>$request->nomorkartu,
                'nik'=>$request->nik,
                'kodepoli'=>$request->kodepoli,
                'tanggalperiksa'=>$request->tanggalperiksa,
                'keluhan'=>$request->keluhan
            ], $rules);

            if($validator->fails()){
                return $this->response->sendError($validator->errors()->first(), '', 201);
            }

            $user = JWTAuth::setToken($request->header('x-token'))->toUser();
            if($data = Antriansoal::where('nomorkartu',$request->nomorkartu)
            ->where('nik',$request->nik)
            ->where('kodepoli',$request->kodepoli)
            ->where('tglpriksa',$request->tanggalperiksa)
            ->where('keluhan',$request->keluhan)
            ->first()){
                $response = array(
                    "nomorantrean" => $data->nomorantrean,
                    "angkaantrean" => $data->angkaantrean,
                    "namapoli" => $data->namapoli,
                    "sisaantrean" => count(Antriansoal::where('tglpriksa',$request->tanggalperiksa)->get()),
                    "antreanpanggil" => $data->nomorantrean,
                    "keterangan" => "Apabila antrean terlewat harap mengambil antrean kembali."
                );
                $metadata = array('message'=>'oke', 'code'=>Response::HTTP_OK);
                return $this->response->sendResponse($response, $metadata);
            }
            else{
                return $this->response->sendError('invalid query or parameter', '', 201);
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

    public function sisaAntrean(Request $request){
        try {
            $rules = [
                'x-username' => 'required',
                'x-token' => 'required',
            ];
            $validator = Validator::make([
                'x-username'=>$request->header('x-username'),
                'x-token'=>$request->header('x-token'),
            ], $rules);

            if($validator->fails()){
                return $this->response->sendError($validator->errors()->first(), '', 201);
            }

            $user = JWTAuth::setToken($request->header('x-token'))->toUser();
            $today = date('Y-m-d');
            $sisaAntrean = Antriansoal::where('tglpriksa',$today)->where('statusdipanggil',0)->get();
            if($data = Antriansoal::where('tglpriksa',$today)->where('statusdipanggil',0)->first()){
                $response = array(
                    "nomorantrean" => $data->nomorantrean,
                    "namapoli" => $data->namapoli,
                    "sisaantrean" => count($sisaAntrean),
                    "antreanpanggil" => $data->nomorantrean,
                    "keterangan" => "",
                );
                $metadata = array('message'=>'oke', 'code'=>Response::HTTP_OK);
                return $this->response->sendResponse($response, $metadata);
            }
            else{
                return $this->response->sendError('invalid query or parameter', '', 201);
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
    public function batal(Request $request)
    {
        try {
            $rules = [
                'x-username' => 'required',
                'x-token' => 'required',
                'nomorkartu' => 'required',
                'kodepoli' => 'required',
                'tanggalperiksa' => 'required'
            ];
            $validator = Validator::make([
                'x-username'=>$request->header('x-username'),
                'x-token'=>$request->header('x-token'),
                'nomorkartu'=>$request->nomorkartu,
                'kodepoli'=>$request->kodepoli,
                'tanggalperiksa'=>$request->tanggalperiksa,
            ], $rules);

            if($validator->fails()){
                return $this->response->sendError($validator->errors()->first(), '', 201);
            }

            $user = JWTAuth::setToken($request->header('x-token'))->toUser();
            if($antrean = Antriansoal::where('nomorkartu',$request->nomorkartu)
            ->where('kodepoli',$request->kodepoli)
            ->where('tglpriksa',$request->tanggalperiksa)
            ->first()){
                $antrean->statusdipanggil = -1;
                if($antrean->save()){
                    $metadata = array('message'=>'oke', 'code'=>Response::HTTP_OK);
                    return $this->response->sendResponse('', $metadata);
                }
                return $this->response->sendResponse('invalid query or parameter', $metadata);
            }
            else{
                return $this->response->sendError('invalid query or parameter', '', 201);
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
