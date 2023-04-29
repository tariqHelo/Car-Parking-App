<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\ZoneResource;

use App\Models\Zone;
class ZoneController extends Controller
{
    
    public function index()
    {
        return ZoneResource::collection(Zone::all());
    }
}
