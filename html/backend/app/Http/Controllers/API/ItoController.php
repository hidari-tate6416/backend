<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItoController extends Controller
{
    /**
     * 試しAPI
     * 
     */
    public function ini(Request $request) {
        
        $result = array(
            "result" => 'OK'
        );

        return response()->success($result);
    }
}
