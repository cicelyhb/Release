<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
   ob_start();
   session_start();
   if(empty($_SESSION['username']) || empty($_SESSION['congregationnumber']) || empty($_SESSION['role']) || $_SESSION['role'] == 'POW' || $_SESSION['role'] == 'VW'){
       header('Location:index.php');
   } 
   
    if(auto_logout("timeout"))
    {
        session_unset();
        session_destroy();
        header('Location:index.php');          
        exit;
    }
    
    function auto_logout($field)
    {
        $t = time();
        $t0 = $_SESSION[$field];
        $diff = $t - $t0;
        if ($diff > 1500 || !isset($t0))
        {          
            return true;
        }
        else
        {
            $_SESSION[$field] = time();
        }
    }    
?>
<html lang = "en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Territory</title>
        <link rel="stylesheet" type="text/css" href="myStyle.css">
        <style>
            .menuleft{

               width:5%; 

            }            
            .menucenter{

               width:80%; 
               font-size: 20px;

            }
            .menuright{

               width:5%; 

            }    

            @media only screen and (max-width: 763px) {
            .menuleft{

               width:5%; 

            }
            .menucenter{

               width:85%; 
               font-size: 20px;

            }  
            .menuright{

               width:5%; 
               font-size: 8px;

            }                
            }
        </style>        
    </head>
    <link rel="shortcut icon" href="icons/TO_smalllogo.png" type="image/png" />    
    <body>
        <div class="top">
        <script src="scripts/menu.js"></script>       
            <?php 
               $territory = $_GET['territory'];
               $sngquote = "'";
               echo '<table class="menutable">',PHP_EOL;
               echo '<tr>',PHP_EOL;
               echo '<td align="position" class="menuleft">',PHP_EOL;    
               echo '<div id="mobilemenu" style="display:none;">',PHP_EOL;
               echo '<button id="mobilemenudisplay" class="dropbtn"><a href="#" class="gradient-menu"></a></button>',PHP_EOL;
               echo '</div>',PHP_EOL;
               echo '<div id="desktopmenu" style="display:block;">',PHP_EOL;  
               echo '<button id="desktopmenudisplay" class="dropbtn">Information</button>',PHP_EOL;                       
               echo '</div>',PHP_EOL;  
               echo '</td>',PHP_EOL;                  
             
               echo '<td id="myname" align="center" class="menucenter"><a href = "welcome.php" class="menutitle">Territory Organizer</a></td>',PHP_EOL;
//               echo '<td align="right" class="menuright">',PHP_EOL; 
               echo '<td align="right" class="menuright">',PHP_EOL; 
               echo '<div class="tooltip"><img src="icons/myprofile2.png"><span class="tooltiptext">My Profile</span></div>',PHP_EOL;                  
               echo '</td>',PHP_EOL;                   
               echo '<td class="menuright">',PHP_EOL;  
              // echo '<form name="_xclick" action="https://www.paypal.com/fk/cgi-bin/webscr" method="post">',PHP_EOL; 
//               echo '<form name="" method="post">',PHP_EOL;                
//               echo '<input type="hidden" name="cmd" value="_xclick">',PHP_EOL;  
//               echo '<input type="hidden" name="business" value="me@mybiz.com">',PHP_EOL;  
//               echo '<input type="hidden" name="item_name" value="Team In Training">',PHP_EOL;  
//               echo '<input type="hidden" name="currency_code" value="USD">',PHP_EOL;  
//               echo '<input type="hidden" name="amount" value="2.50">',PHP_EOL;  
//               echo '<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" name="submit" alt="Make payments with PayPal - it'.$sngquote.'s fast, free and secure!">',PHP_EOL;  
//               echo '</form>',PHP_EOL;
               echo '<button id="donatefunds" class="donate" onclick="location.href='.$sngquote.'donation.php'.$sngquote.';">Donate</button>',PHP_EOL; 
               echo '</td>',PHP_EOL;               
              // echo '<td align="right" class="menuright"><a href = "logout.php" class="button">Sign Out</a></td>',PHP_EOL;
               echo '<td align="right" class="menuright">',PHP_EOL; 
               echo '<div id="signout"><input type="button" value="Sign Out" onclick="location.href='.$sngquote.'logout.php'.$sngquote.';"></div>',PHP_EOL;                
               echo '</td>',PHP_EOL;             
               echo '</tr>',PHP_EOL;
               echo '</table>',PHP_EOL;
            ?>
        </div> 
        <div id= "left" class="staticleft">
        <script src="scripts/menu.js"></script> 
        <div id="selecterritoryeditclose" style="display:none;">
        <table class="menutable">
            <tr><td class="menuleft"><input id="toterr1" type="button" value="Back to create/edit"></td><tr/>
        </table>
        </div>         
            <?php  
                 include("db_ConnectionInfo.php");
                 include("MyClassLibrary.php");
                 
                 $congregationnumber = $_SESSION['congregationnumber'];
                 $terrlist = new territorylist($host,$username,$password,$database,$port,$socket);
                 $terrlist->EditList($congregationnumber);
                 $terrlist->close();

            ?>                     
        </div> 
        
        
        <div id="mobilemenucontrol" class="sideleftnav">
        <script src="scripts/menu.js"></script> 
<!--        <a href="#" class="closebtn" >&times;</a>-->
        <?php
        echo '<table>',PHP_EOL;        
        if($_SESSION['role'] == 'ADM' ){
        echo '<tr><td><a href = "createterritory.php" class="button" style="width: 90%;color: white;font-size: 12px;">Create Territory</a></td></tr>',PHP_EOL;        
        echo '<tr><td><a href = "activateUser.php" class="button" style="width: 90%;color: white;font-size: 12px;">Activate Users</a></td></tr>',PHP_EOL;  
        echo '<tr><td><a href = "#" class="button" style="width: 90%;color: white;font-size: 12px;">Change User Role</a></td></tr>',PHP_EOL;             
        echo '<tr><td><a href = "#" class="button" style="width: 90%;color: white;font-size: 12px;">Reports</a></td></tr>',PHP_EOL; 
        echo '<tr><td><a href = "#" class="button" style="width: 90%;color: white;font-size: 12px;">Dashboards</a></td></tr>',PHP_EOL;         
        }          
        echo '<tr><td><a href = "#" class="button" style="width: 90%;color: white;font-size: 12px;">Contact Us</a></td></tr>',PHP_EOL;    
        echo '<tr><td><div id="signout2" style="display:none;"><a href = "logout.php" class="button" style="width: 90%;color: white;font-size: 12px;">Sign Out</a></div></td></tr>',PHP_EOL;           
        echo '</table>',PHP_EOL;  
        ?>   
        </div>         
        
        
        <div id="menucontrol" class="sideleftnav">
        <script src="scripts/menu.js"></script> 
        <?php
        echo '<table>',PHP_EOL;         
        if($_SESSION['role'] == 'ADM' ){
        echo '<tr><td><a href = "createterritory.php" class="button" style="width: 90%;color: white;font-size: 12px;">Create Territory</a></td></tr>',PHP_EOL;        
        echo '<tr><td><a href = "activateUser.php" class="button" style="width: 90%;color: white;font-size: 12px;">Activate Users</a></td></tr>',PHP_EOL;  
        echo '<tr><td><a href = "#" class="button" style="width: 90%;color: white;font-size: 12px;">Change User Role</a></td></tr>',PHP_EOL;         
        echo '<tr><td><a href = "#" class="button" style="width: 90%;color: white;font-size: 12px;">Reports</a></td></tr>',PHP_EOL; 
        echo '<tr><td><a href = "#" class="button" style="width: 90%;color: white;font-size: 12px;">Dashboards</a></td></tr>',PHP_EOL;         
        }             
        echo '<tr><td><a href = "#" class="button" style="width: 90%;color: white;font-size: 12px;">Contact Us</a></td></tr>',PHP_EOL;        
        echo '</table>',PHP_EOL;  
        ?>   
        </div>   

        
        <div id= "mytoolbox" class="toolbox">
        <script src="scripts/menu.js"></script> 
        <script src="scripts/myscripts.js"></script>
        <table>
            <tr>
                <th width="10%" bgcolor="#0B1F81"><font color="white"> Toolbox </font></th>
            </tr>
            <tr>                
                <td align="center">
                    <div class="tooltip">
                    <button class="toolbutton" onClick="javascript:drawPolygon()"><img src = "icons/polyline.png"></button><span class="tooltiptext">draw polygon</span>
                    </div>
                </td>
            </tr>            
            <tr>                
                <td align="center">
                    <div class="tooltip">
                    <button class="toolbutton" onClick="javascript:snapPolygon()"><img src = "icons/polygon.png"></button><span class="tooltiptext">snap polygon</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <div class="tooltip">
                    <button class="toolbutton" onClick="javascript:selectRectangle()"><img src = "icons/boundary.png"></button><span class="tooltiptext">add rectangle</span>
                    </div>
                </td>
            </tr>    
            <tr>
                <td align="center">
                    <div class="tooltip">
                    <button class="toolbutton" onClick="javascript:selectCompass()"><img src = "icons/north.png"></button><span class="tooltiptext">add compass</span>
                    </div>
                </td>
            </tr> 
            <tr>
                <td align="center">
                    <div class="tooltip">
                    <button class="toolbutton" onClick="javascript:selectHouse()"><img src = "icons/House_NW.png"></button><span class="tooltiptext">add house</span>
                    </div>
                </td>
            </tr>             
            <tr>
                <td align="center">
                    <div class="tooltip">
                    <button class="toolbutton" onClick="javascript:selectPointer()"><img src = "icons/select.png"></button><span class="tooltiptext">select</span>
                    </div>
                </td>
            </tr>                          
<!--            <tr>
                <td align="left">
                    <div class="tooltip">
                    <button class="toolbutton"><img src = "icons/undo.png"></button><span class="tooltiptext">undo</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <div class="tooltip">
                    <button class="toolbutton"><img src = "icons/redo.png"></button><span class="tooltiptext">redo</span>
                    </div>
                </td> 
            </tr>           -->
        </table>
        <br>
        <div class="tab">
         <a href="#" class="tablinks" onclick="openTab(event, 'Layer')">Layer</a>
         <a href="#" class="tablinks" onclick="openTab(event, 'Properties')" id="defaultOpen">Property</a>
        </div>
        <div id="Layer" class="tabcontent">
        <table>
            <tr>
                <td>            
                    <input id="chkPolygon" type="checkbox" name="layer" value="Polygon" onclick="TurnOnOffLayer(this,'Polygon')" checked>Polygon<br>                    
                    <input id="chkRectangle" type="checkbox" name="layer" value="Rectangle" onclick="TurnOnOffLayer(this,'Rectangle')" checked>Rectangle<br>  
                    <input id="chkHouse" type="checkbox" name="layer" value="House" onclick="TurnOnOffLayer(this,'House')" checked>Houses<br> 
                    <input id="chkCompass" type="checkbox" name="layer" value="Compass" onclick="TurnOnOffLayer(this,'Compass')" checked>Compass<br>  
                </td> 
            </tr>
        </table>
        </div>
       <div id="Properties" class="tabcontent">
       <table>
            <tr>
                <td id="label1">Territory:</td>
                <td><input type="text" id="Territory" value="Terr1" style="width: 75px;"></td>
            </tr>
            <tr> 
                 <td id="label2">Default:</td>
                 <td>
                    <select name = "defaultterritoryview" id="defaultterritoryview" onchange="selectDefault()" style="width: 75px;">
                        <option value="true">true</option>
                        <option value="false" selected>false</option>
                    </select>
                </td>                 
            </tr>
      </table>
            <div class="expand"> 
            <table>
            <tr>     
                    <td style="cursor:pointer" onclick="expandCollapse('showHide1','expand1')" id="expand1">[+]: </td>
                    <td>Polygon</td>
             </tr> 
           </table>
           </div>
           <div id="showHide1" style="display:none;">
           <table>
            <tr>
                    <td style="width: 60px;"></td>
                    <td><input type="hidden" id="PolygonChanged" value="false"></td>
            </tr>               
           <tr>    
                    <td style="width: 60px;"></td>
                    <td id="PolygonAction" style="font-size: 12px;">action: none</td>                     
            </tr>
            <tr>    
                    <td style="width: 60px;"></td>
                    <td id="PolygonDateModified" style="font-size: 12px;">date: yyyy-mm-dd hh:mm:ss</td>                   
            </tr>
            <tr>
                    <td style="width: 60px;"></td>
                    <td id="PolygonBounds" style="font-size: 12px;">bounds: x,y</td>
            </tr>             
            </table>
            </div>
        
            <div class="expand"> 
            <table>
            <tr>       
                    <td style="cursor:pointer" onclick="expandCollapse('showHide2','expand2')" id="expand2">[+]: </td>
                    <td>Rectangle</td>                    
            </tr>
           </table>
           </div> 
           <div id="showHide2" style="display:none;">
           <table>  
            <tr>
                    <td style="width: 60px;"></td>
                    <td><input type="hidden" id="RectangleChanged" value="false"></td>
            </tr>                
            <tr>
                    <td style="width: 60px;"></td>
                    <td id="RectangleAction" style="font-size: 12px;">action: none</td>
            </tr>
            <tr>
                    <td style="width: 60px;"></td>
                    <td id="RectangleDateModified" style="font-size: 12px;">date: yyyy-mm-dd hh:mm:ss</td>
            </tr>    
            <tr>
                    <td style="width: 60px;"></td>
                    <td id="RectangleCenter" style="font-size: 12px;">center: x,y</td>
            </tr>             
            <tr>
                    <td style="width: 60px;"></td>
                    <td id="RectangleBounds" style="font-size: 12px;">bounds: x,y</td>
            </tr>   
            <tr>
                    <td style="width: 60px;"></td>
                    <td id="RectangleDrag" style="font-size: 12px;">draggable:
                    <select name = "rectangledraggable" id="rectangledraggable" value="true" onchange="selectDraggable('rectangle')">
                        <option value="true">true</option>
                        <option value="false">false</option>
                    </select>
                    </td>
            </tr>              
          </table>
          </div>  
           
          <div class="expand"> 
          <table>
            <tr>    
                    <td style="cursor:pointer" onclick="expandCollapse('showHide3','expand3')" id="expand3">[+]: </td>
                    <td>Houses</td>                     
            </tr>
          </table>
          </div> 
          <div id="showHide3" style="display:none;">
          <table>  
            <tr>
                    <td style="width: 60px;"></td>
                    <td><input type="hidden" id="HouseChanged" value="false"></td>
            </tr>               
            <tr>
                    <td style="width: 60px;"></td>
                    <td id="HouseAction" style="font-size: 12px;">action: none</td>
            </tr>         
            <tr>
                    <td style="width: 60px;"></td>
                    <td id="HouseDateModified" style="font-size: 12px;">date: yyyy-mm-dd hh:mm:ss</td>
            </tr> 
            <tr>
                    <td style="width: 60px;"></td>
                    <td id="HouseTotal" style="font-size: 12px;">homes: 0</td>
            </tr>               
          </table>
          </div>
           
          <div class="expand"> 
          <table>
            <tr>    
                    <td style="cursor:pointer" onclick="expandCollapse('showHide4','expand4')" id="expand4">[+]: </td>
                    <td>Compass</td>                    
            </tr>
          </table>
          </div> 
          <div id="showHide4" style="display:none;">
          <table>  
            <tr>
                    <td style="width: 60px;"></td>
                    <td><input type="hidden" id="CompassChanged" value="false"></td>
            </tr>              
            <tr>
                    <td style="width: 60px;"></td>
                    <td id="CompassAction" style="font-size: 12px;">action: none</td>
            </tr>
            <tr>
                    <td style="width: 60px;"></td>
                    <td id="CompassDateModified" style="font-size: 12px;">date: yyyy-mm-dd hh:mm:ss</td>
            </tr> 
            <tr>
                    <td style="width: 60px;"></td>
                    <td id="CompassLatLng" style="font-size: 12px;">latlng: x,y</td>
            </tr>    
            <tr>
                    <td style="width: 60px;"></td>
                    <td id="CompassDrag" style="font-size: 12px;">draggable:
                    <select name = "compassdraggable" id="compassdraggable" value="true" onchange="selectDraggable('compass')">
                        <option value="true">true</option>
                        <option value="false">false</option>
                    </select>
                    </td>
            </tr>               
          </table>
          </div>  
           
       </div>
     </div> 
        <div id="menu" class="staticmenu">
        <table>
            <tr>                
                <td align="left">
                    <div id="selecteditlist">
                    </div>
                </td>                
                <td align="left">
                    <div id="newmap">
                    <div class="toolbartip">
                    <button onclick="javascript:newmap()"><img src = "icons/newmap.png"></button><span class="toolbartiptext">new</span>
                    </div>
                    </div>
                </td>
                <td align="left">
                    <div id="savemap"
                    <div class="toolbartip">
                    <button onclick="javascript:save()"><img src = "icons/save_button.png"></button><span class="toolbartiptext">save</span>
                    </div>
                    </div>
                </td> 
                <td align="left">
                    <div id="opentoolbox">
                    </div>
                </td>                 
<!--                <td align="left">
                    <div class="toolbartip">
                    <button><img src = "icons/undo1.png"></button><span class="toolbartiptext">undo</span>
                    </div>
                </td> 
               <td align="left">
                    <div class="toolbartip">
                    <button><img src = "icons/redo1.png"></button><span class="toolbartiptext">redo</span>
                    </div>
                </td>                   -->               
            </tr> 
        </table>            
        </div>
        
        <div id="main" class="staticmain"> 
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1Fdvd0EPg3knllyj9gBhZ8tFoxuWQOTU" type="text/javascript"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!--        <div id="map" style="width:1400px; height:750px;"></div>-->
        <div id="map" style="width:100%; height:800px; padding:0px"></div>
        <div id="myterritory"  class="legend" style="display:block"></div>         
        <script src="scripts/myscripts.js"></script>
        <script type="text/javascript"> 
            
        var sortnumber = 0;
        var territoryassigned = false; 
        var defaultview = false;
        var myLatLng;
        var map;               
        var geocoder = new google.maps.Geocoder();        
        
        var polymarker = [];
        var poly;    
        var polygon;        
        var polygonCoordinates = [];
        var polygonStack = [];
        var polygonInfowindow; 
        var jsonPolygon;                              

        var compassMarker;
        var compass;
        
        var rectangle;
        var rectangleInfowindow; 
        var rectanglecenter;
        var jsonRectangle;
        
        var properties = [
                           {layer:"polygon",action:"none",datemodified:"yyyy-mm-dd hh:mm:ss",draggable:"false",draggablechange:"false"},
                           {layer:"rectangle",action:"none",datemodified:"yyyy-mm-dd hh:mm:ss",draggable:"false",draggablechange:"false"},
                           {layer:"compass",action:"none",datemodified:"yyyy-mm-dd hh:mm:ss",draggable:"false",draggablechange:"false"}
                         ];
        
        var houseMarker = []; 
        var houseUnit = [];
        var houseMulti = []; 
        var houseSave = [];
        var numOfhouses = 0;  
        
        var house = "icons/House_NW.png";
        var housesaved = "icons/House_NW_Saved.png";        
        var apartment = "icons/Apartment_NW.png"
        var multihouse = "icons/Duplex_NW.png";
        var phone = "icons/Phone_NW.png";  
        var phonesaved = "icons/Phone_NW_Saved.png";          


        <?php 
         echo 'var congregationNumber = "'.$congregationnumber.'";';
         echo 'var territorynumber = "'.$territory.'";';
         echo 'var user = "'.$_SESSION['username'].'";';
        ?>
        disableLayers("layer");    
        getTerritoryInfo();
        initialize();
        
//classA will capture the data
//classB will stack objects of classA
//main will control the map and events and capture houses data

