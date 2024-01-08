<!DOCTYPE html>
<html lang="en">
   <head>
      <title></title>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <link
         href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
         rel="stylesheet"
         integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
         crossorigin="anonymous"
         />
      <script
         src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
         integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
         crossorigin="anonymous"
         ></script>
      <script
         type="text/javascript"
         src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_api_key') }}&callback=initMap"
         async
         defer
         ></script>
      <link
         rel="stylesheet"
         href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
         />
      <style>
        .bb1 {
            border-bottom: 1px solid #dddddd;
             padding: 22px;
        }
        .br1 {
            border-right: 1px solid #dddddd;
        }
         .app {
         width: 67vw;
         margin: 0 auto;
         justify-content: space-evenly;
         }
         .bolo {
         position: absolute;
         top: 0px;
         z-index: -1;
         }
         @media only screen and (max-width: 600px) {
         .app {
         flex-direction: column;
         width: 95vw;
         }
         }
         p {
            margin-top: 1rem !important;
            margin-bottom: 1rem !important;
        }
      </style>
   </head>
   <body>
       <?php 
       
       
        $latitude = isset($lat) ? $lat : 0;
        $longitude = isset($lng) ? $lng : 0;
        $place_name = isset($placeName) ? $placeName : '';
   
       ?>
   <!--<iframe
  class="bolo"
  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1841.6970744806413!2d{{ $longitude }}!3d{{ $latitude }}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s!2s!5e0!3m2!1sen!2sin!4v1700904121531!5m2!1sen!2sin&markers=color:red!important%7C{{ $latitude }},{{ $longitude }}"
  width="100%"
  height="450"
  style="border: 0"
  allowfullscreen=""
  loading="lazy"
  referrerpolicy="no-referrer-when-downgrade"
></iframe> -->
<iframe 
    width="100%" 
    height="450" 
    frameborder="0" 
    scrolling="no" 
    marginheight="0" 
    marginwidth="0" 
    src="https://maps.google.com/maps?q=<?php echo $place_name; ?>&hl=en-US&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed">
    
