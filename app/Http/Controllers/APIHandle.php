<?php

namespace App\Http\Controllers;

use App\Http\Requests\APIRequest;
use Illuminate\Http\Request;

class APIHandle extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  App\Http\Requests\APIRequest;
     * @return \Illuminate\Http\Response
     */
    public function __invoke(APIRequest $request)
    {
        return response()->json([]);
    }
}
