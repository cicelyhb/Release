<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
   ob_start();
   session_start();
   if(empty($_SESSION['username'])){
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
        <title>Territory Organizer:Territory Map</title>
        <link rel="stylesheet" type="text/css" href="myStyle.css">
    </head>
    <link rel="shortcut icon" href="icons/TO_smalllogo.png" type="image/png" />  
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
<body>
        <!--<title>Google Maps JavaScript API Example: Map Simple</title>-->
        <div class="top">
        <script src="scripts/menu.js"></script>
            <?php 
               $Territory = $_GET['territory'];
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
//               echo '<td align="position" class="menuleft">',PHP_EOL;    
//               echo '<marquee id="scrollingcampaign" behavior="scroll" direction="left"></marquee>',PHP_EOL;    
//               echo '</td>',PHP_EOL;                  
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
    
        <div id= "myleft1" class="left">
        <script src="scripts/menu.js"></script>
        <div id="streetpageclose" style="display:block;">
        <table class="menutable">
            <tr><td class="menuleft"><input id="toterr1" type="button" value="Back to territory"></td><tr/>
        </table>
        </div>
            <?php  
                 include("db_ConnectionInfo.php");
                 include("MyClassLibrary.php");
                 
                 $Territory = $_GET['territory'];
                 $congregationnumber = $_SESSION['congregationnumber'];                 
                 $terrlist = new territorylist($host,$username,$password,$database,$port,$socket);
                 $terrlist->PrepareStreetList($Territory,$congregationnumber);
                 $terrlist->NavigationStreetList($Territory,$congregationnumber,'icons/available.png','icons/checkout.png');
                 $terrlist->close();                                                                  
            ?>                     
        </div>
    
        <div id="myleft2" class="left">
        <div id="territorypageclose" style="display:block;">            
        <table class="menutable">
            <tr><td class="menuleft"><input id="toterr2" type="button" value="Back to territory"></td><tr/>
        </table>
        </div>            
        <?php        
             $terrlist = new territorylist($host,$username,$password,$database,$port,$socket);
             $terrlist->NavigationList($congregationnumber,'icons/available.png','icons/checkout.png');
             $terrlist->close();
        ?>             
        </div> 
    
    
        <div id="myleft3" class="left" style="display:none;">
        <div id="streetviewmoduleclose">            
        <table class="menutable">
            <tr><td class="menuleft"><input id="toterr3" type="button" value="Back to view streets"></td><tr/>
        </table>
        </div>
        <div id="totalcount" style="display:none"></div>             
        <div id="streetviewdetail"></div>                        
        </div> 
    
        <div id="mobilemenucontrol" class="sideleftnav">
        <script src="scripts/menu.js"></script> 
<!--        <a href="#" class="closebtn" >&times;</a>-->
        <?php
        echo '<table>',PHP_EOL;
        echo '<tr><td><a id="mobileselectterritory" href = "#" class="button" style="width: 90%;color: white;font-size: 12px;">Select Territory</a></td></tr>',PHP_EOL;          
        echo '<tr><td><a id="mobileviewstreet" href = "#" class="button" style="width: 90%;color: white;font-size: 12px;">View Streets</a></td></tr>',PHP_EOL;         
        if($_SESSION['role'] == 'ADM' ){
        echo '<tr><td><a href = "editterritory.php?territory='.$Territory.'" class="button" style="width: 90%;color: white;font-size: 12px;">Edit Territory</a></td></tr>',PHP_EOL;        
        echo '<tr><td><a href = "activateUser.php" class="button" style="width: 90%;color: white;font-size: 12px;">Activate Users</a></td></tr>',PHP_EOL;  
        echo '<tr><td><a href = "#" class="button" style="width: 90%;color: white;font-size: 12px;">Change User Role</a></td></tr>',PHP_EOL;        
        echo '<tr><td><a href = "assignTerritory.php" class="button" style="width: 90%;color: white;font-size: 12px;">Manage Checkouts</a></td></tr>',PHP_EOL;    
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
        echo '<tr><td><a id="selectterritory" href = "#" class="button" style="width: 90%;color: white;font-size: 12px;">Select Territory</a></td></tr>',PHP_EOL;          
        echo '<tr><td><a id="viewstreet" href = "#" class="button" style="width: 90%;color: white;font-size: 12px;">View Streets</a></td></tr>',PHP_EOL;         
        if($_SESSION['role'] == 'ADM' ){
        echo '<tr><td><a href = "editterritory.php?territory='.$Territory.'" class="button" style="width: 90%;color: white;font-size: 12px;">Edit Territory</a></td></tr>',PHP_EOL;        
        echo '<tr><td><a href = "activateUser.php" class="button" style="width: 90%;color: white;font-size: 12px;">Activate Users</a></td></tr>',PHP_EOL;  
        echo '<tr><td><a href = "#" class="button" style="width: 90%;color: white;font-size: 12px;">Change User Role</a></td></tr>',PHP_EOL;        
        echo '<tr><td><a href = "assignTerritory.php" class="button" style="width: 90%;color: white;font-size: 12px;">Manage Checkouts</a></td></tr>',PHP_EOL;    
        echo '<tr><td><a href = "#" class="button" style="width: 90%;color: white;font-size: 12px;">Reports</a></td></tr>',PHP_EOL; 
        echo '<tr><td><a href = "#" class="button" style="width: 90%;color: white;font-size: 12px;">Dashboards</a></td></tr>',PHP_EOL;         
        }             
        echo '<tr><td><a href = "#" class="button" style="width: 90%;color: white;font-size: 12px;">Contact Us</a></td></tr>',PHP_EOL;        
        echo '</table>',PHP_EOL;  
        ?>   
        </div>  
    
        <div id="banner">
            <table class="menutable">
                <tr> 
               <td align="center" class="menucenter">               
               <div id="msg" style="display:block;">    
               <marquee id="scrollingcampaign" behavior="scroll" direction="left"></marquee>                            
               </div> 
               </td> 
                </tr>
            </table>
           
        </div>  
    
        <div id="main1" class="main">        
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1Fdvd0EPg3knllyj9gBhZ8tFoxuWQOTU" type="text/javascript"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>        
        <div id="map" style="width:100%; height:850px; padding:0px"></div>
        <div id="mylegend" class="legend" style="display:block">
<!--            <table class="menutable"><tr><td class="menuright"><a href="#" class="closelegend" >&times;</a></td><tr/></table>-->
            <a id="closelegend" href="#" class="closebtn" >&times;</a>
            <h3>Legend</h3>
        </div>
        <div id="myterritory"  class="legend" style="display:block"></div> 
        <div class="tooltip"><div id="myeyeglass"  class="legend" style="display:block"></div><span class="tooltiptext">View Streets</span></div>         
        <script src="scripts/myscripts.js"></script>
        <script type="text/javascript">    
            <?php
                echo 'var congregationNumber = "'.$congregationnumber.'";',PHP_EOL;
                echo 'var territoryNumber = "'.$Territory.'";',PHP_EOL;
                echo 'var username = "'.$_SESSION['username'].'";',PHP_EOL;
            ?>            
            var d = new Date();
            var marker_resident_nw = [];
            var marker_resident = [];
            var marker_resident_home = [];
            var marker_resident_nt = [];
            
            var marker_phone_nw = [];
            var marker_phone = [];
            var marker_phone_home = [];
            var marker_phone_nt = [];
            var marker_dnc = [];
            
            var infowin_resident_nw = [[]]; //[[html,latitude,longitude]]
            var infowin_resident = [[]]; //[[html,latitude,longitude]]
            var infowin_resident_home = [[]]; //[[html,latitude,longitude]]
            var infowin_resident_nt = [[]]; //[[html,latitude,longitude]]
            
            var infowin_phone_nw = [[]]; //[[html,latitude,longitude]]            
            var infowin_phone = [[]]; //[[html,latitude,longitude]]
            var infowin_phone_home = [[]]; //[[html,latitude,longitude]]
            var infowin_phone_nt = [[]]; //[[html,latitude,longitude]]            
            var infowin_dnc = [[]]; //[[html,latitude,longitude]]
            
            var marker_apt = [];
            var infowin_apt = [[]];
            
            var marker_resident_nw_apt = [];
            var marker_resident_apt = [];
            var marker_resident_home_apt  = [];
            var marker_resident_nt_apt  = [];
            
            var marker_phone_nw_apt  = [];
            var marker_phone_apt  = [];
            var marker_phone_home_apt  = [];
            var marker_phone_nt_apt  = [];
            var marker_dnc_apt  = [];
            
            var infowin_resident_nw_apt  = [[]]; //[[html,latitude,longitude]]            
            var infowin_resident_apt  = [[]]; //[[html,latitude,longitude]]
            var infowin_resident_home_apt  = [[]]; //[[html,latitude,longitude]]
            var infowin_resident_nt_apt  = [[]]; //[[html,latitude,longitude]] 
            
            var infowin_phone_nw_apt  = [[]]; //[[html,latitude,longitude]]
            var infowin_phone_apt  = [[]]; //[[html,latitude,longitude]]
            var infowin_phone_home_apt  = [[]]; //[[html,latitude,longitude]]
            var infowin_phone_nt_apt  = [[]]; //[[html,latitude,longitude]]            
            var infowin_dnc_apt  = [[]]; //[[html,latitude,longitude]]
            
            
            var marker_multi = [];
            var infowin_multi = [[]];
            
            var marker_resident_nw_multi = [];
            var marker_resident_multi = [];
            var marker_resident_home_multi  = [];
            var marker_resident_nt_multi  = [];
            
            var marker_phone_nw_multi  = [];
            var marker_phone_multi  = [];
            var marker_phone_home_multi  = [];
            var marker_phone_nt_multi  = [];
            var marker_dnc_multi  = [];
            
            var infowin_resident_nw_multi  = [[]]; //[[html,latitude,longitude]]            
            var infowin_resident_multi  = [[]]; //[[html,latitude,longitude]]
            var infowin_resident_home_multi  = [[]]; //[[html,latitude,longitude]]
            var infowin_resident_nt_multi  = [[]]; //[[html,latitude,longitude]] 
            
            var infowin_phone_nw_multi  = [[]]; //[[html,latitude,longitude]]
            var infowin_phone_multi  = [[]]; //[[html,latitude,longitude]]
            var infowin_phone_home_multi  = [[]]; //[[html,latitude,longitude]]
            var infowin_phone_nt_multi  = [[]]; //[[html,latitude,longitude]]            
            var infowin_dnc_multi  = [[]]; //[[html,latitude,longitude]] 
            var infowin_index;
            var territorygroups = []; 
             
            
            var icons = {
                            NW: {
                            label: 'Not Worked',
                            icon: 'icons/House_NW.png',
                            mouseovericon:'icons/House_MouseOver.png'
                            },
                            NH: {
                            label: 'Not Home',
                            icon: 'icons/House_NH.png',
                            mouseovericon:'icons/House_MouseOver.png'
                          },
                            HH: {
                            label: 'Home',
                            icon: 'icons/House_HH.png',
                            mouseovericon:'icons/House_MouseOver.png'
                          },
                            NTR: {
                            label: 'No Trespassing',
                            icon: 'icons/House_NTR.png',
                            mouseovericon:'icons/House_MouseOver.png'
                          },   
                            Phone_NW: {
//                            label: 'Not Worked w/ Landline',
                            label: 'Not Worked<br>(Landline)',
                            icon: 'icons/Phone_NW.png',
                            mouseovericon:'icons/Phone_MouseOver.png'
                          },    
                            Phone_NH: {
//                            label: 'Not Home w/ Landline',
                            label: 'Not Home<br>(Landline)',
                            icon: 'icons/Phone_NH.png',
                            mouseovericon:'icons/Phone_MouseOver.png'
                          },  
                            Phone_HH: {
//                            label: 'Home w/ Landline',
                            label: 'Home<br>(Landline)',
                            icon: 'icons/Phone_HH.png',
                            mouseovericon:'icons/Phone_MouseOver.png'
                          },  
                            Phone_NTR: {
//                            label: 'No Trespassing w/ Landline',
                            label: 'No Trespassing<br>(Landline)',
                            icon: 'icons/Phone_NTR.png',
                            mouseovericon:'icons/Phone_MouseOver.png'
                          }, 
                            DNC: {
                            label: 'Do Not Call',
                            icon: 'icons/DNC.png',
                            mouseovericon:'icons/DNC_MouseOver.png'
                          }                          
        };
            

        <?php 
//        include("db_ConnectionInfo.php");
//        include("MyClassLibrary.php");
        
        // Gets data from URL parameters
        $congregationnumber = $_SESSION['congregationnumber'];
        $Territory = $_GET['territory'];
                     
//        $mapLayer= new Layer($server,$database,$username,$password);    
        $mapLayer= new Layer($host,$username,$password,$database,$port,$socket);
        //Build Select query
        $where = "TerritoryNumber = '".$Territory."'";
        $mapLayer->MapPolygon($where); 
        //Build Select query
        $where1 = "TerritoryNumber = '".$Territory."' AND bUnit=0 AND bMulti=0 AND bPhone = 0 AND bTouched = 0 AND Type = 'NH'";
        $mapLayer->MapA($where1,"infowin_resident_nw","marker_resident_nw",false);           
        //Build Select query
        $where2 = "TerritoryNumber = '".$Territory."' AND bUnit=0 AND bMulti=0 AND bPhone = 0 AND bTouched = 1 AND Type = 'NH'";
        $mapLayer->MapA($where2,"infowin_resident","marker_resident",false);              
         //Build Select query
        $where3 = "TerritoryNumber = '".$Territory."' AND bUnit=0 AND bMulti=0 AND bPhone = 0 AND Type = 'HH'";
        $mapLayer->MapA($where3,"infowin_resident_home","marker_resident_home",false);                             
        //Build Select query
        $where4 = "TerritoryNumber = '".$Territory."' AND bUnit=0 AND bMulti=0 AND bPhone = 0 AND Type = 'NTR'";
        $mapLayer->MapA($where4,"infowin_resident_nt","marker_resident_nt",false); 
        //Build Select query
        $where5 = "TerritoryNumber = '".$Territory."' AND bUnit=0 AND bMulti=0 AND bPhone = 1 AND bTouched = 0 AND Type = 'NH'";
        $mapLayer->MapA($where5,"infowin_phone_nw","marker_phone_nw",true);          
        //Build Select query
        $where6 = "TerritoryNumber = '".$Territory."' AND bUnit=0 AND bMulti=0 AND bPhone = 1 AND bTouched = 1 AND Type = 'NH'";
        $mapLayer->MapA($where6,"infowin_phone","marker_phone",true);                       
        //Build Select query
        $where7 = "TerritoryNumber = '".$Territory."' AND bUnit=0 AND bMulti=0 AND bPhone = 1 AND Type = 'HH'";
        $mapLayer->MapA($where7,"infowin_phone_home","marker_phone_home",true);                         
        //Build Select query
        $where8 = "TerritoryNumber = '".$Territory."' AND bUnit=0 AND bMulti=0 AND bPhone = 1 AND Type = 'NTR'";
        $mapLayer->MapA($where8,"infowin_phone_nt","marker_phone_nt",true);                         
        //Build Select query
        $where9 = "TerritoryNumber = '".$Territory."' AND bUnit=0 AND bMulti=0 AND Type = 'DNC'";
        $mapLayer->MapA($where9,"infowin_dnc","marker_dnc",false);  
        //Build Select query
        $param1 =  array(array("Layer"=>"infowin_resident_nw_apt","Marker"=>"marker_resident_nw_apt","bPhone"=>"0","Type"=>"NH","Icon"=>"icons/House_NW.png","IconMouseover"=>"icons/House_MouseOver.png"),
                        array("Layer"=>"infowin_phone_nw_apt","Marker"=>"marker_phone_nw_apt","bPhone"=>"1","Type"=>"NH","Icon"=>"icons/Phone_NW.png","IconMouseover"=>"icons/Phone_MouseOver.png"),
                        array("Layer"=>"infowin_resident_apt","Marker"=>"marker_resident_apt","bPhone"=>"0","Type"=>"NH","Icon"=>"icons/House_NH.png","IconMouseover"=>"icons/House_MouseOver.png"),
                        array("Layer"=>"infowin_resident_home_apt","Marker"=>"marker_resident_home_apt","bPhone"=>"0","Type"=>"HH","Icon"=>"icons/House_HH.png","IconMouseover"=>"icons/House_MouseOver.png"),     
                        array("Layer"=>"infowin_resident_nt_apt","Marker"=>"marker_resident_nt_apt","bPhone"=>"0","Type"=>"NTR","Icon"=>"icons/House_NTR.png","IconMouseover"=>"icons/House_MouseOver.png"),
                        array("Layer"=>"infowin_phone_apt","Marker"=>"marker_phone_apt","bPhone"=>"1","Type"=>"NH","Icon"=>"icons/Phone_NH.png","IconMouseover"=>"icons/Phone_MouseOver.png"),
                        array("Layer"=>"infowin_phone_home_apt","Marker"=>"marker_phone_home_apt","bPhone"=>"1","Type"=>"HH","Icon"=>"icons/Phone_HH.png","IconMouseover"=>"icons/Phone_MouseOver.png"),
                        array("Layer"=>"infowin_phone_nt_apt","Marker"=>"marker_phone_nt_apt","bPhone"=>"1","Type"=>"NTR","Icon"=>"icons/Phone_NTR.png","IconMouseover"=>"icons/Phone_MouseOver.png"),
                        array("Layer"=>"infowin_dnc_apt","Marker"=>"marker_dnc_apt","bPhone"=>"-1","Type"=>"DNC","Icon"=>"icons/DNC.png","IconMouseover"=>"icons/DNC_MouseOver.png"),
            );
        //Build Select query
        $param2 =  array(array("Layer"=>"infowin_resident_nw_multi","Marker"=>"marker_resident_nw_multi","bPhone"=>"0","Type"=>"NH","Icon"=>"icons/House_NW.png","IconMouseover"=>"icons/House_MouseOver.png"),
                        array("Layer"=>"infowin_phone_nw_multi","Marker"=>"marker_phone_nw_multi","bPhone"=>"1","Type"=>"NH","Icon"=>"icons/Phone_NW.png","IconMouseover"=>"icons/Phone_MouseOver.png"),
                        array("Layer"=>"infowin_resident_multi","Marker"=>"marker_resident_multi","bPhone"=>"0","Type"=>"NH","Icon"=>"icons/House_NH.png","IconMouseover"=>"icons/House_MouseOver.png"),
                        array("Layer"=>"infowin_resident_home_multi","Marker"=>"marker_resident_home_multi","bPhone"=>"0","Type"=>"HH","Icon"=>"icons/House_HH.png","IconMouseover"=>"icons/House_MouseOver.png"),     
                        array("Layer"=>"infowin_resident_nt_multi","Marker"=>"marker_resident_nt_multi","bPhone"=>"0","Type"=>"NTR","Icon"=>"icons/House_NTR.png","IconMouseover"=>"icons/House_MouseOver.png"),
                        array("Layer"=>"infowin_phone_multi","Marker"=>"marker_phone_multi","bPhone"=>"1","Type"=>"NH","Icon"=>"icons/Phone_NH.png","IconMouseover"=>"icons/Phone_MouseOver.png"),
                        array("Layer"=>"infowin_phone_home_multi","Marker"=>"marker_phone_home_multi","bPhone"=>"1","Type"=>"HH","Icon"=>"icons/Phone_HH.png","IconMouseover"=>"icons/Phone_MouseOver.png"),
                        array("Layer"=>"infowin_phone_nt_multi","Marker"=>"marker_phone_nt_multi","bPhone"=>"1","Type"=>"NTR","Icon"=>"icons/Phone_NTR.png","IconMouseover"=>"icons/Phone_MouseOver.png"),
                        array("Layer"=>"infowin_dnc_multi","Marker"=>"marker_dnc_multi","bPhone"=>"-1","Type"=>"DNC","Icon"=>"icons/DNC.png","IconMouseover"=>"icons/DNC_MouseOver.png"),
            );        
        
        $mapLayer->MapB($congregationnumber,$Territory ,"infowin_apt","marker_apt",$param1);
        $mapLayer->MapC($congregationnumber,$Territory ,"infowin_multi","marker_multi",$param2);
        $mapLayer->close();

        
        
        ?>
    CreateMarkerA(marker_apt,infowin_apt,'icons/Apartment_NH.png','icons/Apartment_MouseOver.png');
    CreateMarkerA(marker_multi,infowin_multi,'icons/Duplex_NH.png','icons/Duplex_MouseOver.png');
    
    CreateMarkerB(marker_resident_apt,infowin_resident_apt,'icons/Apartment_NH.png','icons/Apartment_MouseOver.png');
    CreateMarkerB(marker_resident_nw_apt,infowin_resident_nw_apt,'icons/Apartment_NH.png','icons/Apartment_MouseOver.png');
    CreateMarkerB(marker_resident_home_apt,infowin_resident_home_apt,'icons/Apartment_NH.png','icons/Apartment_MouseOver.png');
    CreateMarkerB(marker_resident_nt_apt,infowin_resident_nt_apt,'icons/Apartment_NH.png','icons/Apartment_MouseOver.png');
    CreateMarkerB(marker_phone_apt,infowin_phone_apt,'icons/Apartment_NH.png','icons/Apartment_MouseOver.png');
    CreateMarkerB(marker_phone_nw_apt,infowin_phone_nw_apt,'icons/Apartment_NH.png','icons/Apartment_MouseOver.png');    
    CreateMarkerB(marker_phone_home_apt,infowin_phone_home_apt,'icons/Apartment_NH.png','icons/Apartment_MouseOver.png');
    CreateMarkerB(marker_phone_nt_apt,infowin_phone_nt_apt,'icons/Apartment_NH.png','icons/Apartment_MouseOver.png');
    CreateMarkerB(marker_dnc_apt,infowin_dnc_apt,'icons/Apartment_NH.png','icons/Apartment_MouseOver.png');
    
    CreateMarkerB(marker_resident_multi,infowin_resident_multi,'icons/Duplex_NH.png','icons/Duplex_MouseOver.png');
    CreateMarkerB(marker_resident_nw_multi,infowin_resident_nw_multi,'icons/Duplex_NH.png','icons/Duplex_MouseOver.png');
    CreateMarkerB(marker_resident_home_multi,infowin_resident_home_multi,'icons/Duplex_NH.png','icons/Duplex_MouseOver.png');
    CreateMarkerB(marker_resident_nt_multi,infowin_resident_nt_multi,'icons/Duplex_NH.png','icons/Duplex_MouseOver.png');
    CreateMarkerB(marker_phone_multi,infowin_phone_multi,'icons/Duplex_NH.png','icons/Duplex_MouseOver.png');
    CreateMarkerB(marker_phone_nw_multi,infowin_phone_nw_multi,'icons/Duplex_NH.png','icons/Duplex_MouseOver.png');    
    CreateMarkerB(marker_phone_home_multi,infowin_phone_home_multi,'icons/Duplex_NH.png','icons/Duplex_MouseOver.png');
    CreateMarkerB(marker_phone_nt_multi,infowin_phone_nt_multi,'icons/Duplex_NH.png','icons/Duplex_MouseOver.png');
    CreateMarkerB(marker_dnc_multi,infowin_dnc_multi,'icons/Duplex_NH.png','icons/Duplex_MouseOver.png');
   
    CreateMarker(marker_resident,infowin_resident,'icons/House_NH.png','icons/House_MouseOver.png');
    CreateMarker(marker_resident_nw,infowin_resident_nw,'icons/House_NW.png','icons/House_MouseOver.png');
    CreateMarker(marker_resident_home,infowin_resident_home,'icons/House_HH.png','icons/House_MouseOver.png');
    CreateMarker(marker_resident_nt,infowin_resident_nt,'icons/House_NTR.png','icons/House_MouseOver.png');
    CreateMarker(marker_phone,infowin_phone,'icons/Phone_NH.png','icons/Phone_MouseOver.png');
    CreateMarker(marker_phone_nw,infowin_phone_nw,'icons/Phone_NW.png','icons/Phone_MouseOver.png');
    CreateMarker(marker_phone_home,infowin_phone_home,'icons/Phone_HH.png','icons/Phone_MouseOver.png');
    CreateMarker(marker_phone_nt,infowin_phone_nt,'icons/Phone_NTR.png','icons/Phone_MouseOver.png');
    CreateMarker(marker_dnc,infowin_dnc,'icons/DNC.png','icons/DNC_MouseOver.png');
 

  
   function CreateLegend1(){
         var legend = document.getElementById('mylegend');

         for (var key in icons) {
            var type = icons[key];
            var label = type.label;
            var icon = type.icon;
            var div = document.createElement('div');
//            div.innerHTML = '<img src="' + icon + '"> ' + label;
            div.innerHTML = label + ' <br><img src="' + icon + '"><br><br>';
            legend.appendChild(div);
        }

        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
       
   }
   
   function topPanel(){
   var territory = document.getElementById('myterritory');
   var div1 = document.createElement('div');
   div1.innerHTML = '<a href = "territorymap.php?territory=' + territoryNumber + '">' + territoryNumber + '</a>';
   territory.appendChild(div1);
   map.controls[google.maps.ControlPosition.TOP_LEFT].push(territory);
   
   var eyeglass = document.getElementById('myeyeglass');
   var div2 = document.createElement('div');   
   div2.innerHTML = '<img id ="eyeglass" src = "icons/eyeglass1.png">';
   eyeglass.appendChild(div2);
   map.controls[google.maps.ControlPosition.TOP_LEFT].push(eyeglass);
   }
   
//      function CreateLegend2(){
//         var legend = document.getElementById('mylegend');
//         var div = document.createElement('div');
//              
//            div.innerHTML = '<table>' +
//                            '<tr>' +
//                            '<td>' + icons.NW.label + '<img src="' + icons.NW.icon + '"></td>' +
//                            '<td>' + icons.NH.label + '<img src="' + icons.NH.icon + '"></td>' +   
//                            '<td>' + icons.HH.label + '<img src="' + icons.HH.icon + '"></td>' +                              
//                            '</tr>' + 
//                            '<tr>' +
//                            '<td>' + icons.NTR.label + '<img src="' + icons.NTR.icon + '"></td>' +
//                            '<td>' + icons.Phone_NW.label + '<img src="' + icons.Phone_NW.icon + '"></td>' +   
//                            '<td>' + icons.Phone_NH.label + '<img src="' + icons.Phone_NH.icon + '"></td>' +                              
//                            '</tr>' +   
//                            '<tr>' +
//                            '<td>' + icons.Phone_HH.label + '<img src="' + icons.Phone_HH.icon + '"></td>' +
//                            '<td>' + icons.Phone_NTR.label + '<img src="' + icons.Phone_NTR.icon + '"></td>' +   
//                            '<td>' + icons.DNC.label + '<img src="' + icons.DNC.icon + '"></td>' +                              
//                            '</tr>' + 
//                            '</table>' +
//            legend.appendChild(div);
//        }
//
//        map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(legend);
//       
//   }
 
 
   
    function CreateMarker(marker,layer,icon,mouseoverIcon){
        for (var i = 0; i <layer.length; i++) {
               //create marker

               var myinfowindow = new google.maps.InfoWindow({ content: layer[i][0] });

               marker.push(new google.maps.Marker({
                   position: new google.maps.LatLng(layer[i][1], layer[i][2]),
                   icon: icon,
                   map: map,
                   draggable: false,
                   infowindow: myinfowindow

               }));

               marker[i].setMap(map);

               google.maps.event.addListener(marker[i], "click", function () {this.infowindow.open(map, this);});
               google.maps.event.addListener(marker[i], "mouseover",function() {this.setIcon(mouseoverIcon);});
               google.maps.event.addListener(marker[i], "mouseout",function() {this.setIcon(icon);});   
        }
    }
    
    
        function CreateMarkerA(marker,layer,icon,mouseoverIcon){
        for (var i = 0; i <layer.length; i++) {
               //create marker

               var myinfowindow = new google.maps.InfoWindow({ content: layer[i][0] });

               marker.push(new google.maps.Marker({
                   position: new google.maps.LatLng(layer[i][1], layer[i][2]),
                   icon: icon,
                   map: map,
                   draggable: true,
                   infowindow: myinfowindow

               }));

               marker[i].setMap(map);

               google.maps.event.addListener(marker[i], "click", function () {
                   
                    for(var index = 0; index<marker.length;index++){
                        marker[index].infowindow.close();
                    }                   
                    this.infowindow.open(map, this);
                    infowin_index = Number(document.getElementById("index").value);
                   
               });
               google.maps.event.addListener(marker[i], "mouseover",function() {this.setIcon(mouseoverIcon);});
               google.maps.event.addListener(marker[i], "mouseout",function() {this.setIcon(icon);});   
        }
    }
    
    
        function CreateMarkerB(marker,layer,icon,mouseoverIcon){
        for (var i = 0; i <layer.length; i++) {
               //create marker

               var myinfowindow = new google.maps.InfoWindow({ content: layer[i][0] });

               marker.push(new google.maps.Marker({
                   position: new google.maps.LatLng(layer[i][1], layer[i][2]),
                   map: map,
                   draggable: false,
                   infowindow: myinfowindow,
                   visible: false

               }));

               marker[i].setMap(map);
               google.maps.event.addListener(marker[i], "click", function () {this.infowindow.open(map, this);});                 
   
        }
    }

    function disable(){
        var bPhone = escape(document.getElementById("bPhone").value);
        document.getElementById("Language").disabled = true;
        document.getElementById("Type").disabled = true;
        if (bPhone=="true"){
         document.getElementById("PhoneType").disabled = true;}
       
    }

    function enable(){
        var bPhone = escape(document.getElementById("bPhone").value);
        document.getElementById("Language").disabled = false;
        document.getElementById("Type").disabled = false;
        if (bPhone=="true"){
         document.getElementById("PhoneType").disabled = false;}

    }
    
    
    function TerritoryType(type)
    {
        switch(type)
        {
            case "DNC":
             return "Do Not Call";
             break;
            case "HH":
             return "Home";
             break;
            case "NH":
             return "Not Home";
             break;
            case "NTR":
             return "No Trespassing";
             break;
        }


    }


    function openInfowindow(markername,index){
        
        switch  (markername){
                case "marker_resident_nw_apt":  
                  //marker_resident_apt[index].infowindow.open(map, this);
                  google.maps.event.trigger(marker_resident_nw_apt[index], "click");               
                  break;            
                case "marker_resident_apt":  
                  //marker_resident_apt[index].infowindow.open(map, this);
                  google.maps.event.trigger(marker_resident_apt[index], "click");
                  break;
                case "marker_resident_home_apt": 
                  //marker_resident_home_apt[index].infowindow.open(map, this);
                  google.maps.event.trigger(marker_resident_home_apt[index], "click");
                  break;
                case "marker_resident_nt_apt":
                  //marker_resident_nt_apt[index].infowindow.open(map, this);
                  google.maps.event.trigger(marker_resident_nt_apt[index], "click");
                  break;
                case "marker_dnc_apt":
                  //marker_dnc_apt[index].infowindow.open(map, this);
                  google.maps.event.trigger(marker_dnc_apt[index], "click");
                  break;
                case "marker_phone_nw_apt":
                  //marker_phone_apt[index].infowindow.open(map, this);
                  google.maps.event.trigger(marker_phone_nw_apt[index], "click");
                  break;                  
                case "marker_phone_apt":
                  //marker_phone_apt[index].infowindow.open(map, this);
                  google.maps.event.trigger(marker_phone_apt[index], "click");
                  break;
                case "marker_phone_home_apt":
                  //marker_phone_home_apt[index].infowindow.open(map, this);
                  google.maps.event.trigger(marker_phone_home_apt[index], "click");
                  break;
                case "marker_phone_nt_apt":
                  //marker_phone_nt_apt[index].infowindow.open(map, this);
                  google.maps.event.trigger(marker_phone_nt_apt[index], "click");
                  break;                                                      
                case "marker_resident_nw_multi":  
                  //marker_resident_apt[index].infowindow.open(map, this);
                  google.maps.event.trigger(marker_resident_nw_multi[index], "click");
                  break;            
                case "marker_resident_multi":  
                  //marker_resident_apt[index].infowindow.open(map, this);
                  google.maps.event.trigger(marker_resident_multi[index], "click");
                  break;
                case "marker_resident_home_multi": 
                  //marker_resident_home_apt[index].infowindow.open(map, this);
                  google.maps.event.trigger(marker_resident_home_multi[index], "click");
                  break;
                case "marker_resident_nt_multi":
                  //marker_resident_nt_apt[index].infowindow.open(map, this);
                  google.maps.event.trigger(marker_resident_nt_multi[index], "click");
                  break;
                case "marker_dnc_multi":
                  //marker_dnc_apt[index].infowindow.open(map, this);
                  google.maps.event.trigger(marker_dnc_multi[index], "click");
                  break;
                case "marker_phone_nw_multi":
                  //marker_phone_apt[index].infowindow.open(map, this);
                  google.maps.event.trigger(marker_phone_nw_multi[index], "click");
                  break;                  
                case "marker_phone_multi":
                  //marker_phone_apt[index].infowindow.open(map, this);
                  google.maps.event.trigger(marker_phone_multi[index], "click");
                  break;
                case "marker_phone_home_multi":
                  //marker_phone_home_apt[index].infowindow.open(map, this);
                  google.maps.event.trigger(marker_phone_home_multi[index], "click");
                  break;
                case "marker_phone_nt_multi":
                  //marker_phone_nt_apt[index].infowindow.open(map, this);
                  google.maps.event.trigger(marker_phone_nt_multi[index], "click");
                  break;                  
        }  // end of switch
        
        for(var i = 0; i<marker_apt.length;i++){
            marker_apt[i].infowindow.close();
        }
                
        for(var i = 0; i<marker_multi.length;i++){
            marker_multi[i].infowindow.close();
        } 

    }
    
    
    function closeInfowindow(markername,index){
        
        switch  (markername){
                case "marker_resident_nw":
                  marker_resident_nw[index].infowindow.close();
                  break;            
                case "marker_resident":
                  marker_resident[index].infowindow.close();
                  break;
                case "marker_resident_home":
                  marker_resident_home[index].infowindow.close();
                  break;
                case "marker_resident_nt":
                  marker_resident_nt[index].infowindow.close();
                  break;
                case "marker_dnc":
                  marker_dnc[index].infowindow.close();
                  break;
                case "marker_phone_nw":
                  marker_phone_nw[index].infowindow.close();
                  break;                  
                case "marker_phone":
                  marker_phone[index].infowindow.close();
                  break;
                case "marker_phone_home":
                  marker_phone_home[index].infowindow.close();
                  break;
                case "marker_phone_nt":
                  marker_phone_nt[index].infowindow.close();
                  break;
                case "marker_resident_nw_apt":
                  marker_resident_nw_apt[index].infowindow.close();
                  break;                  
                case "marker_resident_apt":
                  marker_resident_apt[index].infowindow.close();
                  break;
                case "marker_resident_home_apt":
                  marker_resident_home_apt[index].infowindow.close();
                  break;
                case "marker_resident_nt_apt":
                  marker_resident_nt_apt[index].infowindow.close();
                  break;
                case "marker_dnc_apt":
                  marker_dnc_apt[index].infowindow.close();
                  break;
                case "marker_phone_nw_apt":
                  marker_phone_nw_apt[index].infowindow.close();
                  break;                  
                case "marker_phone_apt":
                  marker_phone_apt[index].infowindow.close();
                  break;
                case "marker_phone_home_apt":
                  marker_phone_home_apt[index].infowindow.close();
                  break;
                case "marker_phone_nt_apt":
                  marker_phone_nt_apt[index].infowindow.close();
                  break;                                                            
                case "marker_resident_nw_multi":
                  marker_resident_nw_multi[index].infowindow.close();
                  break;                  
                case "marker_resident_multi":
                  marker_resident_multi[index].infowindow.close();
                  break;
                case "marker_resident_home_multi":
                  marker_resident_home_multi[index].infowindow.close();
                  break;
                case "marker_resident_nt_multi":
                  marker_resident_nt_multi[index].infowindow.close();
                  break;
                case "marker_dnc_multi":
                  marker_dnc_multi[index].infowindow.close();
                  break;
                case "marker_phone_nw_multi":
                  marker_phone_nw_multi[index].infowindow.close();
                  break;                  
                case "marker_phone_multi":
                  marker_phone_multi[index].infowindow.close();
                  break;
                case "marker_phone_home_multi":
                  marker_phone_home_multi[index].infowindow.close();
                  break;
                case "marker_phone_nt_multi":
                  marker_phone_nt_multi[index].infowindow.close();
                  break;                        
        }  // end of switch  
    }    
    
    
    function saveData(markername,index,bInfowin) {
        var addressguid;
        var type;
        var language;
        var bPhone;
        var initdate;
        var phonetype;
        var n1; 
        var n2; 
        var n3; 
        var n4; 
        var n5; 
        var n6;
        
        var n1_user; 
        var n2_user; 
        var n3_user; 
        var n4_user; 
        var n5_user; 
        var n6_user;        

        var n1d; 
        var n2d;
        var n3d;
        var n4d; 
        var n5d;
        var n6d;   

        var N1_typedesc;
        var N2_typedesc;
        var N3_typedesc;
        var N4_typedesc;
        var N5_typedesc;
        var N6_typedesc;

        var n;
        var nt;
        var d = new Date(); 
        var datestring = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());
        
      if(bInfowin===0){
        addressguid = escape(document.getElementById("AddressGUID"  + index).value);
        type = escape(document.getElementById("Type" + index).value);
        language = escape(document.getElementById("Language" + index).value);
        bPhone = escape(document.getElementById("bPhone" + index).value);

        initdate = escape(document.getElementById("InitDate" + index).value);

        n = escape(document.getElementById("Notes" + index).value);
        nt = parseInt(escape(document.getElementById("N_total"  + index).value));
        
        if(bPhone=="1")
        {
          phonetype = escape(document.getElementById("PhoneType" + index).value);
        } else{phonetype="NC";}
        
        
        if(initdate=="")
        {
            initdate = datestring;
        }

        if(nt==1) 
        {
            n1 = escape(document.getElementById("N1_content" + index).value); 
            n1_user = escape(document.getElementById("N1_username" + index).value);
            n1d = escape(document.getElementById("N1_date" + index).value);
            N1_typedesc = escape(document.getElementById("N1_typedesc" + index).value);
        }

        if(nt==2) 
        {
            n1 = escape(document.getElementById("N1_content" + index).value);   
            n1_user = escape(document.getElementById("N1_username" + index).value);            
            n1d = escape(document.getElementById("N1_date" + index).value);
            N1_typedesc = escape(document.getElementById("N1_typedesc" + index).value);

            n2 = escape(document.getElementById("N2_content" + index).value);    
            n2_user = escape(document.getElementById("N2_username" + index).value);            
            n2d = escape(document.getElementById("N2_date" + index).value); 
            N2_typedesc = escape(document.getElementById("N2_typedesc" + index).value);
        }     

        if(nt==3) 
        {
            n1 = escape(document.getElementById("N1_content" + index).value);    
            n1_user = escape(document.getElementById("N1_username" + index).value);            
            n1d = escape(document.getElementById("N1_date" + index).value);
            N1_typedesc = escape(document.getElementById("N1_typedesc" + index).value);

            n2 = escape(document.getElementById("N2_content" + index).value); 
            n2_user = escape(document.getElementById("N2_username" + index).value);            
            n2d = escape(document.getElementById("N2_date" + index).value); 
            N2_typedesc = escape(document.getElementById("N2_typedesc" + index).value);

            n3 = escape(document.getElementById("N3_content" + index).value);  
            n3_user = escape(document.getElementById("N3_username" + index).value);            
            n3d = escape(document.getElementById("N3_date" + index).value); 
            N3_typedesc = escape(document.getElementById("N3_typedesc" + index).value);
        }

        if(nt==4) 
        {
            n1 = escape(document.getElementById("N1_content" + index).value); 
            n1_user = escape(document.getElementById("N1_username" + index).value);            
            n1d = escape(document.getElementById("N1_date" + index).value);
            N1_typedesc = escape(document.getElementById("N1_typedesc" + index).value);

            n2 = escape(document.getElementById("N2_content" + index).value); 
            n2_user = escape(document.getElementById("N2_username" + index).value);            
            n2d = escape(document.getElementById("N2_date" + index).value);
            N2_typedesc = escape(document.getElementById("N2_typedesc" + index).value);

            n3 = escape(document.getElementById("N3_content" + index).value); 
            n3_user = escape(document.getElementById("N3_username" + index).value);            
            n3d = escape(document.getElementById("N3_date" + index).value);
            N3_typedesc = escape(document.getElementById("N3_typedesc" + index).value);

            n4 = escape(document.getElementById("N4_content" + index).value); 
            n4_user = escape(document.getElementById("N4_username" + index).value);            
            n4d = escape(document.getElementById("N4_date" + index).value); 
            N4_typedesc = escape(document.getElementById("N4_typedesc" + index).value);
        } 

        if(nt==5) 
        {
            n1 = escape(document.getElementById("N1_content" + index).value); 
            n1_user = escape(document.getElementById("N1_username" + index).value);            
            n1d = escape(document.getElementById("N1_date" + index).value);
            N1_typedesc = escape(document.getElementById("N1_typedesc" + index).value);

            n2 = escape(document.getElementById("N2_content" + index).value);
            n2_user = escape(document.getElementById("N2_username" + index).value);            
            n2d = escape(document.getElementById("N2_date" + index).value);
            N2_typedesc = escape(document.getElementById("N2_typedesc" + index).value);

            n3 = escape(document.getElementById("N3_content" + index).value);  
            n3_user = escape(document.getElementById("N3_username" + index).value);            
            n3d = escape(document.getElementById("N3_date" + index).value); 
            N3_typedesc = escape(document.getElementById("N3_typedesc" + index).value);

            n4 = escape(document.getElementById("N4_content" + index).value);    
            n4_user = escape(document.getElementById("N4_username" + index).value);            
            n4d = escape(document.getElementById("N4_date" + index).value);
            N4_typedesc = escape(document.getElementById("N4_typedesc" + index).value);

            n5 = escape(document.getElementById("N5_content" + index).value);
            n5_user = escape(document.getElementById("N5_username" + index).value);            
            n5d = escape(document.getElementById("N5_date" + index).value);
            N5_typedesc = escape(document.getElementById("N5_typedesc" + index).value);
        }    

        if(nt==6) 
        {
            n1 = escape(document.getElementById("N1_content" + index).value);
            n1_user = escape(document.getElementById("N1_username" + index).value);            
            n1d = escape(document.getElementById("N1_date" + index).value);
            N1_typedesc = escape(document.getElementById("N1_typedesc" + index).value);

            n2 = escape(document.getElementById("N2_content" + index).value);  
            n2_user = escape(document.getElementById("N2_username" + index).value);            
            n2d = escape(document.getElementById("N2_date" + index).value);
            N2_typedesc = escape(document.getElementById("N2_typedesc" + index).value);

            n3 = escape(document.getElementById("N3_content" + index).value); 
            n3_user = escape(document.getElementById("N3_username" + index).value);            
            n3d = escape(document.getElementById("N3_date" + index).value);
            N3_typedesc = escape(document.getElementById("N3_typedesc" + index).value);

            n4 = escape(document.getElementById("N4_content" + index).value); 
            n4_user = escape(document.getElementById("N4_username" + index).value);            
            n4d = escape(document.getElementById("N4_date" + index).value); 
            N4_typedesc = escape(document.getElementById("N4_typedesc" + index).value);

            n5 = escape(document.getElementById("N5_content" + index).value); 
            n5_user = escape(document.getElementById("N5_username" + index).value);            
            n5d = escape(document.getElementById("N5_date" + index).value); 
            N5_typedesc = escape(document.getElementById("N5_typedesc" + index).value);

            n6 = escape(document.getElementById("N6_content" + index).value); 
            n6_user = escape(document.getElementById("N6_username" + index).value);            
            n6d = escape(document.getElementById("N6_date" + index).value); 
            N6_typedesc = escape(document.getElementById("N6_typedesc" + index).value);
        }          
      }
              
      if(bInfowin===1){
        addressguid = escape(document.getElementById("AddressGUID").value);
        type = escape(document.getElementById("Type").value);
        language = escape(document.getElementById("Language").value);
        bPhone = escape(document.getElementById("bPhone").value);

        initdate = escape(document.getElementById("InitDate").value);

        n = escape(document.getElementById("Notes").value);
        nt = parseInt(escape(document.getElementById("N_total").value));
        
        if(bPhone=="true")
        {
          phonetype = escape(document.getElementById("PhoneType").value);
        } else{phonetype="NC";}
        
        
        if(initdate=="")
        {
            initdate = datestring;
        }

        if(nt==1) 
        {
            n1 = escape(document.getElementById("N1_content").value); 
            n1_user = escape(document.getElementById("N1_username").value);
            n1d = escape(document.getElementById("N1_date").value);
            N1_typedesc = escape(document.getElementById("N1_typedesc").value);
        }

        if(nt==2) 
        {
            n1 = escape(document.getElementById("N1_content").value);   
            n1_user = escape(document.getElementById("N1_username").value);            
            n1d = escape(document.getElementById("N1_date").value);
            N1_typedesc = escape(document.getElementById("N1_typedesc").value);

            n2 = escape(document.getElementById("N2_content").value);    
            n2_user = escape(document.getElementById("N2_username").value);            
            n2d = escape(document.getElementById("N2_date").value); 
            N2_typedesc = escape(document.getElementById("N2_typedesc").value);
        }     

        if(nt==3) 
        {
            n1 = escape(document.getElementById("N1_content").value);    
            n1_user = escape(document.getElementById("N1_username").value);            
            n1d = escape(document.getElementById("N1_date").value);
            N1_typedesc = escape(document.getElementById("N1_typedesc").value);

            n2 = escape(document.getElementById("N2_content").value); 
            n2_user = escape(document.getElementById("N2_username").value);            
            n2d = escape(document.getElementById("N2_date").value); 
            N2_typedesc = escape(document.getElementById("N2_typedesc").value);

            n3 = escape(document.getElementById("N3_content").value);  
            n3_user = escape(document.getElementById("N3_username").value);            
            n3d = escape(document.getElementById("N3_date").value); 
            N3_typedesc = escape(document.getElementById("N3_typedesc").value);
        }

        if(nt==4) 
        {
            n1 = escape(document.getElementById("N1_content").value); 
            n1_user = escape(document.getElementById("N1_username").value);            
            n1d = escape(document.getElementById("N1_date").value);
            N1_typedesc = escape(document.getElementById("N1_typedesc").value);

            n2 = escape(document.getElementById("N2_content").value); 
            n2_user = escape(document.getElementById("N2_username").value);            
            n2d = escape(document.getElementById("N2_date").value);
            N2_typedesc = escape(document.getElementById("N2_typedesc").value);

            n3 = escape(document.getElementById("N3_content").value); 
            n3_user = escape(document.getElementById("N3_username").value);            
            n3d = escape(document.getElementById("N3_date").value);
            N3_typedesc = escape(document.getElementById("N3_typedesc").value);

            n4 = escape(document.getElementById("N4_content").value); 
            n4_user = escape(document.getElementById("N4_username").value);            
            n4d = escape(document.getElementById("N4_date").value); 
            N4_typedesc = escape(document.getElementById("N4_typedesc").value);
        } 

        if(nt==5) 
        {
            n1 = escape(document.getElementById("N1_content").value); 
            n1_user = escape(document.getElementById("N1_username").value);            
            n1d = escape(document.getElementById("N1_date").value);
            N1_typedesc = escape(document.getElementById("N1_typedesc").value);

            n2 = escape(document.getElementById("N2_content").value);
            n2_user = escape(document.getElementById("N2_username").value);            
            n2d = escape(document.getElementById("N2_date").value);
            N2_typedesc = escape(document.getElementById("N2_typedesc").value);

            n3 = escape(document.getElementById("N3_content").value);  
            n3_user = escape(document.getElementById("N3_username").value);            
            n3d = escape(document.getElementById("N3_date").value); 
            N3_typedesc = escape(document.getElementById("N3_typedesc").value);

            n4 = escape(document.getElementById("N4_content").value);    
            n4_user = escape(document.getElementById("N4_username").value);            
            n4d = escape(document.getElementById("N4_date").value);
            N4_typedesc = escape(document.getElementById("N4_typedesc").value);

            n5 = escape(document.getElementById("N5_content").value);
            n5_user = escape(document.getElementById("N5_username").value);            
            n5d = escape(document.getElementById("N5_date").value);
            N5_typedesc = escape(document.getElementById("N5_typedesc").value);
        }    

        if(nt==6) 
        {
            n1 = escape(document.getElementById("N1_content").value);
            n1_user = escape(document.getElementById("N1_username").value);            
            n1d = escape(document.getElementById("N1_date").value);
            N1_typedesc = escape(document.getElementById("N1_typedesc").value);

            n2 = escape(document.getElementById("N2_content").value);  
            n2_user = escape(document.getElementById("N2_username").value);            
            n2d = escape(document.getElementById("N2_date").value);
            N2_typedesc = escape(document.getElementById("N2_typedesc").value);

            n3 = escape(document.getElementById("N3_content").value); 
            n3_user = escape(document.getElementById("N3_username").value);            
            n3d = escape(document.getElementById("N3_date").value);
            N3_typedesc = escape(document.getElementById("N3_typedesc").value);

            n4 = escape(document.getElementById("N4_content").value); 
            n4_user = escape(document.getElementById("N4_username").value);            
            n4d = escape(document.getElementById("N4_date").value); 
            N4_typedesc = escape(document.getElementById("N4_typedesc").value);

            n5 = escape(document.getElementById("N5_content").value); 
            n5_user = escape(document.getElementById("N5_username").value);            
            n5d = escape(document.getElementById("N5_date").value); 
            N5_typedesc = escape(document.getElementById("N5_typedesc").value);

            n6 = escape(document.getElementById("N6_content").value); 
            n6_user = escape(document.getElementById("N6_username").value);            
            n6d = escape(document.getElementById("N6_date").value); 
            N6_typedesc = escape(document.getElementById("N6_typedesc").value);
        }                    
        
      }


        var notes="<notes>";
        if(nt==6) 
        {         
            notes=notes + "<note><date>" + n2d + "</date><username>" + n2_user + "</username><typedescription>" + N2_typedesc + "</typedescription><content>" + n2 + "</content></note>";
            notes=notes + "<note><date>" + n3d + "</date><username>" + n3_user + "</username><typedescription>" + N3_typedesc + "</typedescription><content>" + n3 + "</content></note>";
            notes=notes + "<note><date>" + n4d + "</date><username>" + n4_user + "</username><typedescription>" + N4_typedesc + "</typedescription><content>" + n4 + "</content></note>";    
            notes=notes + "<note><date>" + n5d + "</date><username>" + n5_user + "</username><typedescription>" + N5_typedesc + "</typedescription><content>" + n5 + "</content></note>"; 
            notes=notes + "<note><date>" + n6d + "</date><username>" + n6_user + "</username><typedescription>" + N6_typedesc + "</typedescription><content>" + n6 + "</content></note>";           
            notes=notes + "<note><date>" + datestring  + "</date><username>" + username + "</username><typedescription>" + TerritoryType(type) + "</typedescription><content>" + n + "</content></note>";          
        }        
        if(nt==5) 
        {
            notes=notes + "<note><date>" + n1d + "</date><username>" + n1_user + "</username><typedescription>" + N1_typedesc + "</typedescription><content>" + n1 + "</content></note>";          
            notes=notes + "<note><date>" + n2d + "</date><username>" + n2_user + "</username><typedescription>" + N2_typedesc + "</typedescription><content>" + n2 + "</content></note>";
            notes=notes + "<note><date>" + n3d + "</date><username>" + n3_user + "</username><typedescription>" + N3_typedesc + "</typedescription><content>" + n3 + "</content></note>";
            notes=notes + "<note><date>" + n4d + "</date><username>" + n4_user + "</username><typedescription>" + N4_typedesc + "</typedescription><content>" + n4 + "</content></note>";    
            notes=notes + "<note><date>" + n5d + "</date><username>" + n5_user + "</username><typedescription>" + N5_typedesc + "</typedescription><content>" + n5 + "</content></note>";           
            notes=notes + "<note><date>" + datestring  + "</date><username>" + username + "</username><typedescription>" + TerritoryType(type) + "</typedescription><content>" + n + "</content></note>";          
        }      
        if(nt==4) 
        {
            notes=notes + "<note><date>" + n1d + "</date><username>" + n1_user + "</username><typedescription>" + N1_typedesc + "</typedescription><content>" + n1 + "</content></note>";          
            notes=notes + "<note><date>" + n2d + "</date><username>" + n2_user + "</username><typedescription>" + N2_typedesc + "</typedescription><content>" + n2 + "</content></note>";
            notes=notes + "<note><date>" + n3d + "</date><username>" + n3_user + "</username><typedescription>" + N3_typedesc + "</typedescription><content>" + n3 + "</content></note>";
            notes=notes + "<note><date>" + n4d + "</date><username>" + n4_user + "</username><typedescription>" + N4_typedesc + "</typedescription><content>" + n4 + "</content></note>";          
            notes=notes + "<note><date>" + datestring  + "</date><username>" + username + "</username><typedescription>" + TerritoryType(type) + "</typedescription><content>" + n + "</content></note>";          
        }      
        if(nt==3) 
        {
            notes=notes + "<note><date>" + n1d + "</date><username>" + n1_user + "</username><typedescription>" + N1_typedesc + "</typedescription><content>" + n1 + "</content></note>";          
            notes=notes + "<note><date>" + n2d + "</date><username>" + n2_user + "</username><typedescription>" + N2_typedesc + "</typedescription><content>" + n2 + "</content></note>";
            notes=notes + "<note><date>" + n3d + "</date><username>" + n3_user + "</username><typedescription>" + N3_typedesc + "</typedescription><content>" + n3 + "</content></note>";
            notes=notes + "<note><date>" + datestring  + "</date><username>" + username + "</username><typedescription>" + TerritoryType(type) + "</typedescription><content>" + n + "</content></note>";          
        }
        if(nt==2) 
        {
            notes=notes + "<note><date>" + n1d + "</date><username>" + n1_user + "</username><typedescription>" + N1_typedesc + "</typedescription><content>" + n1 + "</content></note>";
            notes=notes + "<note><date>" + n2d + "</date><username>" + n2_user + "</username><typedescription>" + N2_typedesc + "</typedescription><content>" + n2 + "</content></note>";
            notes=notes + "<note><date>" + datestring  + "</date><username>" + username + "</username><typedescription>" + TerritoryType(type) + "</typedescription><content>" + n + "</content></note>";          
        }  
        if(nt==1) 
        {
            notes=notes + "<note><date>" + n1d + "</date><username>" + n1_user + "</username><typedescription>" + N1_typedesc + "</typedescription><content>" + n1 + "</content></note>";
            notes=notes + "<note><date>" + datestring  + "</date><username>" + username + "</username><typedescription>" + TerritoryType(type) + "</typedescription><content>" + n + "</content></note>";          
        }  
        if(nt==0) 
        {
            notes=notes + "<note><date>" + datestring  + "</date><username>" + username + "</username><typedescription>" + TerritoryType(type) + "</typedescription><content>" + n + "</content></note>";          
        }       

        notes=notes + "</notes>";

        var url = "db_SaveRow.php?addressguid=" + addressguid + "&type=" + type + 
                  "&phonetype=" + phonetype + "&language=" + language + "&notes=" + notes + "&initdate=" + initdate + "&moddate=" + datestring;

        downloadUrl(url, function(data, responseCode) {
          if (responseCode == 200 && data.length >= 1) {
      if(bInfowin===0){
          if(type==="NH" && bPhone==='0'){
              document.getElementById("propertyicon" + index).src = icons.NH.icon;
          }
          if(type==="HH" && bPhone==='0'){
              document.getElementById("propertyicon" + index).src = icons.HH.icon;
          } 
          if(type==="NTR" && bPhone==='0'){
              document.getElementById("propertyicon" + index).src = icons.NTR.icon;
          }   
          if(type==="NH" && bPhone==='1'){
              document.getElementById("propertyicon" + index).src = icons.Phone_NH.icon;
          }
          if(type==="HH" && bPhone==='1'){
              document.getElementById("propertyicon" + index).src = icons.Phone_HH.icon;
          } 
          if(type==="NTR" && bPhone==='1'){
              document.getElementById("propertyicon" + index).src = icons.Phone_NTR.icon;
          }
          if(type==="DNC"){
              document.getElementById("propertyicon" + index).src = icons.DNC.icon;
          }          
      }
      if(bInfowin===1){
          switch  (markername){
                  case "marker_resident_nw":
                    if (type==='NH'){
                        google.maps.event.clearListeners(marker_resident_nw[index], "mouseout");
                        google.maps.event.clearListeners(marker_resident_nw[index], "mouseover");                       
                        marker_resident_nw[index].setIcon(icons.NH.icon);
                        google.maps.event.addListener(marker_resident_nw[index], "mouseout",function() {this.setIcon(icons.NH.icon);});
                        google.maps.event.addListener(marker_resident_nw[index], "mouseover",function() {this.setIcon(icons.NH.mouseovericon);});                       
                    }
                    if (type==='HH'){
                        google.maps.event.clearListeners(marker_resident_nw[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_resident_nw[index], "mouseover");                        
                        marker_resident_nw[index].setIcon(icons.HH.icon);
                        google.maps.event.addListener(marker_resident_nw[index], "mouseout",function() {this.setIcon(icons.HH.icon);});
                        google.maps.event.addListener(marker_resident_nw[index], "mouseover",function() {this.setIcon(icons.HH.mouseovericon);});                       
                    }
                    if (type==='NTR'){
                        google.maps.event.clearListeners(marker_resident_nw[index], "mouseout");   
                        google.maps.event.clearListeners(marker_resident_nw[index], "mouseover");                        
                        marker_resident_nw[index].setIcon(icons.NTR.icon);
                        google.maps.event.addListener(marker_resident_nw[index], "mouseout",function() {this.setIcon(icons.NTR.icon);});    
                        google.maps.event.addListener(marker_resident_nw[index], "mouseover",function() {this.setIcon(icons.NTR.mouseovericon);});                       
                    }  
                    if (type==='DNC'){
                        google.maps.event.clearListeners(marker_resident_nw[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_resident_nw[index], "mouseover");                       
                        marker_resident_nw[index].setIcon(icons.DNC.icon);
                        google.maps.event.addListener(marker_resident_nw[index], "mouseout",function() {this.setIcon(icons.DNC.icon);});
                        google.maps.event.addListener(marker_resident_nw[index], "mouseover",function() {this.setIcon(icons.DNC.mouseovericon);});                       
                    }                    
                    marker_resident_nw[index].infowindow.close();
                    break;            
                  case "marker_resident":
                    if (type==='NH'){
                        google.maps.event.clearListeners(marker_resident[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_resident[index], "mouseover");                       
                        marker_resident[index].setIcon(icons.NH.icon);
                        google.maps.event.addListener(marker_resident[index], "mouseout",function() {this.setIcon(icons.NH.icon);});    
                        google.maps.event.addListener(marker_resident[index], "mouseover",function() {this.setIcon(icons.NH.mouseovericon);});                       
                    }
                    if (type==='HH'){
                        google.maps.event.clearListeners(marker_resident[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_resident[index], "mouseover");                         
                        marker_resident[index].setIcon(icons.HH.icon);
                        google.maps.event.addListener(marker_resident[index], "mouseout",function() {this.setIcon(icons.HH.icon);});    
                        google.maps.event.addListener(marker_resident[index], "mouseover",function() {this.setIcon(icons.HH.mouseovericon);});                        
                    }
                    if (type==='NTR'){
                        google.maps.event.clearListeners(marker_resident[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_resident[index], "mouseover");                        
                        marker_resident[index].setIcon(icons.NTR.icon);
                        google.maps.event.addListener(marker_resident[index], "mouseout",function() {this.setIcon(icons.NTR.icon);}); 
                        google.maps.event.addListener(marker_resident[index], "mouseover",function() {this.setIcon(icons.NTR.mouseovericon);});                        
                    }  
                    if (type==='DNC'){
                        google.maps.event.clearListeners(marker_resident[index], "mouseout");   
                        google.maps.event.clearListeners(marker_resident[index], "mouseover");                       
                        marker_resident[index].setIcon(icons.DNC.icon);
                        google.maps.event.addListener(marker_resident[index], "mouseout",function() {this.setIcon(icons.DNC.icon);});
                        google.maps.event.addListener(marker_resident[index], "mouseover",function() {this.setIcon(icons.DNC.mouseovericon);});                       
                    }                      
                    marker_resident[index].infowindow.close();
                    break;
                  case "marker_resident_home":
                    if (type==='NH'){
                        google.maps.event.clearListeners(marker_resident_home[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_resident_home[index], "mouseover");                      
                        marker_resident_home[index].setIcon(icons.NH.icon);
                        google.maps.event.addListener(marker_resident_home[index], "mouseout",function() {this.setIcon(icons.NH.icon);}); 
                        google.maps.event.addListener(marker_resident_home[index], "mouseover",function() {this.setIcon(icons.NH.mouseovericon);});                       
                    }
                    if (type==='HH'){
                        google.maps.event.clearListeners(marker_resident_home[index], "mouseout");  
                        google.maps.event.clearListeners(marker_resident_home[index], "mouseover");                       
                        marker_resident_home[index].setIcon(icons.HH.icon);
                        google.maps.event.addListener(marker_resident_home[index], "mouseout",function() {this.setIcon(icons.HH.icon);});  
                        google.maps.event.addListener(marker_resident_home[index], "mouseover",function() {this.setIcon(icons.HH.mouseovericon);});                        
                    }
                    if (type==='NTR'){
                        google.maps.event.clearListeners(marker_resident_home[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_resident_home[index], "mouseover");                       
                        marker_resident_home[index].setIcon(icons.NTR.icon);
                        google.maps.event.addListener(marker_resident_home[index], "mouseout",function() {this.setIcon(icons.NTR.icon);}); 
                        google.maps.event.addListener(marker_resident_home[index], "mouseover",function() {this.setIcon(icons.NTR.mouseovericon);});                       
                    }  
                    if (type==='DNC'){
                        google.maps.event.clearListeners(marker_resident_home[index], "mouseout");
                        google.maps.event.clearListeners(marker_resident_home[index], "mouseover");                       
                        marker_resident_home[index].setIcon(icons.DNC.icon);
                        google.maps.event.addListener(marker_resident_home[index], "mouseout",function() {this.setIcon(icons.DNC.icon);});  
                        google.maps.event.addListener(marker_resident_home[index], "mouseover",function() {this.setIcon(icons.DNC.mouseovericon);});                        
                    }                      
                    marker_resident_home[index].infowindow.close();
                    break;
                  case "marker_resident_nt":
                    if (type==='NH'){
                        google.maps.event.clearListeners(marker_resident_nt[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_resident_nt[index], "mouseover");                       
                        marker_resident_nt[index].setIcon(icons.NH.icon);
                        google.maps.event.addListener(marker_resident_nt[index], "mouseout",function() {this.setIcon(icons.NH.icon);});     
                        google.maps.event.addListener(marker_resident_nt[index], "mouseover",function() {this.setIcon(icons.NH.mouseovericon);});                        
                    }
                    if (type==='HH'){
                        google.maps.event.clearListeners(marker_resident_nt[index], "mouseout");   
                        google.maps.event.clearListeners(marker_resident_nt[index], "mouseover");                         
                        marker_resident_nt[index].setIcon(icons.HH.icon);
                        google.maps.event.addListener(marker_resident_nt[index], "mouseout",function() {this.setIcon(icons.HH.icon);});     
                        google.maps.event.addListener(marker_resident_nt[index], "mouseover",function() {this.setIcon(icons.HH.mouseovericon);});                        
                    }
                    if (type==='NTR'){
                        google.maps.event.clearListeners(marker_resident_nt[index], "mouseout");  
                        google.maps.event.clearListeners(marker_resident_nt[index], "mouseover");                       
                        marker_resident_nt[index].setIcon(icons.NTR.icon);
                        google.maps.event.addListener(marker_resident_nt[index], "mouseout",function() {this.setIcon(icons.NTR.icon);});   
                        google.maps.event.addListener(marker_resident_nt[index], "mouseover",function() {this.setIcon(icons.NTR.mouseovericon);});                       
                    }  
                    if (type==='DNC'){
                        google.maps.event.clearListeners(marker_resident_nt[index], "mouseout");  
                        google.maps.event.clearListeners(marker_resident_nt[index], "mouseover");                        
                        marker_resident_nt[index].setIcon(icons.DNC.icon);
                        google.maps.event.addListener(marker_resident_nt[index], "mouseout",function() {this.setIcon(icons.DNC.icon);}); 
                        google.maps.event.addListener(marker_resident_nt[index], "mouseover",function() {this.setIcon(icons.DNC.mouseovericon);});                       
                    }                      
                    marker_resident_nt[index].infowindow.close();
                    break;
                  case "marker_dnc":
                    if (type==='NH'){
                        google.maps.event.clearListeners(marker_dnc[index], "mouseout");      
                        google.maps.event.clearListeners(marker_dnc[index], "mouseover");                        
                        marker_dnc[index].setIcon(icons.NH.icon);
                        google.maps.event.addListener(marker_dnc[index], "mouseout",function() {this.setIcon(icons.NH.icon);});  
                        google.maps.event.addListener(marker_dnc[index], "mouseover",function() {this.setIcon(icons.NH.mouseovericon);});                       
                    }
                    if (type==='HH'){
                        google.maps.event.clearListeners(marker_dnc[index], "mouseout");   
                        google.maps.event.clearListeners(marker_dnc[index], "mouseover");                         
                        marker_dnc[index].setIcon(icons.HH.icon);
                        google.maps.event.addListener(marker_dnc[index], "mouseout",function() {this.setIcon(icons.HH.icon);});    
                        google.maps.event.addListener(marker_dnc[index], "mouseover",function() {this.setIcon(icons.HH.mouseovericon);});                       
                    }
                    if (type==='NTR'){
                        google.maps.event.clearListeners(marker_dnc[index], "mouseout");    
                        google.maps.event.clearListeners(marker_dnc[index], "mouseover");                      
                        marker_dnc[index].setIcon(icons.NTR.icon);
                        google.maps.event.addListener(marker_dnc[index], "mouseout",function() {this.setIcon(icons.NTR.icon);});  
                        google.maps.event.addListener(marker_dnc[index], "mouseover",function() {this.setIcon(icons.NTR.mouseovericon);});                        
                    }  
                    if (type==='DNC'){
                        google.maps.event.clearListeners(marker_dnc[index], "mouseout");  
                        google.maps.event.clearListeners(marker_dnc[index], "mouseover");                       
                        marker_dnc[index].setIcon(icons.DNC.icon);
                        google.maps.event.addListener(marker_dnc[index], "mouseout",function() {this.setIcon(icons.DNC.icon);}); 
                        google.maps.event.addListener(marker_dnc[index], "mouseover",function() {this.setIcon(icons.DNC.mouseovericon);});                        
                    }                        
                    marker_dnc[index].infowindow.close();
                    break;
                  case "marker_phone_nw":
                    if (type==='NH'){
                        google.maps.event.clearListeners(marker_phone_nw[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_phone_nw[index], "mouseover");                      
                        marker_phone_nw[index].setIcon(icons.Phone_NH.icon);
                        google.maps.event.addListener(marker_phone_nw[index], "mouseout",function() {this.setIcon(icons.Phone_NH.icon);});
                        google.maps.event.addListener(marker_phone_nw[index], "mouseover",function() {this.setIcon(icons.Phone_NH.mouseovericon);});                       
                    }
                    if (type==='HH'){
                        google.maps.event.clearListeners(marker_phone_nw[index], "mouseout");     
                        google.maps.event.clearListeners(marker_phone_nw[index], "mouseover");                       
                        marker_phone_nw[index].setIcon(icons.Phone_HH.icon);
                        google.maps.event.addListener(marker_phone_nw[index], "mouseout",function() {this.setIcon(icons.Phone_HH.icon);}); 
                        google.maps.event.addListener(marker_phone_nw[index], "mouseover",function() {this.setIcon(icons.Phone_HH.mouseovericon);});                        
                    }
                    if (type==='NTR'){
                        google.maps.event.clearListeners(marker_phone_nw[index], "mouseout");     
                        google.maps.event.clearListeners(marker_phone_nw[index], "mouseover");                       
                        marker_phone_nw[index].setIcon(icons.Phone_NTR.icon);
                        google.maps.event.addListener(marker_phone_nw[index], "mouseout",function() {this.setIcon(icons.Phone_NTR.icon);});  
                        google.maps.event.addListener(marker_phone_nw[index], "mouseover",function() {this.setIcon(icons.Phone_NTR.mouseovericon);});                        
                    }  
                    if (type==='DNC'){
                        google.maps.event.clearListeners(marker_phone_nw[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_phone_nw[index], "mouseover"); 
                        marker_phone_nw[index].setIcon(icons.DNC.icon);
                        google.maps.event.addListener(marker_phone_nw[index], "mouseout",function() {this.setIcon(icons.DNC.icon);});
                        google.maps.event.addListener(marker_phone_nw[index], "mouseover",function() {this.setIcon(icons.DNC.mouseovericon);});                      
                    }                       
                    marker_phone_nw[index].infowindow.close();
                    break;                  
                  case "marker_phone":
                    if (type==='NH'){
                        google.maps.event.clearListeners(marker_phone[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_phone[index], "mouseover");                      
                        marker_phone[index].setIcon(icons.Phone_NH.icon);
                        google.maps.event.addListener(marker_phone[index], "mouseout",function() {this.setIcon(icons.Phone_NH.icon);});
                        google.maps.event.addListener(marker_phone[index], "mouseover",function() {this.setIcon(icons.Phone_NH.mouseovericon);});                        
                    }
                    if (type==='HH'){
                        google.maps.event.clearListeners(marker_phone[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_phone[index], "mouseover");                        
                        marker_phone[index].setIcon(icons.Phone_HH.icon);
                        google.maps.event.addListener(marker_phone[index], "mouseout",function() {this.setIcon(icons.Phone_HH.icon);});
                        google.maps.event.addListener(marker_phone[index], "mouseover",function() {this.setIcon(icons.Phone_HH.mouseovericon);});                       
                    }
                    if (type==='NTR'){
                        google.maps.event.clearListeners(marker_phone[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_phone[index], "mouseover");                       
                        marker_phone[index].setIcon(icons.Phone_NTR.icon);
                        google.maps.event.addListener(marker_phone[index], "mouseout",function() {this.setIcon(icons.Phone_NTR.icon);});
                        google.maps.event.addListener(marker_phone[index], "mouseover",function() {this.setIcon(icons.Phone_NTR.mouseovericon);});                        
                    }  
                    if (type==='DNC'){
                        google.maps.event.clearListeners(marker_phone[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_phone[index], "mouseover");                      
                        marker_phone[index].setIcon(icons.DNC.icon);
                        google.maps.event.addListener(marker_phone[index], "mouseout",function() {this.setIcon(icons.DNC.icon);});
                        google.maps.event.addListener(marker_phone[index], "mouseover",function() {this.setIcon(icons.DNC.mouseovericon);});                         
                    }                     
                    marker_phone[index].infowindow.close();
                    break;
                  case "marker_phone_home":
                    if (type==='NH'){
                        google.maps.event.clearListeners(marker_phone_home[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_phone_home[index], "mouseover");                        
                        marker_phone_home[index].setIcon(icons.Phone_NH.icon);
                        google.maps.event.addListener(marker_phone_home[index], "mouseout",function() {this.setIcon(icons.Phone_NH.icon);});
                        google.maps.event.addListener(marker_phone_home[index], "mouseover",function() {this.setIcon(icons.Phone_NH.mouseovericon);});                       
                    }
                    if (type==='HH'){
                        google.maps.event.clearListeners(marker_phone_home[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_phone_home[index], "mouseover");                         
                        marker_phone_home[index].setIcon(icons.Phone_HH.icon);
                        google.maps.event.addListener(marker_phone_home[index], "mouseout",function() {this.setIcon(icons.Phone_HH.icon);});
                        google.maps.event.addListener(marker_phone_home[index], "mouseover",function() {this.setIcon(icons.Phone_HH.mouseovericon);});                       
                    }
                    if (type==='NTR'){
                        google.maps.event.clearListeners(marker_phone_home[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_phone_home[index], "mouseover");                      
                        marker_phone_home[index].setIcon(icons.Phone_NTR.icon);
                        google.maps.event.addListener(marker_phone_home[index], "mouseout",function() {this.setIcon(icons.Phone_NTR.icon);});
                        google.maps.event.addListener(marker_phone_home[index], "mouseover",function() {this.setIcon(icons.Phone_NTR.mouseovericon);});                       
                    }  
                    if (type==='DNC'){
                        google.maps.event.clearListeners(marker_phone_home[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_phone_home[index], "mouseover");                          
                        marker_phone_home[index].setIcon(icons.DNC.icon);
                        google.maps.event.addListener(marker_phone_home[index], "mouseout",function() {this.setIcon(icons.DNC.icon);});
                        google.maps.event.addListener(marker_phone_home[index], "mouseover",function() {this.setIcon(icons.DNC.mouseovericon);});                        
                    }                       
                    marker_phone_home[index].infowindow.close();
                    break;
                  case "marker_phone_nt":
                    if (type==='NH'){
                        google.maps.event.clearListeners(marker_phone_nt[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_phone_nt[index], "mouseover");                       
                        marker_phone_nt[index].setIcon(icons.Phone_NH.icon);
                        google.maps.event.addListener(marker_phone_nt[index], "mouseout",function() {this.setIcon(icons.Phone_NH.icon);});
                        google.maps.event.addListener(marker_phone_nt[index], "mouseover",function() {this.setIcon(icons.Phone_NH.mouseovericon);});                       
                    }
                    if (type==='HH'){
                        google.maps.event.clearListeners(marker_phone_nt[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_phone_nt[index], "mouseover");                       
                        marker_phone_nt[index].setIcon(icons.Phone_HH.icon);
                        google.maps.event.addListener(marker_phone_nt[index], "mouseout",function() {this.setIcon(icons.Phone_HH.icon);});
                        google.maps.event.addListener(marker_phone_nt[index], "mouseover",function() {this.setIcon(icons.Phone_HH.mouseovericon);});                         
                    }
                    if (type==='NTR'){
                        google.maps.event.clearListeners(marker_phone_nt[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_phone_nt[index], "mouseover");                         
                        marker_phone_nt[index].setIcon(icons.Phone_NTR.icon);
                        google.maps.event.addListener(marker_phone_nt[index], "mouseout",function() {this.setIcon(icons.Phone_NTR.icon);});
                        google.maps.event.addListener(marker_phone_nt[index], "mouseover",function() {this.setIcon(icons.Phone_NTR.mouseovericon);});                       
                    }  
                    if (type==='DNC'){
                        google.maps.event.clearListeners(marker_phone_nt[index], "mouseout"); 
                        google.maps.event.clearListeners(marker_phone_nt[index], "mouseover");                       
                        marker_phone_nt[index].setIcon(icons.DNC.icon);
                        google.maps.event.addListener(marker_phone_nt[index], "mouseout",function() {this.setIcon(icons.DNC.icon);});
                        google.maps.event.addListener(marker_phone_nt[index], "mouseover",function() {this.setIcon(icons.DNC.mouseovericon);});                        
                    }                      
                    marker_phone_nt[index].infowindow.close();
                    break;
                  case "marker_resident_nw_apt":
                    marker_resident_nw_apt[index].infowindow.close();                    
                    google.maps.event.trigger(marker_apt[infowin_index], "click");
                    if (type==='NH'){
                        document.getElementById('imagemarker_resident_nw_apt' + index).src = icons.NH.icon;
                    }
                    if (type==='HH'){
                        document.getElementById('imagemarker_resident_nw_apt' + index).src = icons.HH.icon;                      
                    }
                    if (type==='NTR'){
                        document.getElementById('imagemarker_resident_nw_apt' + index).src = icons.NTR.icon;                          
                    }
                    if (type==='DNC'){
                        document.getElementById('imagemarker_resident_nw_apt' + index).src = icons.DNC.icon;                        
                    }
                    break;                  
                  case "marker_resident_apt":
                    marker_resident_apt[index].infowindow.close();    
                    google.maps.event.trigger(marker_apt[infowin_index], "click");                  
                    if (type==='NH'){
                        document.getElementById('imagemarker_resident_apt' + index).src = icons.NH.icon;
                    }
                    if (type==='HH'){
                        document.getElementById('imagemarker_resident_apt' + index).src = icons.HH.icon;                      
                    }
                    if (type==='NTR'){
                        document.getElementById('imagemarker_resident_apt' + index).src = icons.NTR.icon;                          
                    }
                    if (type==='DNC'){
                        document.getElementById('imagemarker_resident_apt' + index).src = icons.DNC.icon;                        
                    }                    
                    break;
                  case "marker_resident_home_apt":
                    marker_resident_home_apt[index].infowindow.close();   
                    google.maps.event.trigger(marker_apt[infowin_index], "click");                   
                    if (type==='NH'){
                        document.getElementById('imagemarker_resident_home_apt' + index).src = icons.NH.icon;
                    }
                    if (type==='HH'){
                        document.getElementById('imagemarker_resident_home_apt' + index).src = icons.HH.icon;                      
                    }
                    if (type==='NTR'){
                        document.getElementById('imagemarker_resident_home_apt' + index).src = icons.NTR.icon;                          
                    }
                    if (type==='DNC'){
                        document.getElementById('imagemarker_resident_home_apt' + index).src = icons.DNC.icon;                        
                    }                    
                    break;
                  case "marker_resident_nt_apt":
                    marker_resident_nt_apt[index].infowindow.close();   
                    google.maps.event.trigger(marker_apt[infowin_index], "click");                   
                    if (type==='NH'){
                        document.getElementById('imagemarker_resident_nt_apt' + index).src = icons.NH.icon;
                    }
                    if (type==='HH'){
                        document.getElementById('imagemarker_resident_nt_apt' + index).src = icons.HH.icon;                      
                    }
                    if (type==='NTR'){
                        document.getElementById('imagemarker_resident_nt_apt' + index).src = icons.NTR.icon;                          
                    }
                    if (type==='DNC'){
                        document.getElementById('imagemarker_resident_nt_apt' + index).src = icons.DNC.icon;                        
                    }                     
                    break;
                  case "marker_dnc_apt":
                    marker_dnc_apt[index].infowindow.close();  
                    google.maps.event.trigger(marker_apt[infowin_index], "click");                   
                    if (type==='NH'){
                        document.getElementById('imagemarker_dnc_apt' + index).src = icons.NH.icon;
                    }
                    if (type==='HH'){
                        document.getElementById('imagemarker_dnc_apt' + index).src = icons.HH.icon;                      
                    }
                    if (type==='NTR'){
                        document.getElementById('imagemarker_dnc_apt' + index).src = icons.NTR.icon;                          
                    }
                    if (type==='DNC'){
                        document.getElementById('imagemarker_dnc_apt' + index).src = icons.DNC.icon;                        
                    }                     
                    break;
                  case "marker_phone_nw_apt":
                    marker_phone_nw_apt[index].infowindow.close(); 
                    google.maps.event.trigger(marker_apt[infowin_index], "click");                    
                    if (type==='NH'){
                        document.getElementById('imagemarker_phone_nw_apt' + index).src = icons.Phone_NH.icon;
                    }
                    if (type==='HH'){
                        document.getElementById('imagemarker_phone_nw_apt' + index).src = icons.Phone_HH.icon;                      
                    }
                    if (type==='NTR'){
                        document.getElementById('imagemarker_phone_nw_apt' + index).src = icons.Phone_NTR.icon;                          
                    }
                    if (type==='DNC'){
                        document.getElementById('imagemarker_phone_nw_apt' + index).src = icons.DNC.icon;                        
                    }                    
                    break;                  
                  case "marker_phone_apt":
                    marker_phone_apt[index].infowindow.close(); 
                    google.maps.event.trigger(marker_apt[infowin_index], "click");                    
                    if (type==='NH'){
                        document.getElementById('imagemarker_phone_apt' + index).src = icons.Phone_NH.icon;
                    }
                    if (type==='HH'){
                        document.getElementById('imagemarker_phone_apt' + index).src = icons.Phone_HH.icon;                      
                    }
                    if (type==='NTR'){
                        document.getElementById('imagemarker_phone_apt' + index).src = icons.Phone_NTR.icon;                          
                    }
                    if (type==='DNC'){
                        document.getElementById('imagemarker_phone_apt' + index).src = icons.DNC.icon;                        
                    }                       
                    break;
                  case "marker_phone_home_apt":
                    marker_phone_home_apt[index].infowindow.close();   
                    google.maps.event.trigger(marker_apt[infowin_index], "click");                  
                    if (type==='NH'){
                        document.getElementById('imagemarker_phone_home_apt' + index).src = icons.Phone_NH.icon;
                    }
                    if (type==='HH'){
                        document.getElementById('imagemarker_phone_home_apt' + index).src = icons.Phone_HH.icon;                      
                    }
                    if (type==='NTR'){
                        document.getElementById('imagemarker_phone_home_apt' + index).src = icons.Phone_NTR.icon;                          
                    }
                    if (type==='DNC'){
                        document.getElementById('imagemarker_phone_home_apt' + index).src = icons.DNC.icon;                        
                    }                       
                    break;
                  case "marker_phone_nt_apt":
                    marker_phone_nt_apt[index].infowindow.close();     
                    google.maps.event.trigger(marker_apt[infowin_index], "click");                   
                    if (type==='NH'){
                        document.getElementById('imagemarker_phone_nt_apt' + index).src = icons.Phone_NH.icon;
                    }
                    if (type==='HH'){
                        document.getElementById('imagemarker_phone_nt_apt' + index).src = icons.Phone_HH.icon;                      
                    }
                    if (type==='NTR'){
                        document.getElementById('imagemarker_phone_nt_apt' + index).src = icons.Phone_NTR.icon;                          
                    }
                    if (type==='DNC'){
                        document.getElementById('imagemarker_phone_nt_apt' + index).src = icons.DNC.icon;                        
                    }                      
                    break;                                                            
                  case "marker_resident_nw_multi":
                    marker_resident_nw_multi[index].infowindow.close();
                    google.maps.event.trigger(marker_multi[infowin_index], "click");                   
                    if (type==='NH'){
                        document.getElementById('imagemarker_resident_nw_multi' + index).src = icons.NH.icon;
                    }
                    if (type==='HH'){
                        document.getElementById('imagemarker_resident_nw_multi' + index).src = icons.HH.icon;                      
                    }
                    if (type==='NTR'){
                        document.getElementById('imagemarker_resident_nw_multi' + index).src = icons.NTR.icon;                          
                    }
                    if (type==='DNC'){
                        document.getElementById('imagemarker_resident_nw_multi' + index).src = icons.DNC.icon;                        
                    }                   
                    break;                  
                  case "marker_resident_multi":
                    marker_resident_multi[index].infowindow.close();
                    google.maps.event.trigger(marker_multi[infowin_index], "click");                    
                    if (type==='NH'){
                        document.getElementById('imagemarker_resident_multi' + index).src = icons.NH.icon;
                    }
                    if (type==='HH'){
                        document.getElementById('imagemarker_resident_multi' + index).src = icons.HH.icon;                      
                    }
                    if (type==='NTR'){
                        document.getElementById('imagemarker_resident_multi' + index).src = icons.NTR.icon;                          
                    }
                    if (type==='DNC'){
                        document.getElementById('imagemarker_resident_multi' + index).src = icons.DNC.icon;                        
                    }                    
                    break;
                  case "marker_resident_home_multi":
                    marker_resident_home_multi[index].infowindow.close();
                    google.maps.event.trigger(marker_multi[infowin_index], "click");                    
                    if (type==='NH'){
                        document.getElementById('imagemarker_resident_home_multi' + index).src = icons.NH.icon;
                    }
                    if (type==='HH'){
                        document.getElementById('imagemarker_resident_home_multi' + index).src = icons.HH.icon;                      
                    }
                    if (type==='NTR'){
                        document.getElementById('imagemarker_resident_home_multi' + index).src = icons.NTR.icon;                          
                    }
                    if (type==='DNC'){
                        document.getElementById('imagemarker_resident_home_multi' + index).src = icons.DNC.icon;                        
                    }                   
                    break;
                  case "marker_resident_nt_multi":
                    marker_resident_nt_multi[index].infowindow.close();
                    google.maps.event.trigger(marker_multi[infowin_index], "click");                    
                    if (type==='NH'){
                        document.getElementById('imagemarker_resident_nt_multi' + index).src = icons.NH.icon;
                    }
                    if (type==='HH'){
                        document.getElementById('imagemarker_resident_nt_multi' + index).src = icons.HH.icon;                      
                    }
                    if (type==='NTR'){
                        document.getElementById('imagemarker_resident_nt_multi' + index).src = icons.NTR.icon;                          
                    }
                    if (type==='DNC'){
                        document.getElementById('imagemarker_resident_nt_multi' + index).src = icons.DNC.icon;                        
                    }                     
                    break;
                  case "marker_dnc_multi":
                    marker_dnc_multi[index].infowindow.close();
                    google.maps.event.trigger(marker_multi[infowin_index], "click");                    
                    if (type==='NH'){
                        document.getElementById('imagemarker_dnc_multi' + index).src = icons.NH.icon;
                    }
                    if (type==='HH'){
                        document.getElementById('imagemarker_dnc_multi' + index).src = icons.HH.icon;                      
                    }
                    if (type==='NTR'){
                        document.getElementById('imagemarker_dnc_multi' + index).src = icons.NTR.icon;                          
                    }
                    if (type==='DNC'){
                        document.getElementById('imagemarker_dnc_multi' + index).src = icons.DNC.icon;                        
                    }                    
                    break;
                  case "marker_phone_nw_multi":
                    marker_phone_nw_multi[index].infowindow.close();
                    google.maps.event.trigger(marker_multi[infowin_index], "click");                    
                    if (type==='NH'){
                        document.getElementById('imagemarker_phone_nw_multi' + index).src = icons.Phone_NH.icon;
                    }
                    if (type==='HH'){
                        document.getElementById('imagemarker_phone_nw_multi' + index).src = icons.Phone_HH.icon;                      
                    }
                    if (type==='NTR'){
                        document.getElementById('imagemarker_phone_nw_multi' + index).src = icons.Phone_NTR.icon;                          
                    }
                    if (type==='DNC'){
                        document.getElementById('imagemarker_phone_nw_multi' + index).src = icons.DNC.icon;                        
                    }                    
                    break;                  
                  case "marker_phone_multi":
                    marker_phone_multi[index].infowindow.close();
                    google.maps.event.trigger(marker_multi[infowin_index], "click");                    
                    if (type==='NH'){
                        document.getElementById('imagemarker_phone_multi' + index).src = icons.Phone_NH.icon;
                    }
                    if (type==='HH'){
                        document.getElementById('imagemarker_phone_multi' + index).src = icons.Phone_HH.icon;                      
                    }
                    if (type==='NTR'){
                        document.getElementById('imagemarker_phone_multi' + index).src = icons.Phone_NTR.icon;                          
                    }
                    if (type==='DNC'){
                        document.getElementById('imagemarker_phone_multi' + index).src = icons.DNC.icon;                        
                    }                   
                    break;
                  case "marker_phone_home_multi":
                    marker_phone_home_multi[index].infowindow.close();
                    google.maps.event.trigger(marker_multi[infowin_index], "click");                    
                    if (type==='NH'){
                        document.getElementById('imagemarker_phone_home_multi' + index).src = icons.Phone_NH.icon;
                    }
                    if (type==='HH'){
                        document.getElementById('imagemarker_phone_home_multi' + index).src = icons.Phone_HH.icon;                      
                    }
                    if (type==='NTR'){
                        document.getElementById('imagemarker_phone_home_multi' + index).src = icons.Phone_NTR.icon;                          
                    }
                    if (type==='DNC'){
                        document.getElementById('imagemarker_phone_home_multi' + index).src = icons.DNC.icon;                        
                    }                    
                    break;
                  case "marker_phone_nt_multi":
                    marker_phone_nt_multi[index].infowindow.close();
                    google.maps.event.trigger(marker_multi[infowin_index], "click");                    
                    if (type==='NH'){
                        document.getElementById('imagemarker_phone_nt_multi' + index).src = icons.Phone_NH.icon;
                    }
                    if (type==='HH'){
                        document.getElementById('imagemarker_phone_nt_multi' + index).src = icons.Phone_HH.icon;                      
                    }
                    if (type==='NTR'){
                        document.getElementById('imagemarker_phone_nt_multi' + index).src = icons.Phone_NTR.icon;                          
                    }
                    if (type==='DNC'){
                        document.getElementById('imagemarker_phone_nt_multi' + index).src = icons.DNC.icon;                        
                    }                   
                    break;                        
          }  // end of switch       
      }

          };
        });
      
      
    }
    

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request.responseText, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }
    
    function ZeroPadding(number){
        if (number.toString().length == 1) {return "0" + number.toString();}
        else {
            return number.toString();
        };
    };
    function doNothing() {}
    
    function showOddEvenAll(showid){
        var mylength = document.getElementById("totalcount").innerHTML;
        
        if (showid === 1){
            document.getElementById("vweven").checked = false;
            document.getElementById("vwall").checked = false;
            
            for(var i=0;i<mylength;i++){
                if (document.getElementById("iseven" + i).value === 'false'){
                    document.getElementById("houserecord" + i).style.display = 'block';
                }
                else{
                    document.getElementById("houserecord" + i).style.display = 'none';                    
                }                
            }
        }
        
        if (showid === 2){
            document.getElementById("vwodd").checked = false;
            document.getElementById("vwall").checked = false;       
            
            for(var i=0;i<mylength;i++){
                if (document.getElementById("iseven" + i).value === 'true'){
                    document.getElementById("houserecord" + i).style.display = 'block';
                }
                else{
                    document.getElementById("houserecord" + i).style.display = 'none';                    
                }                
            }            
        }   
        
        if (showid === 3){
            document.getElementById("vwodd").checked = false;
            document.getElementById("vweven").checked = false;  
            
            for(var i=0;i<mylength;i++){
               document.getElementById("houserecord" + i).style.display = 'block';                
            }            
        }        
        
    }    
    
    function streetviewmodule(congregation,territorynumber,street,streetsuffix,detail_type){
        var screen = Number($(window).width());
        var menuwidth = Math.round((200/screen)*100);     
        
        var detail = document.getElementById('streetviewdetail');        
        var streetdetailpage = document.getElementById('myleft3');
        detail.innerHTML = "";
        streetdetailpage.style.display = 'block';
        
        if(screen<768){
            document.getElementById("myleft1").style.width = "0";              
            document.getElementById("myleft2").style.width = "0"; 
            document.getElementById("myleft3").style.width = "100%";          
            document.getElementById("mobilemenucontrol").style.width = "0";  
            document.getElementById("main1").style.width = "0";             
        }
        else{
            document.getElementById("myleft1").style.width = "0";              
            document.getElementById("myleft2").style.width = "0"; 
            document.getElementById("myleft3").style.width = "400px";          
            document.getElementById("menucontrol").style.width = "0";  
            document.getElementById("main1").style.marginLeft = "400px";               
        }
      
        
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                 var myJSONResult = JSON.parse(this.responseText);
                 var divheader = document.createElement('div');
                 
                 document.getElementById("totalcount").innerHTML = myJSONResult.length; 
                 divheader.innerHTML =  '<table><tr><form action="">' + 
                                       '<td><input type="checkbox" name="vwOddEven" id = "vwodd"   value="odd" onclick="showOddEvenAll(1)" style="width: 30px;">Odd</td>' +
                                       '<td><input type="checkbox" name="vwOddEven" id = "vweven"  value="even" onclick="showOddEvenAll(2)" style="width: 30px;">Even</td>' + 
                                       '<td><input type="checkbox" name="vwOddEven" id = "vwall"  value="all" onclick="showOddEvenAll(3)" style="width: 30px;" checked>All</td>' +                                           
                                       '</form></tr></table>'                 ;
                 detail.appendChild(divheader);  
                      
                      for(i=0;i<myJSONResult.length;i++){
                      var xmltext = myJSONResult[i].Notes;
                      var xmlDoc;                         
                      var nodes;
                      var postdate_node;
                      var username_node;
                      var typedescription_node;
                      var content_node;
                      var notes_elements;


                      var housesplit = myJSONResult[i].FormattedAddress.toString().split(' ');
                      var housenumber = Number(housesplit[0]);     
                      var iseven = (housenumber % 2) === 0? true:false;
                                            
                      if (window.DOMParser) {
                        parser = new DOMParser();
                        xmlDoc = parser.parseFromString(xmltext,"text/xml");
                      } else {
                        xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
                        xmlDoc.async = false;
                        xmlDoc.loadXML(xmltext); 
                      }
                      
                      nodes = xmlDoc.getElementsByTagName("note");
                      var div = document.createElement('div');
                      var notes='';
                      
                      if(nodes.length>0){
                        notes = '<div class="expand"><table class="formtable"><tr>';
                        notes += '<td></td><td class="formright" align="right" style="cursor:pointer" onclick="expandCollapse(' + '\'' + 'showHidestreetdetail' + i + '\'' + ',' + '\'' + 'expandstreetdetail' + i + '\'' + ');" id="expandstreetdetail' + i + '">[+]';

                        if (nodes.length>1){
                          notes += nodes.length + ' Posted Notes</td>'; 
                        }else{
                          notes += nodes.length + ' Posted Note</td>'; 
                        }    

                        notes += '</tr></table></div>';
                        notes += '<div id="showHidestreetdetail' + i + '" style="display:none;">';
                        notes += '<table><tr><td>';
                             

                        //for(notesindex=0;notesindex<nodes.length;notesindex++){
                        for(notesindex=nodes.length-1;notesindex>=0;notesindex--){
                          var content = xmlDoc.getElementsByTagName("content")[notesindex].innerHTML;
                          var postdate = xmlDoc.getElementsByTagName("date")[notesindex].innerHTML;
                          var typedescription = xmlDoc.getElementsByTagName("typedescription")[notesindex].innerHTML;   
                          var username = xmlDoc.getElementsByTagName("username")[notesindex].innerHTML;                           
                          
                          notes_elements +=  '<tr><td><input type="hidden" id="N' + (notesindex+1) +  '_username' + i + '" value="' + username + '"/></td></tr>' +
                                             '<tr><td><input type="hidden" id="N' + (notesindex+1) +  '_date' + i + '" value="' + postdate + '"/></td></tr>' +
                                             '<tr><td><input type="hidden" id="N' + (notesindex+1) +  '_typedesc' + i + '" value="' + typedescription + '"/></td></tr>' +                                              
                                             '<tr><td><input type="hidden" id="N' + (notesindex+1) +  '_content' + i + '" value="' + content + '"/></td></tr>';
                                            
                          
                          if(content===''){
                            notes += '<p><h4><b>Posted: ' + postdate + '</b><br>[' + typedescription + ']</h4><h5>' + username + '</h5></p>';
                          }else {
                          notes += '<p><h4><b>Posted: ' + postdate + '</b><br>' + content + '<br>[' + typedescription + ']</h4><h5>' + username + '</h5></p>';
                         }                             
                          
                        }

                         notes += '</td></tr></table></div>';
                       }
                       
                       notes_elements += '<tr><td><input type="hidden" id="N_total' + i + '" value="' + nodes.length + '"/></td></tr>';

                      if(myJSONResult[i].Type === 'NH' && myJSONResult[i].DateModified === '' && myJSONResult[i].bPhone === '0' && myJSONResult[i].bUnit === '0'){
                               div.innerHTML = '<div id="houserecord' + i + '" style="display:block;">' +
                                               '<table><td><img id="propertyicon' + i + '" src="icons/House_NW.png" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td><td><p><b>' + myJSONResult[i].FormattedAddress + '</b></p></td></table>'  +
                                               '<div id = "street_detail' + i + '" style="display:none;">' + 
                                               
                                               '<div id="hiddendata' + i + '" style="display:none;">' +
                                               '<table>' +                                                   
                                               '<tr><td><input type="hidden" id="iseven' + i + '"  value="' + iseven + '" readonly></td></tr>' +                                                
                                               '<tr><td><input type="hidden" id="InitDate' + i + '" value="' + myJSONResult[i].InitialDate + '"/></td></tr>' +                 
                                               '<tr><td><input type="hidden" id="AddressGUID' + i + '" value="' + myJSONResult[i].AddressGUID + '"/></td></tr>' +
                                               '<tr><td><input type="hidden" id="bPhone' + i + '" value="' + myJSONResult[i].bPhone + '"/></td></tr>' + notes_elements +
                                               '</table>' +                                                   
                                               '</div>' +
                                               
                                               '<table>' +                                               
                                               '<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Language' + i + '">' + 
                                               '<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>' +  
                                               '<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>' +
                                               '</select> </td></tr>' +    
                                               
                                               '<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Type' + i + '">' + 
                                               '<option value="DNC">Do Not Call</option>' +
                                               '<option value="HH">Home</option>' +
                                               '<option value="NH" selected>Not Home</option>' +
                                               '<option value="NTR">No Trespassing</option>' +
                                               '</select></td></tr>' + 
                                               
                                               '<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><textarea id="Notes' + i + '" rows="5" cols="40" value=""/></textarea></td></tr>' + 
                                                                                              
                                               '</table>' + notes +
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="button" value="Submit Changes" onclick="saveData(' + '\'' + '\'' + ',' + i + ',' + '0)"/></td>' +
                                               '<td><input type="button" value="Close" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td></tr>' +                                               
                                               
                                               '</table>' + 
                                               '</div>' +                                                   
                                               '</div>';
                      }
                      if(myJSONResult[i].Type === 'NH' && myJSONResult[i].DateModified !== '' && myJSONResult[i].bPhone === '0' && myJSONResult[i].bUnit === '0'){
                              div.innerHTML =  '<div id="houserecord' + i + '" style="display:block;">' +
                                               '<table><td><img id="propertyicon' + i + '" src="icons/House_NH.png" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td><td><p><b>' + myJSONResult[i].FormattedAddress + '</b></p></td></table>' + 
                                               '<div id = "street_detail' + i + '" style="display:none;">' + 
                                               
                                               '<div id="hiddendata' + i + '" style="display:none;">' +
                                               '<table>' +                                                   
                                               '<tr><td><input type="hidden" id="iseven' + i + '"  value="' + iseven + '" readonly></td></tr>' +                                                
                                               '<tr><td><input type="hidden" id="InitDate' + i + '" value="' + myJSONResult[i].InitialDate + '"/></td></tr>' +                 
                                               '<tr><td><input type="hidden" id="AddressGUID' + i + '" value="' + myJSONResult[i].AddressGUID + '"/></td></tr>' +
                                               '<tr><td><input type="hidden" id="bPhone' + i + '" value="' + myJSONResult[i].bPhone + '"/></td></tr>' + notes_elements +
                                               '</table>' +                                                   
                                               '</div>' +
                                               
                                               '<table>' +                                               
                                               '<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Language' + i + '">' + 
                                               '<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>' +  
                                               '<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>' +
                                               '</select> </td></tr>' +  
                                               
                                               '<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Type' + i + '">' + 
                                               '<option value="DNC">Do Not Call</option>' +
                                               '<option value="HH">Home</option>' +
                                               '<option value="NH" selected>Not Home</option>' +
                                               '<option value="NTR">No Trespassing</option>' +
                                               '</select></td></tr>' + 
                                               
                                               '<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><textarea id="Notes' + i + '" rows="5" cols="40" value=""/></textarea></td></tr>' + 
                                                                                              
                                               '</table>' + notes +
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="button" value="Submit Changes" onclick="saveData(' + '\'' + '\'' + ',' + i + ',' + '0)"/></td>' +
                                               '<td><input type="button" value="Close" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td></tr>' +                                               
                                               
                                               '</table>' + 
                                               '</div>' +                                                
                                               '</div>';
                      }
                      if(myJSONResult[i].Type === 'HH' && myJSONResult[i].DateModified !== '' && myJSONResult[i].bPhone === '0' && myJSONResult[i].bUnit === '0'){
                              div.innerHTML =  '<div id="houserecord' + i + '" style="display:block;">' +
                                               '<table><td><img id="propertyicon' + i + '" src="icons/House_HH.png" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td><td><p><b>' + myJSONResult[i].FormattedAddress + '</b></p></td></table>' + 
                                               '<div id = "street_detail' + i + '" style="display:none;">' + 
                                               
                                               '<div id="hiddendata' + i + '" style="display:none;">' +
                                               '<table>' +                                                   
                                               '<tr><td><input type="hidden" id="iseven' + i + '"  value="' + iseven + '" readonly></td></tr>' +                                                
                                               '<tr><td><input type="hidden" id="InitDate' + i + '" value="' + myJSONResult[i].InitialDate + '"/></td></tr>' +                 
                                               '<tr><td><input type="hidden" id="AddressGUID' + i + '" value="' + myJSONResult[i].AddressGUID + '"/></td></tr>' +
                                               '<tr><td><input type="hidden" id="bPhone' + i + '" value="' + myJSONResult[i].bPhone + '"/></td></tr>' + notes_elements +
                                               '</table>' +                                                   
                                               '</div>' +
                                               
                                               '<table>' +                                               
                                               '<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Language' + i + '">' + 
                                               '<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>' +  
                                               '<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>' +
                                               '</select> </td></tr>' +    
                                               
                                               '<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Type' + i + '">' + 
                                               '<option value="DNC">Do Not Call</option>' +
                                               '<option value="HH" selected>Home</option>' +
                                               '<option value="NH">Not Home</option>' +
                                               '<option value="NTR">No Trespassing</option>' +
                                               '</select></td></tr>' + 
                                               
                                               '<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><textarea id="Notes' + i + '" rows="5" cols="40" value=""/></textarea></td></tr>' + 
                                                                                              
                                               '</table>' + notes +
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="button" value="Submit Changes" onclick="saveData(' + '\'' + '\'' + ',' + i + ',' + '0)"/></td>' +
                                               '<td><input type="button" value="Close" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td></tr>' +                                               
                                               
                                               '</table>' + 
                                               '</div>' +                                                   
                                               '</div>';
                      }     
                      if(myJSONResult[i].Type === 'NTR' && myJSONResult[i].DateModified !== '' && myJSONResult[i].bPhone === '0' && myJSONResult[i].bUnit === '0'){
                              div.innerHTML =  '<div id="houserecord' + i + '" style="display:block;">' +
                                               '<table><td><img id="propertyicon' + i + '" src="icons/House_NTR.png" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td><td><p><b>' + myJSONResult[i].FormattedAddress + '</b></p></td></table>' + 
                                               '<div id = "street_detail' + i + '" style="display:none;">' + 
                                               
                                               '<div id="hiddendata' + i + '" style="display:none;">' +
                                               '<table>' +                                                   
                                               '<tr><td><input type="hidden" id="iseven' + i + '"  value="' + iseven + '" readonly></td></tr>' +                                                
                                               '<tr><td><input type="hidden" id="InitDate' + i + '" value="' + myJSONResult[i].InitialDate + '"/></td></tr>' +                 
                                               '<tr><td><input type="hidden" id="AddressGUID' + i + '" value="' + myJSONResult[i].AddressGUID + '"/></td></tr>' +
                                               '<tr><td><input type="hidden" id="bPhone' + i + '" value="' + myJSONResult[i].bPhone + '"/></td></tr>' + notes_elements +
                                               '</table>' +                                                   
                                               '</div>' +
                                               
                                               '<table>' +                                               
                                               '<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Language' + i + '">' + 
                                               '<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>' +  
                                               '<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>' +
                                               '</select> </td></tr>' +    
                                               
                                               '<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Type' + i + '">' + 
                                               '<option value="DNC">Do Not Call</option>' +
                                               '<option value="HH">Home</option>' +
                                               '<option value="NH">Not Home</option>' +
                                               '<option value="NTR" selected>No Trespassing</option>' +
                                               '</select></td></tr>' + 
                                               
                                               '<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><textarea id="Notes' + i + '" rows="5" cols="40" value=""/></textarea></td></tr>' + 
                                                                                              
                                               '</table>' + notes +
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="button" value="Submit Changes" onclick="saveData(' + '\'' + '\'' + ',' + i + ',' + '0)"/></td>' +
                                               '<td><input type="button" value="Close" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td></tr>' +                                               
                                               
                                               '</table>' + 
                                               '</div>' +                                                   
                                               '</div>';
                      }                        
                      if(myJSONResult[i].Type === 'DNC' && myJSONResult[i].bUnit === '0'){
                              div.innerHTML =  '<div id="houserecord' + i + '" style="display:block;">' +
                                               '<table><td><img id="propertyicon' + i + '" src="icons/DNC.png" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td><td><p><b>' + myJSONResult[i].FormattedAddress + '</b></p></td></table>' +
                                               '<div id = "street_detail' + i + '" style="display:none;">' + 
                                               
                                               '<div id="hiddendata' + i + '" style="display:none;">' +
                                               '<table>' +                                                   
                                               '<tr><td><input type="hidden" id="iseven' + i + '"  value="' + iseven + '" readonly></td></tr>' +                                                
                                               '<tr><td><input type="hidden" id="InitDate' + i + '" value="' + myJSONResult[i].InitialDate + '"/></td></tr>' +                 
                                               '<tr><td><input type="hidden" id="AddressGUID' + i + '" value="' + myJSONResult[i].AddressGUID + '"/></td></tr>' +
                                               '<tr><td><input type="hidden" id="bPhone' + i + '" value="' + myJSONResult[i].bPhone + '"/></td></tr>' + notes_elements +
                                               '</table>' +                                                   
                                               '</div>' +
                                               
                                               '<table>' +                                               
                                               '<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Language' + i + '">' + 
                                               '<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>' +  
                                               '<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>' +
                                               '</select> </td></tr>' +   
                                               
                                               '<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Type' + i + '">' + 
                                               '<option value="DNC" selected>Do Not Call</option>' +
                                               '<option value="HH">Home</option>' +
                                               '<option value="NH">Not Home</option>' +
                                               '<option value="NTR">No Trespassing</option>' +
                                               '</select></td></tr>' + 
                                               
                                               '<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><textarea id="Notes' + i + '" rows="5" cols="40" value=""/></textarea></td></tr>' + 
                                                                                              
                                               '</table>' + notes +
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="button" value="Submit Changes" onclick="saveData(' + '\'' + '\'' + ',' + i + ',' + '0)"/></td>' +
                                               '<td><input type="button" value="Close" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td></tr>' +                                               
                                               
                                               '</table>' + 
                                               '</div>' +                                                   
                                               '</div>';                                   
                      }    
                      if(myJSONResult[i].Type === 'NH' &&  myJSONResult[i].DateModified === '' && myJSONResult[i].bPhone === '1' && myJSONResult[i].bUnit === '0'){
                              div.innerHTML =  '<div id="houserecord' + i + '" style="display:block;">' +
                                               '<table><td><img id="propertyicon' + i + '" src = "icons/Phone_NW.png" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td><td><p><b>' + myJSONResult[i].FormattedAddress + '</b></p></td></table>' +
                                               '<div id = "street_detail' + i + '" style="display:none;">' + 
                                               
                                               '<div id="hiddendata' + i + '" style="display:none;">' +
                                               '<table>' +                                                   
                                               '<tr><td><input type="hidden" id="iseven' + i + '"  value="' + iseven + '" readonly></td></tr>' +                                                
                                               '<tr><td><input type="hidden" id="InitDate' + i + '" value="' + myJSONResult[i].InitialDate + '"/></td></tr>' +                 
                                               '<tr><td><input type="hidden" id="AddressGUID' + i + '" value="' + myJSONResult[i].AddressGUID + '"/></td></tr>' +
                                               '<tr><td><input type="hidden" id="bPhone' + i + '" value="' + myJSONResult[i].bPhone + '"/></td></tr>' + notes_elements +
                                               '</table>' +                                                   
                                               '</div>' +
                                               
                                               '<table>' +                                               
                                               '<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Language' + i + '">' + 
                                               '<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>' +  
                                               '<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>' +
                                               '</select> </td></tr>' +   
                                               
                                               '<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Type' + i + '">' + 
                                               '<option value="DNC">Do Not Call</option>' +
                                               '<option value="HH">Home</option>' +
                                               '<option value="NH" selected>Not Home</option>' +
                                               '<option value="NTR">No Trespassing</option>' +
                                               '</select></td></tr>' + 
                                               
                                               '</table>' +                                               
                                                                                              
                                               '<table>' +
                                               
                                               '<tr><td><input type="text" value="Phone:" style="border:none;" readonly></td></tr>' +         
                                               '<tr><td><select id="PhoneType' + i + '">' + 
                                               '<option value="AP">Answered Phone</option>' +
                                               '<option value="DNC">Do Not Call</option>' +  
                                               '<option value="PD">Phone Disconnected</option>' + 
                                               '<option value="NC" selected>Not Called</option>' +
                                               '<option value="VM">Voice Message</option>' + 
                                               '</select> </td>' +          
                                               '<td><div class="tooltip"><img src = "icons/Phone_Small.png">' +           
                                               '<span class="tooltiptext">' + 
                                                myJSONResult[i].Resident + '<br>' + myJSONResult[i].Phone +
                                               '</span></div></td></tr>' + 
                                               
                                               '</table>' +                                               
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><textarea id="Notes' + i + '" rows="5" cols="40" value=""/></textarea></td></tr>' + 
                                                                                              
                                               '</table>' + notes +
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="button" value="Submit Changes" onclick="saveData(' + '\'' + '\'' + ',' + i + ',' + '0)"/></td>' +
                                               '<td><input type="button" value="Close" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td></tr>' +                                               
                                               
                                               '</table>' + 
                                               '</div>' +                                                   
                                               '</div>';                                     
                      }  
                      if(myJSONResult[i].Type === 'NTR' &&  myJSONResult[i].DateModified !== '' && myJSONResult[i].bPhone === '1' && myJSONResult[i].bUnit === '0'){
                              div.innerHTML =  '<div id="houserecord' + i + '" style="display:block;">' +
                                               '<table><td><img id="propertyicon' + i + '" src = "icons/Phone_NTR.png" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td><td><p><b>' + myJSONResult[i].FormattedAddress + '</b></p></td></table>' +
                                               '<div id = "street_detail' + i + '" style="display:none;">' + 
                                               
                                               '<div id="hiddendata' + i + '" style="display:none;">' +
                                               '<table>' +                                                   
                                               '<tr><td><input type="hidden" id="iseven' + i + '"  value="' + iseven + '" readonly></td></tr>' +                                                
                                               '<tr><td><input type="hidden" id="InitDate' + i + '" value="' + myJSONResult[i].InitialDate + '"/></td></tr>' +                 
                                               '<tr><td><input type="hidden" id="AddressGUID' + i + '" value="' + myJSONResult[i].AddressGUID + '"/></td></tr>' +
                                               '<tr><td><input type="hidden" id="bPhone' + i + '" value="' + myJSONResult[i].bPhone + '"/></td></tr>' + notes_elements +
                                               '</table>' +                                                   
                                               '</div>' +
                                               
                                               '<table>' +                                               
                                               '<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Language' + i + '">' + 
                                               '<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>' +  
                                               '<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>' +
                                               '</select> </td></tr>' +    
                                               
                                               '<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Type' + i + '">' + 
                                               '<option value="DNC">Do Not Call</option>' +
                                               '<option value="HH">Home</option>' +
                                               '<option value="NH">Not Home</option>' +
                                               '<option value="NTR" selected>No Trespassing</option>' +
                                               '</select></td></tr>' + 
                                               
                                               '</table>' +                                               
                                                                                              
                                               '<table>' +
                                               
                                               '<tr><td><input type="text" value="Phone:" style="border:none;" readonly></td></tr>' +         
                                               '<tr><td><select id="PhoneType' + i + '">' + 
                                               '<option value="AP">Answered Phone</option>' +
                                               '<option value="DNC">Do Not Call</option>' +  
                                               '<option value="PD">Phone Disconnected</option>' + 
                                               '<option value="NC" selected>Not Called</option>' +
                                               '<option value="VM">Voice Message</option>' + 
                                               '</select> </td>' +          
                                               '<td><div class="tooltip"><img src = "icons/Phone_Small.png">' +           
                                               '<span class="tooltiptext">' + 
                                                myJSONResult[i].Resident + '<br>' + myJSONResult[i].Phone +
                                               '</span></div></td></tr>' + 
                                               
                                               '</table>' +                                               
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><textarea id="Notes' + i + '" rows="5" cols="40" value=""/></textarea></td></tr>' + 
                                                                                              
                                               '</table>' + notes +
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="button" value="Submit Changes" onclick="saveData(' + '\'' + '\'' + ',' + i + ',' + '0)"/></td>' +
                                               '<td><input type="button" value="Close" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td></tr>' +                                               
                                               
                                               '</table>' + 
                                               '</div>' +                                                   
                                               '</div>';                                     
                      }         
                      if(myJSONResult[i].Type === 'NH' &&  myJSONResult[i].DateModified !== '' && myJSONResult[i].bPhone === '1' && myJSONResult[i].bUnit === '0'){
                              div.innerHTML =  '<div id="houserecord' + i + '" style="display:block;">' +
                                               '<table><td><img id="propertyicon' + i + '" src = "icons/Phone_NH.png" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td><td><p><b>' + myJSONResult[i].FormattedAddress + '</b></p></td></table>' +
                                               '<div id = "street_detail' + i + '" style="display:none;">' + 
                                               
                                               '<div id="hiddendata' + i + '" style="display:none;">' +
                                               '<table>' +                                                   
                                               '<tr><td><input type="hidden" id="iseven' + i + '"  value="' + iseven + '" readonly></td></tr>' +                                                
                                               '<tr><td><input type="hidden" id="InitDate' + i + '" value="' + myJSONResult[i].InitialDate + '"/></td></tr>' +                 
                                               '<tr><td><input type="hidden" id="AddressGUID' + i + '" value="' + myJSONResult[i].AddressGUID + '"/></td></tr>' +
                                               '<tr><td><input type="hidden" id="bPhone' + i + '" value="' + myJSONResult[i].bPhone + '"/></td></tr>' + notes_elements +
                                               '</table>' +                                                   
                                               '</div>' +
                                               
                                               '<table>' +                                               
                                               '<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Language' + i + '">' + 
                                               '<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>' +  
                                               '<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>' +
                                               '</select> </td></tr>' +   
                                               
                                               '<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Type' + i + '">' + 
                                               '<option value="DNC">Do Not Call</option>' +
                                               '<option value="HH">Home</option>' +
                                               '<option value="NH" selected>Not Home</option>' +
                                               '<option value="NTR">No Trespassing</option>' +
                                               '</select></td></tr>' + 
                                               
                                               '</table>' +                                               
                                                                                              
                                               '<table>' +
                                               
                                               '<tr><td><input type="text" value="Phone:" style="border:none;" readonly></td></tr>' +         
                                               '<tr><td><select id="PhoneType' + i + '">' + 
                                               '<option value="AP">Answered Phone</option>' +
                                               '<option value="DNC">Do Not Call</option>' +  
                                               '<option value="PD">Phone Disconnected</option>' + 
                                               '<option value="NC" selected>Not Called</option>' +
                                               '<option value="VM">Voice Message</option>' + 
                                               '</select> </td>' +          
                                               '<td><div class="tooltip"><img src = "icons/Phone_Small.png">' +           
                                               '<span class="tooltiptext">' + 
                                                myJSONResult[i].Resident + '<br>' + myJSONResult[i].Phone +
                                               '</span></div></td></tr>' + 
                                               
                                               '</table>' +                                               
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><textarea id="Notes' + i + '" rows="5" cols="40" value=""/></textarea></td></tr>' + 
                                                                                              
                                               '</table>' + notes +
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="button" value="Submit Changes" onclick="saveData(' + '\'' + '\'' + ',' + i + ',' + '0)"/></td>' +
                                               '<td><input type="button" value="Close" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td></tr>' +                                               
                                               
                                               '</table>' + 
                                               '</div>' +                                                   
                                               '</div>';                                     
                      }    
                      if(myJSONResult[i].Type === 'HH' &&  myJSONResult[i].DateModified !== '' && myJSONResult[i].bPhone === '1' && myJSONResult[i].bUnit === '0'){
                              div.innerHTML =  '<div id="houserecord' + i + '" style="display:block;">' +
                                               '<table><td><img id="propertyicon' + i + '" src = "icons/Phone_HH.png" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td><td><p><b>' + myJSONResult[i].FormattedAddress + '</b></p></td></table>' +
                                               '<div id = "street_detail' + i + '" style="display:none;">' + 
                                               
                                               '<div id="hiddendata' + i + '" style="display:none;">' +
                                               '<table>' +                                                   
                                               '<tr><td><input type="hidden" id="iseven' + i + '"  value="' + iseven + '" readonly></td></tr>' +                                                
                                               '<tr><td><input type="hidden" id="InitDate' + i + '" value="' + myJSONResult[i].InitialDate + '"/></td></tr>' +                 
                                               '<tr><td><input type="hidden" id="AddressGUID' + i + '" value="' + myJSONResult[i].AddressGUID + '"/></td></tr>' +
                                               '<tr><td><input type="hidden" id="bPhone' + i + '" value="' + myJSONResult[i].bPhone + '"/></td></tr>' + notes_elements +
                                               '</table>' +                                                   
                                               '</div>' +
                                               
                                               '<table>' +                                               
                                               '<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Language' + i + '">' + 
                                               '<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>' +  
                                               '<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>' +
                                               '</select> </td></tr>' + 
                                               
                                               '<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Type' + i + '">' + 
                                               '<option value="DNC">Do Not Call</option>' +
                                               '<option value="HH" selected>Home</option>' +
                                               '<option value="NH">Not Home</option>' +
                                               '<option value="NTR">No Trespassing</option>' +
                                               '</select></td></tr>' + 
                                               
                                               '</table>' +                                               
                                                                                              
                                               '<table>' +
                                               
                                               '<tr><td><input type="text" value="Phone:" style="border:none;" readonly></td></tr>' +         
                                               '<tr><td><select id="PhoneType' + i + '">' + 
                                               '<option value="AP">Answered Phone</option>' +
                                               '<option value="DNC">Do Not Call</option>' +  
                                               '<option value="PD">Phone Disconnected</option>' + 
                                               '<option value="NC" selected>Not Called</option>' +
                                               '<option value="VM">Voice Message</option>' + 
                                               '</select> </td>' +          
                                               '<td><div class="tooltip"><img src = "icons/Phone_Small.png">' +           
                                               '<span class="tooltiptext">' + 
                                                myJSONResult[i].Resident + '<br>' + myJSONResult[i].Phone +
                                               '</span></div></td></tr>' + 
                                               
                                               '</table>' +                                               
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><textarea id="Notes' + i + '" rows="5" cols="40" value=""/></textarea></td></tr>' + 
                                                                                              
                                               '</table>' + notes +
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="button" value="Submit Changes" onclick="saveData(' + '\'' + '\'' + ',' + i + ',' + '0)"/></td>' +
                                               '<td><input type="button" value="Close" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td></tr>' +                                               
                                               
                                               '</table>' + 
                                               '</div>' +                                                   
                                               '</div>';                                     
                      }              
                      
                      
                      
                      if(myJSONResult[i].Type === 'NH' && myJSONResult[i].DateModified === '' && myJSONResult[i].bPhone === '0' && myJSONResult[i].bUnit === '1'){
                               div.innerHTML = '<div id="houserecord' + i + '" style="display:block;">' +
                                               '<table><td><img id="propertyicon' + i + '" src="icons/House_NW.png" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td><td><p><b>' + myJSONResult[i].FormattedAddress.toString().replace(',', ' UNIT# ' + myJSONResult[i].Unit + ',') + '</b></p></td></table>'  +
                                               '<div id = "street_detail' + i + '" style="display:none;">' + 
                                               
                                               '<div id="hiddendata' + i + '" style="display:none;">' +
                                               '<table>' +                                                   
                                               '<tr><td><input type="hidden" id="iseven' + i + '"  value="' + iseven + '" readonly></td></tr>' +                                                
                                               '<tr><td><input type="hidden" id="InitDate' + i + '" value="' + myJSONResult[i].InitialDate + '"/></td></tr>' +                 
                                               '<tr><td><input type="hidden" id="AddressGUID' + i + '" value="' + myJSONResult[i].AddressGUID + '"/></td></tr>' +
                                               '<tr><td><input type="hidden" id="bPhone' + i + '" value="' + myJSONResult[i].bPhone + '"/></td></tr>' + notes_elements +
                                               '</table>' +                                                   
                                               '</div>' +
                                               
                                               '<table>' +                                               
                                               '<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Language' + i + '">' + 
                                               '<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>' +  
                                               '<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>' +
                                               '</select> </td></tr>' +   
                                               
                                               '<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Type' + i + '">' + 
                                               '<option value="DNC">Do Not Call</option>' +
                                               '<option value="HH">Home</option>' +
                                               '<option value="NH" selected>Not Home</option>' +
                                               '<option value="NTR">No Trespassing</option>' +
                                               '</select></td></tr>' + 
                                               
                                               '<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><textarea id="Notes' + i + '" rows="5" cols="40" value=""/></textarea></td></tr>' + 
                                                                                              
                                               '</table>' + notes +
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="button" value="Submit Changes" onclick="saveData(' + '\'' + '\'' + ',' + i + ',' + '0)"/></td>' +
                                               '<td><input type="button" value="Close" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td></tr>' +                                               
                                               
                                               '</table>' + 
                                               '</div>' +                                                   
                                               '</div>';
                      }
                      if(myJSONResult[i].Type === 'NH' && myJSONResult[i].DateModified !== '' && myJSONResult[i].bPhone === '0' && myJSONResult[i].bUnit === '1'){
                              div.innerHTML =  '<div id="houserecord' + i + '" style="display:block;">' +
                                               '<table><td><img id="propertyicon' + i + '" src="icons/House_NH.png" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td><td><p><b>' + myJSONResult[i].FormattedAddress.toString().replace(',', ' UNIT# ' + myJSONResult[i].Unit + ',') + '</b></p></td></table>' + 
                                               '<div id = "street_detail' + i + '" style="display:none;">' + 
                                               
                                               '<div id="hiddendata' + i + '" style="display:none;">' +
                                               '<table>' +                                                   
                                               '<tr><td><input type="hidden" id="iseven' + i + '"  value="' + iseven + '" readonly></td></tr>' +                                                
                                               '<tr><td><input type="hidden" id="InitDate' + i + '" value="' + myJSONResult[i].InitialDate + '"/></td></tr>' +                 
                                               '<tr><td><input type="hidden" id="AddressGUID' + i + '" value="' + myJSONResult[i].AddressGUID + '"/></td></tr>' +
                                               '<tr><td><input type="hidden" id="bPhone' + i + '" value="' + myJSONResult[i].bPhone + '"/></td></tr>' + notes_elements +
                                               '</table>' +                                                   
                                               '</div>' +
                                               
                                               '<table>' +                                               
                                               '<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Language' + i + '">' + 
                                               '<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>' +  
                                               '<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>' +
                                               '</select> </td></tr>' +  
                                               
                                               '<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Type' + i + '">' + 
                                               '<option value="DNC">Do Not Call</option>' +
                                               '<option value="HH">Home</option>' +
                                               '<option value="NH" selected>Not Home</option>' +
                                               '<option value="NTR">No Trespassing</option>' +
                                               '</select></td></tr>' + 
                                               
                                               '<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><textarea id="Notes' + i + '" rows="5" cols="40" value=""/></textarea></td></tr>' + 
                                                                                              
                                               '</table>' + notes +
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="button" value="Submit Changes" onclick="saveData(' + '\'' + '\'' + ',' + i + ',' + '0)"/></td>' +
                                               '<td><input type="button" value="Close" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td></tr>' +                                               
                                               
                                               '</table>' + 
                                               '</div>' +                                                   
                                               '</div>';
                      }
                      if(myJSONResult[i].Type === 'HH' && myJSONResult[i].DateModified !== '' && myJSONResult[i].bPhone === '0' && myJSONResult[i].bUnit === '1'){
                              div.innerHTML =  '<div id="houserecord' + i + '" style="display:block;">' +
                                               '<table><td><img id="propertyicon' + i + '" src="icons/House_HH.png" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td><td><p><b>' + myJSONResult[i].FormattedAddress.toString().replace(',', ' UNIT# ' + myJSONResult[i].Unit + ',') + '</b></p></td></table>' + 
                                               '<div id = "street_detail' + i + '" style="display:none;">' + 
                                               
                                               '<div id="hiddendata' + i + '" style="display:none;">' +
                                               '<table>' +                                                   
                                               '<tr><td><input type="hidden" id="iseven' + i + '"  value="' + iseven + '" readonly></td></tr>' +                                                
                                               '<tr><td><input type="hidden" id="InitDate' + i + '" value="' + myJSONResult[i].InitialDate + '"/></td></tr>' +                 
                                               '<tr><td><input type="hidden" id="AddressGUID' + i + '" value="' + myJSONResult[i].AddressGUID + '"/></td></tr>' +
                                               '<tr><td><input type="hidden" id="bPhone' + i + '" value="' + myJSONResult[i].bPhone + '"/></td></tr>' + notes_elements +
                                               '</table>' +                                                   
                                               '</div>' +
                                               
                                               '<table>' +                                               
                                               '<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Language' + i + '">' + 
                                               '<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>' +  
                                               '<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>' +
                                               '</select> </td></tr>' +    
                                               
                                               '<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Type' + i + '">' + 
                                               '<option value="DNC">Do Not Call</option>' +
                                               '<option value="HH" selected>Home</option>' +
                                               '<option value="NH">Not Home</option>' +
                                               '<option value="NTR">No Trespassing</option>' +
                                               '</select></td></tr>' + 
                                               
                                               '<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><textarea id="Notes' + i + '" rows="5" cols="40" value=""/></textarea></td></tr>' + 
                                                                                              
                                               '</table>' + notes +
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="button" value="Submit Changes" onclick="saveData(' + '\'' + '\'' + ',' + i + ',' + '0)"/></td>' +
                                               '<td><input type="button" value="Close" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td></tr>' +                                               
                                               
                                               '</table>' + 
                                               '</div>' +                                                   
                                               '</div>';
                      }     
                      if(myJSONResult[i].Type === 'NTR' && myJSONResult[i].DateModified !== '' && myJSONResult[i].bPhone === '0' && myJSONResult[i].bUnit === '1'){
                              div.innerHTML =  '<div id="houserecord' + i + '" style="display:block;">' +
                                               '<table><td><img id="propertyicon' + i + '" src="icons/House_NTR.png" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td><td><p><b>' + myJSONResult[i].FormattedAddress.toString().replace(',', ' UNIT# ' + myJSONResult[i].Unit + ',') + '</b></p></td></table>' + 
                                               '<div id = "street_detail' + i + '" style="display:none;">' + 
                                               
                                               '<div id="hiddendata' + i + '" style="display:none;">' +
                                               '<table>' +                                                   
                                               '<tr><td><input type="hidden" id="iseven' + i + '"  value="' + iseven + '" readonly></td></tr>' +                                                
                                               '<tr><td><input type="hidden" id="InitDate' + i + '" value="' + myJSONResult[i].InitialDate + '"/></td></tr>' +                 
                                               '<tr><td><input type="hidden" id="AddressGUID' + i + '" value="' + myJSONResult[i].AddressGUID + '"/></td></tr>' +
                                               '<tr><td><input type="hidden" id="bPhone' + i + '" value="' + myJSONResult[i].bPhone + '"/></td></tr>' + notes_elements +
                                               '</table>' +                                                   
                                               '</div>' +
                                               
                                               '<table>' +                                               
                                               '<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Language' + i + '">' + 
                                               '<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>' +  
                                               '<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>' +
                                               '</select> </td></tr>' +    
                                               
                                               '<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Type' + i + '">' + 
                                               '<option value="DNC">Do Not Call</option>' +
                                               '<option value="HH">Home</option>' +
                                               '<option value="NH">Not Home</option>' +
                                               '<option value="NTR" selected>No Trespassing</option>' +
                                               '</select></td></tr>' + 
                                               
                                               '<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><textarea id="Notes' + i + '" rows="5" cols="40" value=""/></textarea></td></tr>' + 
                                                                                              
                                               '</table>' + notes +
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="button" value="Submit Changes" onclick="saveData(' + '\'' + '\'' + ',' + i + ',' + '0)"/></td>' +
                                               '<td><input type="button" value="Close" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td></tr>' +                                               
                                               
                                               '</table>' + 
                                               '</div>' +                                                   
                                               '</div>';
                      }                        
                      if(myJSONResult[i].Type === 'DNC' && myJSONResult[i].bUnit === '1'){
                              div.innerHTML =  '<div id="houserecord' + i + '" style="display:block;">' +
                                               '<table><td><img id="propertyicon' + i + '" src="icons/DNC.png" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td><td><p><b>' + myJSONResult[i].FormattedAddress.toString().replace(',', ' UNIT# ' + myJSONResult[i].Unit + ',') + '</b></p></td></table>' +
                                               '<div id = "street_detail' + i + '" style="display:none;">' + 
                                               
                                               '<div id="hiddendata' + i + '" style="display:none;">' +
                                               '<table>' +                                                   
                                               '<tr><td><input type="hidden" id="iseven' + i + '"  value="' + iseven + '" readonly></td></tr>' +                                                
                                               '<tr><td><input type="hidden" id="InitDate' + i + '" value="' + myJSONResult[i].InitialDate + '"/></td></tr>' +                 
                                               '<tr><td><input type="hidden" id="AddressGUID' + i + '" value="' + myJSONResult[i].AddressGUID + '"/></td></tr>' +
                                               '<tr><td><input type="hidden" id="bPhone' + i + '" value="' + myJSONResult[i].bPhone + '"/></td></tr>' + notes_elements +
                                               '</table>' +                                                   
                                               '</div>' +
                                               
                                               '<table>' +                                               
                                               '<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Language' + i + '">' + 
                                               '<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>' +  
                                               '<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>' +
                                               '</select> </td></tr>' + 
                                               
                                               '<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Type' + i + '">' + 
                                               '<option value="DNC" selected>Do Not Call</option>' +
                                               '<option value="HH">Home</option>' +
                                               '<option value="NH">Not Home</option>' +
                                               '<option value="NTR">No Trespassing</option>' +
                                               '</select></td></tr>' + 
                                               
                                               '<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><textarea id="Notes' + i + '" rows="5" cols="40" value=""/></textarea></td></tr>' + 
                                                                                              
                                               '</table>' + notes +
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="button" value="Submit Changes" onclick="saveData(' + '\'' + '\'' + ',' + i + ',' + '0)"/></td>' +
                                               '<td><input type="button" value="Close" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td></tr>' +                                               
                                               
                                               '</table>' + 
                                               '</div>' +                                                   
                                               '</div>';                                   
                      }    
                      if(myJSONResult[i].Type === 'NH' &&  myJSONResult[i].DateModified === '' && myJSONResult[i].bPhone === '1' && myJSONResult[i].bUnit === '1'){
                              div.innerHTML =  '<div id="houserecord' + i + '" style="display:block;">' +
                                               '<table><td><img id="propertyicon' + i + '" src = "icons/Phone_NW.png" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td><td><p><b>' + myJSONResult[i].FormattedAddress.toString().replace(',', ' UNIT# ' + myJSONResult[i].Unit + ',') + '</b></p></td></table>' +
                                               '<div id = "street_detail' + i + '" style="display:none;">' + 
                                               
                                               '<div id="hiddendata' + i + '" style="display:none;">' +
                                               '<table>' +                                                   
                                               '<tr><td><input type="hidden" id="iseven' + i + '"  value="' + iseven + '" readonly></td></tr>' +                                                
                                               '<tr><td><input type="hidden" id="InitDate' + i + '" value="' + myJSONResult[i].InitialDate + '"/></td></tr>' +                 
                                               '<tr><td><input type="hidden" id="AddressGUID' + i + '" value="' + myJSONResult[i].AddressGUID + '"/></td></tr>' +
                                               '<tr><td><input type="hidden" id="bPhone' + i + '" value="' + myJSONResult[i].bPhone + '"/></td></tr>' + notes_elements +
                                               '</table>' +                                                   
                                               '</div>' +
                                               
                                               '<table>' +                                               
                                               '<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Language' + i + '">' + 
                                               '<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>' +  
                                               '<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>' +
                                               '</select> </td></tr>' + 
                                               
                                               '<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Type' + i + '">' + 
                                               '<option value="DNC">Do Not Call</option>' +
                                               '<option value="HH">Home</option>' +
                                               '<option value="NH" selected>Not Home</option>' +
                                               '<option value="NTR">No Trespassing</option>' +
                                               '</select></td></tr>' + 
                                               
                                               '</table>' +                                               
                                                                                              
                                               '<table>' +
                                               
                                               '<tr><td><input type="text" value="Phone:" style="border:none;" readonly></td></tr>' +         
                                               '<tr><td><select id="PhoneType' + i + '">' + 
                                               '<option value="AP">Answered Phone</option>' +
                                               '<option value="DNC">Do Not Call</option>' +  
                                               '<option value="PD">Phone Disconnected</option>' + 
                                               '<option value="NC" selected>Not Called</option>' +
                                               '<option value="VM">Voice Message</option>' + 
                                               '</select> </td>' +          
                                               '<td><div class="tooltip"><img src = "icons/Phone_Small.png">' +           
                                               '<span class="tooltiptext">' + 
                                                myJSONResult[i].Resident + '<br>' + myJSONResult[i].Phone +
                                               '</span></div></td></tr>' + 
                                               
                                               '</table>' +                                               
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><textarea id="Notes' + i + '" rows="5" cols="40" value=""/></textarea></td></tr>' + 
                                                                                              
                                               '</table>' + notes +
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="button" value="Submit Changes" onclick="saveData(' + '\'' + '\'' + ',' + i + ',' + '0)"/></td>' +
                                               '<td><input type="button" value="Close" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td></tr>' +                                               
                                               
                                               '</table>' + 
                                               '</div>' +                                                   
                                               '</div>';                                     
                      }  
                      if(myJSONResult[i].Type === 'NTR' &&  myJSONResult[i].DateModified !== '' && myJSONResult[i].bPhone === '1' && myJSONResult[i].bUnit === '1'){
                              div.innerHTML =  '<div id="houserecord' + i + '" style="display:block;">' +
                                               '<table><td><img id="propertyicon' + i + '" src = "icons/Phone_NTR.png" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td><td><p><b>' + myJSONResult[i].FormattedAddress.toString().replace(',', ' UNIT# ' + myJSONResult[i].Unit + ',') + '</b></p></td></table>' +
                                               '<div id = "street_detail' + i + '" style="display:none;">' + 
                                               
                                               '<div id="hiddendata' + i + '" style="display:none;">' +
                                               '<table>' +                                                   
                                               '<tr><td><input type="hidden" id="iseven' + i + '"  value="' + iseven + '" readonly></td></tr>' +                                                
                                               '<tr><td><input type="hidden" id="InitDate' + i + '" value="' + myJSONResult[i].InitialDate + '"/></td></tr>' +                 
                                               '<tr><td><input type="hidden" id="AddressGUID' + i + '" value="' + myJSONResult[i].AddressGUID + '"/></td></tr>' +
                                               '<tr><td><input type="hidden" id="bPhone' + i + '" value="' + myJSONResult[i].bPhone + '"/></td></tr>' + notes_elements +
                                               '</table>' +                                                   
                                               '</div>' +
                                               
                                               '<table>' +                                               
                                               '<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Language' + i + '">' + 
                                               '<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>' +  
                                               '<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>' +
                                               '</select> </td></tr>' +   
                                               
                                               '<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Type' + i + '">' + 
                                               '<option value="DNC">Do Not Call</option>' +
                                               '<option value="HH">Home</option>' +
                                               '<option value="NH">Not Home</option>' +
                                               '<option value="NTR" selected>No Trespassing</option>' +
                                               '</select></td></tr>' + 
                                               
                                               '</table>' +                                               
                                                                                              
                                               '<table>' +
                                               
                                               '<tr><td><input type="text" value="Phone:" style="border:none;" readonly></td></tr>' +         
                                               '<tr><td><select id="PhoneType' + i + '">' + 
                                               '<option value="AP">Answered Phone</option>' +
                                               '<option value="DNC">Do Not Call</option>' +  
                                               '<option value="PD">Phone Disconnected</option>' + 
                                               '<option value="NC" selected>Not Called</option>' +
                                               '<option value="VM">Voice Message</option>' + 
                                               '</select> </td>' +          
                                               '<td><div class="tooltip"><img src = "icons/Phone_Small.png">' +           
                                               '<span class="tooltiptext">' + 
                                                myJSONResult[i].Resident + '<br>' + myJSONResult[i].Phone +
                                               '</span></div></td></tr>' + 
                                               
                                               '</table>' +                                               
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><textarea id="Notes' + i + '" rows="5" cols="40" value=""/></textarea></td></tr>' + 
                                                                                              
                                               '</table>' + notes +
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="button" value="Submit Changes" onclick="saveData(' + '\'' + '\'' + ',' + i + ',' + '0)"/></td>' +
                                               '<td><input type="button" value="Close" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td></tr>' +                                               
                                               
                                               '</table>' + 
                                               '</div>' +                                                   
                                               '</div>';                                     
                      }         
                      if(myJSONResult[i].Type === 'NH' &&  myJSONResult[i].DateModified !== '' && myJSONResult[i].bPhone === '1' && myJSONResult[i].bUnit === '1'){
                              div.innerHTML =  '<div id="houserecord' + i + '" style="display:block;">' +
                                               '<table><td><img id="propertyicon' + i + '" src = "icons/Phone_NH.png" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td><td><p><b>' + myJSONResult[i].FormattedAddress.toString().replace(',', ' UNIT# ' + myJSONResult[i].Unit + ',') + '</b></p></td></table>' +
                                               '<div id = "street_detail' + i + '" style="display:none;">' + 
                                               
                                               '<div id="hiddendata' + i + '" style="display:none;">' +
                                               '<table>' +                                                   
                                               '<tr><td><input type="hidden" id="iseven' + i + '"  value="' + iseven + '" readonly></td></tr>' +                                                
                                               '<tr><td><input type="hidden" id="InitDate' + i + '" value="' + myJSONResult[i].InitialDate + '"/></td></tr>' +                 
                                               '<tr><td><input type="hidden" id="AddressGUID' + i + '" value="' + myJSONResult[i].AddressGUID + '"/></td></tr>' +
                                               '<tr><td><input type="hidden" id="bPhone' + i + '" value="' + myJSONResult[i].bPhone + '"/></td></tr>' + notes_elements +
                                               '</table>' +                                                   
                                               '</div>' +
                                               
                                               '<table>' +                                               
                                               '<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Language' + i + '">' + 
                                               '<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>' +  
                                               '<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>' +
                                               '</select> </td></tr>' +     
                                               
                                               '<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Type' + i + '">' + 
                                               '<option value="DNC">Do Not Call</option>' +
                                               '<option value="HH">Home</option>' +
                                               '<option value="NH" selected>Not Home</option>' +
                                               '<option value="NTR">No Trespassing</option>' +
                                               '</select></td></tr>' + 
                                               
                                               '</table>' +                                               
                                                                                              
                                               '<table>' +
                                               
                                               '<tr><td><input type="text" value="Phone:" style="border:none;" readonly></td></tr>' +         
                                               '<tr><td><select id="PhoneType' + i + '">' + 
                                               '<option value="AP">Answered Phone</option>' +
                                               '<option value="DNC">Do Not Call</option>' +  
                                               '<option value="PD">Phone Disconnected</option>' + 
                                               '<option value="NC" selected>Not Called</option>' +
                                               '<option value="VM">Voice Message</option>' + 
                                               '</select> </td>' +          
                                               '<td><div class="tooltip"><img src = "icons/Phone_Small.png">' +           
                                               '<span class="tooltiptext">' + 
                                                myJSONResult[i].Resident + '<br>' + myJSONResult[i].Phone +
                                               '</span></div></td></tr>' + 
                                               
                                               '</table>' +                                               
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><textarea id="Notes' + i + '" rows="5" cols="40" value=""/></textarea></td></tr>' + 
                                                                                              
                                               '</table>' + notes +
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="button" value="Submit Changes" onclick="saveData(' + '\'' + '\'' + ',' + i + ',' + '0)"/></td>' +
                                               '<td><input type="button" value="Close" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td></tr>' +                                               
                                               
                                               '</table>' + 
                                               '</div>' +                                                   
                                               '</div>';                                     
                      }    
                      if(myJSONResult[i].Type === 'HH' &&  myJSONResult[i].DateModified !== '' && myJSONResult[i].bPhone === '1' && myJSONResult[i].bUnit === '1'){
                              div.innerHTML =  '<div id="houserecord' + i + '" style="display:block;">' +
                                               '<table><td><img id="propertyicon' + i + '" src = "icons/Phone_HH.png" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td><td><p><b>' + myJSONResult[i].FormattedAddress.toString().replace(',', ' UNIT# ' + myJSONResult[i].Unit + ',') + '</b></p></td></table>' +
                                               '<div id = "street_detail' + i + '" style="display:none;">' + 
                                               
                                               '<div id="hiddendata' + i + '" style="display:none;">' +
                                               '<table>' +                                                   
                                               '<tr><td><input type="hidden" id="iseven' + i + '"  value="' + iseven + '" readonly></td></tr>' +                                                
                                               '<tr><td><input type="hidden" id="InitDate' + i + '" value="' + myJSONResult[i].InitialDate + '"/></td></tr>' +                 
                                               '<tr><td><input type="hidden" id="AddressGUID' + i + '" value="' + myJSONResult[i].AddressGUID + '"/></td></tr>' +
                                               '<tr><td><input type="hidden" id="bPhone' + i + '" value="' + myJSONResult[i].bPhone + '"/></td></tr>' + notes_elements +
                                               '</table>' +                                                   
                                               '</div>' +
                                               
                                               '<table>' +                                               
                                               '<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Language' + i + '">' + 
                                               '<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>' +  
                                               '<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>' +
                                               '</select> </td></tr>' +    
                                               
                                               '<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><select id="Type' + i + '">' + 
                                               '<option value="DNC">Do Not Call</option>' +
                                               '<option value="HH" selected>Home</option>' +
                                               '<option value="NH">Not Home</option>' +
                                               '<option value="NTR">No Trespassing</option>' +
                                               '</select></td></tr>' + 
                                               
                                               '</table>' +                                               
                                                                                              
                                               '<table>' +
                                               
                                               '<tr><td><input type="text" value="Phone:" style="border:none;" readonly></td></tr>' +         
                                               '<tr><td><select id="PhoneType' + i + '">' + 
                                               '<option value="AP">Answered Phone</option>' +
                                               '<option value="DNC">Do Not Call</option>' +  
                                               '<option value="PD">Phone Disconnected</option>' + 
                                               '<option value="NC" selected>Not Called</option>' +
                                               '<option value="VM">Voice Message</option>' + 
                                               '</select> </td>' +          
                                               '<td><div class="tooltip"><img src = "icons/Phone_Small.png">' +           
                                               '<span class="tooltiptext">' + 
                                                myJSONResult[i].Resident + '<br>' + myJSONResult[i].Phone +
                                               '</span></div></td></tr>' + 
                                               
                                               '</table>' +                                               
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>' + 
                                               '<tr><td><textarea id="Notes' + i + '" rows="5" cols="40" value=""/></textarea></td></tr>' + 
                                                                                              
                                               '</table>' + notes +
                                               
                                               '<table>' +
                                               
                                               '<tr><td><input type="button" value="Submit Changes" onclick="saveData(' + '\'' + '\'' + ',' + i + ',' + '0)"/></td>' +
                                               '<td><input type="button" value="Close" onclick="expandStreetDetail(' + '\'' + 'street_detail' + i + '\'' + ')"/></td></tr>' +                                               
                                               
                                               '</table>' + 
                                               '</div>' +                                                   
                                               '</div>';                                     
                      }                                               
                      
                      detail.appendChild(div);
      
                      }
            }
        };
        xmlhttp.open("GET", "getstreetmodule.php?congregationnumber=" + congregation + "&territorynumber=" + territorynumber + "&street=" + street + "&streetsuffix=" + streetsuffix + "&detailtype=" + detail_type, true);
        xmlhttp.send();         
    }
    
    function expandStreetDetail(id){
    var showhide = document.getElementById(id);
    if (showhide.style.display === 'block'){
        showhide.style.display = 'none';
        return;
    }
    if (showhide.style.display === 'none'){
        showhide.style.display = 'block';
        return;
    }    
    }
    
    function showGroupID(id){
     var showhide = document.getElementById('displaygrouplist' + id);
     showhide.style.display = 'block';  
     var option='<option value="">' + 'Select group' + '</option>';
     for(var i=0;i<territorygroups.length;i++){                
        option += '<option value="' + territorygroups[i].Guid  + '">' + territorygroups[i].Group + '</option>';                                  
     }
     $('#grplist' + id).append(option);

    }

    function hideGroupID(id){
     var showhide = document.getElementById('displaygrouplist' + id);
     showhide.style.display = 'none';               
    }            

    function submitCheckoutRequest(territory){
        var d = new Date();
        var datestring = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());             
        var xmlhttp = new XMLHttpRequest();
         xmlhttp.onreadystatechange = function() {
             if (this.readyState == 4 && this.status ===200) {
                 var myJSONResult = JSON.parse(this.responseText);
//                 document.getElementById("rtmessage").innerHTML = myJSONResult[0].Message;
             }
         };


         xmlhttp.open("GET", "saveRequestTerritory.php?congregationnumber=" + congregationNumber + 
                                                      '&territorynumber=' + territory +
                                                      '&requestusername=' + username +
                                                      '&groupguid=' + document.getElementById("grplist").value + 
                                                      '&requestdate=' + datestring, true);
         xmlhttp.send();                 
    }  
    
    
    function submitCheckoutRequestID(id){
        var d = new Date();
        var datestring = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());             
        var xmlhttp = new XMLHttpRequest();
         xmlhttp.onreadystatechange = function() {
             if (this.readyState == 4 && this.status ===200) {
                 var myJSONResult = JSON.parse(this.responseText);
//                        document.getElementById("rtmessage").innerHTML = myJSONResult[0].Message;
             }
         };


         xmlhttp.open("GET", "saveRequestTerritory.php?congregationnumber=" + congregationNumber + 
                                                      '&territorynumber=' + id +
                                                      '&requestusername=' + username +
                                                      '&groupguid=' + document.getElementById('grplist' + id).value + 
                                                      '&requestdate=' + datestring, true);
         xmlhttp.send();                 
    }    
    
    function getTerritoryGroups(){
        var xmlhttp = new XMLHttpRequest();
         xmlhttp.onreadystatechange = function() {
             if (this.readyState == 4 && this.status == 200) {
                 var myJSONResult = JSON.parse(this.responseText);
                 for(i=0;i<myJSONResult.length;i++){
                     territorygroups.push({Guid:myJSONResult[i].GroupGUID, Group:myJSONResult[i].GroupName});
                 }
             }
         };
         xmlhttp.open("GET", "getTerritoryGroup.php?congregationnumber=" + congregationNumber, true);
         xmlhttp.send();                             
    }    
    
    function showRequestID(id){
        var showhide = document.getElementById('displayrequest' + id);
        if(showhide.style.display === 'none'){
        showhide.style.display = 'block';    
        }else{
            showhide.style.display = 'none'; 
        }
    }
    
    function selectNavigationRow(){
        document.getElementById('navrow' + territoryNumber).style = "background-color:#FFFFEC;"; //outline: thin solid black;
    }
    
        function getCurrentCampaign(){
           
            var xmlhttp = new XMLHttpRequest();
             xmlhttp.onreadystatechange = function() {
                 if (this.readyState == 4 && this.status == 200) {
                     var myJSONResult = JSON.parse(this.responseText);
                     for(i=0;i<myJSONResult.length;i++){
//                        var d = new Date(); 
//                        var datestring = d.getFullYear() + "-" + ZeroPadding(d.getMonth() + 1) + "-" + ZeroPadding(d.getDate()) + " " + ZeroPadding(d.getHours()) + ":" + ZeroPadding(d.getMinutes()) + ":" + ZeroPadding(d.getSeconds()) + "." + ZeroPadding(d.getMilliseconds());            
//                        var currdate = new Date(datestring);                         
//                        var enddate = new Date(myJSONResult[i].Enddate);
//                        
//                        var date_diff_indays = function(date1, date2) {
//                            dt1 = new Date(date1);
//                            dt2 = new Date(date2);
//                            return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
//                        }   
                        
                        if(myJSONResult[i].CampaignType!=='NCM'){                            
                            document.getElementById("scrollingcampaign").innerHTML = myJSONResult[i].Year + " " + myJSONResult[i].CampaignDescription +  "... " + myJSONResult[i].Days + " days left." + " " + myJSONResult[i].MsgBoard;                  
                        }else{
                            document.getElementById("scrollingcampaign").innerHTML = myJSONResult[i].MsgBoard; 
                        }
                     }

                 }
             };
             xmlhttp.open("GET", "getCurrentCampaign.php?congregationnumber=" + congregationNumber, true);
             xmlhttp.send();             
        }  
    
    $(document).ready(function(){
        var screen = Number($(window).width());
        var menuwidth = Math.round((200/screen)*100);  
        var territorynavigation = false;    
        
        getTerritoryGroups();
        selectNavigationRow();
        topPanel();
        getCurrentCampaign();
        if(screen>=768){
            CreateLegend1();
        }
        
        if(screen<768){
            document.getElementById("donatefunds").innerHTML = "$";            
            document.getElementById("mylegend").innerHTML = "";
            //CreateLegend2();
//            document.getElementById("msg").style.display = 'none';
            document.getElementById("myname").innerHTML = '<a href = "welcome.php" class="menutitle"><img src = "icons/TO_logo.png"></a>';
            document.getElementById("mobilemenu").style.display = 'block';
//            document.getElementById("streetpageclose").style.display = 'block';
//            document.getElementById("territorypageclose").style.display = 'block';
            document.getElementById("desktopmenu").style.display = 'none';     
            document.getElementById("signout").innerHTML = '';
            document.getElementById("signout2").style.display = 'block';            
        };
        
        if(screen>768 && screen<=1024){
//            document.getElementById("msg").style.display = 'none'; 
            document.getElementById("myname").innerHTML = '<a href = "welcome.php" class="menutitle"><img src = "icons/TO_largelogo1.png"></a>';                     
        }        
        
        $("#mobilemenudisplay").hover(function (){   
           document.getElementById("mobilemenucontrol").style.width = menuwidth.toString() + "%";
           document.getElementById("mobilemenucontrol").style.display = 'block';
           document.getElementById("myleft2").style.width = "0"; 
           document.getElementById("main1").style.marginLeft = "0";   
           document.getElementById("main1").style.width = "100%"; 
           document.getElementById("banner").style.marginLeft = "0";   
           document.getElementById("banner").style.width = "100%";            
        });     

        $("#desktopmenudisplay").hover(function (){ 
           territorynavigation = false; 
           document.getElementById("menucontrol").style.width = menuwidth.toString() + "%";
           document.getElementById("menucontrol").style.display = 'block';
           document.getElementById("myleft1").style.width = "0"; 
           document.getElementById("myleft2").style.width = "0";    
           document.getElementById("myleft3").style.width = "0";              
           document.getElementById("main1").style.marginLeft = "0";
        });  
        
        $("#mobileselectterritory").click(function (){  
           document.getElementById("myleft1").style.width = "0";               
           document.getElementById("myleft2").style.width = "100%";                      
           document.getElementById("mobilemenucontrol").style.width = "0";  
           document.getElementById("main1").style.width = "0";   
           document.getElementById("banner").style.width = "0";               
         });  

        $("#selectterritory").click(function (){  
           territorynavigation = true;
           document.getElementById("myleft1").style.width = "0";              
           document.getElementById("myleft2").style.width = "400px";           
           document.getElementById("menucontrol").style.width = "0";  
           document.getElementById("main1").style.marginLeft = "400px"; 
           document.getElementById("banner").style.marginLeft = "400px";            
         }); 
         
        $("#mobileviewstreet").click(function (){ 
           document.getElementById("myleft2").style.width = "0";              
           document.getElementById("myleft1").style.width = "100%";                      
           document.getElementById("mobilemenucontrol").style.width = "0";  
           document.getElementById("main1").style.width = "0";     
           document.getElementById("banner").style.width = "0";                        
         });           
         
        $("#viewstreet").click(function (){ 
           territorynavigation = true;            
           document.getElementById("myleft1").style.width = "400px";
           document.getElementById("myleft2").style.width = "0";   
           document.getElementById("menucontrol").style.width = "0";   
           document.getElementById("main1").style.marginLeft = "400px"; 
           document.getElementById("banner").style.marginLeft = "400px";              
         });   
         
        $("#eyeglass").click(function (){  
            if(screen<768){ 
                document.getElementById("myleft2").style.width = "0";              
                document.getElementById("myleft1").style.width = "100%";                      
                document.getElementById("mobilemenucontrol").style.width = "0";  
                document.getElementById("main1").style.width = "0";     
                document.getElementById("banner").style.width = "0";                 
            }else{
                territorynavigation = true;            
                document.getElementById("myleft1").style.width = "400px";
                document.getElementById("myleft2").style.width = "0";   
                document.getElementById("menucontrol").style.width = "0";   
                document.getElementById("main1").style.marginLeft = "400px"; 
                document.getElementById("banner").style.marginLeft = "400px";                  
            }
         });            
                       
        $(".main").hover(function (){
            document.getElementById("mobilemenucontrol").style.width = "0";
            document.getElementById("menucontrol").style.width = "0";              
            if(territorynavigation === false){
                document.getElementById("main1").style.marginLeft = "0";
                document.getElementById("banner").style.marginLeft = "0";
            }; 
        });
        
        $("#banner").hover(function (){
            document.getElementById("mobilemenucontrol").style.width = "0";
            document.getElementById("menucontrol").style.width = "0";              
            if(territorynavigation === false){
                document.getElementById("main1").style.marginLeft = "0";
                document.getElementById("banner").style.marginLeft = "0";
            }; 
        });        
        
        $("#closelegend").click(function (){ 
            document.getElementById("mylegend").style.display = 'none';
        });            
        
        $("#toterr1").click(function (){ 
           document.getElementById("myleft1").style.width = "0";  
           document.getElementById("main1").style.width = "100%";  
           document.getElementById("banner").style.width = "100%";            
           if(screen>=768){
               document.getElementById("main1").style.marginLeft = "0";
               document.getElementById("banner").style.marginLeft = "0";               
           }           
         });  
         
        $("#toterr3").click(function (){ 
           document.getElementById("myleft3").style.width = "0"; 
           if(screen<768){
               document.getElementById("myleft1").style.width = "100%"; 
           }
           else{
               document.getElementById("myleft1").style.width = "400px";               
           }
              

         });           
         
        $("#toterr2").click(function (){ 
           document.getElementById("myleft2").style.width = "0";            
           document.getElementById("main1").style.width = "100%";
           document.getElementById("banner").style.width = "100%";           
           if(screen>=768){
               document.getElementById("main1").style.marginLeft = "0";
               document.getElementById("banner").style.marginLeft = "0";               
           }
         });           


    });
</script>
</div>

    </body>
</html>