</iframe> 
<!--
<iframe src="https://maps.google.com/maps?q=<?php echo $latitude;?>, <?php echo $longitude; ?>&hl=en-US&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
frameborder="0" 
style="border:0"
class="bolo"
width="100%"
height="450"
style="border: 0"
allowfullscreen=""
loading="lazy"
referrerpolicy="no-referrer-when-downgrade"
    ></iframe>
    -->
         
    @foreach($business_details as $business_detail)
      <div style="display: flex; padding: 300px 10px; margin-top: -434px " class="app">
      <div class="p-2" style="width:100%;">
            <div class="card">
               <div class="card-body">
                  <h1 class="text-left" style="font-weight: bold; margin-top: 21px;font-size: 2.75rem;"><?php  if($DesiredRating > $business_detail['rating']){
                                      $DesiredRating=$DesiredRating; 
                  }else{  $DesiredRating= 4.9;}
                  $total_rating= $business_detail['user_ratings_total'];
                  $current_rating=$business_detail['rating'];
                  $diff=$DesiredRating - $current_rating;
                 
                                    $difference =str_replace('.', '', $diff);
                                  
                                    $neededPoints=  $total_rating * $difference;
                                    echo $neededPoints;
                  ?></h1>
                  <h6 class="text-left">5-star review needed to achieve</h6>
                  <h6 class="text-left">a <?php echo $DesiredRating;?> star ratin</h6>
                  <div
                     style="
                     display: grid;
                     grid-template-columns: 9fr 1fr;
                     grid-auto-flow: row;
                     "
                     >


      <div>
                        <div
                           style="
                           height: 54%;
                           display: flex;
                           justify-content: center;
                           align-items: center;
                           flex-direction: column;
                           "
                           >
                           <h1 style="font-weight: bold; font-size: 3rem; margin-top: -137px;;margin-right: -464px;">restuarent</h1>
                           <div>
                           <h6 style="font-size: 1.5rem ;margin-left: 394px;">{{ $business_detail['rating'] }} <?php 
                                 echo "<span class='stars'>";
                                 for ( $i = 1; $i <= 5; $i++ ) {
                                     if ( round( $business_detail['rating'] - .25 ) >= $i ) {
                                             echo "<i class='fa fa-star checked text-warning'></i>"; //fas fa-star for v5
                                     } elseif ( round( $business_detail['rating'] + .25 ) >= $i ) {
                                             echo "<i class='fa fa-star-half-o checked text-warning'></i>"; //fas fa-star-half-alt for v5
                                     } else {
                                             echo "<i class='fa fa-star-o checked text-warning'></i>"; //far fa-star for v5
                                     }
                                 }
                                 echo '</span>';
                                 ?></h6>
                           </div>
                           <h1 style="margin-top: 3px; font-size: 1rem; margin-left: 401px;"><?php echo $business_detail['user_ratings_total'];?>  Google Rating</h1>
                        </div>
                     </div>
                              </div>
                              </div>
                              </div>
                              </div>
   </div>
   

       </table>
                               
                              </p>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <?php  
            // dd($placeName);
            $topNearbyPlaces = array_slice($business_detailss , 0, 5); 
           ?>
            
            <div class="div1" style="margin-top: -296px;">
                <h1 style="text-align: center; margin-left: -258px;">How long it takes to get <?php echo $neededPoints;?> ratings?</h1>
                <div
                  class="irfan"
                  style="display: flex; flex-direction: row; padding: 20px; gap: 30px; text-align: center; justify-content: center;"
                >
                  <div
                    style="
                      background-color: blue;
                      height: 300px;
                      width: 480px;
                      border-radius: 20px;
                      text-align: center;
                      font-size: large;
                      font-weight: bold;
                      color: white;
                      padding-top: 60px;
                    "
                  >
                    <p style="font-size: xx-large;">With Starbooster</p>
                    <br />
                    <h3><?php
                                if($neededPoints>=95)
                                {
                                    $month= number_format($neededPoints/95,1); 
                                    echo $month.' months';
                                    
                                }
                                else
                                {
                                $days=number_format((30/95)*($neededPoints),1);
                                echo $days.' days';
                               
                                }
                                ?></h4>
                  </div>
                  <div style="background-color: blue;
                  height: 300px;
                  width: 480px;
                  border-radius: 20px;
                  text-align: center;
                  font-size: large;
                  font-weight: bold;
                  color: white;
                  padding-top: 60px;">
                    <p style="font-size: xx-large;">With Out Starbooster</p>
                    <br />
                    <h3> <?php  if($neededPoints>=95)
                                {
                                   $month= number_format($neededPoints/4,1); 
                                    echo $month.' months';
                                    
                                }
                                else
                                {
                                $days=number_format((30/4)*($neededPoints),1);
                                echo $days.' days';
                               
                                }
                                ?></h4>
                  </div>
                </div>
                <!-- <h1>How dose Starboost work?</h1> -->
          
              </div>  
           
          
         </div>
         
      </div>
    @endforeach
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
      function initMap() {
        const map = new google.maps.Map(
          document.getElementById("map-container"),
          {
             center: { lat: {{ $lat }}, lng: {{ $lng }} },
            zoom: 12,
          }
        );

        var searchInput = "autocomplete";

        $(document).ready(function () {
          var auto;
          auto = new google.maps.places.Autocomplete(
            document.getElementById(searchInput),
            {
              types: ["address"], // Use 'address' instead of 'geocode'
            }
          );
        });
      }

      initMap();

      $(document).ready(function () {
        $("#autocomplete").on("input", function () {
          var query = $(this).val();

          $.get("/autocomplete", { query: query }, function (data) {
            $("#autocompleteResults").empty();

            data.forEach(function (prediction) {
              $("#autocompleteResults").append(
                "<li>" + prediction.description + "</li>"
              );
            });
          });
        });
      });

    </script>
   </body>
</html>