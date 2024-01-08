<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class RatingCalculatorController extends Controller
{
    public function index(){
        return view('rating-calculator');
    }
    // public function calculate(Request $request){
    //     $fiveStarRatings = $request->input('five_star_ratings');
    //     $starboost = $request->input('starboost');

    //     // Implement the calculation logic
    //     $timeWithStarboost = ($starboost === 'with') ? ($fiveStarRatings / 95) : ($fiveStarRatings / 4);

    //     $result = [
    //         'timeWithStarboost' => round($timeWithStarboost, 2) . ' months',
    //     ];

    //     return response()->$result;
    // }

    public function getReviews(Request $request)
    {
        //dd($request->all());
        $placeId=$request->place_id;
        $apiKey = 'AIzaSyDbSq9NXgcdfv9CsRpDx_L-XNGn8SeR-tg';
        $client = new Client();

        $url = "https://maps.googleapis.com/maps/api/place/details/json";
        $params = [
            'place_id' => $placeId,
            'fields' => 'reviews',
            'key' => $apiKey,
        ];

        $response = $client->get($url, ['query' => $params]);
        $data = json_decode($response->getBody(), true);

        $reviews = $data['result']['reviews'] ?? [];

        return view('reviews.index', compact('reviews'));
    }
}