/*classA 
 * variables
 * var polygon;
 * var rectangle;
 * var compass;
 * 
 * functions
 * event('objectname'); returns boolean
 * action('objectname'); returns string 'created',position_changed','delete'
 * datemodified('objectname'); returns string
 * polygon(); returns path array
 * rectangle(); returns bounds array
 * compass(); returns latLng
 * */
 
        function topPanel(){
            var territory = document.getElementById('myterritory');
            var div1 = document.createElement('div');
            div1.innerHTML = '<a href = "territorymap.php?territory=' + territorynumber + '">' + territorynumber + '</a>';
            territory.appendChild(div1);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(territory);
        }
        
        function topPanelEdit(terrnum){
            var territory = document.getElementById('myterritory');
            territory.innerHTML="";
            map.controls[google.maps.ControlPosition.TOP_LEFT].clear(); 
            
            var div1 = document.createElement('div');
            div1.innerHTML = '<a href = "territorymap.php?territory=' + terrnum + '">' + terrnum + '</a>';
            territory.appendChild(div1);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(territory);
        }        
        
        function initialize(){
        // Get the element with id="defaultOpen" and click on it
           document.getElementById('defaultOpen').click();   
//           document.getElementById('Territory').disabled = true;
           document.getElementById('rectangledraggable').disabled = true;
           document.getElementById('compassdraggable').disabled = true; 
           document.getElementById('defaultterritoryview').disabled = true;           
        }
        
        function getCoordinates(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                     var myJSONResult = JSON.parse(this.responseText);
                     var latitude  = Number(myJSONResult[0].Latitude);
                     var longitude = Number(myJSONResult[0].Longitude);  
                     initialMap(latitude,longitude,7);
                }
            };
            xmlhttp.open("GET", "getCoordinates.php?congregationnumber=" + congregationNumber, true);
            xmlhttp.send();             
        }
        
        function initialMap(latitude,longitude,zoom){
            map = new google.maps.Map(document.getElementById('map'), {
              zoom: zoom,
             // center: {lat: 41.879, lng: -87.624}  // Center the map on Chicago, USA.
//              center: {lat: 28.5360389, lng: -81.350069} 
                center: {lat: latitude, lng: longitude}
            });
        } 
        
        function selectDraggable(layername){
            if (layername === 'rectangle'){
                if (rectangle){
                    properties[1].draggable = document.getElementById('rectangledraggable').value;
                    properties[1].draggablechange = "true";
                    if(properties[1].draggable === 'false') { 
                      rectangle.setOptions({draggable: false});
                    }
                    if(properties[1].draggable === 'true') { 
                       rectangle.setOptions({draggable: true});
                    }                   
                }                  
            }
            if (layername === 'compass'){
                if (compassMarker){
                    properties[2].draggable = document.getElementById('compassdraggable').value;
                    properties[2].draggablechange = "true";
                    if(properties[2].draggable === 'false') { 
                      compassMarker.setOptions({draggable: false});
                    }
                    if(properties[2].draggable === 'true') { 
                       compassMarker.setOptions({draggable: true});
                    }                   
                }                    
            }          
            
        }  
        
        function selectDefault() {
            if(document.getElementById('defaultterritoryview').value === "true"){
               defaultview = true;
            }
        }         
        
        function openTab(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
       }   
       
       function TurnOnOffLayer(checkbox,value) {
            if (checkbox.checked) {
            if( value == 'Polygon')  {showLayer('Polygon')};
            if( value == 'Rectangle'){showLayer('Rectangle')};
            if( value == 'Compass')  {showLayer('Compass')};
            if( value == 'House')    {showLayer('House')};            
            }
            else {
            if( value == 'Polygon')  {hideLayer('Polygon')};
            if( value == 'Rectangle'){hideLayer('Rectangle')}; 
            if( value == 'Compass')  {hideLayer('Compass')}; 
            if( value == 'House')    {hideLayer('House')};             
            }
        } 
        
        function setPolygonProperties(){
            var xy = [];
            var d = new Date();
            var len = polygon.getPath().getLength();
            var htmlStr = "";

            for (var i = 0; i < len; i++) {
                var coordinatestring = polygon.getPath().getAt(i).toUrlValue(5).toString();
                var array = coordinatestring.split(',');
                xy.push({lat: Number(array[0]), lng:  Number(array[1])});
                
            } 
            
            htmlStr = JSON.stringify(xy);
            jsonPolygon = JSON.stringify(xy);
            
            document.getElementById('PolygonChanged').value = "true";
            document.getElementById('PolygonAction').innerHTML = "action: resized";
            document.getElementById('PolygonDateModified').innerHTML = 'date: ' + d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
            document.getElementById('PolygonBounds').innerHTML = 'bounds:<br>' + htmlStr;   
            
            properties[0].action = "resized";
            properties[0].datemodified = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
        }
        
      function disableLayers(name) {
            var elems = document.getElementsByName(name);
            for(i=0; i<elems.length; i++) {
                elems[i].disabled = true;
            }
       }
       
       function enableLayer(name,index){
           var elems = document.getElementsByName(name);
           elems[index].disabled = false;
       }
       
       function disableLayer(name,index){
           var elems = document.getElementsByName(name);
           elems[index].disabled = true;
       }       
       
       function showLayer(name){
           if (name=='Polygon')  {polygon.setMap(map);} 
           if (name=='Rectangle'){rectangle.setMap(map);} 
           if (name=='Compass')  {compassMarker.setMap(map);}           
           if (name=='House'){
                for(i=0;houseMarker.length-1;i++){              
                    houseMarker[i].setMap(map);
                }
           }
       }
       
       function hideLayer(name){
           if (name=='Polygon')  {polygon.setMap(null);} 
           if (name=='Rectangle'){rectangle.setMap(null);} 
           if (name=='Compass')  {compassMarker.setMap(null);}
           if (name=='House'){
                for(i=0;houseMarker.length-1;i++){              
                    houseMarker[i].setMap(null);
                }
           }           
       }       

       
        function drawPolygon(){
            
            if (polygon==null){
                // Remove listeners from map instance.
                google.maps.event.clearInstanceListeners(map);

                map.setOptions({draggableCursor:'crosshair'});

                poly = new google.maps.Polyline({
                  strokeColor: '#000000',
                  strokeOpacity: 1.0,
                  strokeWeight: 3,
                  geodesic: true
                });
                poly.setMap(map);

                // Add a listener for the click event
                map.addListener('click', addLatLng);
           }
            
        }
        
        
        function selectPointer(){
            // Remove listeners from map instance.
            google.maps.event.clearInstanceListeners(map);  
            map.setOptions({draggableCursor: 'default'});
            
        }
        
        function selectCompass(){
            if(compassMarker==null){
                // Remove listeners from map instance.
                google.maps.event.clearInstanceListeners(map);  
                map.setOptions({draggableCursor: 'crosshair'});    

                // Add a listener for the click event
                map.addListener('click', addCompass);            
            }             
        }
        
        function selectHouse(){
            // Remove listeners from map instance.
            google.maps.event.clearInstanceListeners(map);  
            map.setOptions({draggableCursor: 'crosshair'});    
            //new code 7/16/2017 start here
            hideLayer('Polygon');
            hideLayer('Rectangle');             
            //new code 7/16/2017 end here             
            // Add a listener for the click event
            map.addListener('click', addHouse);            
                        
        } 
        
        function selectRectangle(){
            if(rectangle==null){
                // Remove listeners from map instance.
                google.maps.event.clearInstanceListeners(map);  
                map.setOptions({draggableCursor: 'crosshair'});

                // Add a listener for the click event
                map.addListener('click', addRectangle);            
           }            
        }          
       
       function snapPolygon(){
        var d = new Date();
        polygonCoordinates.push(polygonCoordinates[0]);
        google.maps.event.clearInstanceListeners(map);
        poly.setMap(null);
        jsonPolygon = JSON.stringify(polygonCoordinates);
        var html = '<table><tr><td>Polygon</td><td align="right"><div class="toolbartip"><img src = "icons/trashbinsymbol.png" onclick="removePolygon()"/><span class="toolbartiptext">delete</span></div></td></tr></table>';
                          
        
         polygon = new google.maps.Polygon({
                paths: polygonCoordinates,
                strokeColor: '#072f72',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#072f72',
                fillOpacity: 0.05,
                editable: true
          });
          polygon.setMap(map);
          
          polygonInfowindow = new google.maps.InfoWindow({ content: html });     
          polygonInfowindow.setPosition(polygonStack[0]);
        
          google.maps.event.addListener(polygon, "click", function() {            
            polygonInfowindow.open(map);
           }); 
           
            
          google.maps.event.addListener(polygon.getPath(), "insert_at", setPolygonProperties);             
          google.maps.event.addListener(polygon.getPath(), "set_at", setPolygonProperties);    
               
                    
          polygonCoordinates = [];
          polygonStack = []; 
          
          for (var index in polymarker) {
               polymarker[index].setMap(null); 
          }
          selectPointer();
          enableLayer("layer",0);
          
          document.getElementById('PolygonChanged').value = "true";
          document.getElementById('PolygonAction').innerHTML = "action: created";
          document.getElementById('PolygonDateModified').innerHTML = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
          document.getElementById('PolygonBounds').innerHTML = jsonPolygon;
          
          properties[0].action = "created";
          properties[0].datemodified = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
       }
       
 

      // Handles click events on a map, and adds a new point to the Polyline.
      function addLatLng(event) {
        var path = poly.getPath();
        var LatLng = event.latLng;
        // Because path is an MVCArray, we can simply append a new coordinate
        // and it will automatically appear.
        path.push(event.latLng);
        polygonStack.push(event.latLng);
        polygonCoordinates.push({lat: Number(parseFloat(LatLng.lat()).toFixed(5).toString()), lng:  Number(parseFloat(LatLng.lng()).toFixed(5).toString())});
        // Add a new marker at the new plotted point on the polyline.
        polymarker.push(new google.maps.Marker({
          position: event.latLng,
          title: '{lat: ' + parseFloat(LatLng.lat()).toFixed(5).toString() + ', lng: ' + parseFloat(LatLng.lng()).toFixed(5).toString() + '}',
                   icon: {
                            path: google.maps.SymbolPath.CIRCLE,                            
                            scale: 2
                         }, 
          draggable: false,  
          editable: true,
          map: map
        }));

    }
    
      // Handles click events on a map, and adds a new point to the Polyline.
      function movePolyline(event) {
        var path = poly.getPath();
        // Because path is an MVCArray, we can simply append a new coordinate
        // and it will automatically appear.
        path.push(event.latLng);
                      
        
      }  
      
      // Handles click events on a map, and adds a new compass.
      function addCompass(event) {
        var d = new Date();  
        var LatLng = event.latLng;
        
        var html = '<table><tr><td>Compass</td><td align="right"><div class="toolbartip"><img src = "icons/trashbinsymbol.png" onclick="removeCompass()"/><span class="toolbartiptext">delete</span></div></td></tr></table>';
        // Add a new marker at the new plotted point on the polyline.
        var myinfowindow = new google.maps.InfoWindow({ content: html });
        
        compassMarker = new google.maps.Marker({
          position: event.latLng,
          title: 'North Compass',
                   icon: {
                            path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,                            
                            scale: 12
                         }, 
          draggable: true,                          
          map: map,
          infowindow: myinfowindow
        });

        compassMarker.setMap(map);
        google.maps.event.addListener(compassMarker, "click", function () {this.infowindow.open(map, this);});           
         
        google.maps.event.addListener(compassMarker, "dragend", function (event) {
             var LatLng = event.latLng;
             var d = new Date();
             document.getElementById('CompassChanged').value = "true";
             document.getElementById('CompassAction').innerHTML = "action: position_changed";
             document.getElementById('CompassDateModified').innerHTML = 'date: ' + d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
             document.getElementById('CompassLatLng').innerHTML = 'latlng: ' + parseFloat(LatLng.lat()).toFixed(5).toString() + ', ' + parseFloat(LatLng.lng()).toFixed(5).toString();
             
             compass = parseFloat(LatLng.lat()).toFixed(5).toString() + ', ' + parseFloat(LatLng.lng()).toFixed(5).toString();
                
             properties[2].action = "position_changed";
             properties[2].datemodified = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
        });
         
        selectPointer(); 
        enableLayer("layer",3);
        document.getElementById('CompassChanged').value = "true";
        document.getElementById('CompassAction').innerHTML = "action: created";
        document.getElementById('CompassDateModified').innerHTML = 'date: ' + d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
        document.getElementById('CompassLatLng').innerHTML = 'latlng: ' + parseFloat(LatLng.lat()).toFixed(5).toString() + ', ' + parseFloat(LatLng.lng()).toFixed(5).toString();
        
        compass = parseFloat(LatLng.lat()).toFixed(5).toString() + ', ' + parseFloat(LatLng.lng()).toFixed(5).toString();
        
        properties[2].action = "created";
        properties[2].datemodified = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());        
        
        document.getElementById('compassdraggable').disabled = false;        
      }   
      
      // Handles click events on a map, and adds a house.
      function addHouse(event) {
        var LatLng = event.latLng;               
              
        geocodePosition(LatLng); 
        selectPointer();  
        enableLayer("layer",2);
        numOfhouses+=1;
        
        var d = new Date();
        document.getElementById('HouseChanged').value = true;
        document.getElementById('HouseAction').innerHTML = "action: created";
        document.getElementById('HouseTotal').innerHTML = "homes: 0/" + numOfhouses;
        document.getElementById('HouseDateModified').innerHTML = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
        
//        new code 7/16/2017 start here        
          TurnOnOffLayer(document.getElementById('chkPolygon'),'Polygon');
          TurnOnOffLayer(document.getElementById('chkRectangle'),'Rectangle');            
//        new code 7/16/2017 end here          
      }  
      
      function removeHouse(index){ 
          var d = new Date();
          var datemodified = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
          if (houseSave[index] === true){   
                if (confirm("Are you sure you want to remove property?") === true) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState === 4 && this.status === 200) {
                             var myJSONResult = JSON.parse(this.responseText);
//                              if (myJSONResult[0].Error === "0"){                              
                                    numOfhouses = parseInt(myJSONResult[0].Count);
                                    document.getElementById('HouseTotal').innerHTML = "homes: " + myJSONResult[0].Count;
                                    document.getElementById('HouseDateModified').innerHTML = datemodified;

                                    houseMarker[index].setMap(null);   
                                    houseMarker[index]=null;          
                                    numOfhouses-=1;
                                    if (numOfhouses<1){disableLayer("layer",2);} 
//                              }
                        }
                    };

                    xmlhttp.open("GET", "removeProperty.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value  + "&placeid=" + document.getElementById('place_id').value, true);             
                    xmlhttp.send(); 

                } else {
                      //do nothing
                }
            } 
                      
            if (houseSave[index] === false){
                
                houseMarker[index].setMap(null);   
                houseMarker[index]=null;          
                numOfhouses-=1;

                document.getElementById('HouseTotal').innerHTML = "homes: " + numOfhouses;
                document.getElementById('HouseDateModified').innerHTML = datemodified;
                if (numOfhouses<1){disableLayer("layer",2);}  
                
            }
          
      }
      
      
      function removeCompass(){
          compassMarker.setMap(null);  
          compassMarker=null;
          disableLayer("layer",3);
          
            var d = new Date();
            var datemodified = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
            var jsonProperty = JSON.stringify(properties);
            
            properties[2].action = "delete";
            properties[2].datemodified = datemodified;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                     var myJSONResult = JSON.parse(this.responseText);
                      if (myJSONResult[0].Error === "0"){
                        document.getElementById('CompassAction').innerHTML = "action: delete";
                        document.getElementById('CompassDateModified').innerHTML = datemodified;
                        document.getElementById('CompassChanged').value = "false";
                        document.getElementById('compassdraggable').disabled = true;                        
                      }
                }
            };

            xmlhttp.open("GET", "removeLayer.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value  + "&layer=compass" + "&propertyjson=" + jsonProperty, true);             
            xmlhttp.send();            
      }
      
      function removeRectangle(){
          rectangle.setMap(null); 
          rectangle=null;
          rectangleInfowindow.close();
          disableLayer("layer",1);
          
            var d = new Date();
            var datemodified = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
            var jsonProperty = JSON.stringify(properties);
            
            properties[1].action = "delete";
            properties[1].datemodified = datemodified;
            //alert("saveLayer.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value  + "&layer=rectangle" + "&layerjson=" + jsonRectangle + "&latlng=" + rectanglecenter +  "&propertyjson=" + jsonProperty + "&initialdate=" + datemodified);
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                     var myJSONResult = JSON.parse(this.responseText);
                      if (myJSONResult[0].Error === "0"){
                        document.getElementById('RectangleAction').innerHTML = "action: delete";
                        document.getElementById('RectangleDateModified').innerHTML = datemodified;
                        document.getElementById('RectangleChanged').value = "false";
                        document.getElementById('rectangledraggable').disabled = true;                        
                      }
                }
            };

            xmlhttp.open("GET", "removeLayer.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value  + "&layer=rectangle" + "&propertyjson=" + jsonProperty, true);            
            xmlhttp.send();           
      }  
      
      function removePolygon(){
          polygon.setMap(null); 
          polygon=null;
          polygonInfowindow.close();   
          disableLayer("layer",0);
          
          
            var d = new Date();
            var datemodified = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
            var jsonProperty = JSON.stringify(properties);
            
            properties[0].action = "delete";
            properties[0].datemodified = datemodified;
           // alert("inside function");
           // alert("saveLayer.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value  + "&layer=polygon" + "&layerjson=" + jsonPolygon + "&propertyjson=" + jsonProperty + "&initialdate=" + datemodified);
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                     var myJSONResult = JSON.parse(this.responseText);
                      if (myJSONResult[0].Error === "0"){
                        document.getElementById('PolygonAction').innerHTML = "action: delete";
                        document.getElementById('PolygonDateModified').innerHTML = datemodified;
                        document.getElementById('PolygonChanged').value = "false";
                      }
                }
            };

            xmlhttp.open("GET", "removeLayer.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value  + "&layer=polygon" + "&propertyjson=" + jsonProperty, true);
            xmlhttp.send();           
      }
      
      function save(){
          var territoryname;
          
          if(territoryassigned === false){
              territoryname = prompt("Please save territory as:", "Terr1");
              if (territoryname == null || territoryname == "") {
              }
              else{
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState === 4 && this.status === 200) {
                             var myJSONResult = JSON.parse(this.responseText);
                              if (myJSONResult[0].Exist === "1"){
                                   if(confirm("Do you want to replace existing territory?") === true){
                                        territoryassigned = true;                                       
                                        if (document.getElementById('PolygonChanged').value === "true"){
                                            savePolygon();                                            
                                        }
                                        if (document.getElementById('CompassChanged').value === "true"){
                                            saveCompass();                                         
                                        }
                                        if (document.getElementById('RectangleChanged').value === "true"){
                                            saveRectangle();                                           
                                        }   
                                        if (properties[1].draggablechange === "true" || properties[2].draggablechange === "true" ){
                                            saveProperties();                                            
                                        } 
                                        if (defaultview === true){
                                            saveDefault();
                                        }
                                   }
                                   else{
                                       territoryassigned = false;
                                   }
                              }
                              else{
                                   territoryassigned = true;
                                   document.getElementById('Territory').value = territoryname;
                                    if (document.getElementById('PolygonChanged').value === "true"){
                                        savePolygon();
                                    }
                                    if (document.getElementById('CompassChanged').value === "true"){
                                        saveCompass();                                          
                                    }
                                    if (document.getElementById('RectangleChanged').value === "true"){
                                        saveRectangle();                                           
                                    } 
                                    if (properties[1].draggablechange === "true" || properties[2].draggablechange === "true" ){
                                        saveProperties();                                            
                                    }
                                    if (defaultview === true){
                                        saveDefault();
                                    }                                    
                                    
                                    document.getElementById('terrname' + mapnumber).innerHTML = territoryname;
                                    document.getElementById('addterritory' + mapnumber).innerHTML = '<a href = "editterritory.php?territory=' + territoryname + '"><img src = "icons/newterritory.png"></a>';                                   
                                    document.getElementById('noentries').innerHTML = '';
                              }
                        }
                    };

                    xmlhttp.open("GET", "territoryexist.php?congregationnumber=" + congregationNumber + "&territorynumber=" + territoryname, true);
                    xmlhttp.send();                    
              }
          }
          
          if(territoryassigned === true){
                if (document.getElementById('PolygonChanged').value === "true"){
                    savePolygon();
                }
                if (document.getElementById('CompassChanged').value === "true"){
                    saveCompass();                                          
                }
                if (document.getElementById('RectangleChanged').value === "true"){
                    saveRectangle();                                           
                } 
                if (properties[1].draggablechange === "true" || properties[2].draggablechange === "true" ){
                    saveProperties();                                            
                }
                if (defaultview === true){
                    saveDefault();
                }   
                if (document.getElementById('Territory').value !== territorynumber){
                    topPanelEdit(document.getElementById('Territory').value);
                    document.getElementById('terrid' + territorynumber).innerHTML = document.getElementById('Territory').value;                    
                    document.getElementById('terrlink' + territorynumber).innerHTML = '<a href = "editterritory.php?territory=' + document.getElementById('Territory').value + '"><img src = "icons/newterritory.png"></a>';
                }                
          }

      }
      
      function savePolygon(){
            var d = new Date();
            var datemodified = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
            var jsonProperty = JSON.stringify(properties);
           // alert("inside function");
           // alert("saveLayer.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value  + "&layer=polygon" + "&layerjson=" + jsonPolygon + "&propertyjson=" + jsonProperty + "&initialdate=" + datemodified);
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                     var myJSONResult = JSON.parse(this.responseText);
                      if (myJSONResult[0].Error === "0"){
                        document.getElementById('PolygonAction').innerHTML = "action: saved";
                        document.getElementById('PolygonDateModified').innerHTML = datemodified;
                        document.getElementById('PolygonChanged').value = "false";
                        properties[1].draggablechange = "false";
                        properties[2].draggablechange = "false";                           
                      }
                }
            };
            xmlhttp.open("POST", "saveLayer.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value  + "&layer=polygon" + "&layerjson=" + jsonPolygon + "&propertyjson=" + jsonProperty + "&initialdate=" + datemodified + "&user=" + user, true);
            //xmlhttp.open("GET", "saveLayer.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value  + "&layer=polygon" + "&layerjson=" + jsonPolygon + "&propertyjson=" + jsonProperty + "&initialdate=" + datemodified + "&user=" + user, true);
            xmlhttp.send();  
      }  
      
      function saveCompass(){
            var d = new Date();
            var datemodified = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
            var jsonProperty = JSON.stringify(properties);
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                     var myJSONResult = JSON.parse(this.responseText);
                      if (myJSONResult[0].Error === "0"){
                        document.getElementById('CompassAction').innerHTML = "action: saved";
                        document.getElementById('CompassDateModified').innerHTML = datemodified;
                        document.getElementById('CompassChanged').value = "false";
                        properties[1].draggablechange = "false";
                        properties[2].draggablechange = "false";                           
                      }
                }
            };
            xmlhttp.open("POST", "saveLayer.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value  + "&layer=compass" + "&compass=" + compass + "&propertyjson=" + jsonProperty + "&initialdate=" + datemodified + "&user=" + user, true);            
           // xmlhttp.open("GET", "saveLayer.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value  + "&layer=compass" + "&compass=" + compass + "&propertyjson=" + jsonProperty + "&initialdate=" + datemodified + "&user=" + user, true);
            xmlhttp.send();            
      }
      
      function saveRectangle(){
            var d = new Date();
            var datemodified = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
            var jsonProperty = JSON.stringify(properties);
            //alert("saveLayer.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value  + "&layer=rectangle" + "&layerjson=" + jsonRectangle + "&latlng=" + rectanglecenter +  "&propertyjson=" + jsonProperty + "&initialdate=" + datemodified);
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                     var myJSONResult = JSON.parse(this.responseText);
                      if (myJSONResult[0].Error === "0"){
                        document.getElementById('RectangleAction').innerHTML = "action: saved";
                        document.getElementById('RectangleDateModified').innerHTML = datemodified;
                        document.getElementById('RectangleChanged').value = "false";
                        properties[1].draggablechange = "false";
                        properties[2].draggablechange = "false";                           
                      }
                }
            };
            xmlhttp.open("POST", "saveLayer.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value  + "&layer=rectangle" + "&layerjson=" + jsonRectangle + "&latlng=" + rectanglecenter +  "&propertyjson=" + jsonProperty + "&initialdate=" + datemodified + "&user=" + user, true);            
           // xmlhttp.open("GET", "saveLayer.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value  + "&layer=rectangle" + "&layerjson=" + jsonRectangle + "&latlng=" + rectanglecenter +  "&propertyjson=" + jsonProperty + "&initialdate=" + datemodified + "&user=" + user, true);
            xmlhttp.send();            
      } 
      
      function saveProperties(){
            var d = new Date();
            var datemodified = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
            var jsonProperty = JSON.stringify(properties);
            //alert("saveLayer.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value  + "&layer=rectangle" + "&layerjson=" + jsonRectangle + "&latlng=" + rectanglecenter +  "&propertyjson=" + jsonProperty + "&initialdate=" + datemodified);
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                     var myJSONResult = JSON.parse(this.responseText);
                      if (myJSONResult[0].Error === "0"){
                        properties[1].draggablechange = "false";
                        properties[2].draggablechange = "false";                           
                      }
                }
            };
            xmlhttp.open("POST", "saveLayer.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value  + "&layer=properties&layerjson=&latlng=&propertyjson=" + jsonProperty + "&initialdate=" + datemodified + "&user=" + user, true);            
            //xmlhttp.open("GET", "saveLayer.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value  + "&layer=properties&layerjson=&latlng=&propertyjson=" + jsonProperty + "&initialdate=" + datemodified + "&user=" + user, true);
            xmlhttp.send();            
      }      
      
      function saveDefault(){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                     var myJSONResult = JSON.parse(this.responseText);
                      if (myJSONResult[0].Error === "0"){
                        defaultview = false;                          
                      }
                }
            };
            
            xmlhttp.open("GET", "saveDefaultTerritory.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value + "&user=" + user, true);
            xmlhttp.send();            
      }   
      
      
      function addRectangle(event){ 
        var d = new Date();  
        var LatLng = event.latLng;
        
        var html = '<table><tr><td>Rectangle</td><td align="right"><div class="toolbartip"><img src = "icons/trashbinsymbol.png" onclick="removeRectangle()"/><span class="toolbartiptext">delete</span></div></td></tr></table>';

        // and it will automatically appear.        
        var north = parseFloat(LatLng.lat()).toFixed(5).toString();
        var south = parseFloat(LatLng.lat()).toFixed(5).toString();
        var east  = parseFloat(LatLng.lng()).toFixed(5).toString();
        var west  = parseFloat(LatLng.lng()).toFixed(5).toString();
          
        var x_north = Number(north);
        var x_south = Number(south) + (-.00050);
        var y_east  = Number(east)  + (.00050);
        var y_west  = Number(west);            
         

        rectangle = new google.maps.Rectangle({
        strokeColor: '#072f72',
        strokeOpacity: 0.8,
        strokeWeight: 5,
        fillColor: '#072f72',
        fillOpacity: 0,
        editable: true,
        draggable: true,
        bounds: {north: x_north,south: x_south,east: y_east,west: y_west}
        }); 
        rectangle.setMap(map); 
        //'bounds: {north: 28.53799,south: 28.53323,east: -81.34752,west: -81.35191}'
        
        rectangleInfowindow = new google.maps.InfoWindow({ content: html });     
        rectangleInfowindow.setPosition(rectangle.getBounds().getNorthEast());
        
        google.maps.event.addListener(rectangle, "click", function() {            
            rectangleInfowindow.open(map);
        });
        
    
         rectangle.addListener('bounds_changed', function() {         
          
             var d = new Date();
             var ne = rectangle.getBounds().getNorthEast();
             var sw = rectangle.getBounds().getSouthWest();
             var center = rectangle.getBounds().getCenter();
             
             var x_north = parseFloat(parseFloat(ne.lat()).toFixed(5).toString());
             var y_east = parseFloat(parseFloat(ne.lng()).toFixed(5).toString());
             var x_south = parseFloat(parseFloat(sw.lat()).toFixed(5).toString());
             var y_west = parseFloat(parseFloat(sw.lng()).toFixed(5).toString());
             var bounds = [{north:x_north,south:x_south,east:y_east,west:y_west}];
                          
             jsonRectangle = JSON.stringify(bounds);
                      
             document.getElementById('RectangleChanged').value = "true";
             document.getElementById('RectangleAction').innerHTML = "action: position_changed";
             document.getElementById('RectangleDateModified').innerHTML = 'date: ' + d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
             document.getElementById('RectangleCenter').innerHTML = 'center: ' + parseFloat(center.lat()).toFixed(5).toString() + ',' + parseFloat(center.lng()).toFixed(5).toString();
             document.getElementById('RectangleBounds').innerHTML = 'bounds:' + jsonRectangle.replace(new RegExp(',', 'g'),',<br>').replace('[{','[{<br>');
             
             rectanglecenter = parseFloat(center.lat()).toFixed(5).toString() + ',' + parseFloat(center.lng()).toFixed(5).toString();
             
             properties[1].action = "position_changed";
             properties[1].datemodified = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
         });
         
        selectPointer(); 
        enableLayer("layer",1);
       
        var ne = rectangle.getBounds().getNorthEast();
        var sw = rectangle.getBounds().getSouthWest();
        var center = rectangle.getBounds().getCenter();
              
        var x_north = parseFloat(parseFloat(ne.lat()).toFixed(5).toString());
        var y_east = parseFloat(parseFloat(ne.lng()).toFixed(5).toString());
        var x_south = parseFloat(parseFloat(sw.lat()).toFixed(5).toString());
        var y_west = parseFloat(parseFloat(sw.lng()).toFixed(5).toString());
        var bounds = [{north:x_north,south:x_south,east:y_east,west:y_west}];
       
        jsonRectangle = JSON.stringify(bounds);
       
        document.getElementById('RectangleChanged').value = "true";
        document.getElementById('RectangleAction').innerHTML = "action: created";
        document.getElementById('RectangleDateModified').innerHTML = 'date: ' + d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
        document.getElementById('RectangleCenter').innerHTML = 'center: ' + parseFloat(center.lat()).toFixed(5).toString() + ',' + parseFloat(center.lng()).toFixed(5).toString();       
        document.getElementById('RectangleBounds').innerHTML = 'bounds:' + jsonRectangle.replace(new RegExp(',', 'g'),',<br>').replace('[{','[{<br>');
        
        rectanglecenter = parseFloat(center.lat()).toFixed(5).toString() + ',' + parseFloat(center.lng()).toFixed(5).toString();
        
        properties[1].action = "created";
        properties[1].datemodified = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());        
        
        document.getElementById('rectangledraggable').disabled = false;          
      }
      
