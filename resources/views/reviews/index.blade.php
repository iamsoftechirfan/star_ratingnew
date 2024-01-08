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
      <link
         rel="stylesheet"
         href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
         />
      <style>
         .app {
         width: 60vw;
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
      </style>
   </head>
   <body>
      <iframe
         class="bolo"
         src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1841.6970744806413!2d88.38184523885532!3d22.601752094867777!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f8bb34e13008ab%3A0xb88776c0052769b0!2sKolkata%20Railway%20Station%20(Chitpur%20Station)!5e0!3m2!1sen!2sin!4v1700904121531!5m2!1sen!2sin"
         width="100%"
         height="450"
         style="border: 0"
         allowfullscreen=""
         loading="lazy"
         referrerpolicy="no-referrer-when-downgrade"
         ></iframe>
      @foreach($business_details as $business_detail)
      <div style="display: flex; padding: 300px 10px" class="app">
         <div class="p-2">
            <div
               class="card"
               style="background-color: #214679; color: #fff; width: 600px"
               >
               <div class="card-body">
                  <h5>Thank you for your inquiry!</h5>
                  <h6>Your Results</h6>
                  <div>
                     <p>
                        We will check your google business profile and get back to you
                        soon as possible.
                     </p>
                     <p>
                        A details analysis of your profile will now carried out by the
                        lower.
                     </p>
                     <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Impedit, placeat.
                     </p>
                     <p>
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                        Impedit nostrum quos itaque autem perspiciatis ipsa rem quisquam
                        quasi neque vero.
                     </p>
                  </div>
               </div>
            </div>
            <div
               class="accordion"
               id="accordionExample"
               style="color: #fff; width: 600px; margin-top: 1rem"
               >
               <div class="accordion-item">
                  <h2 class="accordion-header">
                     <button
                        class="accordion-button"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseOne"
                        aria-expanded="true"
                        aria-controls="collapseOne"
                        >
                     All Views
                     </button>
                  </h2>
                  <div
                     id="collapseOne"
                     class="accordion-collapse collapse show"
                     data-bs-parent="#accordionExample"
                     >
                     @if(isset($business_detail['reviews']) && is_array($business_detail['reviews']))
                     @foreach($business_detail['reviews'] as $key=>$reviews)
                     <div class="accordion-body">
                        <div style="display: flex; gap: 20px">
                           <i style="font-size: 50px" class="fa fa-regular fa-user"></i>
                           <div
                              style="
                              display: flex;
                              flex-direction: column;
                              margin-top: -5px;
                              "
                              >
                              <p>{{ $reviews['author_name'] }}</p>
                              <?php 
                                 echo "<span class='stars'>";
                                 for ( $i = 1; $i <= 5; $i++ ) {
                                     if ( round( $reviews['rating'] - .25 ) >= $i ) {
                                             echo "<i class='fa fa-star'></i>"; //fas fa-star for v5
                                     } elseif ( round( $reviews['rating'] + .25 ) >= $i ) {
                                             echo "<i class='fa fa-star-half-o'></i>"; //fas fa-star-half-alt for v5
                                     } else {
                                             echo "<i class='fa fa-star-o'></i>"; //far fa-star for v5
                                     }
                                 }
                                 echo '</span>';
                                 ?>
                              <p>{{ $reviews['text'] }}</p>
                           </div>
                           <div>
                              <input
                                 style="padding: 10px"
                                 class="form-check-input mt-0"
                                 type="checkbox"
                                 value="checked"
                                 />
                           </div>
                        </div>
                     </div>
                     @endforeach
                     @else
                     <p>No reviews available.</p>
                     @endif
                  </div>
               </div>
            </div>
         </div>
         <div class="p-2">
            <div class="card">
               <div class="card-body">
                  <h5 class="text-left">Statistics</h5>
                  <div
                     style="
                     display: grid;
                     grid-template-columns: 9fr 1fr;
                     grid-auto-flow: row;
                     "
                     >
                     <div class="all-p">
                        @if(isset($business_detail['rating_stats']) && is_array($business_detail['rating_stats']))
                        @foreach($business_detail['rating_stats'] as $key=>$rating_stats)
                        <?php
                           $star_rating_analysis=($rating_stats/5)*100;
                           ?>
                        <div class="d-flex align-items-center p-container">
                           <p class="p-text">{{$key}}</p>
                           <div
                              class="progress w-100"
                              style="height: 10px"
                              role="progressbar"
                              aria-label="Basic example"
                              aria-valuenow="50"
                              aria-valuemin="0"
                              aria-valuemax="100"
                              >
                              <div
                                 class="progress-bar bg-warning"
                                 style="width: <?=$star_rating_analysis;?>%"
                                 ></div>
                           </div>
                           <p class="p-text">{{$rating_stats}}</p>
                        </div>
                        @endforeach
                        @else
                        <p>No ratings available.</p>
                        @endif
                     </div>
                     <div style="height;: 100% ;">
                        <div
                           style="
                           height: 100%;
                           display: flex;
                           justify-content: center;
                           align-items: center;
                           flex-direction: column;
                           "
                           >
                           <h1 style="font-weight: bold; font-size: 4rem">{{ $business_detail['rating'] }}</h1>
                           <div>
                              <?php 
                                 echo "<span class='stars'>";
                                 for ( $i = 1; $i <= 5; $i++ ) {
                                     if ( round( $business_detail['rating'] - .25 ) >= $i ) {
                                             echo "<i class='fa fa-star'></i>"; //fas fa-star for v5
                                     } elseif ( round( $business_detail['rating'] + .25 ) >= $i ) {
                                             echo "<i class='fa fa-star-half-o'></i>"; //fas fa-star-half-alt for v5
                                     } else {
                                             echo "<i class='fa fa-star-o'></i>"; //far fa-star for v5
                                     }
                                 }
                                 echo '</span>';
                                 ?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="card mt-2">
               <div class="card-body">
                  <div class="list">
                     <div style="list-style: none">
                        <h5>Diagnostics</h5>
                        <ul style="display: flex; flex-direction: column; gap: 10px">
                           <li>
                              <p>
                                 Your
                                 <span style="color: rgb(5, 5, 5); font-weight: bold"
                                    >average rating is {{$business_detail['rating']}}</span
                                    >
                              </p>
                           </li>
                           @if(isset($business_detail['rating_stats']))
                           <li>
                              <p>They Have total {{$business_detail['negative_reviews_count']}} negetive ratings</p>
                           </li>
                           @endif
                           <li>
                              <p>
                                 To get back to a
                                 <span style="color: #0ce4c0; font-weight: bold"
                                    >star average of 5.0 you will need to add</span>
                                 <?php echo $business_detail['numberOfFiveStarRatingsNeeded'];?> more 5 star review.
                              </p>
                           </li>
                           <li>
                              <p>
                                 They Currently have
                                 <span style="color: rgb(5, 5, 5); font-weight: bold"
                                    ><?php echo (isset($business_detail['rating_stats']) && is_array($business_detail['rating_stats'])) ? $business_detail['rating_stats'][5] : 'N/A'; ?></span
                                    >star ratings
                              </p>
                              <div
                                 style="
                                 background-image: linear-gradient(
                                 to right,
                                 #8700b0,
                                 #0d2cdd,
                                 #0ce4c0,
                                 #5f9108,
                                 #e99c0e,
                                 orange,
                                 red
                                 );
                                 height: 5px;
                                 width: 100%;
                                 "
                                 ></div>
                              <div class="mt-2">
                                 <div
                                    style="
                                    display: grid;
                                    grid-auto-flow: column;
                                    column-gap: 10px;
                                    grid-template-columns: 2fr 10fr;
                                    "
                                    >
                                    <div style="width: 100%">
                                       <div
                                          style="display: flex; justify-content: flex-end"
                                          class="my-2"
                                          >
                                          <span
                                             class="fa fa-star checked text-warning"
                                             ></span>
                                          <span
                                             class="fa fa-star checked text-warning"
                                             ></span>
                                          <span
                                             class="fa fa-star checked text-warning"
                                             ></span>
                                          <span
                                             class="fa fa-star checked text-warning"
                                             ></span>
                                          <!-- To display unchecked star rating icons -->
                                          <span class="fa fa-star text-warning"></span>
                                       </div>
                                       <div
                                          style="
                                          height: 10px;
                                          width: 100%;
                                          border: 1px solid black;
                                          border-top: none;
                                          "
                                          ></div>
                                       <p class="text-center"><?php echo (isset($business_detail['rating_stats']) && is_array($business_detail['rating_stats'])) ? $business_detail['rating_stats'][5] : 'N/A'; ?></p>
                                    </div>
                                    <div style="width: 100%">
                                       <div
                                          style="display: flex; justify-content: flex-end"
                                          class="my-2"
                                          >
                                          <span
                                             class="fa fa-star checked text-warning"
                                             ></span>
                                          <span
                                             class="fa fa-star checked text-warning"
                                             ></span>
                                          <span
                                             class="fa fa-star checked text-warning"
                                             ></span>
                                          <span
                                             class="fa fa-star checked text-warning"
                                             ></span>
                                          <!-- To display unchecked star rating icons -->
                                          <span class="fa fa-star text-warning"></span>
                                       </div>
                                       <div
                                          style="
                                          height: 10px;
                                          width: 100%;
                                          border: 1px solid black;
                                          border-top: none;
                                          "
                                          ></div>
                                       <p class="text-center"><?=$business_detail['numberOfFiveStarRatingsNeeded'];?></p>
                                    </div>
                                 </div>
                              </div>
                           </li>
                           <li>
                              <p>
                                 A review process can be requested for negetive reviews.If
                                 a deletion is completely successful.Your average will be
                                 increased from {{$business_detail['rating']}} to 4.8
                              </p>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @endforeach
   </body>
</html>