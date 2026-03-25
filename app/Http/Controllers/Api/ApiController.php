<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Appointment;
use App\Models\Package;
use App\Models\Step;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function videos()
    {
        $data = Video::where('status', 1)->get();

        return $data;
    }
    public function about()
    {
        $data = About::where('status', 1)->get();

        return $data;
    }
    public function steps()
    {
        $data = Step::where('status', 1)->get();

        return $data;
    }


    public function packages()
    {
        $data = Package::where('status', 1)->get();

        return $data;
    }
    public function appointments(Request $request)
    {
        Appointment::create($request->all());
        return response()->json([
            'status' => 'ok'
        ]);
    }
}