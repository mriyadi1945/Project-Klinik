<?php
namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($response = [], $metadata)
    {
        if(!empty($response)){
            $data = [
                'response' => $response,
                'metadata' => $metadata,
            ];
        }
        else{
            $data = [
                'metadata' => $metadata,
            ];
        }
        return response()->json($data);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $status_code)
    {
    	$response = [
            'code' => $status_code,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $status_code);
    }
}