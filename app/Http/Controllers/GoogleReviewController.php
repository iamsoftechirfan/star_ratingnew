<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Models\Settings;
use App\Mail\MyCustomEmail;
use Illuminate\Support\Facades\Mail;



class GoogleReviewController extends Controller
{
    
    public function autocomplete(Request $request)
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $input = $request->input('query');

        $client = new Client();

        $response = $client->get("https://maps.googleapis.com/maps/api/place/autocomplete/json?input=$input&key=$apiKey");

        $predictions = json_decode($response->getBody(), true)['predictions'];

        return response()->json($predictions);
    }

    public function getReviews(Request $request)
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $apibusiness=env('GOOGLE_MAPS_API_KEY_BUSINESS');
        //$placeName = 'Döner Stop,Basel Claraplatz';
        $placeName=$request->place_id;
        $DesiredRating=$request->rating;
        // dd($placeName);
        $client = new Client();
        $reviews = [];
        // Set the initial page token to null
        $pageToken = null;
          
           
                 $placeResponse = $client->get("https://maps.googleapis.com/maps/api/place/textsearch/json?query=$placeName&key=$apiKey");
                
            
        // Use double quotes to interpolate variables in the URL
      
        
        $placeDetails = json_decode($placeResponse->getBody(), true);
        $lat=0;
        $lng=0;
        // dd($placeDetails);
        
          
    //   dd($business_details);
        if (isset($placeDetails['results'])) {
        foreach ($placeDetails['results'] as $key => $value) {
             if (isset($value['geometry'])) {
                foreach($value['geometry'] as $geo){
                    if (isset($geo['lat'])) { 
                $lat=$geo['lat'];
                 $lng=$geo['lng'];
                    }
            }  
             }
           
        }
         
        }
        //irfan
         $nearbyUrl = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$lat,$lng&radius=500&type=restaurant,hotel,office,mall&key=$apiKey";
    $nearbyResponse = $client->get($nearbyUrl);
    $nearbyData = json_decode($nearbyResponse->getBody(), true);
    $business_detailss=array();
     $j=0;
    
         foreach ($nearbyData['results'] as $key => $value) {
            
              if(isset($value['rating'])){
                   
                 $business_detailss[$j]['place_name']=$value['name'];
                //  dd($value);
            $business_detailss[$j]['address']=$placeName;
            // $business_details[$j]['place_id']=$value['place_id'];
            // $business_detailss[$j]['photoes']=$value['photos']; 
             $business_detailss[$j]['user_ratings_total']=$value['user_ratings_total'];
             $business_detailss[$j]['vicinity']=$value['vicinity']; 
            $business_detailss[$j]['rating']=$value['rating'];
            // dd($business_detailss);
             $j++;
              }
            //  dd($business_detailss);      
        
         }
    // dd($business_detailss);
   //irfan
    //   dd($lat);
       
        $place_details=$placeDetails['results'];
         
        $business_details=array();
      
         $i=0;
        foreach ($placeDetails['results'] as $key => $value) {
            # code...
            //dd($value);
            $business_details[$i]['place_name']=$value['name'];
            $business_details[$i]['formatted_address']=$value['formatted_address'];
            $business_details[$i]['place_id']=$value['place_id'];
            $business_details[$i]['types']=$value['types'];
            if(isset($value['rating'])){
                $business_details[$i]['rating']=$value['rating'];
            }else{
                $business_details[$i]['rating']=0;
            }
            
            
            $placeId=$value['place_id'];
            // dd($placeId);
            // $apiKey="AIzaSyDwTtA4XfsSNLfwcpTYkp152W4IP3EszzU";
            // $url = "https://mybusiness.googleapis.com/v4/accounts?key={$apiKey}";
            // $response = $client->get($url);
            // dd($response);
            // $data = json_decode($response->getBody(), true);
            // dd($data);
            // dd($placeId);
            // $accountId="923180107197";
         
            $url = "https://maps.googleapis.com/maps/api/place/details/json?placeid=$placeId&key=$apiKey";
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);
            //   dd($data);          
            if (isset($data['result']['reviews'])) {
                // Add the reviews to the array
                //  dd($data);
                $business_details[$i]['user_ratings_total']=$data['result']['user_ratings_total'];
                $business_details[$i]['reviews']=$data['result']['reviews'];
                $business_details[$i]['rating_stats'] = $this->calculateRatingsDistribution($data['result']['reviews']);
                $business_details[$i]['lat'] = $value['geometry']['location']['lat'];
                $business_details[$i]['lng'] = $value['geometry']['location']['lng'];
                $business_details[$i]['negative_reviews_count'] = $this->countNegativeReviews($data['result']['reviews']);;
            }
              $targetAverage = 5; 
            $currentAverage = $business_details[$i]['rating']; 
            $impactPerRating = (5-$business_details[$i]['rating']); 
            if($impactPerRating<=0){
            $impactPerRating =1;
            }
            
            $difference = $targetAverage - $currentAverage;
            $business_details[$i]['numberOfFiveStarRatingsNeeded'] = ((($difference / $impactPerRating)/5)*100);
            // $targetAverage = 5; 
           
            // $user_ratings_total = $business_details[$i]['user_ratings_total']; 
            //  $currentAverage = $business_details[$i]['rating']; 
            //  $difference = $targetAverage - $currentAverage;
            //  if($difference <= 0){
            //      $difference=1
                  
            //  }
            //  $neededPoints= round($user_ratings_total/$currentAverage)/$difference;
            // // $neededPoints= round($user_ratings_total/$currentAverage)/$difference;
            // //  dd($neededPoints);
           
          
            // $business_details[$i]['numberOfFiveStarRatingsNeeded'] = $neededPoints;

            // dd($business_details);
            // foreach ($business_details as $key => $value) {
            //     # code...
            //     $settings = new Settings;
            //     $settings->name = $request->name;
            //     $settings->email = $request->email;
            //     $settings->place_id = $request->place_id;
            //     $settings->search_item = $value['place_name'];
            //     $settings->formatted_address = $value['formatted_address'];
            //     $settings->place_id = $value['place_id'];
            //     $settings->types = json_encode($value['types']);
            //     $settings->rating = $value['rating'];
            //     if(isset($value['reviews'])){
            //         $settings->reviews = json_encode($value['reviews']);
            //     }else{
            //         $settings->reviews =null;
            //     }
            //     if(isset($value['rating_stats'])){
            //         $settings->rating_stats = json_encode($value['rating_stats']);
            //     }else{
            //         $settings->rating_stats =null;
            //     }

            //     if(isset($value['lat'])){
            //         $settings->lat = json_encode($value['lat']);
            //     }else{
            //         $settings->lat =null;
            //     }

            //     if(isset($value['lng'])){
            //         $settings->lng = json_encode($value['lng']);
            //     }else{
            //         $settings->lng =null;
            //     }
            //     if(isset($value['negative_reviews_count'])){
            //         $settings->negative_reviews_count = json_encode($value['negative_reviews_count']);
            //     }else{
            //         $settings->negative_reviews_count =null;
            //     }
            //     $settings->save();
            // }
            // dd($business_details);
            $i++;
        }
        //  dd($placeName);
        // $data = [
        //     'name' => $request->name,
        //     'description'=>'Thank you for your inquiry!
        //     Your Results
        //     We will check your google business profile and get back to you soon as possible.
            
        //     A details analysis of your profile will now carried out by the lower.
            
        //     Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit, placeat.
            
        //     Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit nostrum quos itaque autem perspiciatis ipsa rem quisquam quasi neque vero.'
        // ];
       
        // Mail::to($request->email)->send(new MyCustomEmail($data));
    //   dd($business_details);
       return view('reviews.indexx', compact('business_details','lat','lng','business_detailss','placeName','DesiredRating'));
    }
    
    private function calculateRatingsDistribution($businessDetails)
    {
        
        $ratingsDistribution = [
            '5' => 0,
            '4' => 0,
            '3' => 0,
            '2' => 0,
            '1' => 0,
        ];

        foreach ($businessDetails as $business) {
            //dd($business);
            if (isset($business['rating'])) {
                $rating = $business['rating'];
                $ratingsDistribution[$rating]++;
            }
        }

        return $ratingsDistribution;
    }
    

private function countNegativeReviews($reviews)
{
    $negativeReviewsCount = 0;

    foreach ($reviews as $review) {
        if (isset($review['rating']) && $review['rating'] <= 2) {
            $negativeReviewsCount++;
        }
    }

    return $negativeReviewsCount;
}
    

    
}
