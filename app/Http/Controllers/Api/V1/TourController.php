<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Travel $travels)
    {
        $tours = $travels->tours() //Tour::where('travel_id', $travel->id) both are the same
            ->orderBy('starting_date')
            ->paginate();
// dd($travel);
        return TourResource::collection($tours);
    }
}
