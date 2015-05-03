<html>
    <head>
        <link type="text/css" rel="stylesheet" href="stylesheet.css"/>
        <title>EVSProject</title>
         <style>
         table, th, td {
    border: 1px solid black;
}
</style>
    </head>
    <body>
    <form action="getimages.php" method="get" name="inputs">
        Source: <input type="text" name="fname"><br><br>
        DESTINATION: <input type="text" name="lname"><br><br>
        <!--Type: you can enter TRANSIT(means both bus and metro) BUS TRAIN(means metro) DRIVING WALKING BICYCLING --><input type="hidden" name="type" value="DRIVING" ><br><br>
        Owns a car:
        <select name="choice" onchange="onselectmileage(this.value)">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
        </select><br>
          CarDieselorPetrol:
        <select name="choicefuel" disabled>
            <option value="Diesel">Diesel</option>
            <option value="Petrol">Petrol</option>
            <option value="CNG">CNG</option>
          </select><br><br>
          mileage:<input type="number" name="mileage" disabled ><br><br> 
          NumberOfPersons:<input type="number" name="persons" onchange="onselecttwowheeler(this.value)"><br><br>  
          <p id="fortwowheeler"></p>
          OwnsATwoWheeler:
          <select name="choicetwowheeler" disabled value="No" onchange="onselecttwomileage(this.value)">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
        </select><br><br>
        mileage:<input type="number" name="mileagetwowheeler" disabled ><br><br>
       <!-- FarePetrol:"63.16 Rs/l"<br><br>
        FareDiesel:"49.57 Rs/l"<br><br>
        FareCNG:"38.15 Rs/Kg"<br><br>
        FareBus:<img src="Busfare.png"><br><br>
        FareMetro:"Min Rs 8 and Max Rs30"<br><br>
        FareAuto:"Rs 25/- for first fall of 2 Kilometer (upon downing the meter) and thereafter Rs. 8/- per Kilometer for every additional Kilometer"<br><br>
        FareTaxi:"25+7/km   UberGo"<br><br>
        Averageautospeed:"km/h"<br><br>
        Averagecarspeed:"45km/h"<br><br>
        Averagebikespeed:"40km/h"<br><br>
        Carboncar:"67 gmCO2/km/passenger"<br><br>
        Carbontaxi(CNG):"72 gmCO2/km/passenger"<br><br>
        Carbontwowheeler:"28 gmCO2/km/passenger"<br><br>
        Carbonautorikshaw:"35 gmCO2/km/passenger"<br><br>
        Carbonbus(CNG):27 gmCO2/km/passenger<br><br>
        Carbonmetro:"20 gmCO2/km/passenger"<br><br>-->
        <input type="submit" value="Submit">
    </form>
    <br><br><br><br>

        <script>
        function onselectmileage(val) {

        if(val=="Yes")
        {
        document.inputs.choicefuel.disabled=false;
        document.inputs.mileage.disabled=false;
        }else
        {
        document.inputs.choicefuel.disabled=true;
        document.inputs.mileage.disabled=true;
        }
        }
        function onselecttwowheeler(val) {
        onpersons(val);
        if(val < 3)
        {
        document.inputs.choicetwowheeler.disabled=false;
        }else
        {
        document.inputs.choicetwowheeler.disabled=true;
        }
        }
        function onselecttwomileage(val) {
        if(val =="Yes")
        {
        document.inputs.mileagetwowheeler.disabled=false;
        }else
        {
        document.inputs.mileagetwowheeler.disabled=true;
        }
        }
        function onpersons(val) {

        if(val > 2)
        {
        document.getElementById("fortwowheeler").innerHTML = "Since number of persons are greater than two hence we cant allow you to use two wheeler for your journey";
        }
        }


        </script>

        <form action = "<?php echo $_SERVER["PHP_SELF"]; ?>" method = "post">
        <?php
            $apo = 1;
            $person_empty= 1;
            $ds = 0;
            $mileagetwowheeler_exists=0;
            $mileage_exists=0;
            if ($_SERVER["REQUEST_METHOD"] == "GET"){  
                         
                if(empty($_GET["fname"])){
                    echo " empty! ";
                }
                else{
                    $words = $_GET["fname"];
                }
                if(empty($_GET["lname"])){
                    echo " empty! ";
                }
                else{
                    $ords = $_GET["lname"];
                }
               if(empty($_GET["persons"])){
                    $person_empty = 0;
                }
                else{
                    $persons = $_GET["persons"];
                }
                if($_GET["type"]=="YES"){
                    $rds = "WALKING";
                    $apo = 0;
                }
                else{
                    $rds = $_GET["type"];
                    $apo = 1;
                    if(strcmp($rds, "TRAIN") == 0 || strcmp($rds, "BUS") == 0)
                        $ds = 1;
                }
                if (array_key_exists('mileage', $_GET))
                {
                    $mileage_exists = 1;
                    $mileage = $_GET["mileage"];
                    $choicefuel = $_GET["choicefuel"];
                }

                if (array_key_exists('mileagetwowheeler', $_GET))
                {
                   
                    $mileagetwowheeler_exists = 1;
                    $mileagetwowheeler = $_GET["mileagetwowheeler"];
                }
            }
            $ty = urlencode($ords);
            $yt = urlencode($words);
            $urt = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$ty.'&destinations='.$yt;
            $urt1 = $urt.'&mode=walking';
            $routes=json_decode(file_get_contents($urt1))->rows;
            echo "walking : <br>";
            $a = $routes[0]->elements[0]->distance->text;
            echo $a;
            echo " ";
            $c = $routes[0]->elements[0]->duration->text;
            echo $c;
            echo "<br>";
            if ($apo != 0){
            $urt2 = $urt.'&mode=driving';
            $routes=json_decode(file_get_contents($urt2))->rows;
         //   echo "auto/car/taxi : <br>";
            $b = $routes[0]->elements[0]->distance->text;
        //    echo $b;
            echo " ";
            $d = $routes[0]->elements[0]->duration->text;
          //  echo $d;
            echo "<br>";}
        ?>

        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
        <script>
            var geocoder;
            var origin2 = "<?php echo $ords; ?>";
            var destinationA = "<?php echo $words; ?>";
            
            var count = 3;
            var cost = [];
            var carbon = [];
            var f = parseInt("<?php echo $a; ?>");
           // cost['W'] = 0;
           // carbon['W'] = 0;
            var i = parseInt("<?php echo $b; ?>");
            if (i<2){
            cost['A'] = 25;}
            else{
                cost['A'] = (i-2)*8 + 25;}
                cost['T'] = (7 * i) + 25;
            <?php if ($mileage_exists == 1){
                if ($choicefuel == "Petrol"){
                echo "cost['C'] = i/".$mileage."*63.16;";
                echo "carbon['C'] = i*67;";
            }
                if ($choicefuel == "Diesel"){
                echo "cost['C'] = i/".$mileage."*49.57;";
                echo "carbon['C'] = i*70;";}
                    if($choicefuel == "CNG"){
                echo "cost['C'] = i/".$mileage."*38.15;";
                echo "carbon['C'] = i*72;";}
                }?>
            <?php if ($mileagetwowheeler_exists == 1){
                echo "cost['M'] = i/".$mileagetwowheeler."*63.16;";}
                ?>
            var times = "<?php echo $c; ?>".split(" ");
            if (times.length == 2)
                var min = parseInt(times[0], 10);
            else    
                var min = parseInt(times[2], 10) + (parseInt(times[0], 10) * 60)
            var time = [];
            //time['W'] = min;
            var times = "<?php echo $d; ?>".split(" ");
            if (times.length == 2)
                var min = parseInt(times[0], 10);
            else    
                var min = parseInt(times[2], 10) + (parseInt(times[0], 10) * 60)
            
            var cartime = min;
            <?php if($mileage_exists==1){
                    echo "time['C'] = cartime;";
                }?>

                <?php if($mileagetwowheeler_exists==1){
                    echo "time['M'] = cartime/4*4.5;";
                    echo "carbon['M'] = 28*i;";
                }?>
                time['A'] = cartime/3*4.5;
                time['T'] = cartime;

                carbon['A'] = 35*i;
                carbon['T'] = 72*i;

            


            function calculateDistances() {
              geocoder = new google.maps.Geocoder();
              var service = new google.maps.DistanceMatrixService();
              service.getDistanceMatrix(
                {
                  origins: [origin2],
                  destinations: [destinationA],
                  travelMode: google.maps.TravelMode.TRANSIT,
                  transitOptions: {
                    modes: [google.maps.TransitMode.TRAIN],
                    routingPreference: google.maps.TransitRoutePreference.FEWER_TRANSFERS
                      },
                  unitSystem: google.maps.UnitSystem.METRIC,
                  avoidHighways: false,
                  avoidTolls: false
                }, callback);
            }
            function callback(response, status) 
            {
              if (status != google.maps.DistanceMatrixStatus.OK) 
              {
                alert('Error was: ' + status);
              } else 
              {
                var origins = response.originAddresses;
                var destinations = response.destinationAddresses;
              var outputDiv = document.getElementById('outputDiv1');
               outputDiv.innerHTML = '';

                for (var i = 0; i < origins.length; i++) {
                  var results = response.rows[i].elements;
                  for (var j = 0; j < results.length; j++) {
                 outputDiv.innerHTML += results[j].distance.text + ' in '
                      + results[j].duration.text + '<br>';

                     //  distance[2] = parseInt(results[j].distance.text);

                        var times = results[j].duration.text.split(" ");
                        if (times.length == 2)
                            var min = parseInt(times[0], 10);
                        else    
                            var min = parseInt(times[2], 10) + (parseInt(times[0], 10) * 60)
                        
                        var metrotime = min;
                           }
                    }
              }
              calculateDistances1();
            }
            function calculateDistances1() {
              geocoder = new google.maps.Geocoder();
              var service = new google.maps.DistanceMatrixService();
              service.getDistanceMatrix(
                {
                  origins: [origin2],
                  destinations: [destinationA],
                  travelMode: google.maps.TravelMode.TRANSIT,
                  transitOptions: {
                    modes: [google.maps.TransitMode.BUS],
                    routingPreference: google.maps.TransitRoutePreference.FEWER_TRANSFERS
                      },
                  unitSystem: google.maps.UnitSystem.METRIC,
                  avoidHighways: false,
                  avoidTolls: false
                }, callback1);
            }
            function callback1(response, status) {
              if (status != google.maps.DistanceMatrixStatus.OK) {
                alert('Error was: ' + status);
              } else {
                var origins = response.originAddresses;
                var destinations = response.destinationAddresses;
                var outputDiv = document.getElementById('outputDiv');
                outputDiv.innerHTML = '';

                for (var i = 0; i < origins.length; i++) {
                  var results = response.rows[i].elements;
                  for (var j = 0; j < results.length; j++) {
                   outputDiv.innerHTML += results[j].distance.text + ' in '
                        + results[j].duration.text + '<br>';

                        var distance_bus = parseInt(results[j].distance.text);
                      <?php if ($person_empty == 1 ){
                            echo"
                      if (distance_bus < 4)
                            cost['B'] = 5*".$persons.";
                        else if (distance_bus > 4 && distance_bus < 10)
                            cost['B'] = 10*".$persons.";
                        else if (distance_bus > 10)
                            cost['B'] = 25*".$persons.";";}
                        ?>
                      var times = results[j].duration.text.split(" ");
                        if (times.length == 2)
                            var min = parseInt(times[0], 10);
                        else    
                            var min = parseInt(times[2], 10) + (parseInt(times[0], 10) * 60)
                        
                        time['B'] = min;
                        carbon['B'] = 27*distance_bus;
                  }
                }
              }
              funas();
            }



            var rendererOptions = {draggable: true};
            var directionsDisplay;
            var directionsService = new google.maps.DirectionsService();
            function initialize() 
            {
                directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
                var mapOptions = {zoom: 4, center: new google.maps.LatLng(21,78 )};
                var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                directionsDisplay.setMap(map);
                directionsDisplay.setPanel(document.getElementById('directions-panel'));
                google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {computeTotalDistance(directionsDisplay.directions);});
                var start = "<?php echo $ords; ?>";
                var end = "<?php echo $words; ?>";;
                var request = {
                    origin: start, destination: end, travelMode: google.maps.TravelMode.<?php 
                    if ($ds == 0) echo $rds; else echo "TRANSIT" ?>
                    <?php 
                    if ($ds == 1) echo 
                    ", 
                    transitOptions: {
                    modes: [google.maps.TransitMode.$rds],
                    routingPreference: google.maps.TransitRoutePreference.FEWER_TRANSFERS
                      }"
                      ?>
                  };
                directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) 
                {
                    directionsDisplay.setDirections(response);
                }
                });
            }
            <?php if ($apo == 1)
            echo "google.maps.event.addDomListener(window, 'load', calculateDistances);";
            else
                echo
                "google.maps.event.addDomListener(window, 'load', initialize);";
            ?>
            function funas(){


                    var tablepos=1;
                     for (var key in cost)
                    {
                    var pd = tablepos.toString();
                    document.getElementById(pd).innerHTML=cost[key];
                    tablepos++;
                    }
                    var tablepos=6;
                     for (var key in cost)
                    {
                    var pd = tablepos.toString();
                    document.getElementById(pd).innerHTML=time[key];
                    tablepos++;
                    }
                    var tablepos=11;

                     for (var key in cost)
                    {
                    var pd = tablepos.toString();
                    document.getElementById(pd).innerHTML=carbon[key];
                    tablepos++;
                    }
                    var tablepos=16;
                    for (var key in cost)
                    {
                    var pd = tablepos.toString();
                    if(key=='A'){
                        document.getElementById(pd).innerHTML="Auto";
                    }else if(key=='B'){
                        document.getElementById(pd).innerHTML="Bus";
                    }else if(key=='C'){
                        document.getElementById(pd).innerHTML="Car";
                    }else if(key=='T'){
                        document.getElementById(pd).innerHTML="Taxi";
                    }else if(key=='M'){
                        document.getElementById(pd).innerHTML="Two Wheeler";
                    }
                   // document.getElementById(pd).innerHTML=key;
                    tablepos++;
                    }
                
                var countcost=0;
                var min_keycost;
                var cost_s=[];
                for (var key in cost)
                {
                var mincost = 100000;
                   for (var y in cost)
                    {
                        if (cost[y]<mincost)
                        {
                            mincost = cost[y];
                            min_keycost = y;
                        }
                      
                    }
                  cost_s[countcost++] = min_keycost;
                    cost[min_keycost]=100000;
                }


                   var counttime=0;
                var min_keytime;
                var time_s=[];
                for (var key in time)
                {
                var mintime = 100000;
                   for (var y in time)
                    {
                        if (time[y]<mintime)
                        {
                            mintime = time[y];
                            min_keytime = y;
                        }
                      
                    }
                  time_s[counttime++] = min_keytime;
                    time[min_keytime]=100000;
                }

                   var countcarbon=0;
                var min_keycarbon;
                var carbon_s=[];
                for (var key in carbon)
                {
                var mincarbon = 100000;
                   for (var y in carbon)
                    {
                        if (carbon[y]<mincarbon)
                        {
                            mincarbon = carbon[y];
                            min_keycarbon = y;
                        }
                      
                    }
                  carbon_s[countcarbon++] = min_keycarbon;
                    carbon[min_keycarbon]=100000;
                }
               // window.alert(cost_s.indexOf('B'));
                
                var opt = [];
                for (var key in cost)
                {
                    opt[key] = cost_s.indexOf(key) + time_s.indexOf(key) + carbon_s.indexOf(key);
                    // window.alert(key);
                }
               var minopt = 10000;
                var min_keyopt;
                   for (var y in opt)
                    {
                        if (opt[y]<minopt)
                        {
                            minopt = opt[y];
                            min_keyopt = y;
                        }else if(opt[y]==minopt){
                            if(carbon_s.indexOf(y)<carbon_s.indexOf(min_keyopt)){
                                min_keyopt=y;
                                minopt=opt[y];
                            }
                        }
                      
                    }
                      if(min_keyopt=='A'){
                        window.alert("Auto is the best mode of transport for your journey");
                    }else if(min_keyopt=='B'){
                        window.alert("Bus is the best mode of transport for your journey");
                    }else if(min_keyopt=='C'){
                        window.alert("Car is the best mode of transport for your journey");
                    }else if(min_keyopt=='T'){
                        window.alert("Taxi is the best mode of transport for your journey");
                    }else if(min_keyopt=='M'){
                        window.alert("Two Wheeler is the best mode of transport for your journey");
                    }
                 
                if(min_keyopt=='M'||min_keyopt=='T'||min_keyopt=='A'||min_keyopt=='C'){
                   directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
                var mapOptions = {zoom: 4, center: new google.maps.LatLng(21,78 )};
                var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                directionsDisplay.setMap(map);
                directionsDisplay.setPanel(document.getElementById('directions-panel'));
                google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {computeTotalDistance(directionsDisplay.directions);});
                var start = "<?php echo $ords; ?>";
                var end = "<?php echo $words; ?>";;
                var request = {
                    origin: start, destination: end, travelMode: google.maps.TravelMode.DRIVING/*<?php 
                    if ($ds == 0) echo $rds; else echo "TRANSIT" ?>
                    <?php 
                    if ($ds == 1) echo 
                    ", 
                    transitOptions: {
                    modes: [google.maps.TransitMode.$rds],
                    routingPreference: google.maps.TransitRoutePreference.FEWER_TRANSFERS
                      }"
                      ?>*/
                  };
                directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) 
                {
                    directionsDisplay.setDirections(response);
                }
                });
                }
                else{
                    directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
                var mapOptions = {zoom: 4, center: new google.maps.LatLng(21,78 )};
                var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                directionsDisplay.setMap(map);
                directionsDisplay.setPanel(document.getElementById('directions-panel'));
                google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {computeTotalDistance(directionsDisplay.directions);});
                var start = "<?php echo $ords; ?>";
                var end = "<?php echo $words; ?>";;
                var request = {
                    origin: start, destination: end, travelMode: google.maps.TravelMode.TRANSIT, 
                    transitOptions: {
                    modes: [google.maps.TransitMode.BUS],
                    routingPreference: google.maps.TransitRoutePreference.FEWER_TRANSFERS
                      }
                  };
                directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) 
                {
                    directionsDisplay.setDirections(response);
                }
                });
                }
               

                
           }
        </script>
        
       metro/train : <div id= "outputDiv1"></div>
        bus : <div id= "outputDiv"></div>
        <div id="directions-panel"></div>
        <div id="map-canvas"></div>
        <table id="myTable">
  <tr>
    <td>Mode</td>
    <td>Carbon(gmCO2/Km/person)</td>
    <td>Cost(Rs)</td>
    <td>Time(min)</td>
    </tr>
  <tr>
    <td id = "16"></td>
    <td id = "11"></td>
    <td id = "1"></td>
    <td id = "6"></td>
  </tr>
  <tr>
    <td id = "17"></td>
    <td id = "12"></td>
    <td id = "2"></td>
    <td id = "7"></td>
  </tr>
  <tr>
    <td id = "18"> </td>
    <td id = "13"></td>
    <td id = "3"></td>
    <td id = "8"></td>
  </tr>
  <tr>
    <td id = "19"> </td>
    <td id = "14"></td>
    <td id = "4"></td>
    <td id = "9"></td>
  </tr>
  <tr>
    <td id = "20"> </td>
    <td id = "15"></td>
    <td id = "5"></td>
    <td id = "10"></td>
  </tr>
</table>

    </body>
</html>