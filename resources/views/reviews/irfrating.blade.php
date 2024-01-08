<!DOCTYPE html>
<html lang="en">
  <head>
    <title></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script
      type="text/javascript"
      src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    ></script>
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
      src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap"
      async
      defer
    ></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    />

    <style>
      /* Style for the map container */
      #header {
        width: auto;
        padding-top: 10px;
        padding-bottom: 20px;
        padding-left: 10%;
      }

      #map-container {
        height: 400px;
        width: 100%;
        position: relative;
      }

      /* Style for the card */
      #map-card {
        width: 500px;
        height: fit-content;
        margin: 10px;
        line-height: 1cm;
        background-color: #043265;
        color: #fff;
        position: absolute;
        top: 20%;
        left: 10%;
        z-index: 1;
        padding: 10px;
        border-radius: 10px;
        border: 2px solid #000000;
      }

      .btn {
        display: flex;
        border: none;
        float: right;
        background-color: transparent;
        font-size: 18px;
        cursor: pointer;
      }

      /* Button 1 */
      .btn-1 {
        color: #fff;
        font-weight: 500;
        border-radius: 30px;
        padding: 18px 47px;
        background: #3a86ff;
      }

      .btn-1:hover {
        border: 1px solid #fff;
      }

      li {
        font-size: 18px;
      }

      input[type="text"] {
        width: 100%;
        border-radius: 5px;
        height: 40px;
      }

      .floating-buttons {
        position: fixed;
        bottom: 20px;
        right: 20px;
      }

      .floating-buttons button {
        display: block;
        margin: 10px 0;
        background-color: darkblue;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 18px;
        cursor: pointer;
      }

      input {
        padding: 10px;
      }

      .bhim img {
        height: 50px;
        width: 50px;
      }

      .bhim button {
        color: white;
        background-color: white;
      }

      @media only screen and (max-width: 600px) {
        #map-card {
          width: 90vw;
          left: 3%;
        }
      }

      .social img {
        border-radius: 50px;
      }
    </style>
  </head>

  <body style="padding: 30px 0px">
    <!-- The card to display information -->
    <div id="map-card">
      <h4>Scannen, Löschen,<br />Monitoring, Bewertungsfilter</h4>
      <ul>
        <li>Prüfen Sie Ihr Löschpotenzial in 10 Sekunden</li>
        <li>Wettbewerber vergleichen</li>
        <li>Kostenloses Monitoring Ihrer Bewertungen</li>
        <li>Bewertungsfilter für negative Bewertungen einrichten</li>
      </ul>
      <form action="{{ route('rating-calculator.calculate') }}" method="post">
        @csrf
      <input
        type="text"
        name="name"
        placeholder="Ansprechperson" required
      />
      <input
        type="text"
        name="email"
        placeholder="Email*" required
      />
      <p>
        Bitte geben Sie den genauen Namen Ihres Google My Business Profils ein.
        Wir analysieren Ihre Bewertungen und kontaktieren Sie.
      </p>
      
        <input id="address-input" type="text" name="place_id" placeholder="Search for a location" required />
        <ul id="autocompleteResults"></ul>
        <button type="submit"  style="float: right; border-radius: 10%; background-color: #fff; color: #022349; padding: 5px;"> Calculate</button>
      </form>
    </div>

    <!-- The map container -->
    <div id="map-container" class="mb-5"></div>
    <div class="bhim floating-buttons">
      <button>
        <img src="https://bhim.vercel.app/images/gmail.png" alt="" />
      </button>
      <button>
        <img
          src="https://imgs.search.brave.com/3q8VFiRiPRTeX7QTFx16jpekpGEaRbAQH8Kb7WOVsKw/rs:fit:860:0:0/g:ce/aHR0cHM6Ly92LmZh/c3RjZG4uY28vdS81/MWU1MTcxZC8zMjY0/MzIzNi0wLXdoYXRz/YXBwLS0tLnBuZw"
          alt=""
        />
      </button>
      <button>
        <img
          src="https://imgs.search.brave.com/a2E1uqvVIF0jyNYkzNYl16-ShE1aLF1Fm9nOmVMg9AE/rs:fit:860:0:0/g:ce/aHR0cHM6Ly9zdGF0/aWMudGhlbm91bnBy/b2plY3QuY29tL3Bu/Zy80MTQ2NDgwLTIw/MC5wbmc"
          alt=""
        />
      </button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    let map; // Define map variable globally
    let marker; // Define marker variable globally

    // Function to initialize the map
    function initMap() {
      map = new google.maps.Map(document.getElementById('map-container'), {
        center: { lat: -34.397, lng: 150.644 },
        zoom: 8
      });

      marker = new google.maps.Marker({
        map: map,
        draggable: true
      });

      // Event listener for when marker is dragged
      marker.addListener('dragend', function() {
        reverseGeocode(marker.getPosition());
      });

      // Autocomplete for the address input field
      const input = document.getElementById('address-input');
      const autocomplete = new google.maps.places.Autocomplete(input);
      autocomplete.bindTo('bounds', map);

      autocomplete.addListener('place_changed', function() {
        const place = autocomplete.getPlace();
        if (!place.geometry) {
          // Place details not found for this input.
          return;
        }

        if (place.geometry.viewport) {
          map.fitBounds(place.geometry.viewport);
        } else {
          map.setCenter(place.geometry.location);
          map.setZoom(17);
        }

        marker.setPosition(place.geometry.location);
        reverseGeocode(marker.getPosition());

        // Set the selected address in the input field
        input.value = place.formatted_address;
      });
    }

    // Reverse geocoding to get address from coordinates
    function reverseGeocode(latLng) {
      const geocoder = new google.maps.Geocoder();
      geocoder.geocode({ 'location': latLng }, function(results, status) {
        if (status === 'OK') {
          if (results[0]) {
            document.getElementById('address-input').value = results[0].formatted_address;
          }
        } else {
          console.log('Geocoder failed due to: ' + status);
        }
      });
    }

    // Include Google Maps API script
    function loadGoogleMapsScript() {
      const script = document.createElement('script');
      script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyDc8IfB5vM1DQxq_jLd-hIauX7PwyszXOU&libraries=places&callback=initMap`;
      script.defer = true;
      document.head.appendChild(script);
    }

    // Check if Google Maps is defined before calling initMap
    if (typeof google === 'undefined') {
      // Load Google Maps API when the document is ready
      $(document).ready(function() {
        loadGoogleMapsScript();
      });
    } else {
      // Google Maps API is already available, directly call initMap
      initMap();
    }
    </script>
  </body>
</html>