//results[1].formatted_address;
    function geocodePosition(pos) {

      geocoder.geocode({latLng: pos}, 
      function(results, status) {
       if (status === google.maps.GeocoderStatus.OK) {            
        var addresssplit = results[0].formatted_address.toString().split(' '); 
        var housenumber = addresssplit[0];
        var address = results[0].formatted_address.toString().replace(housenumber,'');        
        var html = '<table><tr><td id="addressHeader"><h3><p><b>' + results[0].formatted_address + '</h3></p></b></td></tr></table>' +
                '<input type = "hidden" id = "formatted_address" value = "' + results[0].formatted_address + '">' + 
                '<input type = "hidden" id = "place_id" value = "' + results[0].place_id + '">' + 
                '<input type = "hidden" id = "addressguid" value = "">' +                 
                '<input type = "hidden" id = "latitude" value = "' + Number(parseFloat(pos.lat()).toFixed(5).toString()) + '">' + 
                '<input type = "hidden" id = "longitude" value = "' + Number(parseFloat(pos.lng()).toFixed(5).toString()) + '">' +  
                '<input type = "hidden" id = "street" value = "' + results[0].address_components[1].short_name + '">' + 
                '<input type = "hidden" id = "city" value = "' + results[0].address_components[2].short_name + '">' +
                '<input type = "hidden" id = "state" value = "' + results[0].address_components[4].short_name + '">' + 
                '<input type = "hidden" id = "zipcode" value = "' + results[0].address_components[6].short_name + '">' +                  
                 
                '<div id="addresscorrect" style="display:block;">' + 
                '<table><tr><td>Does the above address need correction?</td></tr></table>' +
                '<table><tr><form action=""><td><input type="radio" name="correct" id = "needcorrection_yes" value="yes" style="width: 30px;" onclick="showAddressCorrection(' + houseMarker.length + ')">Yes</td>' +
                '<td><input type="radio" name="correct" id = "needcorrection_no"  value="no"  style="width: 30px;" onclick="hideAddressCorrection(' + houseMarker.length + ')" checked>No</td></form></tr></table>' +                
                '<div id="correctaddress" style="display:none;">' +
                '<table><tr><td><input id="housenumberchange" type="text" value="' + housenumber + '"></td><td id="addresssplit">' + address + '</td></tr></table>' +
                '<table><tr><td><input id="changeAddr" type="button" value="change" onclick="changeAddress(' + houseMarker.length + ')" style="padding: 8px 32px;"></td></tr></table>' +        
                '</div></div>' +    
                
                '<div id="units0" style="display:block;">' +                  
                '<table><tr><td>Is this an apartment building?</td></tr></table>' +
                '<table><tr><form action=""><td><input type="radio" name="haveUnits" id = "units_yes" value="yes" style="width: 30px;" onclick="showApartment(' + houseMarker.length + ')">Yes</td>' +
                '<td><input type="radio" name="haveUnits" id = "units_no"  value="no"  style="width: 30px;" onclick="hideApartment(' + houseMarker.length + ')" checked>No</td></form></tr></table>' +
                '<div id="units" style="display:none;"><div id="apartment"></div></div></div>' +                 
                
                '<div id="multi0" style="display:block;">' + 
                '<table><tr><td>Is this an multifamly house (Ex: duplex, triplex, fourplex)?</td></tr></table>' +
                '<table><tr><form action=""><td><input type="radio" name="haveMulti" id = "multi_yes" value="yes" style="width: 30px;" onclick="showMultiHouse(' + houseMarker.length + ')">Yes</td>' +
                '<td><input type="radio" name="haveMulti" id = "multi_no"  value="no"  style="width: 30px;" onclick="hideMultiHouse(' + houseMarker.length + ')" checked>No</td></form></tr></table>' +                
                '<div id="multi" style="display:none;"><div id="multihouse"></div></div></div>' +                

                         
                '<div id="phone" style="display:block;"><div id="phonehouse">' +                
                '<table><tr><td>Does this home have a landline?</td></tr></table>' +
                '<table><tr><form action=""><td><input type="radio" name="havePhone" id = "phone_yes" value="yes" style="width: 30px;" onclick="showHousePhone(' + houseMarker.length + ')">Yes</td>' +
                '<td><input type="radio" name="havePhone" id = "phone_no"  value="no"  style="width: 30px;" onclick="hideHousePhone(' + houseMarker.length + ')" checked>No</td></form></tr></table>' +
                '<div id="phoneinfo" style="display:none;">' + 
                '<table><tr><td>Resident</td><td>Phone</td></tr><tr><td><input id="resident" type="text"></td><td>(<input id="areacode" type="text" style="width: 30px;" maxlength="3">)<input id="first3digit" type="text" style="width: 30px;" maxlength="3">-<input id="last4digit" type="text" style="width: 40px;" maxlength="4"></td></tr></table></div></div></div>' +
                '<table><tr><td><input type="button" value="Save" onclick="saveHouse(' + houseMarker.length +')" style="padding: 8px 32px;"></td><td><input type="button" value="Cancel" onclick="closeHouse(' + houseMarker.length +')" style="padding: 8px 32px;"></td><td><img src = "icons/export.png"></td><td align="right"><div class="toolbartip"><img src = "icons/trashbinsymbol.png" onclick="removeHouse(' + houseMarker.length +')"><span class="toolbartiptext">delete</span></div></td></tr></table>';
        
        
        //<table><tr><td><input type="button" value="Add Apartment" onclick="MultiHouse(' + houseMarker.length + ')" style="padding: 8px 32px;"></td></tr></table>'
        // Add a new marker at the new plotted point on the polyline.
        var myinfowindow = new google.maps.InfoWindow({ content: html });        
                
          
        houseMarker.push(new google.maps.Marker({
          position: pos,
          title: results[0].formatted_address,
          icon:  house,
          draggable: false,                                                         
          map: map,
          infowindow: myinfowindow
        }));

        houseMarker[houseMarker.length - 1].setMap(map);          
        
        google.maps.event.addListener(houseMarker[houseMarker.length - 1], "click", function () {this.infowindow.open(map, this);}); 
        

        houseUnit.push(0);
        houseMulti.push(0);
        houseSave.push(false);
//        alert('place_id:' + '\n' + results[0].place_id + '\n' + 
//               'length: ' + results[0].place_id.length +  '\n' + 
//               'lat: ' + Number(parseFloat(pos.lat()).toFixed(5).toString()) + ' ' +
//               'lng: ' + Number(parseFloat(pos.lng()).toFixed(5).toString())               
//               );
        
            } else {
              
              //alert('Geocode was not successful for the following reason: ' + status);
            }            
       });
      
    }
    
   function showMultiHouse(index){
        if (houseMulti[index] == 0){
                var htmltable =    '<br><table><thead><tr><th></th>' +
                                   '<th>House Number</th>' +
                                   '<th>Phone</th>' +
                                   '<th>Resident Name</th>' + 
                                   '<th>Phone</th>' +
                                   '<th></th>' +
                                   '<th></th>' +
                                   '<th></th>' +
                                   '</tr></thead><tbody>';

                 for (i = 0; i < 10; i++){
                    htmltable += '<tr id="rowmulti' + i + 
                                 '"><td align="center" id="editMulti' + i + 
                                 '"><input type="text" value="new" style="width: 40px;color: #80ff00;border: none;"></td><td><input id="houseMulti' + i + 
                                 '" type="text" style="width: 100px;"></td><td align="center"><input type="checkbox" id="hasPhoneMulti' + i + 
                                 '" value="yes" onclick="havePhoneMulti(' + i + 
                                 ')"></td><td><input id="residentMulti' + i + 
                                 '" type="text"></td><td>(<input id="areacodeMulti' + i + 
                                 '" type="text" style="width: 25px;" maxlength="3">)<input id="first3digitMulti' + i + 
                                 '" type="text" style="width: 25px;" maxlength="3">-<input id="last4digitMulti' + i + 
                                 '" type="text" style="width: 30px;" maxlength="4"></td><td id="addrowmulti' + i + 
                                 '"></td><td><input type="hidden" id="geoCodedMulti' +  i + 
                                 '" value="false"></td><td><input type="hidden" id="addressMulti' +  i + 
                                 '" value=""></td><td><input type="hidden" id="xyaddressMulti' +  i + 
                                 '" value=""></td><td><input type="hidden" id="addressguid1Multi' +  i + 
                                 '" value=""></td><td><input type="hidden" id="eventMulti' +  i + 
                                 '" value="false"></td></tr>';

                }

                htmltable +='</tbody></table>';
                document.getElementById('multihouse').innerHTML = htmltable;
                document.getElementById('addrowmulti0').innerHTML = '<input type = "button" id = "add"  value = "+" onclick="addRowMulti(' + index + ')" style="padding: 4px 16px;"><input type = "button" id = "add"  value = "-" style="padding: 4px 16px;">';
                
                //all rows are hidden except first row
                for (i = 1; i < 10; i++){
                   document.getElementById('rowmulti' + i).hidden = true; 
                }
                
                
                for (i = 0; i < 10; i++){
                    // lock phone fields from editing
                    document.getElementById('residentMulti' + i).disabled = true;
                    document.getElementById('areacodeMulti' + i).disabled = true;
                    document.getElementById('first3digitMulti' + i).disabled = true;
                    document.getElementById('last4digitMulti' + i).disabled = true;
                                                           
                }                                                   
              
         }
         

        var showhideunit  = document.getElementById('units');
        var showhidephone = document.getElementById('phone');
        var showhidemulti0 = document.getElementById('multi0');
        var showhidemulti = document.getElementById('multi');
        
        var disableunits_yes  = document.getElementById('units_yes');  
        var disableunits_no  = document.getElementById('units_no');         
        
        disableunits_yes.disabled = true;
        disableunits_no.disabled = true;

        showhideunit.style.display = 'none';
        showhidemulti.style.display = 'block';
       // showhidemulti0.style.display = 'block';        
        showhidephone.style.display = 'none';
        houseMarker[index].setIcon(multihouse);                
                
   }
    
    function showApartment(index){
        if (houseUnit[index] == 0){
                var htmltable = 
                        '<br><table><tr><td>Building Name:</td><td><input id="bldgname" type="text" style="width: 280px;"></td>' +
                        '<td><input type = "hidden" id = "eventBuilding" value = "false"></td>' + 
                        '<td id="editBuilding"></td></tr></table><br>' +
                        '<table>' + 
                        '<thead><tr><th></th>' +
                                   '<th>Building Number</th>' +
                                   '<th>Unit</th>' +
                                   '<th>Phone</th>' +
                                   '<th>Resident Name</th>' + 
                                   '<th>Phone</th>' +                                           
                                   '</tr></thead><tbody>';

                 for (i = 0; i < 1000; i++){
                    htmltable += '<tr id="row' + i + '"><td align="center" id="editUnit' + i + 
                                 '"><input type="text" value="new" style="width: 40px;color: #80ff00;border: none;"></td><td><input id="building' + i + 
                                 '" type="text" style="width: 100px;"></td><td><input id="apt' + i + 
                                 '" type="text" style="width: 35px;"></td><td align="center"><input type="checkbox" id="hasPhone' + i + 
                                 '" value="yes" onclick="havePhone(' + i + 
                                 ')"></td><td><input id="resident' + i + 
                                 '" type="text"></td><td>(<input id="areacode' + i + 
                                 '" type="text" style="width: 25px;" maxlength="3">)<input id="first3digit' + i + 
                                 '" type="text" style="width: 25px;" maxlength="3">-<input id="last4digit' + i + 
                                 '" type="text" style="width: 30px;" maxlength="4"></td><td id="addrow' + i + 
                                 '"></td><td><input type="hidden" id="geoCoded' +  i + 
                                 '" value="false"></td><td><input type="hidden" id="address' +  i + 
                                 '" value=""></td><td><input type="hidden" id="xyaddress' +  i + 
                                 '" value=""></td><td><input type="hidden" id="addressguid1' +  i + 
                                 '" value=""></td><td><input type="hidden" id="eventUnit' +  i + 
                                 '" value="false"></td></tr>';

                }

                htmltable +='</tbody></table>';
                document.getElementById('apartment').innerHTML = htmltable;
                document.getElementById('addrow0').innerHTML = '<input type = "button" id = "add"  value = "+" onclick="addRowUnit(' + index + ')" style="padding: 4px 16px;"><input type = "button" id = "add"  value = "-" style="padding: 4px 16px;">';
                
                //all rows are hidden except first row
                for (i = 1; i < 1000; i++){
                   document.getElementById('row' + i).hidden = true; 
                }
                
                for (i = 0; i < 1000; i++){
                    // lock phone fields from editing
                    document.getElementById('resident' + i).disabled = true;
                    document.getElementById('areacode' + i).disabled = true;
                    document.getElementById('first3digit' + i).disabled = true;
                    document.getElementById('last4digit' + i).disabled = true;                                                            
                }                               
                                       
         }
         
        var showhideunit  = document.getElementById('units');
        var showhidephone = document.getElementById('phone');
       // var showhidemulti = document.getElementById('multi');
        var showhidemulti0 = document.getElementById('multi0');        
        
        showhideunit.style.display = 'block';
        //showhidemulti.style.display = 'none';
        showhidemulti0.style.display = 'none';        
        showhidephone.style.display = 'none';
        houseMarker[index].setIcon(apartment);
    }
    
    function hideApartment(index){
        var showhideunit  = document.getElementById('units');
        var showhidephone = document.getElementById('phone');
        var showhidemulti = document.getElementById('multi');
        var showhidemulti0 = document.getElementById('multi0');         
        
        showhideunit.style.display = 'none';
       // showhidemulti.style.display = 'none';
        showhidemulti0.style.display = 'block';        
        showhidephone.style.display = 'block';
        houseMarker[index].setIcon(house);
    }
    
    function hideMultiHouse(index){
        var showhideunit  = document.getElementById('units');
        var showhidephone = document.getElementById('phone');
        var showhidemulti = document.getElementById('multi');
        var showhidemulti0 = document.getElementById('multi0');   
        
        var disableunits_yes  = document.getElementById('units_yes');  
        var disableunits_no  = document.getElementById('units_no');
        
        disableunits_yes.disabled = false;
        disableunits_no.disabled = false;
        
        showhideunit.style.display = 'none';
        showhidemulti.style.display = 'none';
        //showhidemulti0.display = 'none';        
        showhidephone.style.display = 'block';
        houseMarker[index].setIcon(house);        
    }
    
    function changeAddress(index){
      var addr = document.getElementById('housenumberchange').value + ' ' + document.getElementById('addresssplit').innerHTML;        
      geocoder.geocode({address: addr}, 
      function(results, status) {
       if (status === google.maps.GeocoderStatus.OK) { 
           document.getElementById('formatted_address').value = results[0].formatted_address;
           document.getElementById('addressHeader').innerHTML = '<h3><p><b>' + results[0].formatted_address + '</h3></p></b>';
           document.getElementById('place_id').value = results[0].place_id;
       }
       });
    }
    
    function showAddressCorrection(index){
        var showhidephone = document.getElementById('correctaddress');
               
        if (houseSave[index]){        
            document.getElementById('housenumberchange').disabled = true;
            document.getElementById('changeAddr').disabled = true;              
        }
                 
        showhidephone.style.display = 'block';        
        
    }
    
    function hideAddressCorrection(index){
        var showhidephone = document.getElementById('correctaddress');
        
        if (houseSave[index]){       
            document.getElementById('housenumberchange').disabled = true;    
            document.getElementById('changeAddr').disabled = true;  
        }
                
        showhidephone.style.display = 'none';                
    }
    
    
    function showHousePhone(index){
        var showhidephone = document.getElementById('phoneinfo');
        
        var disableunits_yes  = document.getElementById('units_yes');  
        var disableunits_no  = document.getElementById('units_no');
        var disablemulti_yes  = document.getElementById('multi_yes');  
        var disablemulti_no  = document.getElementById('multi_no');        
        
        disableunits_yes.disabled = true;
        disableunits_no.disabled = true;  
        disablemulti_yes.disabled = true;
        disablemulti_no.disabled = true;          
        
        showhidephone.style.display = 'block';
        houseMarker[index].setIcon(phone);         
    }
    
    function hideHousePhone(index){
        var showhidephone = document.getElementById('phoneinfo');
        
        var disableunits_yes  = document.getElementById('units_yes');  
        var disableunits_no  = document.getElementById('units_no');
        var disablemulti_yes  = document.getElementById('multi_yes');  
        var disablemulti_no  = document.getElementById('multi_no'); 
        
        if (houseSave[index]){       
            disableunits_yes.disabled = true;
            disableunits_no.disabled = true;  
            disablemulti_yes.disabled = true;
            disablemulti_no.disabled = true;                  
        }
        else {
            disableunits_yes.disabled = false;
            disableunits_no.disabled = false;  
            disablemulti_yes.disabled = false;
            disablemulti_no.disabled = false;             
        }
         
       
        showhidephone.style.display = 'none';
        houseMarker[index].setIcon(house);        
    }
    
    function havePhone(row){
        if (document.getElementById('hasPhone' + row).checked === true){
            document.getElementById('resident' + row).disabled = false;
            document.getElementById('areacode' + row).disabled = false;
            document.getElementById('first3digit' + row).disabled = false;
            document.getElementById('last4digit' + row).disabled = false;                        
        }
        
        if (document.getElementById('hasPhone' + row).checked === false){
            document.getElementById('resident' + row).disabled = true;
            document.getElementById('areacode' + row).disabled = true;
            document.getElementById('first3digit' + row).disabled = true;
            document.getElementById('last4digit' + row).disabled = true;                        
        }        
    }
    
    function havePhoneMulti(row){
        if (document.getElementById('hasPhoneMulti' + row).checked === true){
            document.getElementById('residentMulti' + row).disabled = false;
            document.getElementById('areacodeMulti' + row).disabled = false;
            document.getElementById('first3digitMulti' + row).disabled = false;
            document.getElementById('last4digitMulti' + row).disabled = false;                        
        }
        
        if (document.getElementById('hasPhoneMulti' + row).checked === false){
            document.getElementById('residentMulti' + row).disabled = true;
            document.getElementById('areacodeMulti' + row).disabled = true;
            document.getElementById('first3digitMulti' + row).disabled = true;
            document.getElementById('last4digitMulti' + row).disabled = true;                        
        }        
    }  
    
    function closeHouse(index){
         houseMarker[index].infowindow.close();
    } 
    
    function saveHouse(index){        
        var disableunits_yes  = document.getElementById('units_yes');  
        var disableunits_no  = document.getElementById('units_no');
        var disablemulti_yes  = document.getElementById('multi_yes');  
        var disablemulti_no  = document.getElementById('multi_no');            
        
        disableunits_yes.disabled = true;
        disableunits_no.disabled = true;  
        disablemulti_yes.disabled = true;
        disablemulti_no.disabled = true; 
        
        houseSave[index] = true;
        
        if (document.getElementById('units_yes').checked === true){
            geoCodeUnits(index);
            return;
        }
        else if (document.getElementById('multi_yes').checked === true){
            geoCodeMulti(index);
            return;
        }
        else{
           var bPhone = dataPrepare();
           if(bPhone === 1){
             houseMarker[index].setIcon(phonesaved);
           }else{    
             houseMarker[index].setIcon(housesaved);
           }             
        }
        
        houseMarker[index].infowindow.close();
              
    }
    
    function dataPrepare(){
        var street = document.getElementById('street').value.toString().split(" ");
        var streetname, suffix;
        var suffixes = ['Ave','Blvd','Cir','Ct','Dr','Ln','Pkwy','Pl','Rd','St','Ter','Way'];

        suffixes.forEach(function(s) {
             if (street[street.length - 1] === s){
                 suffix = s;
                 street[street.length - 1] = "";
                 streetname = street.join(" ");
                 streetname = streetname.toString().trim();
             }
         }); 

        var houses = [];
        var upsert;
        var addressguid = '';
        var bphone = 0;
        var bunit = 0;
        var bmulti = 0;
        var phoneinfo = '';
        var resident = '';
        var building = '';
        var unit = '';
        var buildingname = '';

        if (document.getElementById('addressguid').value === ''){
            upsert = 'insert';                                                                                   
        }
        else{
            upsert = 'update';
            addressguid = document.getElementById('addressguid').value;
        }

        if (document.getElementById('phone_yes').checked === true){
            bphone = 1;
        }

        if (document.getElementById('resident').value === ''){
            resident = '';
        }
        else{
            resident = document.getElementById('resident').value;
        }

        if (document.getElementById('areacode').value === '' || document.getElementById('first3digit').value === '' || document.getElementById('last4digit').value === ''){                            
            phoneinfo = '';
        }
        else{
            phoneinfo = '(' + document.getElementById('areacode').value + ') ' + document.getElementById('first3digit').value + '-' + document.getElementById('last4digit').value;                    
        }

        
        houses.push({event: true,
                     action: upsert,
                     placeid: document.getElementById('place_id').value,
                     addressguid: addressguid,
                     lat: document.getElementById('latitude').value,
                     lng: document.getElementById('longitude').value,
                     isUnit: bunit,
                     isMultihouse: bmulti,
                     formattedaddress: document.getElementById('formatted_address').value,
                     formattedxyaddress: document.getElementById('formatted_address').value,
                     street: streetname,
                     suffix: suffix,
                     building: building,
                     unit: unit,
                     hasPhone:bphone,
                     residentname: resident,
                     phone:phoneinfo,
                     buildingname:buildingname
                 });



       //send data and return guid(key)
         var key = executeData(houses,false,-1);  
         
         if (bphone===1){             
             return 1;
         }else{
             return 0;
         }
         
    }
    
    function dataPrepare_(row,isUnit,isMulti){
        //prepare data
        alert("update data");
         var street = document.getElementById('street').value.toString().split(" ");
         var streetname, suffix;
         var suffixes = ['Ave','Blvd','Cir','Ct','Dr','Ln','Pkwy','Pl','Rd','St','Ter','Way'];

         suffixes.forEach(function(s) {
              if (street[street.length - 1] === s){
                  suffix = s;
                  street[street.length - 1] = "";
                  streetname = street.join(" ");
                  streetname = streetname.toString().trim();
              }
         }); 

         var houses = [];
         var upsert;
         var addressguid = '';
         var bphone = 0;
         var bunit = 0;
         var bmulti = 0;
         var phoneinfo = '';
         var resident = '';
         var building = '';
         var unit = '';
         var buildingname = '';
         var address = '';

        if (isUnit){
         bunit = 1; 
         document.getElementById('eventUnit' + row).value = "false"; 
         
         document.getElementById('hasPhone' + row).disabled = true;
         document.getElementById('resident' + row).disabled = true;
         document.getElementById('areacode' + row).disabled = true;
         document.getElementById('first3digit' + row).disabled = true;
         document.getElementById('last4digit' + row).disabled = true;
         document.getElementById('bldgname').disabled = true;
         
         if (document.getElementById('addressguid1' + row).value === ''){
             upsert = 'insert';                                                                                   
         }
         else{
             upsert = 'update';
             addressguid = document.getElementById('addressguid1' + row).value;
         }

         if (document.getElementById('address' + row).value === ''){
             address = '';
         }
         else{
             address = document.getElementById('address' + row).value;
         }
         
         if (document.getElementById('bldgname').value === ''){
             buildingname = '';
         }
         else{
             buildingname = document.getElementById('bldgname').value;
         }

         if (document.getElementById('hasPhone' + row).checked === true){
             bphone = 1;

         }

         if (document.getElementById('resident' + row).value === ''){
             resident = '';
         }
         else{
             resident = document.getElementById('resident' + row).value;
         }

         if (document.getElementById('areacode' + row).value === '' || document.getElementById('first3digit' + row).value === '' || document.getElementById('last4digit' + row).value === ''){                            
             phoneinfo = '';
         }
         else{
             phoneinfo = '(' + document.getElementById('areacode' + row).value + ') ' + document.getElementById('first3digit' + row).value + '-' + document.getElementById('last4digit' + row).value;                    
         }

         if (document.getElementById('apt' + row).value === ''){
             unit = '';
         }
         else{
             unit = document.getElementById('apt' + row).value;
         }

         if (document.getElementById('building' + row).value === ''){
             building = '';
         }
         else{
             building = document.getElementById('building' + row).value;
         }

        }

        if (isMulti){
         bmulti = 1;
         document.getElementById('eventMulti' + row).value = "false";
         
         document.getElementById('hasPhoneMulti' + row).disabled = true;
         document.getElementById('residentMulti' + row).disabled = true;
         document.getElementById('areacodeMulti' + row).disabled = true;
         document.getElementById('first3digitMulti' + row).disabled = true;
         document.getElementById('last4digitMulti' + row).disabled = true;
         
         if (document.getElementById('addressguid1Multi' + row).value === ''){
             upsert = 'insert';                                                                                  
         }
         else{
             upsert = 'update';
             addressguid = document.getElementById('addressguid1Multi' + row).value;
         }
         
         if (document.getElementById('addressMulti' + row).value === ''){
             address = '';
         }
         else{
             address = document.getElementById('addressMulti' + row).value;
         }         

         if (document.getElementById('hasPhoneMulti' + row).checked === true){
             bphone = 1;

         }

         if (document.getElementById('residentMulti' + row).value === ''){
             resident = '';
         }
         else{
             resident = document.getElementById('residentMulti' + row).value;
         }

         if (document.getElementById('areacodeMulti' + row).value === '' || document.getElementById('first3digitMulti' + row).value === '' || document.getElementById('last4digitMulti' + row).value === ''){                            
             phoneinfo = '';
         }
         else{
             phoneinfo = '(' + document.getElementById('areacodeMulti' + row).value + ') ' + document.getElementById('first3digitMulti' + row).value + '-' + document.getElementById('last4digitMulti' + row).value;                    
         }                        
        }



         houses.push({event: true,
                      action: upsert,
                      placeid: document.getElementById('place_id').value,
                      addressguid: addressguid,
                      lat: document.getElementById('latitude').value,
                      lng: document.getElementById('longitude').value,
                      isUnit: bunit,
                      isMultihouse: bmulti,
                      formattedaddress: address,
                      formattedxyaddress: document.getElementById('formatted_address').value,
                      street: streetname,
                      suffix: suffix,
                      building: building,
                      unit: unit,
                      hasPhone:bphone,
                      residentname: resident,
                      phone:phoneinfo,
                      buildingname:buildingname
                  });



        //send data and return guid(key)
         var key = executeData(houses,false,row);         
    }
    function dataPrepare_Geocode(address,row,isUnit,isMulti){
        //prepare data
        alert("geocode address and insert data");
         var street = document.getElementById('street').value.toString().split(" ");
         var streetname, suffix;
         var suffixes = ['Ave','Blvd','Cir','Ct','Dr','Ln','Pkwy','Pl','Rd','St','Ter','Way'];

         suffixes.forEach(function(s) {
              if (street[street.length - 1] === s){
                  suffix = s;
                  street[street.length - 1] = "";
                  streetname = street.join(" ");
                  streetname = streetname.toString().trim();
              }
         }); 

         var houses = [];
         var upsert;
         var addressguid = '';
         var bphone = 0;
         var bunit = 0;
         var bmulti = 0;
         var phoneinfo = '';
         var resident = '';
         var building = '';
         var unit = '';
         var buildingname = '';

        if (isUnit){
         bunit = 1; 
         document.getElementById('eventUnit' + row).value = "false";
         
         document.getElementById('hasPhone' + row).disabled = true;
         document.getElementById('resident' + row).disabled = true;
         document.getElementById('areacode' + row).disabled = true;
         document.getElementById('first3digit' + row).disabled = true;
         document.getElementById('last4digit' + row).disabled = true;
         document.getElementById('bldgname').disabled = true;
         
         document.getElementById('address' + row).value = address;
         document.getElementById('editUnit' + row).innerHTML = '<input type = "button" id = "edit"  value = "edit" onclick="editRow(true,false,' + row + ')" style="padding: 4px 16px;">'; 
         document.getElementById('editBuilding').innerHTML = '<input type = "button" id = "edit"  value = "edit" onclick="editBuilding()" style="padding: 4px 16px;">'; 
         document.getElementById('geoCoded' + row).value = "true";
         document.getElementById('xyaddress' + row).value = document.getElementById('formatted_address').value;                           
         document.getElementById('building' + row).disabled = true;
         document.getElementById('apt' + row).disabled = true;

         if (document.getElementById('addressguid1' + row).value === ''){
             upsert = 'insert';                                                                                   
         }
         else{
             upsert = 'update';

             addressguid = document.getElementById('addressguid1' + row).value;
         }

        // bldgname
         if (document.getElementById('bldgname').value === ''){
             buildingname = '';
         }
         else{
             buildingname = document.getElementById('bldgname').value;
         }

         if (document.getElementById('hasPhone' + row).checked === true){
             bphone = 1;

         }

         if (document.getElementById('resident' + row).value === ''){
             resident = '';
         }
         else{
             resident = document.getElementById('resident' + row).value;
         }

         if (document.getElementById('areacode' + row).value === '' || document.getElementById('first3digit' + row).value === '' || document.getElementById('last4digit' + row).value === ''){                            
             phoneinfo = '';
         }
         else{
             phoneinfo = '(' + document.getElementById('areacode' + row).value + ') ' + document.getElementById('first3digit' + row).value + '-' + document.getElementById('last4digit' + row).value;                    
         }

         if (document.getElementById('apt' + row).value === ''){
             unit = '';
         }
         else{
             unit = document.getElementById('apt' + row).value;
         }

         if (document.getElementById('building' + row).value === ''){
             building = '';
         }
         else{
             building = document.getElementById('building' + row).value;
         }

        }

        if (isMulti){
         bmulti = 1;
         document.getElementById('eventMulti' + row).value = "false";
         
         document.getElementById('hasPhoneMulti' + row).disabled = true;
         document.getElementById('residentMulti' + row).disabled = true;
         document.getElementById('areacodeMulti' + row).disabled = true;
         document.getElementById('first3digitMulti' + row).disabled = true;
         document.getElementById('last4digitMulti' + row).disabled = true;
                  
         document.getElementById('addressMulti' + row).value = address;
         document.getElementById('editMulti' + row).innerHTML = '<input type = "button" id = "edit"  value = "edit" onclick="editRow(false,true,' + row + ')" style="padding: 4px 16px;">'; 
         document.getElementById('geoCodedMulti' + row).value = "true";
         document.getElementById('xyaddressMulti' + row).value = document.getElementById('formatted_address').value;                             
         document.getElementById('houseMulti' + row).disabled = true;  

         if (document.getElementById('addressguid1Multi' + row).value === ''){
             upsert = 'insert';                                                                                  
         }
         else{
             upsert = 'update';

             addressguid = document.getElementById('addressguid1Multi' + row).value;
         }

         if (document.getElementById('hasPhoneMulti' + row).checked === true){
             bphone = 1;

         }

         if (document.getElementById('residentMulti' + row).value === ''){
             resident = '';
         }
         else{
             resident = document.getElementById('residentMulti' + row).value;
         }

         if (document.getElementById('areacodeMulti' + row).value === '' || document.getElementById('first3digitMulti' + row).value === '' || document.getElementById('last4digitMulti' + row).value === ''){                            
             phoneinfo = '';
         }
         else{
             phoneinfo = '(' + document.getElementById('areacodeMulti' + row).value + ') ' + document.getElementById('first3digitMulti' + row).value + '-' + document.getElementById('last4digitMulti' + row).value;                    
         }                        
        }



         houses.push({event: true,
                      action: upsert,
                      placeid: document.getElementById('place_id').value,
                      addressguid: addressguid,
                      lat: document.getElementById('latitude').value,
                      lng: document.getElementById('longitude').value,
                      isUnit: bunit,
                      isMultihouse: bmulti,
                      formattedaddress: address,
                      formattedxyaddress: document.getElementById('formatted_address').value,
                      street: streetname,
                      suffix: suffix,
                      building: building,
                      unit: unit,
                      hasPhone:bphone,
                      residentname: resident,
                      phone:phoneinfo,
                      buildingname:buildingname
                  });



        //send data and return guid(key)
         var key = executeData(houses,false,row);        
    }
    
    function executeData(data,buildingevent,row){

       if (data[0].action === 'none'){
           return 0;
       }
       
       //returns message
       if (data[0].action === 'delete'){           
           //connects to database and delete record and returns message
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                     var myJSONResult = JSON.parse(this.responseText);
                      if (myJSONResult[0].Error === "0"){

                      }
                }
            };
            
           xmlhttp.open("GET", "deleteAddress.php?addressguid=" + data[0].addressguid, true);           
           xmlhttp.send();
           
           return 0;
       }
       
       //returns guid
       if (data[0].action === 'update'){
           //connects to database and update record and returns guid
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                     var myJSONResult = JSON.parse(this.responseText);
                      if (myJSONResult[0].Error === "0"){                      

                      }
                }
            };
            
            if (buildingevent === true){
                xmlhttp.open("GET", "updateBuildingName.php?congregationnumber=" + congregationNumber + 
                                    "&territorynumber=" + document.getElementById('Territory').value  + 
                                    "&placeid=" + data[0].placeid + 
                                    "&buildingname=" + data[0].buildingname, true);                
            }
            if (buildingevent === false){
                xmlhttp.open("GET", "updateAddress.php?congregationnumber=" + congregationNumber + 
                                    "&territorynumber=" + document.getElementById('Territory').value  + 
                                    "&addressguid=" + data[0].addressguid + 
                                    "&placeid=" + data[0].placeid + 
                                    "&latitude=" + data[0].lat + 
                                    "&longitude=" + data[0].lng +  
                                    "&formattedAddress=" + data[0].formattedaddress + 
                                    "&formattedxyAddress=" + data[0].formattedxyaddress + 
                                    "&street=" + data[0].street +
                                    "&streetsuffix=" + data[0].suffix +
                                    "&bmulti=" + data[0].isMultihouse +
                                    "&bunit=" + data[0].isUnit + 
                                    "&bphone=" + data[0].hasPhone +
                                    "&resident=" + data[0].residentname +
                                    "&phone=" + data[0].phone +
                                    "&building=" + data[0].building +
                                    "&unit=" + data[0].unit, true);
            }
            xmlhttp.send();
           
           return 0;
       }  
       
       //returns guid
       if (data[0].action === 'insert'){
           //connects to database and insert record and returns guid
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                     var myJSONResult = JSON.parse(this.responseText);
                      if (myJSONResult[0].Error === "0"){
                          if(data[0].isUnit === 1){
                           document.getElementById('addressguid1' + row).value = myJSONResult[0].GUID;
                          }
                          if(data[0].isMultihouse === 1){
                           document.getElementById('addressguid1Multi' + row).value = myJSONResult[0].GUID;
                          }
                                                      
                      }
                }
            };
            
                        
            xmlhttp.open("GET", "addAddress.php?congregationnumber=" + congregationNumber + 
                                "&territorynumber=" + document.getElementById('Territory').value  + 
                                "&placeid=" + data[0].placeid + 
                                "&latitude=" + data[0].lat + 
                                "&longitude=" + data[0].lng +  
                                "&formattedAddress=" + data[0].formattedaddress + 
                                "&formattedxyAddress=" + data[0].formattedxyaddress + 
                                "&street=" + data[0].street +
                                "&streetsuffix=" + data[0].suffix +
                                "&bmulti=" + data[0].isMultihouse +
                                "&bunit=" + data[0].isUnit + 
                                "&bphone=" + data[0].hasPhone +
                                "&resident=" + data[0].residentname +
                                "&phone=" + data[0].phone +
                                "&building=" + data[0].building +
                                "&unit=" + data[0].unit + 
                                "&buildingname=" + data[0].buildingname, true);


           xmlhttp.send();
           
           return 1;
       }         
    }
    
    
    function editBuilding(){
            document.getElementById('bldgname').disabled = false;
            document.getElementById('eventBuilding').value = "true";
    }
    
    function editRow(isUnit,isMulti,row){
        if (isUnit === true){
            document.getElementById('eventUnit' + row).value = "true";
            
            document.getElementById('hasPhone' + row).disabled = false;
            document.getElementById('resident' + row).disabled = false;
            document.getElementById('areacode' + row).disabled = false;
            document.getElementById('first3digit' + row).disabled = false;
            document.getElementById('last4digit' + row).disabled = false;             
        }
        if (isMulti === true){
            document.getElementById('eventMulti' + row).value = "true";  
            
            document.getElementById('hasPhoneMulti' + row).disabled = false;
            document.getElementById('residentMulti' + row).disabled = false;
            document.getElementById('areacodeMulti' + row).disabled = false;
            document.getElementById('first3digitMulti' + row).disabled = false;
            document.getElementById('last4digitMulti' + row).disabled = false;            
        }        
    }
    
    function saveBuilding(){
        alert('update buildingname');
         var houses = [];
         var buildingname = '';
                                    
         document.getElementById('bldgname').disabled = true;
         document.getElementById('eventBuilding').value = "false";
         
         if (document.getElementById('bldgname').value === ''){
             buildingname = '';
         }
         else{
             buildingname = document.getElementById('bldgname').value;
         }         
                  
         houses.push({event: true,
                      action: 'update',
                      placeid: document.getElementById('place_id').value,
                      buildingname:buildingname
                  });


        //send data and return guid(key)
         var key = executeData(houses,true,-1);         
        
    }
    
    
    function geoCodeUnits(index){
        
        for (i = 0;i < 1000;i++){
            if (document.getElementById('row' + i).hidden === false){
                  var building = document.getElementById('building' + i).value;
                  var unit = document.getElementById('apt' + i).value;
                  var address = building + ' ' + document.getElementById('street').value + ', ' + document.getElementById('city').value + ', ' +  document.getElementById('state').value + ' ' + document.getElementById('zipcode').value;                  
                  if (document.getElementById('geoCoded' + i).value === "false"){    
                    if (building !== '' && unit !== ''){geoCodeAddress(address, i, true, false);}
                  }
                  else if (document.getElementById('eventUnit' + i).value === "true"){
                      dataPrepare_(i,true,false);
                  }
                  else if (document.getElementById('eventBuilding').value === "true"){
                      saveBuilding();
                  }
            }
        }
                        
 
    }
    
 
    function geoCodeMulti(index){
        
        for (i = 0;i < 10;i++){
            if (document.getElementById('rowmulti' + i).hidden === false){
                  var house = document.getElementById('houseMulti' + i).value;
                  var address = house  + ' ' + document.getElementById('street').value + ', ' + document.getElementById('city').value + ', ' +  document.getElementById('state').value + ' ' + document.getElementById('zipcode').value;
                  if (document.getElementById('geoCodedMulti' + i).value === "false"){ 
                    if (house !== ''){geoCodeAddress(address,i, false, true);}
                  } 
                  else if (document.getElementById('eventMulti' + i).value === "true"){
                      dataPrepare_(i,false, true);
                  }                  
            }
        }
                        
 
    }    
    
    
    function geoCodeAddress(address,row,isUnit,isMulti){ 
        geocoder.geocode({'address': address}, function(results, status) {
             if (status === google.maps.GeocoderStatus.OK) { 
                   if (results[0].address_components[0].types[0]=== 'street_number'){
                        var address2 = results[0].formatted_address;
                        dataPrepare_Geocode(address2,row,isUnit,isMulti);
                   }
             }

        });
                
    }
    
    
    function addRowUnit(index){
        houseUnit[index]+=1;
        numOfhouses+=1;
        document.getElementById('row' + houseUnit[index]).hidden = false; 
        //document.getElementById('addrow' + (houseUnit[index]-1)).innerHTML = '<input type = "button" id = "add"  value = "-" onclick="removeRowUnit(' + index + ',' + (houseUnit[index]-1) + ')" style="padding: 4px 16px;">'; 
        document.getElementById('addrow' + (houseUnit[index]-1)).innerHTML = '<input type = "button" id = "add"  value = "+" onclick="addRowUnit(' + index + ')" style="padding: 4px 16px;"><input type = "button" id = "add"  value = "-" onclick="removeRowUnit('  + index + ',' + (houseUnit[index]-1) + ')" style="padding: 4px 16px;">'; 
        document.getElementById('addrow' + houseUnit[index]).innerHTML = '<input type = "button" id = "add"  value = "+" onclick="addRowUnit(' + index + ')" style="padding: 4px 16px;"><input type = "button" id = "add"  value = "-" onclick="removeRowUnit('  + index + ',' + houseUnit[index] + ')" style="padding: 4px 16px;">';     
        
        var d = new Date();
        document.getElementById('HouseChanged').value = true;
        document.getElementById('HouseAction').innerHTML = "action: created";
        document.getElementById('HouseTotal').innerHTML = "homes: 0/" + numOfhouses;
        document.getElementById('HouseDateModified').innerHTML = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
     }
     
    function addRowMulti(index){
        houseMulti[index]+=1;
        numOfhouses+=1;
        document.getElementById('rowmulti' + houseMulti[index]).hidden = false; 
        //document.getElementById('addrowmulti' + (houseMulti[index]-1)).innerHTML = '<input type = "button" id = "add"  value = "-" onclick="removeRowMulti(' + index + ',' + (houseMulti[index]-1) + ')" style="padding: 4px 16px;">'; 
        document.getElementById('addrowmulti' + (houseMulti[index]-1)).innerHTML = '<input type = "button" id = "add"  value = "+" onclick="addRowMulti(' + index + ')" style="padding: 4px 16px;"><input type = "button" id = "add"  value = "-" onclick="removeRowMulti('  + index + ',' + (houseMulti[index]-1) + ')" style="padding: 4px 16px;">';  
        document.getElementById('addrowmulti' + houseMulti[index]).innerHTML = '<input type = "button" id = "add"  value = "+" onclick="addRowMulti(' + index + ')" style="padding: 4px 16px;"><input type = "button" id = "add"  value = "-" onclick="removeRowMulti('  + index + ',' + houseMulti[index] + ')" style="padding: 4px 16px;">';     
        
        var d = new Date();
        document.getElementById('HouseChanged').value = true;
        document.getElementById('HouseAction').innerHTML = "action: created";
        document.getElementById('HouseTotal').innerHTML = "homes: 0/" + numOfhouses;
        document.getElementById('HouseDateModified').innerHTML = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
     }     
     
   function removeRowUnit(index,row){

       
//
 
//                if (confirm("Are you sure you want to remove property?") === true) {
      //prepare data
      var houses = [];
      var upsert;
      var addressguid = '';
        
      if (document.getElementById('addressguid1' + row).value === ''){
          upsert = 'none';
      }
      else{
            upsert = 'delete';
            addressguid = document.getElementById('addressguid1' + row).value;
      }

        houses.push({  event:true,
             action:upsert,
             addressguid:addressguid
         });

        if (upsert==='none'){
            //send data and return guid(key)
             var key = executeData(houses,false,row);

             numOfhouses-=1;
             document.getElementById('row' + row).hidden = true; 
        }
        
         if (upsert==='delete'){
             if (confirm("Are you sure you want to remove property?") === true){
                //send data and return guid(key)
                 var key = executeData(houses,false,row);

                 numOfhouses-=1;
                 document.getElementById('row' + row).hidden = true; 
            }
        }
      
        var d = new Date();
        document.getElementById('HouseChanged').value = true;
        document.getElementById('HouseAction').innerHTML = "action: delete";
        document.getElementById('HouseTotal').innerHTML = "homes: 0/" + numOfhouses;
        document.getElementById('HouseDateModified').innerHTML = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());       
       
    }
    
   function removeRowMulti(index,row){                      
        //prepare data
        var houses = [];
        var upsert;
        var addressguid = '';


        if (document.getElementById('addressguid1Multi' + row).value === ''){
            upsert = 'none';
        }
        else{
            upsert = 'delete';
            addressguid = document.getElementById('addressguid1Multi' + row).value;
        }

        houses.push({  event:true,
                       action:upsert,
                       addressguid:addressguid
                   });

        if (upsert==='none'){
            //send data and return guid(key)
             var key = executeData(houses,false,row);

             numOfhouses-=1;
             document.getElementById('rowmulti' + row).hidden = true;  
        }
        
        if (upsert==='delete'){
             if (confirm("Are you sure you want to remove property?") === true){
                //send data and return guid(key)
                 var key = executeData(houses,false,row);

                 numOfhouses-=1;
                 document.getElementById('rowmulti' + row).hidden = true;  
            }
        }
            
        var d = new Date();
        document.getElementById('HouseChanged').value = true;
        document.getElementById('HouseAction').innerHTML = "action: delete";
        document.getElementById('HouseTotal').innerHTML = "homes: 0/" + numOfhouses;
        document.getElementById('HouseDateModified').innerHTML = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());       
       
    }    
    
    function removeTerritory(territoryname){
        if(confirm("Do you want to delete " + territoryname + "?") === true){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                     var myJSONResult = JSON.parse(this.responseText);
//                      if (myJSONResult[0].Error === "0"){                              
                         newmap();
                         document.getElementById('rowid' + territoryname).hidden = true;
//                      }
                }
            };

            xmlhttp.open("GET", "removeTerritory.php?congregationnumber=" + congregationNumber + "&territorynumber=" + territoryname, true);             
            xmlhttp.send();    
        }
    }
    
    
    function ZeroPadding(number){
        if (number.toString().length == 1) {return "0" + number.toString();}
        else {
            return number.toString();
        };
    }; 
    
    function newmap(){
        territoryassigned = false;                   
        defaultview = false; 
        
        polymarker = [];
        polygon=null;
        rectangle=null;
        compassMarker=null;
        polygonCoordinates = [];
        polygonStack = [];
        
        
        properties = [
                           {layer:"polygon",action:"none",datemodified:"yyyy-mm-dd hh:mm:ss",draggable:"false",draggablechange:"false"},
                           {layer:"rectangle",action:"none",datemodified:"yyyy-mm-dd hh:mm:ss",draggable:"false",draggablechange:"false"},
                           {layer:"compass",action:"none",datemodified:"yyyy-mm-dd hh:mm:ss",draggable:"false",draggablechange:"false"}
                         ];
        
        houseMarker = []; 
        houseUnit = [];
        houseMulti = []; 
        houseSave = [];
        numOfhouses = 0;   
        
        document.getElementById('Territory').value = "Terr1";  

        document.getElementById('PolygonChanged').innerHTML = "false";
        document.getElementById('PolygonAction').innerHTML = "action: none";
        document.getElementById('PolygonDateModified').innerHTML = "date: yyyy-mm-dd hh:mm:ss";                
        document.getElementById('PolygonBounds').innerHTML = "bounds: x,y";    
        
        document.getElementById('RectangleChanged').innerHTML = "false";
        document.getElementById('RectangleAction').innerHTML = "action: none";
        document.getElementById('RectangleDateModified').innerHTML = "date: yyyy-mm-dd hh:mm:ss";
        document.getElementById('RectangleCenter').innerHTML = "center: x,y";
        document.getElementById('RectangleBounds').innerHTML = "bounds: x,y";   
        
        document.getElementById('HouseChanged').innerHTML = "false";
        document.getElementById('HouseAction').innerHTML = "action: none";
        document.getElementById('HouseDateModified').innerHTML = "date: yyyy-mm-dd hh:mm:ss";
        document.getElementById('HouseTotal').innerHTML = "homes: 0"; 
        
        document.getElementById('CompassChanged').innerHTML = "false";
        document.getElementById('CompassAction').innerHTML = "action: none";
        document.getElementById('CompassDateModified').innerHTML = "date: yyyy-mm-dd hh:mm:ss";
        document.getElementById('CompassLatLng').innerHTML = "latlng: x,y";  
        
        document.getElementsByName('Polygon').checked = true;                 
        document.getElementsByName('Rectangle').checked = true; 
        document.getElementsByName('House').checked = true;  
        document.getElementsByName('Compass').checked = true; 
        
        getCoordinates();
        initialize();
        disableLayers("layer");

    
    }
    
    function getTerritoryInfo(){
      document.getElementById('Territory').value = territorynumber; 
      document.getElementById('sortup' + territorynumber).innerHTML = '<img src = "icons/sortup2.png" onclick="sortUp()"/>';
      document.getElementById('sortdown' + territorynumber).innerHTML = '<img src = "icons/sortdown2.png" onclick="sortDown()"/>';            
      document.getElementById('trashbin' + territorynumber).innerHTML = '<img src = "icons/trashbinsymbol2.png" onclick="removeTerritory('+ '\'' + territorynumber + '\'' + ')"/>';
      territoryassigned = true;
      //initialMap(28.53555,-81.34978,17);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             var myJSONResult = JSON.parse(this.responseText);
             var center_  = myJSONResult[0].Center;
             var rectangle_ = JSON.parse(myJSONResult[0].Rectangle);  
             var compass_ = myJSONResult[0].Compass;
             var zoom_ = Number(myJSONResult[0].Zoom);
             var polygon_ = JSON.parse(myJSONResult[0].Polygon);
             var properties_ = JSON.parse(myJSONResult[0].Properties);
             var default_ =  Number(myJSONResult[0].DefaultView);
                     
             var latlng = center_.split(',');
             var latitude = Number(latlng[0].toString().trim());
             var longitude = Number(latlng[1].toString().trim()); 
             var rectanglehtml = '<table><tr><td>Rectangle</td><td align="right"><div class="toolbartip"><img src = "icons/trashbinsymbol.png" onclick="removeRectangle()"/><span class="toolbartiptext">delete</span></div></td></tr></table>';
             var polygonhtml = '<table><tr><td>Polygon</td><td align="right"><div class="toolbartip"><img src = "icons/trashbinsymbol.png" onclick="removePolygon()"/><span class="toolbartiptext">delete</span></div></td></tr></table>';
             var compasshtml = '<table><tr><td>Compass</td><td align="right"><div class="toolbartip"><img src = "icons/trashbinsymbol.png" onclick="removeCompass()"/><span class="toolbartiptext">delete</span></div></td></tr></table>';
             initialMap(latitude,longitude,zoom_);
             topPanel();
             properties[0].action = properties_[0].action;
             properties[0].datemodified = properties_[0].datemodified;
             
             properties[1].action = properties_[1].action;
             properties[1].datemodified = properties_[1].datemodified;
             properties[1].draggable = properties_[1].draggable;
             properties[1].draggablechange = properties_[1].draggablechange;  
             
             properties[2].action = properties_[2].action;
             properties[2].datemodified = properties_[2].datemodified;
             properties[2].draggable = properties_[2].draggable;
             properties[2].draggablechange = properties_[2].draggablechange;  
             
             document.getElementById('defaultterritoryview').value = default_ === 1? "true":"false";
             document.getElementById('defaultterritoryview').disabled = false;
             
             document.getElementById('PolygonChanged').value = "true";
             document.getElementById('PolygonAction').innerHTML = "action: " + properties[0].action;
             document.getElementById('PolygonDateModified').innerHTML = "date: " + properties[0].datemodified;   
             
             document.getElementById('RectangleChanged').value = "true";
             document.getElementById('RectangleAction').innerHTML = "action: " + properties[1].action;
             document.getElementById('RectangleDateModified').innerHTML = "date: " + properties[1].datemodified;
             
             document.getElementById('CompassChanged').value = "true";
             document.getElementById('CompassAction').innerHTML = "action: " + properties[2].action;
             document.getElementById('CompassDateModified').innerHTML = "date: " + properties[2].datemodified;             
             
              
             
            if (rectangle_){
                rectanglecenter = center_;
                rectangle = new google.maps.Rectangle({
                strokeColor: '#072f72',
                strokeOpacity: 0.8,
                strokeWeight: 5,
                fillColor: '#072f72',
                fillOpacity: 0,
                editable: true,
                draggable: properties[1].draggable === 'true'? true:false,
                bounds: {north:rectangle_[0].north,south:rectangle_[0].south,east:rectangle_[0].east,west:rectangle_[0].west}
                }); 

                rectangle.setMap(map); 
                rectangleInfowindow = new google.maps.InfoWindow({ content: rectanglehtml });     
                rectangleInfowindow.setPosition(rectangle.getBounds().getNorthEast());

                google.maps.event.addListener(rectangle, "click", function() {            
                    rectangleInfowindow.open(map);
                });


                rectangle.addListener('bounds_changed', function() {         
                    var d = new Date();
                    var ne = rectangle.getBounds().getNorthEast();
                    var sw = rectangle.getBounds().getSouthWest();
                    var center = rectangle.getBounds().getCenter();

                    var x_north = parseFloat(parseFloat(ne.lat()).toFixed(5).toString());
                    var y_east = parseFloat(parseFloat(ne.lng()).toFixed(5).toString());
                    var x_south = parseFloat(parseFloat(sw.lat()).toFixed(5).toString());
                    var y_west = parseFloat(parseFloat(sw.lng()).toFixed(5).toString());
                    var bounds = [{north:x_north,south:x_south,east:y_east,west:y_west}];

                    jsonRectangle = JSON.stringify(bounds);

                    document.getElementById('RectangleChanged').value = "true";
                    document.getElementById('RectangleAction').innerHTML = "action: position_changed";
                    document.getElementById('RectangleDateModified').innerHTML = 'date: ' + d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
                    document.getElementById('RectangleCenter').innerHTML = 'center: ' + parseFloat(center.lat()).toFixed(5).toString() + ',' + parseFloat(center.lng()).toFixed(5).toString();
                    document.getElementById('RectangleBounds').innerHTML = 'bounds:' + jsonRectangle.replace(new RegExp(',', 'g'),',<br>').replace('[{','[{<br>');

                    rectanglecenter = parseFloat(center.lat()).toFixed(5).toString() + ',' + parseFloat(center.lng()).toFixed(5).toString();

                    properties[1].action = "position_changed";
                    properties[1].datemodified = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
             });

             selectPointer(); 
             enableLayer("layer",1);             

             var ne = rectangle.getBounds().getNorthEast();
             var sw = rectangle.getBounds().getSouthWest();
             var center = rectangle.getBounds().getCenter();

             var x_north = parseFloat(parseFloat(ne.lat()).toFixed(5).toString());
             var y_east = parseFloat(parseFloat(ne.lng()).toFixed(5).toString());
             var x_south = parseFloat(parseFloat(sw.lat()).toFixed(5).toString());
             var y_west = parseFloat(parseFloat(sw.lng()).toFixed(5).toString());
             var bounds = [{north:x_north,south:x_south,east:y_east,west:y_west}];

             jsonRectangle = JSON.stringify(bounds);

             document.getElementById('RectangleCenter').innerHTML = 'center: ' + parseFloat(center.lat()).toFixed(5).toString() + ',' + parseFloat(center.lng()).toFixed(5).toString();
             document.getElementById('RectangleBounds').innerHTML = 'bounds:' + jsonRectangle.replace(new RegExp(',', 'g'),',<br>').replace('[{','[{<br>');             
             document.getElementById('rectangledraggable').value = properties[1].draggable;
             document.getElementById('rectangledraggable').disabled = false;
        }
        
        
         if (polygon_){                         
            polygon = new google.maps.Polygon({
                   paths: polygon_,
                   strokeColor: '#072f72',
                   strokeOpacity: 0.8,
                   strokeWeight: 2,
                   fillColor: '#072f72',
                   fillOpacity: 0.05,
                   editable: true
             });

             polygon.setMap(map);

             polygonInfowindow = new google.maps.InfoWindow({ content: polygonhtml });     
             polygonInfowindow.setPosition(center_);

             google.maps.event.addListener(polygon, "click", function() {            
               polygonInfowindow.open(map);
              }); 

             google.maps.event.addListener(polygon.getPath(), "insert_at", setPolygonProperties);             
             google.maps.event.addListener(polygon.getPath(), "set_at", setPolygonProperties);    

             selectPointer();
             enableLayer("layer",0);  

             jsonPolygon = JSON.stringify(polygon_);
             document.getElementById('PolygonBounds').innerHTML = "bounds:<br>" + jsonPolygon; 
         }
         
        if (compass_){ 
            compass = compass_;
            var myInfowindow = new google.maps.InfoWindow({ content: compasshtml });
            var latlng_ = compass_.toString().split(',');
            var lat = Number(latlng_[0].toString().trim());
            var lng = Number(latlng_[1].toString().trim());

            compassMarker = new google.maps.Marker({
              position: {lat:lat,lng:lng},
              title: 'North Compass',
                       icon: {
                                path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,                            
                                scale: 12
                             }, 
              draggable: properties[2].draggable === 'true'? true:false,                          
              map: map,
              infowindow: myInfowindow
            });

            compassMarker.setMap(map);
            google.maps.event.addListener(compassMarker, "click", function () {this.infowindow.open(map, this);});           

            google.maps.event.addListener(compassMarker, "dragend", function (event) {
                 var LatLng = event.latLng;
                 var d = new Date();
                 document.getElementById('CompassChanged').value = "true";
                 document.getElementById('CompassAction').innerHTML = "action: position_changed";
                 document.getElementById('CompassDateModified').innerHTML = 'date: ' + d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
                 document.getElementById('CompassLatLng').innerHTML = 'latlng: ' + parseFloat(LatLng.lat()).toFixed(5).toString() + ', ' + parseFloat(LatLng.lng()).toFixed(5).toString();

                 compass = parseFloat(LatLng.lat()).toFixed(5).toString() + ', ' + parseFloat(LatLng.lng()).toFixed(5).toString();

                 properties[2].action = "position_changed";
                 properties[2].datemodified = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
            });

            selectPointer(); 
            enableLayer("layer",3);
            document.getElementById('CompassLatLng').innerHTML = 'latlng: ' + lat + ', ' + lng ;
            document.getElementById('compassdraggable').value = properties[2].draggable;
            document.getElementById('compassdraggable').disabled = false;
        } 
          getProperty(territorynumber);

         }
        };
    xmlhttp.open("GET", "getTerritoryInfo.php?congregationnumber=" + congregationNumber + "&territorynumber=" + territorynumber, true);
    xmlhttp.send(); 
      
    }
    
    function getProperty(territorynumber){
        var xmlhttp1 = new XMLHttpRequest();
        xmlhttp1.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             var myJSONResult = JSON.parse(this.responseText);
             for(i=0;i<myJSONResult.length;i++){
                  var phonetag;
                  var icon_;
                  var lat = Number(myJSONResult[i].Latitude);
                  var lng = Number(myJSONResult[i].Longitude); 
                  var housesplit = myJSONResult[i].FormattedAddress.toString().split(' ');
                  var housenumber = housesplit[0];                  
                  var address = myJSONResult[i].FormattedAddress.toString().replace(housenumber,'');   
                  
                  if(myJSONResult[i].bPhone === "0"){
                  icon_ = housesaved;    
                  phonetag = '<table><tr><form action=""><td><input type="radio" name="havePhone" id = "phone_yes" value="yes" style="width: 30px;" onclick="showHousePhone(' + i.toString() + ')">Yes</td>' +
                  '<td><input type="radio" name="havePhone" id = "phone_no"  value="no"  style="width: 30px;" onclick="hideHousePhone(' + i.toString() + ')" checked>No</td></form></tr></table>' +
                  '<div id="phoneinfo" style="display:none;">' + 
                  '<table><tr><td>Resident</td><td>Phone</td></tr><tr><td><input id="resident" type="text"></td><td>(<input id="areacode" type="text" style="width: 30px;" maxlength="3">)<input id="first3digit" type="text" style="width: 30px;" maxlength="3">-<input id="last4digit" type="text" style="width: 40px;" maxlength="4"></td></tr></table></div></div></div>';
                 }
                  if(myJSONResult[i].bPhone === "1"){ 
                  icon_= phonesaved;
                  var areacode = myJSONResult[i].Phone.toString().replace('(','').replace(')','').replace(' ','').replace('-','').substring(0,3); 
                  var first3digit = myJSONResult[i].Phone.toString().replace('(','').replace(')','').replace(' ','').replace('-','').substring(3,6); 
                  var last4digit = myJSONResult[i].Phone.toString().replace('(','').replace(')','').replace(' ','').replace('-','').substring(6,10);
                  
                  phonetag = '<table><tr><form action=""><td><input type="radio" name="havePhone" id = "phone_yes" value="yes" style="width: 30px;" onclick="showHousePhone(' + i.toString() + ')" checked>Yes</td>' +
                  '<td><input type="radio" name="havePhone" id = "phone_no"  value="no"  style="width: 30px;" onclick="hideHousePhone(' + i.toString() + ')">No</td></form></tr></table>' +
                  '<div id="phoneinfo" style="display:block;">' + 
                  '<table><tr><td>Resident</td><td>Phone</td></tr><tr><td><input id="resident" type="text" value="' + myJSONResult[i].Resident + '"></td>' + 
                  '<td>(<input id="areacode" type="text" value="' + areacode + '" style="width: 30px;" maxlength="3">)' + 
                  '<input id="first3digit" type="text" value="' + first3digit + '" style="width: 30px;" maxlength="3">-' + 
                  '<input id="last4digit" type="text" value="' + last4digit + '" style="width: 40px;" maxlength="4"></td></tr></table></div></div></div>';                            
                  }      
                  
                var html = '<table><tr><td id="addressHeader"><h3><p><b>' + myJSONResult[i].FormattedAddress + '</h3></p></b></td></tr></table>' +
                        '<input type = "hidden" id = "formatted_address" value = "' + myJSONResult[i].FormattedAddress + '">' + 
                        '<input type = "hidden" id = "place_id" value = "' + myJSONResult[i].PlaceID + '">' + 
                        '<input type = "hidden" id = "addressguid" value = "' + myJSONResult[i].AddressGUID + '">' +               
                        '<input type = "hidden" id = "latitude" value = "' + Number(myJSONResult[i].Latitude) + '">' + 
                        '<input type = "hidden" id = "longitude" value = "' + Number(myJSONResult[i].Longitude) + '">' +  
                        '<input type = "hidden" id = "street" value = "">' + 
                        '<input type = "hidden" id = "city" value = "">' +
                        '<input type = "hidden" id = "state" value = "">' + 
                        '<input type = "hidden" id = "zipcode" value = "">' +  
                        
                        '<div id="addresscorrect" style="display:block;">' + 
                        '<table><tr><td>Does the above address need correction?</td></tr></table>' +
                        '<table><tr><form action=""><td><input type="radio" name="correct" id = "needcorrection_yes" value="yes" style="width: 30px;" onclick="showAddressCorrection(' + houseMarker.length + ')">Yes</td>' +
                        '<td><input type="radio" name="correct" id = "needcorrection_no"  value="no"  style="width: 30px;" onclick="hideAddressCorrection(' + houseMarker.length + ')" checked>No</td></form></tr></table>' +                
                        '<div id="correctaddress" style="display:none;">' +
                        '<table><tr><td><input id="housenumberchange" type="text" value="' + housenumber + '"></td><td id="addresssplit">' + address + '</td></tr></table>' +
                        '<table><tr><td><input id="changeAddr" type="button" value="change" onclick="changeAddress(' + houseMarker.length + ')" style="padding: 8px 32px;"></td></tr></table>' +        
                        '</div></div>' +                            

                        '<div id="units0" style="display:block;">' +                  
                        '<table><tr><td>Is this an apartment building?</td></tr></table>' +
                        '<table><tr><form action=""><td><input type="radio" name="haveUnits" id = "units_yes" value="yes" style="width: 30px;" onclick="showApartment(' + i.toString() + ')" disabled>Yes</td>' +
                        '<td><input type="radio" name="haveUnits" id = "units_no"  value="no"  style="width: 30px;" onclick="hideApartment(' + i.toString() + ')" disabled checked>No</td></form></tr></table>' +
                        '<div id="units" style="display:none;"><div id="apartment"></div></div></div>' +                 

                        '<div id="multi0" style="display:block;">' + 
                        '<table><tr><td>Is this an multifamly house (Ex: duplex, triplex, fourplex)?</td></tr></table>' +
                        '<table><tr><form action=""><td><input type="radio" name="haveMulti" id = "multi_yes" value="yes" style="width: 30px;" onclick="showMultiHouse(' + i.toString() + ')" disabled>Yes</td>' +
                        '<td><input type="radio" name="haveMulti" id = "multi_no"  value="no"  style="width: 30px;" onclick="hideMultiHouse(' + i.toString() + ')" disabled checked>No</td></form></tr></table>' +                
                        '<div id="multi" style="display:none;"><div id="multihouse"></div></div></div>' +                


                        '<div id="phone" style="display:block;"><div id="phonehouse">' +                
                        '<table><tr><td>Does this home have a landline?</td></tr></table>' + phonetag +                        

                        '<table><tr><td><input type="button" value="Save" onclick="saveHouse(' + i.toString() +')" style="padding: 8px 32px;"></td><td><input type="button" value="Cancel" style="padding: 8px 32px;"></td><td><img src = "icons/export.png"></td><td align="right"><div class="toolbartip"><img src = "icons/trashbinsymbol.png" onclick="removeHouse(' + i.toString() +')"><span class="toolbartiptext">delete</span></div></td></tr></table>';
        

                        // Add a new marker at the new plotted point on the polyline.
                        var myinfowindow = new google.maps.InfoWindow({ content: html });        


                        houseMarker.push(new google.maps.Marker({
                          position: {lat:lat,lng:lng},
                          title: myJSONResult[i].FormattedAddress,
                          icon:  icon_,
                          draggable: false,                                                         
                          map: map,
                          infowindow: myinfowindow
                        }));

                        houseMarker[houseMarker.length - 1].setMap(map);          

                        google.maps.event.addListener(houseMarker[houseMarker.length - 1], "click", function () {this.infowindow.open(map, this);}); 
        

                        houseUnit.push(0);
                        houseMulti.push(0);
                        houseSave.push(true);
                        
                        enableLayer("layer",2);
                        numOfhouses+=1;
                         
                        document.getElementById('HouseAction').innerHTML = "action: none";
                        document.getElementById('HouseTotal').innerHTML = "homes: " + numOfhouses;                         
             }
         }
        };
    xmlhttp1.open("GET", "getProperty.php?congregationnumber=" + congregationNumber + "&territorynumber=" + territorynumber + "&bmulti=0&bunit=0", true);
    xmlhttp1.send();   
    
    
        var xmlhttp2 = new XMLHttpRequest();
        xmlhttp2.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             var myJSONResult = JSON.parse(this.responseText);
             var placeid = '';
             var lat;
             var lng;
             var formattedaddress;
             var icon_= multihouse;
             var multitag;
             var gid = 0;
             var rid = 0;
             var last_rid = 0;
             
             for(i=0;i<myJSONResult.length;i++){
                  var housesplit = myJSONResult[i].FormattedAddress.toString().split(' ');
                  var housenumber = housesplit[0];                  
                  var address = myJSONResult[i].FormattedAddress.toString().replace(housenumber,'');   
                  var phonetag;
                  numOfhouses+=1;
                  
                  if (myJSONResult[i].bPhone === "0"){   
                    phonetag =   '<td align="center"><input type="checkbox" id="hasPhoneMulti' + rid + 
                                 '" value="yes" onclick="havePhoneMulti(' + rid + 
                                 ')" disabled></td><td><input id="residentMulti' + rid + 
                                 '" type="text" disabled></td><td>(<input id="areacodeMulti' + rid + 
                                 '" type="text" style="width: 25px;" maxlength="3" disabled>)<input id="first3digitMulti' + rid + 
                                 '" type="text" style="width: 25px;" maxlength="3" disabled>-<input id="last4digitMulti' + rid + 
                                 '" type="text" style="width: 30px;" maxlength="4" disabled></td>' ;
                  }
                  if (myJSONResult[i].bPhone === "1"){ 
                    var areacode = myJSONResult[i].Phone.toString().replace('(','').replace(')','').replace(' ','').replace('-','').substring(0,3); 
                    var first3digit = myJSONResult[i].Phone.toString().replace('(','').replace(')','').replace(' ','').replace('-','').substring(3,6); 
                    var last4digit = myJSONResult[i].Phone.toString().replace('(','').replace(')','').replace(' ','').replace('-','').substring(6,10);
                  
                    phonetag =   '<td align="center"><input type="checkbox" id="hasPhoneMulti' + rid + 
                                 '" value="yes" onclick="havePhoneMulti(' + rid + 
                                 ')" checked disabled></td><td><input id="residentMulti' + rid + 
                                 '" type="text" value="' + myJSONResult[i].Resident + '" disabled></td><td>(<input id="areacodeMulti' + rid + 
                                 '" type="text" value="' + areacode + '" style="width: 25px;" maxlength="3" disabled>)<input id="first3digitMulti' + rid + 
                                 '" type="text" value="' + first3digit + '" style="width: 25px;" maxlength="3" disabled>-<input id="last4digitMulti' + rid + 
                                 '" type="text" value="' + last4digit + '" style="width: 30px;" maxlength="4" disabled></td>' ;                          
                  } 

                  if (placeid !== myJSONResult[i].PlaceID){
                      if (placeid !== ''){
                      last_rid = rid;
                      for (var x = rid; x < 10; x++){
                           multitag +=  '<tr id="rowmulti' + x + 
                                        '"><td align="center" id="editMulti' + x + 
                                        '"><input type="text" value="new" style="width: 40px;color: #80ff00;border: none;"></td><td><input id="houseMulti' + x + 
                                        '" type="text" style="width: 100px;"></td><td align="center"><input type="checkbox" id="hasPhoneMulti' + x + 
                                        '" value="yes" onclick="havePhoneMulti(' + x + 
                                        ')"></td><td><input id="residentMulti' + x + 
                                        '" type="text"></td><td>(<input id="areacodeMulti' + x + 
                                        '" type="text" style="width: 25px;" maxlength="3">)<input id="first3digitMulti' + x + 
                                        '" type="text" style="width: 25px;" maxlength="3">-<input id="last4digitMulti' + x + 
                                        '" type="text" style="width: 30px;" maxlength="4"></td><td id="addrowmulti' + x + 
                                        '"></td><td><input type="hidden" id="geoCodedMulti' +  x + 
                                        '" value="false"></td><td><input type="hidden" id="addressMulti' +  x + 
                                        '" value=""></td><td><input type="hidden" id="xyaddressMulti' +  x + 
                                        '" value=""></td><td><input type="hidden" id="addressguid1Multi' +  x + 
                                        '" value=""></td><td><input type="hidden" id="eventMulti' +  x + 
                                        '" value="false"></td></tr>';

                        }                          
                        rid = 0;
                        multitag +='</tbody></table>';    
                        var html = '<table><tr><td id="addressHeader"><h3><p><b>' + formattedaddress + '</h3></p></b></td></tr></table>' +
                                '<input type = "hidden" id = "formatted_address" value = "' + formattedaddress + '">' + 
                                '<input type = "hidden" id = "place_id" value = "' + placeid + '">' + 
                                '<input type = "hidden" id = "addressguid" value = "">' +               
                                '<input type = "hidden" id = "latitude" value = "' + lat + '">' + 
                                '<input type = "hidden" id = "longitude" value = "' + lng + '">' +  
                                '<input type = "hidden" id = "street" value = "">' + 
                                '<input type = "hidden" id = "city" value = "">' +
                                '<input type = "hidden" id = "state" value = "">' + 
                                '<input type = "hidden" id = "zipcode" value = "">' + 
                                
                                '<div id="addresscorrect" style="display:block;">' + 
                                '<table><tr><td>Does the above address need correction?</td></tr></table>' +
                                '<table><tr><form action=""><td><input type="radio" name="correct" id = "needcorrection_yes" value="yes" style="width: 30px;" onclick="showAddressCorrection(' + houseMarker.length + ')">Yes</td>' +
                                '<td><input type="radio" name="correct" id = "needcorrection_no"  value="no"  style="width: 30px;" onclick="hideAddressCorrection(' + houseMarker.length + ')" checked>No</td></form></tr></table>' +                
                                '<div id="correctaddress" style="display:none;">' +
                                '<table><tr><td><input id="housenumberchange" type="text" value="' + housenumber + '"></td><td id="addresssplit">' + address + '</td></tr></table>' +
                                '<table><tr><td><input id="changeAddr" type="button" value="change" onclick="changeAddress(' + houseMarker.length + ')" style="padding: 8px 32px;"></td></tr></table>' +        
                                '</div></div>' +                                    

                                '<div id="units0" style="display:block;">' +                  
                                '<table><tr><td>Is this an apartment building?</td></tr></table>' +
                                '<table><tr><form action=""><td><input type="radio" name="haveUnits" id = "units_yes" value="yes" style="width: 30px;" onclick="showApartment(' + gid.toString() + ')" disabled>Yes</td>' +
                                '<td><input type="radio" name="haveUnits" id = "units_no"  value="no"  style="width: 30px;" onclick="hideApartment(' + gid.toString() + ')" disabled checked>No</td></form></tr></table>' +
                                '<div id="units" style="display:none;"><div id="apartment"></div></div></div>' +                 

                                '<div id="multi0" style="display:block;">' + 
                                '<table><tr><td>Is this an multifamly house (Ex: duplex, triplex, fourplex)?</td></tr></table>' +
                                '<table><tr><form action=""><td><input type="radio" name="haveMulti" id = "multi_yes" value="yes" style="width: 30px;" onclick="showMultiHouse(' + gid.toString() + ')" disabled checked>Yes</td>' +
                                '<td><input type="radio" name="haveMulti" id = "multi_no"  value="no"  style="width: 30px;" onclick="hideMultiHouse(' + gid.toString() + ')" disabled>No</td></form></tr></table>' +                
                                '<div id="multi" style="display:block;"><div id="multihouse">' + multitag + '</div></div></div>' +                


                                '<div id="phone" style="display:none;"><div id="phonehouse">' +                
                                '<table><tr><td>Does this home have a landline?</td></tr></table>' + 
                                '<table><tr><form action=""><td><input type="radio" name="havePhone" id = "phone_yes" value="yes" style="width: 30px;" onclick="showHousePhone(' + gid.toString() + ')">Yes</td>' +
                                '<td><input type="radio" name="havePhone" id = "phone_no"  value="no"  style="width: 30px;" onclick="hideHousePhone(' + gid.toString() + ')" checked>No</td></form></tr></table>' +
                                '<div id="phoneinfo" style="display:none;">' + 
                                '<table><tr><td>Resident</td><td>Phone</td></tr><tr><td><input id="resident" type="text"></td><td>(<input id="areacode" type="text" style="width: 30px;" maxlength="3">)<input id="first3digit" type="text" style="width: 30px;" maxlength="3">-<input id="last4digit" type="text" style="width: 40px;" maxlength="4"></td></tr></table></div></div></div>' +                        

                                '<table><tr><td><input type="button" value="Save" onclick="saveHouse(' + gid.toString() +')" style="padding: 8px 32px;"></td><td><input type="button" value="Cancel" style="padding: 8px 32px;"></td><td><img src = "icons/export.png"></td><td align="right"><div class="toolbartip"><img src = "icons/trashbinsymbol.png" onclick="removeHouse(' + gid.toString() +')"><span class="toolbartiptext">delete</span></div></td></tr></table>';                          
                        
                        // Add a new marker at the new plotted point on the polyline.
                        var myinfowindow = new google.maps.InfoWindow({ content: html });        

                        houseMarker.push(new google.maps.Marker({
                          position: {lat:lat,lng:lng},
                          title: formattedaddress,
                          icon:  icon_,
                          draggable: false,                                                         
                          map: map,
                          infowindow: myinfowindow
                        }));

                        houseMarker[houseMarker.length - 1].setMap(map);          

                        google.maps.event.addListener(houseMarker[houseMarker.length - 1], "click", function () {
                            this.infowindow.open(map, this);
                            //all rows are hidden except saved rows
                            for (i = 0; i < 10; i++){
                                if(document.getElementById('houseMulti' + i).value===''){document.getElementById('rowmulti' + i).hidden = true;} 
                            }


                            for (i = 0; i < 10; i++){
                                // lock phone fields from editing
                                document.getElementById('residentMulti' + i).disabled = true;
                                document.getElementById('areacodeMulti' + i).disabled = true;
                                document.getElementById('first3digitMulti' + i).disabled = true;
                                document.getElementById('last4digitMulti' + i).disabled = true;

                            }                             
                        });        
                        
                        enableLayer("layer",2);
                         
                        document.getElementById('HouseAction').innerHTML = "action: none";
                        document.getElementById('HouseTotal').innerHTML = "homes: " + numOfhouses; 
                   
                        gid+=1;
                      }
                      //assign new 
                      placeid = myJSONResult[i].PlaceID;
                      lat = Number(myJSONResult[i].Latitude);
                      lng = Number(myJSONResult[i].Longitude);
                      formattedaddress = myJSONResult[i].FormattedXYAddress;
                      houseUnit.push(0);
                      houseMulti.push(0);
                      houseSave.push(true);
                      houseMulti[houseMulti.length - 1]+=1;
                      multitag =  '<br><table><thead><tr><th></th>' +
                                  '<th>House Number</th>' +
                                  '<th>Phone</th>' +
                                  '<th>Resident Name</th>' + 
                                  '<th>Phone</th>' +
                                  '<th></th>' +
                                  '<th></th>' +
                                  '<th></th>' +
                                  '</tr></thead><tbody>' +
                          
                                 '<tr id="rowmulti' + rid + 
                                 '"><td align="center" id="editMulti' + rid + 
                                 '"><input type = "button" id = "edit"  value = "edit" onclick="editRow(false,true,' + rid + ')" style="padding: 4px 16px;"></td><td><input id="houseMulti' + rid + 
                                 '" type="text" value="' + housenumber + '" style="width: 100px;" disabled></td>' + phonetag +
                                 '<td id="addrowmulti' + rid + 
                                 '"><input type = "button" id = "add"  value = "+" onclick="addRowMulti(' + rid + ')" style="padding: 4px 16px;"><input type = "button" id = "add"  value = "-" onclick="removeRowMulti('  + rid + ',' + houseMulti[houseMulti.length - 1] + ')" style="padding: 4px 16px;"></td>' + 
                                 '<td><input type="hidden" id="geoCodedMulti' +  rid + 
                                 '" value="true"></td><td><input type="hidden" id="addressMulti' +  rid + 
                                 '" value="' + myJSONResult[i].FormattedAddress + '"></td><td><input type="hidden" id="xyaddressMulti' +  rid + 
                                 '" value="' + myJSONResult[i].FormattedXYAddress + '"></td><td><input type="hidden" id="addressguid1Multi' +  rid + 
                                 '" value="' + myJSONResult[i].AddressGUID + '"></td><td><input type="hidden" id="eventMulti' +  rid + 
                                 '" value="false"></td></tr>'; 
                         
                      rid+=1;
                                  
                  }
                  else{
                        multitag+=  '<tr id="rowmulti' + rid + 
                                    '"><td align="center" id="editMulti' + rid + 
                                    '"><input type = "button" id = "edit"  value = "edit" onclick="editRow(false,true,' + rid + ')" style="padding: 4px 16px;"></td><td><input id="houseMulti' + rid + 
                                    '" type="text" value="' + housenumber + '" style="width: 100px;" disabled></td>' + phonetag +
                                    '<td id="addrowmulti' + rid + 
                                    '"><input type = "button" id = "add"  value = "+" onclick="addRowMulti(' + rid + ')" style="padding: 4px 16px;"><input type = "button" id = "add"  value = "-" onclick="removeRowMulti('  + rid + ',' + houseMulti[houseMulti.length - 1] + ')" style="padding: 4px 16px;"></td>' + 
                                    '<td><input type="hidden" id="geoCodedMulti' +  rid + 
                                    '" value="true"></td><td><input type="hidden" id="addressMulti' +  rid + 
                                    '" value="' + myJSONResult[i].FormattedAddress + '"></td><td><input type="hidden" id="xyaddressMulti' +  rid + 
                                    '" value="' + myJSONResult[i].FormattedXYAddress + '"></td><td><input type="hidden" id="addressguid1Multi' +  rid + 
                                    '" value="' + myJSONResult[i].AddressGUID + '"></td><td><input type="hidden" id="eventMulti' +  rid + 
                                    '" value="false"></td></tr>'; 
                         
                        rid+=1;                      
                  }
                  
                  
             }
                      last_rid = rid;
                      for (var x = rid; x < 10; x++){
                           multitag +=  '<tr id="rowmulti' + x + 
                                        '"><td align="center" id="editMulti' + x + 
                                        '"><input type="text" value="new" style="width: 40px;color: #80ff00;border: none;"></td><td><input id="houseMulti' + x + 
                                        '" type="text" style="width: 100px;"></td><td align="center"><input type="checkbox" id="hasPhoneMulti' + x + 
                                        '" value="yes" onclick="havePhoneMulti(' + x + 
                                        ')"></td><td><input id="residentMulti' + x + 
                                        '" type="text"></td><td>(<input id="areacodeMulti' + x + 
                                        '" type="text" style="width: 25px;" maxlength="3">)<input id="first3digitMulti' + x + 
                                        '" type="text" style="width: 25px;" maxlength="3">-<input id="last4digitMulti' + x + 
                                        '" type="text" style="width: 30px;" maxlength="4"></td><td id="addrowmulti' + x + 
                                        '"></td><td><input type="hidden" id="geoCodedMulti' +  x + 
                                        '" value="false"></td><td><input type="hidden" id="addressMulti' +  x + 
                                        '" value=""></td><td><input type="hidden" id="xyaddressMulti' +  x + 
                                        '" value=""></td><td><input type="hidden" id="addressguid1Multi' +  x + 
                                        '" value=""></td><td><input type="hidden" id="eventMulti' +  x + 
                                        '" value="false"></td></tr>';

                        }             
                        rid = 0;
                        multitag +='</tbody></table>';    
                        var html = '<table><tr><td id="addressHeader"><h3><p><b>' + formattedaddress + '</h3></p></b></td></tr></table>' +
                                '<input type = "hidden" id = "formatted_address" value = "' + formattedaddress + '">' + 
                                '<input type = "hidden" id = "place_id" value = "' + placeid + '">' + 
                                '<input type = "hidden" id = "addressguid" value = "">' +               
                                '<input type = "hidden" id = "latitude" value = "' + lat + '">' + 
                                '<input type = "hidden" id = "longitude" value = "' + lng + '">' +  
                                '<input type = "hidden" id = "street" value = "">' + 
                                '<input type = "hidden" id = "city" value = "">' +
                                '<input type = "hidden" id = "state" value = "">' + 
                                '<input type = "hidden" id = "zipcode" value = "">' +    
                                
                                '<div id="addresscorrect" style="display:block;">' + 
                                '<table><tr><td>Does the above address need correction?</td></tr></table>' +
                                '<table><tr><form action=""><td><input type="radio" name="correct" id = "needcorrection_yes" value="yes" style="width: 30px;" onclick="showAddressCorrection(' + houseMarker.length + ')">Yes</td>' +
                                '<td><input type="radio" name="correct" id = "needcorrection_no"  value="no"  style="width: 30px;" onclick="hideAddressCorrection(' + houseMarker.length + ')" checked>No</td></form></tr></table>' +                
                                '<div id="correctaddress" style="display:none;">' +
                                '<table><tr><td><input id="housenumberchange" type="text" value="' + housenumber + '"></td><td id="addresssplit">' + address + '</td></tr></table>' +
                                '<table><tr><td><input id="changeAddr" type="button" value="change" onclick="changeAddress(' + houseMarker.length + ')" style="padding: 8px 32px;"></td></tr></table>' +        
                                '</div></div>' +                                    

                                '<div id="units0" style="display:block;">' +                  
                                '<table><tr><td>Is this an apartment building?</td></tr></table>' +
                                '<table><tr><form action=""><td><input type="radio" name="haveUnits" id = "units_yes" value="yes" style="width: 30px;" onclick="showApartment(' + gid.toString() + ')" disabled>Yes</td>' +
                                '<td><input type="radio" name="haveUnits" id = "units_no"  value="no"  style="width: 30px;" onclick="hideApartment(' + gid.toString() + ')" disabled checked>No</td></form></tr></table>' +
                                '<div id="units" style="display:none;"><div id="apartment"></div></div></div>' +                 

                                '<div id="multi0" style="display:block;">' + 
                                '<table><tr><td>Is this an multifamly house (Ex: duplex, triplex, fourplex)?</td></tr></table>' +
                                '<table><tr><form action=""><td><input type="radio" name="haveMulti" id = "multi_yes" value="yes" style="width: 30px;" onclick="showMultiHouse(' + gid.toString() + ')" disabled checked>Yes</td>' +
                                '<td><input type="radio" name="haveMulti" id = "multi_no"  value="no"  style="width: 30px;" onclick="hideMultiHouse(' + gid.toString() + ')" disabled>No</td></form></tr></table>' +                
                                '<div id="multi" style="display:block;"><div id="multihouse">' + multitag + '</div></div></div>' +                


                                '<div id="phone" style="display:none;"><div id="phonehouse">' +                
                                '<table><tr><td>Does this home have a landline?</td></tr></table>' + 
                                '<table><tr><form action=""><td><input type="radio" name="havePhone" id = "phone_yes" value="yes" style="width: 30px;" onclick="showHousePhone(' + gid.toString() + ')">Yes</td>' +
                                '<td><input type="radio" name="havePhone" id = "phone_no"  value="no"  style="width: 30px;" onclick="hideHousePhone(' + gid.toString() + ')" checked>No</td></form></tr></table>' +
                                '<div id="phoneinfo" style="display:none;">' + 
                                '<table><tr><td>Resident</td><td>Phone</td></tr><tr><td><input id="resident" type="text"></td><td>(<input id="areacode" type="text" style="width: 30px;" maxlength="3">)<input id="first3digit" type="text" style="width: 30px;" maxlength="3">-<input id="last4digit" type="text" style="width: 40px;" maxlength="4"></td></tr></table></div></div></div>' +                        

                                '<table><tr><td><input type="button" value="Save" onclick="saveHouse(' + gid.toString() +')" style="padding: 8px 32px;"></td><td><input type="button" value="Cancel" style="padding: 8px 32px;"></td><td><img src = "icons/export.png"></td><td align="right"><div class="toolbartip"><img src = "icons/trashbinsymbol.png" onclick="removeHouse(' + gid.toString() +')"><span class="toolbartiptext">delete</span></div></td></tr></table>';                          
                        
                        // Add a new marker at the new plotted point on the polyline.
                        var myinfowindow = new google.maps.InfoWindow({ content: html });        

                        houseMarker.push(new google.maps.Marker({
                          position: {lat:lat,lng:lng},
                          title: formattedaddress,
                          icon:  icon_,
                          draggable: false,                                                         
                          map: map,
                          infowindow: myinfowindow
                        }));

                        houseMarker[houseMarker.length - 1].setMap(map);          

                        google.maps.event.addListener(houseMarker[houseMarker.length - 1], "click", function () {
                            this.infowindow.open(map, this);
                            //all rows are hidden except saved rows
                            for (i = 0; i < 10; i++){
                                if(document.getElementById('houseMulti' + i).value===''){document.getElementById('rowmulti' + i).hidden = true;} 
                            }


                            for (i = 0; i < 10; i++){
                                // lock phone fields from editing
                                document.getElementById('residentMulti' + i).disabled = true;
                                document.getElementById('areacodeMulti' + i).disabled = true;
                                document.getElementById('first3digitMulti' + i).disabled = true;
                                document.getElementById('last4digitMulti' + i).disabled = true;

                            }                              
                        });        
                        
                        enableLayer("layer",2);
                         
                        document.getElementById('HouseAction').innerHTML = "action: none";
                        document.getElementById('HouseTotal').innerHTML = "homes: " + numOfhouses;              
         }
        };
    xmlhttp2.open("GET", "getProperty.php?congregationnumber=" + congregationNumber + "&territorynumber=" + territorynumber + "&bmulti=1&bunit=0", true);
    xmlhttp2.send();   
    
    
    
        var xmlhttp3 = new XMLHttpRequest();
        xmlhttp3.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
             var myJSONResult = JSON.parse(this.responseText);
             var placeid = '';
             var lat;
             var lng;
             var formattedaddress;
             var icon_= apartment;
             var unittag;
             var gid = 0;
             var rid = 0;
             var last_rid = 0;
             
             for(i=0;i<myJSONResult.length;i++){
                  var phonetag;
                  var housesplit = myJSONResult[i].FormattedAddress.toString().split(' ');
                  var housenumber = housesplit[0];                  
                  var address = myJSONResult[i].FormattedAddress.toString().replace(housenumber,'');                     
                  numOfhouses+=1;
                  
                  if (myJSONResult[i].bPhone === "0"){   
                    phonetag =   '<td align="center"><input type="checkbox" id="hasPhone' + rid + 
                                 '" value="yes" onclick="havePhone(' + rid + 
                                 ')" disabled></td><td><input id="resident' + rid + 
                                 '" type="text" disabled></td><td>(<input id="areacode' + rid + 
                                 '" type="text" style="width: 25px;" maxlength="3" disabled>)<input id="first3digit' + rid + 
                                 '" type="text" style="width: 25px;" maxlength="3" disabled>-<input id="last4digit' + rid + 
                                 '" type="text" style="width: 30px;" maxlength="4" disabled></td>' ;
                  }
                  if (myJSONResult[i].bPhone === "1"){ 
                    var areacode = myJSONResult[i].Phone.toString().replace('(','').replace(')','').replace(' ','').replace('-','').substring(0,3); 
                    var first3digit = myJSONResult[i].Phone.toString().replace('(','').replace(')','').replace(' ','').replace('-','').substring(3,6); 
                    var last4digit = myJSONResult[i].Phone.toString().replace('(','').replace(')','').replace(' ','').replace('-','').substring(6,10);
                  
                    phonetag =   '<td align="center"><input type="checkbox" id="hasPhone' + rid + 
                                 '" value="yes" onclick="havePhone(' + rid + 
                                 ')" checked disabled></td><td><input id="resident' + rid + 
                                 '" type="text" value="' + myJSONResult[i].Resident + '" disabled></td><td>(<input id="areacode' + rid + 
                                 '" type="text" value="' + areacode + '" style="width: 25px;" maxlength="3" disabled>)<input id="first3digit' + rid + 
                                 '" type="text" value="' + first3digit + '" style="width: 25px;" maxlength="3" disabled>-<input id="last4digit' + rid + 
                                 '" type="text" value="' + last4digit + '" style="width: 30px;" maxlength="4" disabled></td>' ;                          
                  } 

                  if (placeid !== myJSONResult[i].PlaceID){
                      if (placeid !== ''){
                      last_rid = rid;
                      for (var x = rid; x < 1000; x++){
                           unittag +=  '<tr id="row' + x + '"><td align="center" id="editUnit' + x + 
                                        '"><input type="text" value="new" style="width: 40px;color: #80ff00;border: none;"></td><td><input id="building' + x + 
                                        '" type="text" style="width: 100px;"></td><td><input id="apt' + x + 
                                        '" type="text" style="width: 35px;"></td><td align="center"><input type="checkbox" id="hasPhone' + x + 
                                        '" value="yes" onclick="havePhone(' + x + 
                                        ')"></td><td><input id="resident' + x + 
                                        '" type="text"></td><td>(<input id="areacode' + x + 
                                        '" type="text" style="width: 25px;" maxlength="3">)<input id="first3digit' + x + 
                                        '" type="text" style="width: 25px;" maxlength="3">-<input id="last4digit' + x + 
                                        '" type="text" style="width: 30px;" maxlength="4"></td><td id="addrow' + x + 
                                        '"></td><td><input type="hidden" id="geoCoded' +  x + 
                                        '" value="false"></td><td><input type="hidden" id="address' +  x + 
                                        '" value=""></td><td><input type="hidden" id="xyaddress' +  x + 
                                        '" value=""></td><td><input type="hidden" id="addressguid1' +  x + 
                                        '" value=""></td><td><input type="hidden" id="eventUnit' +  x + 
                                        '" value="false"></td></tr>';

                       }                          
                        rid = 0;
                        unittag +='</tbody></table>';    
                        var html = '<table><tr><td id="addressHeader"><h3><p><b>' + formattedaddress + '</h3></p></b></td></tr></table>' +
                                '<input type = "hidden" id = "formatted_address" value = "' + formattedaddress + '">' + 
                                '<input type = "hidden" id = "place_id" value = "' + placeid + '">' + 
                                '<input type = "hidden" id = "addressguid" value = "">' +               
                                '<input type = "hidden" id = "latitude" value = "' + lat + '">' + 
                                '<input type = "hidden" id = "longitude" value = "' + lng + '">' +  
                                '<input type = "hidden" id = "street" value = "">' + 
                                '<input type = "hidden" id = "city" value = "">' +
                                '<input type = "hidden" id = "state" value = "">' + 
                                '<input type = "hidden" id = "zipcode" value = "">' +       
                                
                                '<div id="addresscorrect" style="display:block;">' + 
                                '<table><tr><td>Does the above address need correction?</td></tr></table>' +
                                '<table><tr><form action=""><td><input type="radio" name="correct" id = "needcorrection_yes" value="yes" style="width: 30px;" onclick="showAddressCorrection(' + houseMarker.length + ')">Yes</td>' +
                                '<td><input type="radio" name="correct" id = "needcorrection_no"  value="no"  style="width: 30px;" onclick="hideAddressCorrection(' + houseMarker.length + ')" checked>No</td></form></tr></table>' +                
                                '<div id="correctaddress" style="display:none;">' +
                                '<table><tr><td><input id="housenumberchange" type="text" value="' + housenumber + '"></td><td id="addresssplit">' + address + '</td></tr></table>' +
                                '<table><tr><td><input id="changeAddr" type="button" value="change" onclick="changeAddress(' + houseMarker.length + ')" style="padding: 8px 32px;"></td></tr></table>' +        
                                '</div></div>' +                                   

                                '<div id="units0" style="display:block;">' +                  
                                '<table><tr><td>Is this an apartment building?</td></tr></table>' +
                                '<table><tr><form action=""><td><input type="radio" name="haveUnits" id = "units_yes" value="yes" style="width: 30px;" onclick="showApartment(' + gid.toString() + ')" disabled checked>Yes</td>' +
                                '<td><input type="radio" name="haveUnits" id = "units_no"  value="no"  style="width: 30px;" onclick="hideApartment(' + gid.toString() + ')" disabled>No</td></form></tr></table>' +
                                '<div id="units" style="display:block;"><div id="apartment">' + unittag + '</div></div></div>' +                 

                                '<div id="multi0" style="display:none;">' + 
                                '<table><tr><td>Is this an multifamly house (Ex: duplex, triplex, fourplex)?</td></tr></table>' +
                                '<table><tr><form action=""><td><input type="radio" name="haveMulti" id = "multi_yes" value="yes" style="width: 30px;" onclick="showMultiHouse(' + gid.toString() + ')" disabled>Yes</td>' +
                                '<td><input type="radio" name="haveMulti" id = "multi_no"  value="no"  style="width: 30px;" onclick="hideMultiHouse(' + gid.toString() + ')" disabled checked>No</td></form></tr></table>' +                
                                '<div id="multi" style="display:none;"><div id="multihouse"></div></div></div>' +                


                                '<div id="phone" style="display:none;"><div id="phonehouse">' +                
                                '<table><tr><td>Does this home have a landline?</td></tr></table>' + 
                                '<table><tr><form action=""><td><input type="radio" name="havePhone" id = "phone_yes" value="yes" style="width: 30px;" onclick="showHousePhone(' + gid.toString() + ')">Yes</td>' +
                                '<td><input type="radio" name="havePhone" id = "phone_no"  value="no"  style="width: 30px;" onclick="hideHousePhone(' + gid.toString() + ')" checked>No</td></form></tr></table>' +
                                '<div id="phoneinfo" style="display:none;">' + 
                                '<table><tr><td>Resident</td><td>Phone</td></tr><tr><td><input id="resident" type="text"></td><td>(<input id="areacode" type="text" style="width: 30px;" maxlength="3">)<input id="first3digit" type="text" style="width: 30px;" maxlength="3">-<input id="last4digit" type="text" style="width: 40px;" maxlength="4"></td></tr></table></div></div></div>' +                        

                                '<table><tr><td><input type="button" value="Save" onclick="saveHouse(' + gid.toString() +')" style="padding: 8px 32px;"></td><td><input type="button" value="Cancel" style="padding: 8px 32px;"></td><td><img src = "icons/export.png"></td><td align="right"><div class="toolbartip"><img src = "icons/trashbinsymbol.png" onclick="removeHouse(' + gid.toString() +')"><span class="toolbartiptext">delete</span></div></td></tr></table>';                          
                        
                        // Add a new marker at the new plotted point on the polyline.
                        var myinfowindow = new google.maps.InfoWindow({ content: html });        

                        houseMarker.push(new google.maps.Marker({
                          position: {lat:lat,lng:lng},
                          title: formattedaddress,
                          icon:  icon_,
                          draggable: false,                                                         
                          map: map,
                          infowindow: myinfowindow
                        }));

                        houseMarker[houseMarker.length - 1].setMap(map);          

                        google.maps.event.addListener(houseMarker[houseMarker.length - 1], "click", function () {
                            this.infowindow.open(map, this);
                            
                            //all rows are hidden except saved rows
                            for (i = 0; i < 1000; i++){
                                if(document.getElementById('apt' + i).value===''){document.getElementById('row' + i).hidden = true;} 
                            }

                            for (i = 0; i < 1000; i++){
                                // lock phone fields from editing
                                document.getElementById('resident' + i).disabled = true;
                                document.getElementById('areacode' + i).disabled = true;
                                document.getElementById('first3digit' + i).disabled = true;
                                document.getElementById('last4digit' + i).disabled = true;                                                            
                            }                               
                        });        
                        
                        enableLayer("layer",2);
                         
                        document.getElementById('HouseAction').innerHTML = "action: none";
                        document.getElementById('HouseTotal').innerHTML = "homes: " + numOfhouses; 
                   
                        gid+=1;
                      }
                      //assign new 
                      placeid = myJSONResult[i].PlaceID;
                      lat = Number(myJSONResult[i].Latitude);
                      lng = Number(myJSONResult[i].Longitude);
                      formattedaddress = myJSONResult[i].FormattedXYAddress;
                      houseUnit.push(0);
                      houseMulti.push(0);
                      houseSave.push(true);
                      houseUnit[houseUnit.length - 1]+=1;
                      unittag =   '<br><table><tr><td>Building Name:</td><td><input id="bldgname" type="text" value="' + myJSONResult[i].BuildingName + '" style="width: 280px;" disabled></td>' +
                                  '<td><input type = "hidden" id = "eventBuilding" value = "false"></td>' + 
                                  '<td id="editBuilding"><input type = "button" id = "edit"  value = "edit" onclick="editBuilding()" style="padding: 4px 16px;"></td></tr></table><br>' +
                              
                                  '<table><thead><tr><th></th>' +
                                   '<th>Building Number</th>' +
                                   '<th>Unit</th>' +
                                   '<th>Phone</th>' +
                                   '<th>Resident Name</th>' + 
                                   '<th>Phone</th>' +     
                                  '</tr></thead><tbody>' +
                          
                                 '<tr id="row' + rid + 
                                 '"><td align="center" id="editUnit' + rid + 
                                 '"><input type = "button" id = "edit"  value = "edit" onclick="editRow(true,false,' + rid + ')" style="padding: 4px 16px;"></td><td><input id="building' + rid + 
                                 '" type="text" value="' + myJSONResult[i].Building + '" style="width: 100px;" disabled></td><td><input id="apt' + rid + 
                                 '" type="text" value="' + myJSONResult[i].Unit + '" style="width: 35px;" disabled></td></td>' + phonetag +
                                 '<td id="addrow' + rid + 
                                 '"><input type = "button" id = "add"  value = "+" onclick="addRowUnit(' + rid + ')" style="padding: 4px 16px;"><input type = "button" id = "add"  value = "-" onclick="removeRowUnit('  + rid + ',' + houseUnit[houseUnit.length - 1] + ')" style="padding: 4px 16px;"></td>' + 
                                 '<td><input type="hidden" id="geoCoded' +  rid + 
                                 '" value="true"></td><td><input type="hidden" id="address' +  rid + 
                                 '" value="' + myJSONResult[i].FormattedAddress + '"></td><td><input type="hidden" id="xyaddress' +  rid + 
                                 '" value="' + myJSONResult[i].FormattedXYAddress + '"></td><td><input type="hidden" id="addressguid1' +  rid + 
                                 '" value="' + myJSONResult[i].AddressGUID + '"></td><td><input type="hidden" id="eventUnit' +  rid + 
                                 '" value="false"></td></tr>'; 
                         
                      rid+=1;
                                  
                  }
                  else{
                        houseUnit[houseUnit.length -1]+=1;
                        unittag+= '<tr id="row' + rid + 
                                  '"><td align="center" id="editUnit' + rid + 
                                  '"><input type = "button" id = "edit"  value = "edit" onclick="editRow(true,false,' + rid + ')" style="padding: 4px 16px;"></td><td><input id="building' + rid + 
                                  '" type="text" value="' + myJSONResult[i].Building + '" style="width: 100px;" disabled></td><td><input id="apt' + rid + 
                                  '" type="text" value="' + myJSONResult[i].Unit + '" style="width: 35px;" disabled></td></td>' + phonetag +
                                  '<td id="addrow' + rid + 
                                  '"><input type = "button" id = "add"  value = "+" onclick="addRowUnit(' + rid + ')" style="padding: 4px 16px;"><input type = "button" id = "add"  value = "-" onclick="removeRowUnit('  + rid + ',' + houseUnit[houseUnit.length - 1] + ')" style="padding: 4px 16px;"></td>' + 
                                  '<td><input type="hidden" id="geoCoded' +  rid + 
                                  '" value="true"></td><td><input type="hidden" id="address' +  rid + 
                                  '" value="' + myJSONResult[i].FormattedAddress + '"></td><td><input type="hidden" id="xyaddress' +  rid + 
                                  '" value="' + myJSONResult[i].FormattedXYAddress + '"></td><td><input type="hidden" id="addressguid1' +  rid + 
                                  '" value="' + myJSONResult[i].AddressGUID + '"></td><td><input type="hidden" id="eventUnit' +  rid + 
                                  '" value="false"></td></tr>'; 
                         
                        rid+=1;                      
                  }
                  
                  
             }
                       last_rid = rid;
                       for (var x = rid; x < 1000; x++){
                           unittag +=  '<tr id="row' + x + '"><td align="center" id="editUnit' + x + 
                                        '"><input type="text" value="new" style="width: 40px;color: #80ff00;border: none;"></td><td><input id="building' + x + 
                                        '" type="text" style="width: 100px;"></td><td><input id="apt' + x + 
                                        '" type="text" style="width: 35px;"></td><td align="center"><input type="checkbox" id="hasPhone' + x + 
                                        '" value="yes" onclick="havePhone(' + x + 
                                        ')"></td><td><input id="resident' + x + 
                                        '" type="text"></td><td>(<input id="areacode' + x + 
                                        '" type="text" style="width: 25px;" maxlength="3">)<input id="first3digit' + x + 
                                        '" type="text" style="width: 25px;" maxlength="3">-<input id="last4digit' + x + 
                                        '" type="text" style="width: 30px;" maxlength="4"></td><td id="addrow' + x + 
                                        '"></td><td><input type="hidden" id="geoCoded' +  x + 
                                        '" value="false"></td><td><input type="hidden" id="address' +  x + 
                                        '" value=""></td><td><input type="hidden" id="xyaddress' +  x + 
                                        '" value=""></td><td><input type="hidden" id="addressguid1' +  x + 
                                        '" value=""></td><td><input type="hidden" id="eventUnit' +  x + 
                                        '" value="false"></td></tr>';

                        }                  
                        rid = 0;
                        unittag +='</tbody></table>';    
                        var html = '<table><tr><td id="addressHeader"><h3><p><b>' + formattedaddress + '</h3></p></b></td></tr></table>' +
                                '<input type = "hidden" id = "formatted_address" value = "' + formattedaddress + '">' + 
                                '<input type = "hidden" id = "place_id" value = "' + placeid + '">' + 
                                '<input type = "hidden" id = "addressguid" value = "">' +               
                                '<input type = "hidden" id = "latitude" value = "' + lat + '">' + 
                                '<input type = "hidden" id = "longitude" value = "' + lng + '">' +  
                                '<input type = "hidden" id = "street" value = "">' + 
                                '<input type = "hidden" id = "city" value = "">' +
                                '<input type = "hidden" id = "state" value = "">' + 
                                '<input type = "hidden" id = "zipcode" value = "">' +    
                                
                                '<div id="addresscorrect" style="display:block;">' + 
                                '<table><tr><td>Does the above address need correction?</td></tr></table>' +
                                '<table><tr><form action=""><td><input type="radio" name="correct" id = "needcorrection_yes" value="yes" style="width: 30px;" onclick="showAddressCorrection(' + houseMarker.length + ')">Yes</td>' +
                                '<td><input type="radio" name="correct" id = "needcorrection_no"  value="no"  style="width: 30px;" onclick="hideAddressCorrection(' + houseMarker.length + ')" checked>No</td></form></tr></table>' +                
                                '<div id="correctaddress" style="display:none;">' +
                                '<table><tr><td><input id="housenumberchange" type="text" value="' + housenumber + '"></td><td id="addresssplit">' + address + '</td></tr></table>' +
                                '<table><tr><td><input id="changeAddr" type="button" value="change" onclick="changeAddress(' + houseMarker.length + ')" style="padding: 8px 32px;"></td></tr></table>' +        
                                '</div></div>' +                                 

                                '<div id="units0" style="display:block;">' +                  
                                '<table><tr><td>Is this an apartment building?</td></tr></table>' +
                                '<table><tr><form action=""><td><input type="radio" name="haveUnits" id = "units_yes" value="yes" style="width: 30px;" onclick="showApartment(' + gid.toString() + ')" disabled checked>Yes</td>' +
                                '<td><input type="radio" name="haveUnits" id = "units_no"  value="no"  style="width: 30px;" onclick="hideApartment(' + gid.toString() + ')" disabled>No</td></form></tr></table>' +
                                '<div id="units" style="display:block;"><div id="apartment">' + unittag + '</div></div></div>' +                 

                                '<div id="multi0" style="display:none;">' + 
                                '<table><tr><td>Is this an multifamly house (Ex: duplex, triplex, fourplex)?</td></tr></table>' +
                                '<table><tr><form action=""><td><input type="radio" name="haveMulti" id = "multi_yes" value="yes" style="width: 30px;" onclick="showMultiHouse(' + gid.toString() + ')" disabled>Yes</td>' +
                                '<td><input type="radio" name="haveMulti" id = "multi_no"  value="no"  style="width: 30px;" onclick="hideMultiHouse(' + gid.toString() + ')" disabled checked>No</td></form></tr></table>' +                
                                '<div id="multi" style="display:none;"><div id="multihouse"></div></div></div>' +                


                                '<div id="phone" style="display:none;"><div id="phonehouse">' +                
                                '<table><tr><td>Does this home have a landline?</td></tr></table>' + 
                                '<table><tr><form action=""><td><input type="radio" name="havePhone" id = "phone_yes" value="yes" style="width: 30px;" onclick="showHousePhone(' + gid.toString() + ')">Yes</td>' +
                                '<td><input type="radio" name="havePhone" id = "phone_no"  value="no"  style="width: 30px;" onclick="hideHousePhone(' + gid.toString() + ')" checked>No</td></form></tr></table>' +
                                '<div id="phoneinfo" style="display:none;">' + 
                                '<table><tr><td>Resident</td><td>Phone</td></tr><tr><td><input id="resident" type="text"></td><td>(<input id="areacode" type="text" style="width: 30px;" maxlength="3">)<input id="first3digit" type="text" style="width: 30px;" maxlength="3">-<input id="last4digit" type="text" style="width: 40px;" maxlength="4"></td></tr></table></div></div></div>' +                        

                                '<table><tr><td><input type="button" value="Save" onclick="saveHouse(' + gid.toString() +')" style="padding: 8px 32px;"></td><td><input type="button" value="Cancel" style="padding: 8px 32px;"></td><td><img src = "icons/export.png"></td><td align="right"><div class="toolbartip"><img src = "icons/trashbinsymbol.png" onclick="removeHouse(' + gid.toString() +')"><span class="toolbartiptext">delete</span></div></td></tr></table>';                          
                        
                        // Add a new marker at the new plotted point on the polyline.
                        var myinfowindow = new google.maps.InfoWindow({ content: html });        

                        houseMarker.push(new google.maps.Marker({
                          position: {lat:lat,lng:lng},
                          title: formattedaddress,
                          icon:  icon_,
                          draggable: false,                                                         
                          map: map,
                          infowindow: myinfowindow
                        }));

                        houseMarker[houseMarker.length - 1].setMap(map);          

                        google.maps.event.addListener(houseMarker[houseMarker.length - 1], "click", function () {
                            this.infowindow.open(map, this);
                            
                            //all rows are hidden except saved rows
                            for (i = 0; i < 1000; i++){
                                if(document.getElementById('apt' + i).value===''){document.getElementById('row' + i).hidden = true;} 
                            }

                            for (i = 0; i < 1000; i++){
                                // lock phone fields from editing
                                document.getElementById('resident' + i).disabled = true;
                                document.getElementById('areacode' + i).disabled = true;
                                document.getElementById('first3digit' + i).disabled = true;
                                document.getElementById('last4digit' + i).disabled = true;                                                            
                            }                               
                        });         
                        
                        enableLayer("layer",2);
                         
                        document.getElementById('HouseAction').innerHTML = "action: none";
                        document.getElementById('HouseTotal').innerHTML = "homes: " + numOfhouses;              
         }
        };
    xmlhttp3.open("GET", "getProperty.php?congregationnumber=" + congregationNumber + "&territorynumber=" + territorynumber + "&bmulti=0&bunit=1", true);
    xmlhttp3.send(); 
        
    }
    
    function sortDown() {
        document.getElementById('sortsave' + territorynumber).innerHTML = '<img src = "icons/sortsave.png" onclick="sortSave()"/>'; 
        // Read table body node.
        var tableData = document.getElementById('terr_table').innerHTML;

        var tag = false;
        // Read table row nodes.
        var tableArray = tableData.toString().replace('<table>','').replace('</table>','').replace('<tbody>','').replace('</tbody','').split('</tr>');

        for(var i = 0; i < tableArray.length - 1; i++) {
           tableArray[i] = tableArray[i].concat('</tr>');           
        }
        
        for(var i = 0; i < tableArray.length - 1; i++) {
           if(tableArray[i].indexOf(document.getElementById('Territory').value)> -1){
                if(tag === false && (i + 1) < tableArray.length - 1){
                    sortnumber = i + 1;
                   // alert(sortnumber);
                    var swap = tableArray[i+1];
                    tableArray[i+1] = tableArray[i];
                    tableArray[i] = swap;   
                    tag = true;
               }
           }
        }        
        
       tableData = '<table>';  
       
        for(var i = 0; i < tableArray.length - 1; i++) {
            tableData += tableArray[i];         
        }
        
        tableData += '</table>';   
        
        document.getElementById('terr_table').innerHTML = tableData;
    }
    
        function sortUp() {
            document.getElementById('sortsave' + territorynumber).innerHTML = '<img src = "icons/sortsave.png" onclick="sortSave()"/>'; 
            // Read table body node.
            var tableData = document.getElementById('terr_table').innerHTML;

            var tag = false;
            // Read table row nodes.
            var tableArray = tableData.toString().replace('<table>','').replace('</table>','').replace('<tbody>','').replace('</tbody','').split('</tr>');

            for(var i = 0; i < tableArray.length - 1; i++) {
               tableArray[i] = tableArray[i].concat('</tr>');           
            }

            for(var i = tableArray.length - 1; i > -1; i--) {
               if(tableArray[i].indexOf(document.getElementById('Territory').value)> -1){
                    if(tag === false && (i - 1) > -1){
                        sortnumber = i - 1;
                        //alert(sortnumber);
                        var swap = tableArray[i-1];
                        tableArray[i-1] = tableArray[i];
                        tableArray[i] = swap;   
                        tag = true;
                   }
               }
            }        

           tableData = '<table>';  

            for(var i = 0; i < tableArray.length - 1; i++) {
                tableData += tableArray[i];         
            }

            tableData += '</table>';   

            document.getElementById('terr_table').innerHTML = tableData;
    }
    
    function sortSave(){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                 var myJSONResult = JSON.parse(this.responseText);
                 ///do nothing
            }
        };
        xmlhttp.open("GET", "saveSort.php?congregationnumber=" + congregationNumber + "&territorynumber=" + document.getElementById('Territory').value + "&sort=" + sortnumber, true);
        xmlhttp.send();                  
    }
    
    function showediterrlist(){ 
        var screen = Number($(window).width());
        var menuwidth = Math.round((200/screen)*100);
        if(screen<768){
            document.getElementById("left").style.width = "100%";  
            document.getElementById("mobilemenucontrol").style.width = "0"; 
            document.getElementById("main").style.width= "0"; 
            document.getElementById("menu").style.width = "0";  
        }
        
        if(screen>=768 && screen<=1024){ 
            document.getElementById("left").style.width = "20%"; 
            document.getElementById("main").style.marginLeft= "20%"; 
            document.getElementById("menu").style.marginLeft = "20%";            
            document.getElementById("main").style.width= "50%"; 
            document.getElementById("menu").style.width = "50%"; 
        }
    }
    
    function showtoolbox(){
        if(document.getElementById("main").style.width="70%"){
            document.getElementById("mytoolbox").style.display = 'block';            
        }
        if(document.getElementById("main").style.width="50%"){
            document.getElementById("mytoolbox").style.display = 'block';            
        }     
        if(document.getElementById("main").style.width="100%"){
            document.getElementById("main").style.width="70%";
            document.getElementById("mytoolbox").style.display = 'block';            
        }        
    }

            $(document).ready(function(){
                var screen = Number($(window).width());
                var menuwidth = Math.round((200/screen)*100);                
                var territorynavigation = false;                
                
                if(screen<768){
//                    document.getElementById("msg").style.display = 'none';
                    document.getElementById("donatefunds").innerHTML = "$";
                    document.getElementById("myname").innerHTML = '<a href = "welcome.php" class="menutitle"><img src = "icons/TO_logo.png"></a>';
                    document.getElementById("mobilemenu").style.display = 'block';
                    document.getElementById("desktopmenu").style.display = 'none';
                    document.getElementById("selecterritoryeditclose").style.display = 'block';
                    document.getElementById("selecteditlist").innerHTML = '<input type="button" value="edit another territory" onclick="showediterrlist()">'
                    document.getElementById("newmap").innerHTML = '<input type="button" value="new" onclick="newmap()">'
                    document.getElementById("savemap").innerHTML = '<input type="button" value="save" onclick="save()">'                    
                    document.getElementById("left").style.width = "0";  
                    document.getElementById("menu").style.marginLeft = "0"; 
                    document.getElementById("main").style.marginLeft = "0"; 
                    document.getElementById("main").style.width= "70%"; 
                    document.getElementById("menu").style.width = "70%"; 
                    document.getElementById("mytoolbox").style.width = "20%"; 
                    document.getElementById("label1").innerHTML = "";
                    document.getElementById("label2").innerHTML = "";
                    document.getElementById("signout").innerHTML = '';
                    document.getElementById("signout2").style.display = 'block';                    
                };
                
                if(screen>=768 && screen<=1024){
//                    document.getElementById("msg").style.display = 'none'; 
                    document.getElementById("myname").innerHTML = '<a href = "welcome.php" class="menutitle"><img src = "icons/TO_largelogo1.png"></a>';                     
                    document.getElementById("selecterritoryeditclose").style.display = 'block';
                    document.getElementById("selecteditlist").innerHTML = '<input type="button" value="edit another territory" onclick="showediterrlist()">'
                    document.getElementById("newmap").innerHTML = '<input type="button" value="new" onclick="newmap()">'
                    document.getElementById("savemap").innerHTML = '<input type="button" value="save" onclick="save()">'                      
                    document.getElementById("left").style.width = "0";  
                    document.getElementById("menu").style.marginLeft = "0"; 
                    document.getElementById("main").style.marginLeft = "0"; 
                    document.getElementById("main").style.width= "70%"; 
                    document.getElementById("menu").style.width = "70%";  
//                    document.getElementById("toolboxclosesection").style.display = 'block';
                    document.getElementById("label1").innerHTML = "";
                    document.getElementById("label2").innerHTML = "";                    
                }
                
                $("#mobilemenudisplay").hover(function (){ 
                    if(screen<768){
                        document.getElementById("mobilemenucontrol").style.width = menuwidth.toString() + "%";
                        document.getElementById("mobilemenucontrol").style.display = 'block';                    
                        document.getElementById("left").style.width = "0";                         
                        
                    }else{
                        document.getElementById("mobilemenucontrol").style.width = menuwidth.toString() + "%";
                        document.getElementById("mobilemenucontrol").style.display = 'block';
                        document.getElementById("main").style.marginLeft = "25%"; 
                        document.getElementById("menu").style.marginLeft = "25%";    
                        document.getElementById("main").style.width= "50%"; 
                        document.getElementById("menu").style.width = "50%";                    
                        document.getElementById("left").style.width = "0"; 
                  }
                });     
                
                $("#desktopmenudisplay").hover(function (){   
                   document.getElementById("menucontrol").style.width = menuwidth.toString() + "%";
                   document.getElementById("menucontrol").style.display = 'block';
                   document.getElementById("main").style.marginLeft = "12%"; 
                   document.getElementById("menu").style.marginLeft = "12%";    
                   document.getElementById("main").style.width= "70%"; 
                   document.getElementById("menu").style.width = "70%";                    
                   document.getElementById("left").style.width = "0";   
                });                  
                
                
                $(".staticleft").hover(function (){   
                    if(screen>1024){              
                    document.getElementById("left").style.width = "10%";  
                    document.getElementById("main").style.marginLeft = "12%"; 
                    document.getElementById("menu").style.marginLeft = "12%";  
                    document.getElementById("main").style.width= "70%"; 
                    document.getElementById("menu").style.width = "70%"; 
                   }
                   
                });  
                                
                
                $(".staticmain").hover(function (){ 
                    if(screen>768 && screen<=1024){                    
                    document.getElementById("menucontrol").style.width = "0"; 
                    document.getElementById("mobilemenucontrol").style.width = "0";                    
                    document.getElementById("left").style.width = "10%";  
                    document.getElementById("main").style.marginLeft = "10%"; 
                    document.getElementById("menu").style.marginLeft = "10%";  
                    document.getElementById("main").style.width= "67%"; 
                    document.getElementById("menu").style.width = "67%";                          
                    }
                    if(screen>1024){    
                    document.getElementById("menucontrol").style.width = "0"; 
                    document.getElementById("mobilemenucontrol").style.width = "0";                    
                    document.getElementById("left").style.width = "10%";  
                    document.getElementById("main").style.marginLeft = "12%"; 
                    document.getElementById("menu").style.marginLeft = "12%";  
                    document.getElementById("main").style.width= "70%"; 
                    document.getElementById("menu").style.width = "70%";                          
                    }
                  });
                    
                   $("#toterr1").click(function (){ 

                       document.getElementById("left").style.width = "0";  
                       document.getElementById("main").style.marginLeft = "0"; 
                       document.getElementById("menu").style.marginLeft = "0";                       
                       document.getElementById("main").style.width = "70%"; 
                       document.getElementById("menu").style.width = "70%"; 
                   
                   }); 
                   
//                   $("#closetoolbox").click(function (){ 
//                       document.getElementById("mytoolbox").style.display = 'none';
//                       document.getElementById("main").style.width = "100%"; 
//                       document.getElementById("menu").style.width = "100%";  
//                       document.getElementById("opentoolbox").innerHTML = '<input type="button" value="toolbox" onclick="showtoolbox()">'
//                   });                        
                
            });
        <?php
        // put your code here
        ?>

       </script>
      </div>       
    </body>
</html>

