<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LayerClass
 *
 * @author Cicely
 */
class UserInfo{
    private $data = array();
 public function __construct($congregation,$connection)   {
        $sql="call getusername('$congregation')";
        $stmt = mysqli_query($connection,$sql);
        
        if (!$stmt ) {
          die('Invalid query: ' . mysqli_error($connection)); 
          
        }    
        
        while( $row = mysqli_fetch_array( $stmt, MYSQLI_NUM))
        {
            $this->data[] = array("username"=>$row[0],"name"=>$row[1]);
        } 
        
        $stmt->close();
        $connection->next_result();        
 }
 
 public function getUsername($username){
    for($i=0;$i<count($this->data);$i++){     
      if($this->data[$i]["username"]==$username){
          return $this->data[$i]["name"]; 
      }      
    }              
 }
 
}


class Login{
    private $conn;
    private $username;
    private $isuser=false;
    private $password;
    private $passwordkey;
    private $email;
    private $name;
    private $congregation;
    private $confirmationnumber;
    private $role;
    private $errornumber;
    private $errormessage;
    
    public function close(){
        mysqli_close($this->conn);
    }
    
    function __construct($host,$username,$password,$database,$port,$socket){
        $this->conn = mysqli_connect($host,$username,$password,$database,$port,$socket);
    }
    
    public function login_username($Username){
        $sql="call login_username('$Username')";
        $stmt = mysqli_query($this->conn,$sql);
        
        if (!$stmt ) {
          die('Invalid query: '); 
          
        }    
        
        while( $row = mysqli_fetch_array( $stmt, MYSQLI_NUM))
        {
            if($row[0]==0){
                $this->errornumber=0;
                $this->isuser=true;
                $this->username=$Username;
                $this->password=$row[2];
                $this->passwordkey=$row[3]; 
                $this->congregation=$row[4];
                $this->role=$row[5];
            }
            
            if($row[0]==1){
                $this->errornumber=1;
                $this->errormessage=$row[1];                
            }   
        
        }   
        
        $stmt->close();
        $this->conn->next_result();         
        
    }
        
    public function IsUser(){
        return $this->isuser;
    }
    
    public function username(){
        return $this->username;
    }
    
    public function password(){
        return $this->password;
    }
    
    public function passwordkey(){
        return $this->passwordkey;
    }
    
    public function congregation(){
        return $this->congregation;
    }
    
    public function role(){
        return $this->role;
    }    
    
    public function login_successful(){
        $sql="call login_success('$this->username')";
        $stmt = mysqli_query($this->conn,$sql);
        
        if (!$stmt ) {
          die('Invalid query: '); 
          
        }  
        
        while( $row = mysqli_fetch_array( $stmt, MYSQLI_NUM))
        {
            if($row[0]==0){
                $this->errornumber=0;
                $this->errormessage=$row[1];
               
            }
        }
        
        $stmt->close();
        $this->conn->next_result();          
    }
    
    public function createaccount($Firstname,$Lastname,$MiddleInit,$Suffixname,$Address,$Apartment,$City,$State,$ZipCode,$HomeCongregationNumber,$Username,$Email,$Password,$Password_Key,$CongregationNumber,$CongregationName,$PhoneNumber,$CongregationApartment,$CongregationCity,$CongregationState,$CongregationZipCode,$CongregationFormattedAddress,$Latitude,$Longitude,$LanguageGUID){
        
        $sql="call createcongregation('$Firstname','$Lastname','$MiddleInit','$Suffixname','$Address','$Apartment','$City','$State','$ZipCode','$HomeCongregationNumber','$Username','$Email','$Password','$Password_Key','$CongregationNumber','$CongregationName','$PhoneNumber','$CongregationApartment','$CongregationCity','$CongregationState','$CongregationZipCode','$CongregationFormattedAddress','$Latitude','$Longitude','$LanguageGUID')";

        $stmt = mysqli_query($this->conn,$sql);
        
        if (!$stmt ) {
          die('Invalid query create account'.' Error description: ' . mysqli_error($this->conn)); 
          
        } 
        
        if($HomeCongregationNumber!=''){
            $this->congregation=$HomeCongregationNumber;
        }
        else{
            $this->congregation=$CongregationNumber;
        }
        
        while( $row = mysqli_fetch_array( $stmt, MYSQLI_NUM))
        {
            if($row[0]==0){
                $this->errornumber=0;
                $this->confirmationnumber=$row[1];
                $this->username=$Username;
                $this->email=$Email;
                $this->name=$Firstname.' '.$Lastname;
            }
            
            if($row[0]==1){
                $this->errornumber=1;
                $this->errormessage=$row[1];                
            }            
        }
        
        $stmt->close();
        $this->conn->next_result(); 
    }
    

    
    public function error(){
        return $this->errornumber;
    }
    
    public function errormessage(){
        return $this->errormessage;
    }
    
    public function confirmationnumber(){
        return $this->confirmationnumber;
    }
    
    public function emailconfirmation($econfirmationnumber){
        $sql="call confirmation('$this->username','$econfirmationnumber')";
        $stmt = mysqli_query($this->conn,$sql);
        
        if (!$stmt ) {
          die('Invalid query email confirmation'); 
          
        } 
        
        $stmt->close();
        $this->conn->next_result(); 
        
       // $to=$this->email;
//        $to="cecebrown2013@gmail.com";
//        $subject="New account confirmation";
//        $message = 'Hi '.$this->name.',\r\nThank you for creating account.\nClick this link will confirm your account with Territory Manager: confirmationreceipt.php?confirm='.$econfirmationnumber;
//        $message = wordwrap($message,70);
//       
//        $headers= "From: cecebrown2013@gmail.com";
//        
//        //send email
//       $mail_sent= mail($to,$subject,$message,$headers);
//       echo $mail_sent ? "Email successfully sent!" : "Email delivery failed..";

    }
    
    public function emailverification($econfirmationnumber){
        $sngquote = "'" ;
        $confirmationnumber= str_replace($sngquote,'' , $econfirmationnumber);
        $sql="call emailverification('$confirmationnumber')";
        $stmt = mysqli_query($this->conn,$sql);
        if (!$stmt ) {
          die('Invalid query: '.$confirmationnumber); 
          
        }  
        while( $row = mysqli_fetch_array( $stmt, MYSQLI_NUM))
        {      
            if ($row[0]==0){
                echo '<h1> This account not exist!</h1>',PHP_EOL;
            }
            if($row[0]==1 && $row[1]==0){
            echo '<h1> Your account has already been verified!</h1>',PHP_EOL;
            echo '<h2> If your account has not been activated. Please allow 24 hrs or less for activation.</h2>',PHP_EOL;                                
            }
            if($row[0]==1 && $row[1]==1){
            echo '<h1> Your account has been verified!</h1>',PHP_EOL;
            echo '<h2> Please allow 24 hrs or less for activation.</h2>',PHP_EOL;
            }
        }
        $stmt->close();
        $this->conn->next_result();
    }
    
    public function admin_emails(){
        $emails;
        $sql="call admin_email('".congregation()."')";
        $stmt = mysqli_query($this->conn,$sql);
        if (!$stmt ) {
          die('Invalid query: '.$confirmationnumber); 
          
        }     
        while( $row = mysqli_fetch_array( $stmt, MYSQLI_NUM))
        { 
            $emails[] = array("Name"=>$row[0].' '.$row[1],"Email"=>$row[2]);
        }        
        $stmt->close();
        $this->conn->next_result(); 
        
        return $emails;
    }
    
    public function activationlist(){
        $nonactivatedaccounts;
        $sql="call displayusers4activation('".congregation()."')";
        $stmt = mysqli_query($this->conn,$sql);
        if (!$stmt ) {
          die('Invalid query activationlist'); 
          
        }  

        while( $row = mysqli_fetch_array( $stmt, MYSQLI_NUM))
        {          
            $nonactivatedaccounts[] = array("Name"=>$row[0].' '.$row[1],"Username"=>$row[2]);
        }

        $stmt->close();
        $this->conn->next_result(); 
        
        return $nonactivatedaccounts;
    }
    public function displaynonactivatedaccounts(){
        $sql="call displayusers4activation('".congregation()."')";
        $stmt = mysqli_query($this->conn,$sql);
        if (!$stmt ) {
          die('Invalid query displayusers4activation'); 
          
        }  
        
        echo '<table>',PHP_EOL;
        echo '<tr>',PHP_EOL;
        echo '<th bgcolor="#0B1F81"><font color="white">Name</font></th>',PHP_EOL;
        echo '<th bgcolor="#0B1F81"><font color="white">Username</font></th>',PHP_EOL;
        echo '<th bgcolor="#0B1F81"><font color="white">Role</font></th>',PHP_EOL; 
        echo '<th bgcolor="#0B1F81"><font color="white">Activate</font></th>',PHP_EOL;
        echo '</tr>',PHP_EOL;
        while( $row = mysqli_fetch_array( $stmt, MYSQLI_NUM))
        {      
            echo '<tr>',PHP_EOL;
            
            echo '<td>',PHP_EOL;
            echo $row[0].' '.$row[1],PHP_EOL;
            echo '</td>',PHP_EOL;
            
            echo '<td>',PHP_EOL;
            echo $row[2],PHP_EOL;
            echo '</td>',PHP_EOL;      
            
            echo '<td>',PHP_EOL;
            echo $row[3],PHP_EOL;
            echo '</td>',PHP_EOL;  
            
            //<input type="checkbox" name="layer" value="Polygon" onclick="TurnOnOffLayer(this,'Polygon')" checked>
            echo '<td>',PHP_EOL;
            echo '<input type="checkbox" name="activate" value="0">',PHP_EOL;
            echo '</td>',PHP_EOL; 

            echo '</tr>',PHP_EOL;
        }
        echo '</table>',PHP_EOL;
        $stmt->close();
        $this->conn->next_result();        
    }
    
}
        class territorylist
        {

            private $conn;
            private $codeinjector = array();
            private $lat;
            private $long;
            
            function __construct($host,$username,$password,$database,$port,$socket)
            {
               $this->conn = mysqli_connect($host,$username,$password,$database,$port,$socket);

            }
            
            public function close()
            {

                mysqli_close($this->conn);
            }
            
            public function Latitude(){
                return $this->lat;
            }
            
            public function Longitude(){
                return $this->long;
            }
            
            public function InitialMap($congregationnumber){
               $sql="call getCoordinatesCongregation('$congregationnumber')";
               $stmt = mysqli_query($this->conn,$sql);   
               while( $row = mysqli_fetch_array( $stmt, MYSQLI_NUM))
               { 
                 $this->lat=$row[0];
                 $this->long=$row[1];
               }               
               $stmt->close();
               $this->conn->next_result(); 
            }
            
            public function NavigationList($congregationnumber,$checkinicon,$checkouticon)
            {
               $sql="call territorylist('$congregationnumber')";
               $stmt = mysqli_query($this->conn,$sql);
               $sngquote = "'" ;
               
               echo '<table>',PHP_EOL;
               echo '<tr>',PHP_EOL;
               echo '<th>',PHP_EOL;
               echo '</th>',PHP_EOL;
               echo '<th>',PHP_EOL;
               echo '</th>',PHP_EOL;                    
//               echo '<th align="right">',PHP_EOL;
//               echo '<a href="#" onclick="closeNav2()">&times;</a>',PHP_EOL;
//               echo '</th>',PHP_EOL;                     
               echo '</tr>',PHP_EOL;
               echo '<tr>',PHP_EOL;               
               echo '<th bgcolor="#0B1F81"><font color="white">',PHP_EOL;
               echo 'Territory',PHP_EOL;
               echo '</font></th>',PHP_EOL;
               echo '<th bgcolor="#0B1F81"><font color="white">',PHP_EOL;
               echo 'Available',PHP_EOL;
               echo '</font></th>',PHP_EOL;                 
               echo '<th bgcolor="#0B1F81"><font color="white">',PHP_EOL;
               echo 'Progress',PHP_EOL;
               echo '</font></th>',PHP_EOL;
               echo '<th bgcolor="#0B1F81"><font color="white">',PHP_EOL;
               echo 'Houses',PHP_EOL;
               echo '</font></th>',PHP_EOL;                 
               echo '</tr>',PHP_EOL;
               while( $row = mysqli_fetch_array( $stmt, MYSQLI_NUM))
               {  
                   echo '<tr id="navrow'.$row[1].'">',PHP_EOL;
                   echo '<td width="20%">',PHP_EOL;
                   //echo '<a href = "territorymap.php?territory='.$row[1].'">'.$row[0].'</a>',PHP_EOL;
                   echo '<center><a href = "territorymap.php?territory='.$row[1].'" style="padding: 0px 0px 0px 0px;">'.$row[1].'</a></center>',PHP_EOL;
                   echo '</td>',PHP_EOL;
                   
                   if ($row[4]=='0'){
                        echo '<td>',PHP_EOL;
                       // echo '<div class="tooltip">',PHP_EOL;                        
                        echo '<center><img src = "'.$checkinicon.'" onclick="showRequestID('.$sngquote.$row[1].$sngquote.')"/></center>',PHP_EOL;                                                 
                        echo '</td>',PHP_EOL; 

                   }
                   
                   if ($row[4]=='1'){
                        echo '<td>',PHP_EOL;
                        echo '<center>',PHP_EOL;
                        echo '<div class="tooltip"><img src = "'.$checkouticon.'"/><span class="tooltiptext" style="width: 200px;">',PHP_EOL;
                        echo '<table><td><img src="icons/checkout2.png"/></td><td>'.$row[7].'</td></table>',PHP_EOL; 
                        echo '<table>',PHP_EOL; 
                        if($row[13]!=''){                        
                        echo '<tr><td align="left">group:</td><td align="left">'.$row[13].'</td></tr>',PHP_EOL; 
                        }
                        echo '<tr><td align="left">request:</td><td align="left">'.$row[8].'</td></tr>',PHP_EOL;
                        echo '<tr><td align="left">assign:</td><td align="left">'.$row[9].'</td></tr>',PHP_EOL;
                        echo '</table></span></div>',PHP_EOL;
                        echo '</center>',PHP_EOL;                                                
                        echo '</td>',PHP_EOL;                       
                   }                   
                   
                   echo '<td width="40%">',PHP_EOL;
                   echo '<div class="tooltip">',PHP_EOL;
                   echo '<progress value="'.$row[2].'" max="100"></progress>',PHP_EOL;
                   echo '<span class="tooltiptext">'.$row[2].'%',PHP_EOL;
                   echo '</span></div>',PHP_EOL;
                   echo '</td>',PHP_EOL;

                     
  
                   
                   echo '<td width="20%">',PHP_EOL;
                   echo '<p><center>'.$row[3].'</center></p>',PHP_EOL;
                   echo '</td>',PHP_EOL;                        
                   echo '</tr>',PHP_EOL;
                   
                   echo '<tr>',PHP_EOL;  
                   echo '<td>',PHP_EOL;  
                   echo '<td colspan="3">',PHP_EOL;  
                   echo '<div id="displayrequest'.$row[1].'" style="display:none;">',PHP_EOL;
                   echo '<table><tr bgcolor="#FFFFC1"><td>Request for checkout on territory '.$row[1].'?</td></tr></table>',PHP_EOL;
                   echo '<table><tr><form action=""><td><input type="radio" id = "checkout_yes'.$row[1].'" value="yes" style="width: 30px;" onclick="showCheckoutRequestID('.$sngquote.$row[1].$sngquote.')">Yes</td>',PHP_EOL;
                   echo '<td><input type="radio" id = "checkout_no'.$row[1].'" value="no"  style="width: 30px;" onclick="hideCheckoutRequestID('.$sngquote.$row[1].$sngquote.')" checked>No</td></form></tr></table>',PHP_EOL;
                   echo '<div id="displaycheckout'.$row[1].'" style="display:block;">',PHP_EOL;

                   echo '<table><tr bgcolor="#FFFFC1"><td>Will this territory be issued to service group?</td></tr></table>',PHP_EOL;
                   echo '<table><tr><form action=""><td><input type="radio" id = "group_yes'.$row[1].'" value="yes" style="width: 30px;" onclick="showGroupID('.$sngquote.$row[1].$sngquote.')">Yes</td>',PHP_EOL;
                   echo '<td><input type="radio" id = "group_no'.$row[1].'" value="no"  style="width: 30px;" onclick="hideGroupID('.$sngquote.$row[1].$sngquote.')" checked>No</td></form></tr></table>',PHP_EOL; 
                   echo '<div id="displaygrouplist'.$row[1].'" style="display:none;"><table><tr><td><select id = "grplist'.$row[1].'" style="width: 150px;"></select></td></tr></table></div>',PHP_EOL;

                   echo '<div id="checkout'.$row[1].'"><table><tr><td><input type="button" value="Request Checkout" onclick="submitCheckoutRequestID('.$sngquote.$row[1].$sngquote.')" style="padding: 8px 32px;"></td>',PHP_EOL;
                   echo '</tr><tr></tr></table></div>',PHP_EOL;
                   echo '</div>',PHP_EOL;
                   echo '</div>',PHP_EOL;
                   echo '</td>',PHP_EOL; 
                   echo '</td>',PHP_EOL;                    
                   echo '</tr>',PHP_EOL;                   
               }
               echo '</table>',PHP_EOL;
               $stmt->close();
               $this->conn->next_result();   
            }
            
            
            public function NavigationStreetList($territoryNumber,$congregationnumber,$checkinicon,$checkouticon) 
            {
                    $sngquote = "'" ;
                                      
                   // echo '<table class="table">',PHP_EOL;
                    echo '<table>',PHP_EOL;
                    //echo '<thead>',PHP_EOL;
                    echo '<tr>',PHP_EOL;
                    echo '<th>',PHP_EOL;
                    echo '</th>',PHP_EOL;
                    echo '<th>',PHP_EOL;
                    echo '</th>',PHP_EOL;                    
//                    echo '<th align="right">',PHP_EOL;
//                    //echo '<a href="#" class="closebtn" onclick="closeNav()">&times;</a>',PHP_EOL;
//                    echo '<a href="#" onclick="closeNav1()">&times;</a>',PHP_EOL;
//                    echo '</th>',PHP_EOL;                     
                    echo '</tr>',PHP_EOL;
                    echo '<tr>',PHP_EOL;
                    // echo '<th bgcolor="#0B1F81"><font color="white">',PHP_EOL;
                    // echo 'Territory',PHP_EOL;
                    // echo '</font></th>',PHP_EOL;
                    echo '<th bgcolor="#0B1F81"><font color="white">',PHP_EOL;
                    echo 'Progress',PHP_EOL;
                    echo '</font></th>',PHP_EOL;
                    echo '<th bgcolor="#0B1F81"><font color="white">',PHP_EOL;
                    echo 'Houses',PHP_EOL;
                    echo '</font></th>',PHP_EOL; 
                    echo '<th bgcolor="#0B1F81"><font color="white">',PHP_EOL;
                    echo 'NH',PHP_EOL;
                    echo '</font></th>',PHP_EOL; 					
                    echo '<th bgcolor="#0B1F81"><font color="white">',PHP_EOL;
                    echo 'DNC',PHP_EOL;
                    echo '</font></th>',PHP_EOL; 
                    echo '<th bgcolor="#0B1F81"><font color="white">',PHP_EOL;
                    echo 'Phone',PHP_EOL;
                    echo '</font></th>',PHP_EOL;   
                    echo '<th bgcolor="#0B1F81"><font color="white">',PHP_EOL;
                    echo 'Letter',PHP_EOL;
                    echo '</font></th>',PHP_EOL; 					
                    echo '</tr>',PHP_EOL;
                   // echo '</thead>',PHP_EOL;
                
                    $sql="call territorylist('$congregationnumber')";                    
                    $stmt = mysqli_query($this->conn,$sql);

                    while( $territory = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                    {

                        
                       if ($territory[1] == $territoryNumber)
                        {
                           // echo '<tbody>',PHP_EOL;
                           // echo '<div class="table-wrap">',PHP_EOL;
                            echo '<tr>',PHP_EOL;
                            // echo '<td align="center">',PHP_EOL;
                            // echo '<a href = "territorymap.php?territory='.$territory[1].'" style="padding: 0px 0px 0px 0px;">'.trim($territory[1]).'</a>',PHP_EOL;
                            // echo '</td>',PHP_EOL;
                            echo '<td align="center">',PHP_EOL;
                            echo '<div class="tooltip">',PHP_EOL;
                            echo '<progress value="'.$territory[2].'" max="100"></progress>',PHP_EOL;
                            echo '<span class="tooltiptext">'.$territory[2].'%',PHP_EOL;
                            echo '</span></div>',PHP_EOL;
                            echo '</td>',PHP_EOL;
                            echo '<td align="center">',PHP_EOL;
                            echo $territory[3],PHP_EOL;
                            echo '</td>',PHP_EOL;
                            echo '<td>',PHP_EOL;
                            echo '<center>'.$territory[15].'</center>',PHP_EOL;
                            echo '</td>',PHP_EOL; 							
                            echo '<td>',PHP_EOL;
                            echo '<center>'.$territory[5].'</center>',PHP_EOL;
                            echo '</td>',PHP_EOL;  
                            echo '<td>',PHP_EOL;
                            echo '<center>'.$territory[6].'</center>',PHP_EOL;
                            echo '</td>',PHP_EOL;     
                            echo '<td>',PHP_EOL;
                            echo '<center>'.$territory[14].'</center>',PHP_EOL;
                            echo '</td>',PHP_EOL;  							
                            echo '</tr>',PHP_EOL;
   
                            foreach($this->codeinjector AS $line ){
                                 echo $line,PHP_EOL;
                             }
//                            echo '<tr>',PHP_EOL;
//                            echo '</tr>',PHP_EOL;
                           
                        
                        }
//                        else 
//                         {
//                            echo '<tr>',PHP_EOL;
//                            echo '<td align="center">',PHP_EOL;
//                            echo '<a href = "territorymap.php?territory='.$territory[1].'">'.$territory[1].'</a>',PHP_EOL;
//                            echo '</td>',PHP_EOL;
//                            echo '<td align="center">',PHP_EOL;
//                            echo '<div class="tooltip">',PHP_EOL;
//                            echo '<progress value="'.$territory[2].'" max="100"></progress>',PHP_EOL;
//                            echo '<span class="tooltiptext">'.$territory[2].'%',PHP_EOL;
//                            echo '</span></div>',PHP_EOL;
//                            echo '</td>',PHP_EOL;
//                            echo '<td align="center">',PHP_EOL;
//                            echo $territory[3],PHP_EOL;
//                            echo '</td>',PHP_EOL;
//                            echo '<td>',PHP_EOL;
//                            echo '</td>',PHP_EOL;
//                            echo '</tr>',PHP_EOL;
//                        }
                        
                       
                    } 
                   // echo '</div>',PHP_EOL;
                  //  echo '</tbody>',PHP_EOL;
                    echo '</table>',PHP_EOL;
                    $stmt->close();
                    $this->conn->next_result(); 
                 
              
            }   
            
            public function PrepareStreetList($territoryNumber,$congregationnumber) 
            {
                   $sngquote = "'" ;
                   $sql="call territorystreetlist('$congregationnumber','$territoryNumber')";
                   $stmt = mysqli_query($this->conn,$sql);
                                      
                   
                     while( $street = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                     {                             
                          $this->codeinjector[] = '<tr>';
                          // $this->codeinjector[] = '<td width="20%">';
                          // $this->codeinjector[] = '</td>';
                          $this->codeinjector[] = '<td align="center">';
                          $this->codeinjector[] = $street[0].' '.$street[1];                                
                          $this->codeinjector[] = '</td>';
                          $this->codeinjector[] = '</tr>';
                          $this->codeinjector[] = '<tr>';  
                          // $this->codeinjector[] = '<td>';
                          // //echo $TerritoryNumber,PHP_EOL;
                          // $this->codeinjector[] = '</td>';
                          $this->codeinjector[] = '<td align="center">';
                          $this->codeinjector[] = '<div class="tooltip">';
                          $this->codeinjector[] = '<progress value="'.$street[2].'" max="100"></progress>';
                          $this->codeinjector[] = '<span class="tooltiptext">'.$street[2].'%';
                          $this->codeinjector[] = '</span></div>';
                          $this->codeinjector[] = '</td>';
                          $this->codeinjector[] = '<td align="center">';
                          $this->codeinjector[] = '<center><a href = "#" onclick="streetviewmodule('.$sngquote.$congregationnumber.$sngquote.','.$sngquote.$territoryNumber.$sngquote.','.$sngquote.$street[0].$sngquote.','.$sngquote.$street[1].$sngquote.',1);" style="padding: 0px 0px 0px 0px;">'.$street[3].'/'.$street[4].'</a></center>';
                          $this->codeinjector[] = '</td>';
                          $this->codeinjector[] = '<td align="center">';
                          $this->codeinjector[] = '<center><a href = "#" onclick="streetviewmodule('.$sngquote.$congregationnumber.$sngquote.','.$sngquote.$territoryNumber.$sngquote.','.$sngquote.$street[0].$sngquote.','.$sngquote.$street[1].$sngquote.',5);" style="padding: 0px 0px 0px 0px;">'.$street[8].'</a></center>';
                          $this->codeinjector[] = '</td>';						  
                          $this->codeinjector[] = '<td align="center">';
                          $this->codeinjector[] = '<center><a href = "#" onclick="streetviewmodule('.$sngquote.$congregationnumber.$sngquote.','.$sngquote.$territoryNumber.$sngquote.','.$sngquote.$street[0].$sngquote.','.$sngquote.$street[1].$sngquote.',2);" style="padding: 0px 0px 0px 0px;">'.$street[5].'</a></center>';
                          $this->codeinjector[] = '</td>';    
                          $this->codeinjector[] = '<td align="center">';
                          $this->codeinjector[] = '<center><a href = "#" onclick="streetviewmodule('.$sngquote.$congregationnumber.$sngquote.','.$sngquote.$territoryNumber.$sngquote.','.$sngquote.$street[0].$sngquote.','.$sngquote.$street[1].$sngquote.',3);" style="padding: 0px 0px 0px 0px;">'.$street[6].'</a></center>';
                          $this->codeinjector[] = '</td>';  
                          $this->codeinjector[] = '<td align="center">';
                          $this->codeinjector[] = '<center><a href = "#" onclick="streetviewmodule('.$sngquote.$congregationnumber.$sngquote.','.$sngquote.$territoryNumber.$sngquote.','.$sngquote.$street[0].$sngquote.','.$sngquote.$street[1].$sngquote.',4);" style="padding: 0px 0px 0px 0px;">'.$street[7].'</a></center>';
                          $this->codeinjector[] = '</td>';  						  
                          $this->codeinjector[] = '</tr>';
                    }  
                    $stmt->close();
                    $this->conn->next_result(); 
            }
            
            public function EditList($congregationnumber)
            {
               $sngquote = "'" ;
               $rowcount = 0;
               $sql="call territoryeditlist('$congregationnumber')";
               $stmt = mysqli_query($this->conn,$sql);
               echo '<table>',PHP_EOL;
               echo '<tr>',PHP_EOL;
               echo '<th width="10%" bgcolor="#0B1F81"><font color="white"> Territory </font></th>',PHP_EOL;
               echo '</tr>',PHP_EOL;
               echo '</table>',PHP_EOL;
               echo '<div id="terr_table">',PHP_EOL; 
               echo '<table>',PHP_EOL;
               while( $row = mysqli_fetch_array( $stmt, MYSQLI_NUM))
               {  
                   if((int)$row[0]==0){
                        echo '<tr id="rowid'.$row[1].'">',PHP_EOL;                  
                        echo '<td id="terrid'.$row[1].'">',PHP_EOL;
                        echo $row[1],PHP_EOL;
                        echo '</td>',PHP_EOL;
                        echo '<td id="terrlink'.$row[1].'">',PHP_EOL;
                        echo '<a href = "editterritory.php?territory='.$row[1].'"><img src = "icons/newterritory.png"></a>',PHP_EOL;
                        echo '</td>',PHP_EOL;
                        echo '<td id="sortid'.$row[1].'" style="display:none;">',PHP_EOL; 
                        echo $rowcount;
                        echo '</td>',PHP_EOL;                        
                        echo '<td id="sortup'.$row[1].'">',PHP_EOL; 
                        echo '</td>',PHP_EOL;
                        echo '<td id="sortdown'.$row[1].'">',PHP_EOL; 
                        echo '</td>',PHP_EOL;  
                        echo '<td id="sortsave'.$row[1].'">',PHP_EOL; 
                        echo '</td>',PHP_EOL;                         
                        echo '<td id="trashbin'.$row[1].'">',PHP_EOL; 
                        echo '</td>',PHP_EOL;
                        echo '</tr>',PHP_EOL;
                        
                        $rowcount+=1;
                   }
                   else{

                        echo '<tr>',PHP_EOL; 
                        echo '<td id="noentries">',PHP_EOL;
                        echo $row[2],PHP_EOL;
                        echo '</td>',PHP_EOL;
                        echo '</tr>',PHP_EOL;  
                     
                   }
                  
                   //echo '<tr><td><a href = "territorymap.php?territory='.$row[1].'">'.$row[0].'</a></td><td><div id="progress"><span id="percent">'.$row[2].'%</span><div id="bar" width="'.$row[2].'"></div></div></td></tr>',PHP_EOL;
               }              
               echo '</table>',PHP_EOL;
               echo '</div>',PHP_EOL;               

               echo '<div id="addterr">',PHP_EOL; 
               echo '<table>',PHP_EOL;
               for($i=0;$i<100;$i++){
                    echo '<tr id="rid'.$i.'">',PHP_EOL;
                    echo '<td id="terrname'.$i.'">',PHP_EOL;
                    echo '</td>',PHP_EOL;
                    echo '<td id="addterritory'.$i.'">',PHP_EOL;
                    echo '</td>',PHP_EOL;
                    echo '<td>',PHP_EOL; 
                    echo '</td>',PHP_EOL;
                    echo '</tr>',PHP_EOL;
               }   
               echo '</table>',PHP_EOL;
               echo '</div>',PHP_EOL;

               $stmt->close();
               $this->conn->next_result();                   
            }
      }
        
        
        class Layer
        {

            private $init = FALSE;
            private $conn;
            private $xy;
            private $form = array();
            private $codeinjector = array();
            private $header_latitude;
            private $header_longitude;
            private $userinfo;
            

//            function __construct($servername,$dbname,$user,$pwd)
            function __construct($host,$username,$password,$database,$port,$socket,$congregation)
            {

              //if ($this->init===TRUE){return;}
                
                $this->init = TRUE;
                //$connectionInfo = array("UID"=>$user,"PWD"=>$pwd,"Database"=>$dbname,"ReturnDatesAsStrings"=>true);
//                $this->conn = sqlsrv_connect( $servername, $connectionInfo); 
                $this->conn = mysqli_connect($host,$username,$password,$database,$port,$socket);
             
                $this->userinfo = new UserInfo($congregation,$this->conn);
            }
            
            public function close()
            {

              //if ($this->init===FALSE){return;}
                
                $this->init = FALSE;
               // sqlsrv_close($this->conn); 
                mysqli_close($this->conn);
            }  
            
            public function MapPolygon($Where)
            {
//                $sql = "SELECT LatLng,Polygon,NorthArrow,Zoom FROM dbo.TerritoryCard WHERE ".$Where;
                $sql = "SELECT LatLng,Boundary,NorthArrow,Zoom,Polygon  FROM ministryapp.territorycard WHERE ".$Where;
                //$stmt = sqlsrv_query($this->conn,$sql);
                $stmt = mysqli_query($this->conn,$sql);
//                if ( !$stmt )  
//                {  
//                    echo "Error in statement execution.\n";  
//                    die( print_r( sqlsrv_errors(), true));  
//                }  

           
//                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))  
                while( $row = mysqli_fetch_array( $stmt, MYSQLI_NUM)) 
                {  
                    
                    $LatLng=$row[0];
                    $Rectangle=$row[1];   
                    $NorthArrow=$row[2];
                    $Zoom=$row[3];
                    $Polygon=$row[4];
                    
                    $Rectangle = str_replace('[','' , $Rectangle);
                    $Rectangle = str_replace(']','' , $Rectangle);
                    $Rectangle = str_replace('"','' , $Rectangle);
                    
                    $Polygon = str_replace('"','' , $Polygon);
                    
                    echo "var screen = Number($(window).width());",PHP_EOL;
                    echo "if(screen<768){",PHP_EOL;
                    echo "var mapOptions = {center:new google.maps.LatLng($LatLng),zoom:16};}",PHP_EOL;
                    echo "else{var mapOptions = {center:new google.maps.LatLng($LatLng),zoom:$Zoom};};",PHP_EOL;
                    echo "var map = new google.maps.Map(document.getElementById(\"map\"), mapOptions);",PHP_EOL;
                    
                    echo "// Construct the polygon.",PHP_EOL;
                    
                    echo "var polygon = new google.maps.Polygon({",PHP_EOL;
                    echo "paths: ".$Polygon.",",PHP_EOL;
                    echo "strokeColor: '#072f72',",PHP_EOL;
                    echo "strokeOpacity: 0.8,",PHP_EOL;
                    echo "strokeWeight: 2,",PHP_EOL;
                    echo "fillColor: '#072f72',",PHP_EOL;
                    echo "fillOpacity: 0.05,",PHP_EOL;
                    echo "editable: false,",PHP_EOL;
                    echo "map:map",PHP_EOL;                    
                    echo "});",PHP_EOL;                      
                    
//                    echo "// Construct the rectangle.",PHP_EOL;
//                    echo "var rectangle = new google.maps.Rectangle({",PHP_EOL;
//                    echo "bounds: ".$Rectangle.",",PHP_EOL;
//                    echo "strokeColor: '#072f72',",PHP_EOL;
//                    echo "strokeOpacity: 0.8,",PHP_EOL;
//                    echo "strokeWeight: 5,",PHP_EOL;
//                    echo "fillColor: '#072f72',",PHP_EOL;
//                    echo "fillOpacity: 0,",PHP_EOL;
//                    echo "map:map",PHP_EOL;
//                    echo "});",PHP_EOL;  

                    echo "var marker = new google.maps.Marker({",PHP_EOL;
                    echo "position: new google.maps.LatLng($NorthArrow),",PHP_EOL;
                    echo "icon: {path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW, scale: 12},",PHP_EOL;
                    echo "map: map,",PHP_EOL;
                    echo "draggable: false,",PHP_EOL;
                    echo "});",PHP_EOL;              
                       

                }           

            } 
            
            
            
            public function MapC($congregationnumber,$territory,$layername,$markername,$array)
            {

                $sql="call multihousingterritory('$congregationnumber','$territory',0,1)";

                $stmt = mysqli_query($this->conn,$sql);
               
//                if ( !$stmt )  
//                {  
//                    echo "Error in statement execution.\n";  
//                    die( print_r( sqlsrv_errors(), true));  
//                }  
                $i;
                $i1=0;
                $i2=0;
                $i3=0;
                $i4=0;
                $i5=0;
                $i6=0;
                $i7=0;
                $i8=0;
                $i9=0;
                $i10=0;		
                $i11=0;	
                $i12=0;		
                $i13=0;	
                $i14=0;	
                $i15=0;		
                $i16=0;		
                $i17=0;		
                $i18=0;		
                $i19=0;	
                $i20=0;		
                $i21=0;	
                $i22=0;	
                $i23=0;	
                $i24=0;					
                $total=0;
                $column = array(22);
                $multihome= array(array());
                $coordxy = array(3);
                $index=0;
                $expand=0;
                $sngquote = "'" ;
                $escapesngquote = "\'" ;
//                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC)) 
                while( $row = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                {                                      
                   $node=new SimpleXMLElement($row[4]);                   
                   foreach($node->Address as $Territory){
                       $column[0]  = $Territory->AddressGUID;
                       $column[1]  = $Territory->TerritoryNumber;
                       $column[2]  = $Territory->Latitude;
                       $column[3]  = $Territory->Longitude;
                       $column[4]  = $Territory->FormattedAddress;
                       $column[5]  = $Territory->Type;
                       $column[6]  = $Territory->Resident;
                       $column[7]  = $Territory->PhoneType;
                       $column[8]  = $Territory->Language;
                       $column[9]  = $Territory->InitialDate;
                       $column[10] = $Territory->Notes; 
                       $column[11] = $Territory->DateModified;
                       $column[12] = $Territory->bPhone;
                       $column[13] = $Territory->Unit;
	                   $column[14] = $Territory->bMulti;
	                   $column[15] = $Territory->bUnit;    
	                   $column[16] = $Territory->Phone;
	                   $column[17] = $Territory->Building; 
                       $column[18] = $Territory->bTouched; 
                       $column[19] = $Territory->bLetter;					   
                       $column[20] = $Territory->LetterType;
                       $column[21] = $Territory->iSubmit;					   
                      //AddressGUID,TerritoryNumber,Latitude,Longitude,FormattedAddress,Type,Residents,PhoneType,Language,InitialDate,Notes,ModifiedDate,bPhone,Apartment 
                       $address_array = explode(' ',$column[4]);
                       //Bucket 1

                            if($array[0]["Type"]==$column[5] && (int)$array[0]["bPhone"]==(int)$column[12] && $column[18]=="0"){
                               $layername1=$array[0]["Layer"];
                               $markername1=$array[0]["Marker"];
                               $Icon=$array[0]["Icon"];
                               $IconMouseover=$array[0]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i1+=1;
                               $i=$i1;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';							   
                            } 
                       //Bucket 2

                            if($array[1]["Type"]==$column[5] && (int)$array[1]["bPhone"]==(int)$column[12] && $column[18]=="0"){
                               $layername1=$array[1]["Layer"];
                               $markername1=$array[1]["Marker"];
                               $Icon=$array[1]["Icon"];
                               $IconMouseover=$array[1]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i2+=1;
                               $i=$i2;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';							   
                            }                             
                       //Bucket 3
                       
                           if($array[2]["Type"]==$column[5] && (int)$array[2]["bPhone"]==(int)$column[12] && $column[18]=="1"  && (int)$column[21] < 2){
                                   $layername1=$array[2]["Layer"];
                                   $markername1=$array[2]["Marker"];
                                   $Icon=$array[2]["Icon"];
                                   $IconMouseover=$array[2]["IconMouseover"];
                                   $HavePhone=false;
                                   $total+=1;
                                   $i3+=1;
                                   $i=$i3;   
                                   $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';								   
                           }
                           
                       //Bucket 4
                               
                            if($array[3]["Type"]==$column[5] && (int)$array[3]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[3]["Layer"];
                               $markername1=$array[3]["Marker"];
                               $Icon=$array[3]["Icon"];
                               $IconMouseover=$array[3]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i4+=1;
                               $i=$i4;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';							   
                            }
                            
                       //Bucket 5
                               
                            if($array[4]["Type"]==$column[5] && (int)$array[4]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[4]["Layer"];
                               $markername1=$array[4]["Marker"];
                               $Icon=$array[4]["Icon"];
                               $IconMouseover=$array[4]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i5+=1;
                               $i=$i5;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';							   
                            }   
                            
                       //Bucket 6
                           if($array[5]["Type"]==$column[5] && (int)$array[5]["bPhone"]==(int)$column[12] && $column[18]=="1" && (int)$column[21] < 2){
                                   $layername1=$array[5]["Layer"];
                                   $markername1=$array[5]["Marker"];
                                   $Icon=$array[5]["Icon"];
                                   $IconMouseover=$array[5]["IconMouseover"];                                   
                                   $HavePhone=true;
                                   $total+=1;
                                   $i6+=1;
                                   $i=$i6; 
                                  $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';								   
                           }
                           
                       //Bucket 7
                               
                            if($array[6]["Type"]==$column[5] && (int)$array[6]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[6]["Layer"];
                               $markername1=$array[6]["Marker"];
                               $Icon=$array[6]["Icon"];
                               $IconMouseover=$array[6]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i7+=1;
                               $i=$i7;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';							   
                            }                           
                                                      
                       //Bucket 8
                               
                            if($array[7]["Type"]==$column[5] && (int)$array[7]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[7]["Layer"];
                               $markername1=$array[7]["Marker"];
                               $Icon=$array[7]["Icon"];
                               $IconMouseover=$array[7]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i8+=1;
                               $i=$i8;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';							   
                            } 
                            
                       //Bucket 9
                               
                            if($array[8]["Type"]==$column[5]){
                               $layername1=$array[8]["Layer"];
                               $markername1=$array[8]["Marker"];
                               $Icon=$array[8]["Icon"];
                               $IconMouseover=$array[8]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i9+=1;
                               $i=$i9;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';							   
                            }  
							
                       //Bucket 10
                               
                            if($array[9]["Type"]==$column[5] && $array[9]["PhoneType"]==$column[7] && (int)$array[9]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[9]["Layer"];
                               $markername1=$array[9]["Marker"];
                               $Icon=$array[9]["Icon"];
                               $IconMouseover=$array[9]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i10+=1;
                               $i=$i10;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';							   
                            }  

                       //Bucket 11
                               
                            if($array[10]["Type"]==$column[5] && $array[10]["PhoneType"]==$column[7] && (int)$array[10]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[10]["Layer"];
                               $markername1=$array[10]["Marker"];
                               $Icon=$array[10]["Icon"];
                               $IconMouseover=$array[10]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i11+=1;
                               $i=$i11;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';							   
                            } 

                       //Bucket 12
                               
                            if($array[11]["Type"]==$column[5] && $array[11]["PhoneType"]==$column[7] && (int)$array[11]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[11]["Layer"];
                               $markername1=$array[11]["Marker"];
                               $Icon=$array[11]["Icon"];
                               $IconMouseover=$array[11]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i12+=1;
                               $i=$i12;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';							   
                            }  	

                       //Bucket 13
                               
                            if($array[12]["Type"]==$column[5] && $array[12]["PhoneType"]==$column[7] && (int)$array[12]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[12]["Layer"];
                               $markername1=$array[12]["Marker"];
                               $Icon=$array[12]["Icon"];
                               $IconMouseover=$array[12]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i13+=1;
                               $i=$i13;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';							   
                            } 							
                            
                       //Bucket 14
                               
                            if($array[13]["Type"]==$column[5] && $array[13]["PhoneType"]==$column[7] && (int)$array[13]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[13]["Layer"];
                               $markername1=$array[13]["Marker"];
                               $Icon=$array[13]["Icon"];
                               $IconMouseover=$array[13]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i14+=1;
                               $i=$i14;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';							   
                            } 	

                       //Bucket 15
                               
                            if($array[14]["Type"]==$column[5] && $array[14]["LetterType"]==$column[20] && (int)$array[14]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[14]["Layer"];
                               $markername1=$array[14]["Marker"];
                               $Icon=$array[14]["Icon"];
                               $IconMouseover=$array[14]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i15+=1;
                               $i=$i15;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';							   
                            } 							
       
                       //Bucket 16
                               
                            if($array[15]["Type"]==$column[5] && $array[15]["LetterType"]==$column[20] && (int)$array[15]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[15]["Layer"];
                               $markername1=$array[15]["Marker"];
                               $Icon=$array[15]["Icon"];
                               $IconMouseover=$array[15]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i16+=1;
                               $i=$i16;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';							   
                            } 
							
                       //Bucket 17
                               
                            if($array[16]["Type"]==$column[5] && $array[16]["LetterType"]==$column[20] && (int)$array[16]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[16]["Layer"];
                               $markername1=$array[16]["Marker"];
                               $Icon=$array[16]["Icon"];
                               $IconMouseover=$array[16]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i17+=1;
                               $i=$i17;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';							   
                            } 

                       //Bucket 18
                               
                            if($array[17]["Type"]==$column[5] && $array[17]["LetterType"]==$column[20] && (int)$array[17]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[17]["Layer"];
                               $markername1=$array[17]["Marker"];
                               $Icon=$array[17]["Icon"];
                               $IconMouseover=$array[17]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i18+=1;
                               $i=$i18;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';							   
                            } 	

                       //Bucket 19
                               
                            if($array[18]["Type"]==$column[5] && (int)$array[18]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[18]["Layer"];
                               $markername1=$array[18]["Marker"];
                               $Icon=$array[18]["Icon"];
                               $IconMouseover=$array[18]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i19+=1;
                               $i=$i19;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';							   
                            } 	

                       //Bucket 20
                               
                            if($array[19]["Type"]==$column[5] && (int)$array[19]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[19]["Layer"];
                               $markername1=$array[19]["Marker"];
                               $Icon=$array[19]["Icon"];
                               $IconMouseover=$array[19]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i20+=1;
                               $i=$i20;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';							   
                            } 		

					  //Bucket 21
                               
                            if($array[20]["Type"]==$column[5] && (int)$array[20]["bPhone"]==(int)$column[12] && $column[18]=="1" && (int)$column[21] > 1 && (int)$column[21] < 3 ){
                               $layername1=$array[20]["Layer"];
                               $markername1=$array[20]["Marker"];
                               $Icon=$array[20]["Icon"];
                               $IconMouseover=$array[20]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i21+=1;
                               $i=$i21;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';								   
                            } 
							
					  //Bucket 22
                               
                            if($array[21]["Type"]==$column[5] && (int)$array[21]["bPhone"]==(int)$column[12] && $column[18]=="1" && (int)$column[21] > 2){
                               $layername1=$array[21]["Layer"];
                               $markername1=$array[21]["Marker"];
                               $Icon=$array[21]["Icon"];
                               $IconMouseover=$array[21]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i22+=1;
                               $i=$i22;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';								   
                            } 	

					  //Bucket 23
                               
                            if($array[22]["Type"]==$column[5] && (int)$array[22]["bPhone"]==(int)$column[12] && $column[18]=="1" && (int)$column[21] > 1 && (int)$column[21] < 3 ){
                               $layername1=$array[22]["Layer"];
                               $markername1=$array[22]["Marker"];
                               $Icon=$array[22]["Icon"];
                               $IconMouseover=$array[22]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i23+=1;
                               $i=$i23;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';								   
                            } 
							
					  //Bucket 24
                               
                            if($array[23]["Type"]==$column[5] && (int)$array[23]["bPhone"]==(int)$column[12] && $column[18]=="1" && (int)$column[21] > 2){
                               $layername1=$array[23]["Layer"];
                               $markername1=$array[23]["Marker"];
                               $Icon=$array[23]["Icon"];
                               $IconMouseover=$array[23]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i24+=1;
                               $i=$i24;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>House:'.$address_array[0].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +';								   
                            } 								
                        
						
                        if ($HavePhone)
                            {
                                 $this->Phone($column,$layername1,$markername1,$i);                       
                            }
                        else
                            {
                                 $this->Home($column,$layername1,$markername1,$i);                       
                            }
                }    //end for
                   
                
                    $LatLng = $row[1].",".$row[2]; 
                    if($this->xy!=$LatLng){
                       if($index>0){$this->MultiHomeFooter($row,$total,$index);}
                       $this->xy=$LatLng; 
                       $this->header_latitude=$row[1];
                       $this->header_longitude=$row[2];                       
                       $total=0;
                       $index+=1;
                       $expand=0;
                       $this->MultiHomeHeader($layername,$row[3],$row[5],$expand);
                    }else{
                       $expand+=1; 
                       $this->MultiHomeBody($row[3],$expand); 
                    }
                   
                    $coordxy[1]= $row[1];
                    $coordxy[2]= $row[2];        

                }  //end while 
                if ($coordxy[1]!=""){
                $this->MultiHomeFooter($coordxy,$total,$index);}
                mysqli_stmt_free_result($stmt);
                $this->conn->next_result(); 
            }
            
            
            public function MapB($congregationnumber,$territory,$layername,$markername,$array)
            {
 
                $sql="call multihousingterritory('$congregationnumber','$territory',1,0)";
                //$stmt = sqlsrv_query($this->conn,$sql);
                $stmt = mysqli_query($this->conn,$sql);
               
//                if ( !$stmt )  
//                {  
//                    echo "Error in statement execution.\n";  
//                    die( print_r( sqlsrv_errors(), true));  
//                }  
                $i;
                $i1=0;
                $i2=0;
                $i3=0;
                $i4=0;
                $i5=0;
                $i6=0;
                $i7=0;
                $i8=0;
                $i9=0;
                $i10=0;	
                $i11=0;	
                $i12=0;	
                $i13=0;	
                $i14=0;	
                $i15=0;		
				$i16=0;	
				$i17=0;	
				$i18=0;		
				$i19=0;	
				$i20=0;	
				$i21=0;	
				$i22=0;		
				$i23=0;	
				$i24=0;					
                $total=0;
                $column = array(22);
                $multihome= array(array());
                $coordxy = array(3);
                $index=0;
                $expand=0;
                $sngquote = "'" ;
                $escapesngquote = "\'" ;
//                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC)) 
                while( $row = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                {                                      
                   $node=new SimpleXMLElement($row[4]);                   
                   foreach($node->Address as $Territory){
                       $column[0]  = $Territory->AddressGUID;
                       $column[1]  = $Territory->TerritoryNumber;
                       $column[2]  = $Territory->Latitude;
                       $column[3]  = $Territory->Longitude;
                       $column[4]  = $Territory->FormattedAddress;
                       $column[5]  = $Territory->Type;
                       $column[6]  = $Territory->Resident;
                       $column[7]  = $Territory->PhoneType;
                       $column[8]  = $Territory->Language;
                       $column[9]  = $Territory->InitialDate;
                       $column[10] = $Territory->Notes; 
                       $column[11] = $Territory->DateModified;
                       $column[12] = $Territory->bPhone;
                       $column[13] = $Territory->Unit;
	                   $column[14] = $Territory->bMulti;
	                   $column[15] = $Territory->bUnit;    
	                   $column[16] = $Territory->Phone;
	                   $column[17] = $Territory->Building;     
                       $column[18] = $Territory->bTouched; 
                       $column[19] = $Territory->bLetter;					   
                       $column[20] = $Territory->LetterType;	
                       $column[21] = $Territory->iSubmit;					   


                           
                       //Bucket 1

                            if($array[0]["Type"]==$column[5] && (int)$array[0]["bPhone"]==(int)$column[12] && $column[18]=="0"){
                               $layername1=$array[0]["Layer"];
                               $markername1=$array[0]["Marker"];
                               $Icon=$array[0]["Icon"];
                               $IconMouseover=$array[0]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i1+=1;
                               $i=$i1;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            } 
                       //Bucket 2

                            if($array[1]["Type"]==$column[5] && (int)$array[1]["bPhone"]==(int)$column[12] && $column[18]=="0"){
                               $layername1=$array[1]["Layer"];
                               $markername1=$array[1]["Marker"];
                               $Icon=$array[1]["Icon"];
                               $IconMouseover=$array[1]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i2+=1;
                               $i=$i2;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            }                             
                       //Bucket 3
                       
                           if($array[2]["Type"]==$column[5] && (int)$array[2]["bPhone"]==(int)$column[12] && $column[18]=="1"  && (int)$column[21] < 2){
                              $layername1=$array[2]["Layer"];
                              $markername1=$array[2]["Marker"];
                              $Icon=$array[2]["Icon"];
                              $IconMouseover=$array[2]["IconMouseover"];
                              $HavePhone=false;
                              $total+=1;
                              $i3+=1;
                              $i=$i3;  
                              $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 								   
                           }
                           
                       //Bucket 4
                               
                            if($array[3]["Type"]==$column[5] && (int)$array[3]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[3]["Layer"];
                               $markername1=$array[3]["Marker"];
                               $Icon=$array[3]["Icon"];
                               $IconMouseover=$array[3]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i4+=1;
                               $i=$i4;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            }
                            
                       //Bucket 5
                               
                            if($array[4]["Type"]==$column[5] && (int)$array[4]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[4]["Layer"];
                               $markername1=$array[4]["Marker"];
                               $Icon=$array[4]["Icon"];
                               $IconMouseover=$array[4]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i5+=1;
                               $i=$i5;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            }   
                            
                       //Bucket 6
                           if($array[5]["Type"]==$column[5] && (int)$array[5]["bPhone"]==(int)$column[12] && $column[18]=="1" && (int)$column[21] < 2){
                                   $layername1=$array[5]["Layer"];
                                   $markername1=$array[5]["Marker"];
                                   $Icon=$array[5]["Icon"];
                                   $IconMouseover=$array[5]["IconMouseover"];                                   
                                   $HavePhone=true;
                                   $total+=1;
                                   $i6+=1;
                                   $i=$i6;  
                                   $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 								   
                           }
                           
                       //Bucket 7
                               
                            if($array[6]["Type"]==$column[5] && (int)$array[6]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[6]["Layer"];
                               $markername1=$array[6]["Marker"];
                               $Icon=$array[6]["Icon"];
                               $IconMouseover=$array[6]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i7+=1;
                               $i=$i7;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            }                           
                                                      
                       //Bucket 8
                               
                            if($array[7]["Type"]==$column[5] && (int)$array[7]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[7]["Layer"];
                               $markername1=$array[7]["Marker"];
                               $Icon=$array[7]["Icon"];
                               $IconMouseover=$array[7]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i8+=1;
                               $i=$i8;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            } 
                            
                       //Bucket 9
                               
                            if($array[8]["Type"]==$column[5]){
                               $layername1=$array[8]["Layer"];
                               $markername1=$array[8]["Marker"];
                               $Icon=$array[8]["Icon"];
                               $IconMouseover=$array[8]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i9+=1;
                               $i=$i9;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            }  
							
                       //Bucket 10
                               
                            if($array[9]["Type"]==$column[5] && $array[9]["PhoneType"]==$column[7] && (int)$array[9]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[9]["Layer"];
                               $markername1=$array[9]["Marker"];
                               $Icon=$array[9]["Icon"];
                               $IconMouseover=$array[9]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i10+=1;
                               $i=$i10;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            }  

                       //Bucket 11
                               
                            if($array[10]["Type"]==$column[5] && $array[10]["PhoneType"]==$column[7] && (int)$array[10]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[10]["Layer"];
                               $markername1=$array[10]["Marker"];
                               $Icon=$array[10]["Icon"];
                               $IconMouseover=$array[10]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i11+=1;
                               $i=$i11;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            } 

                       //Bucket 12
                               
                            if($array[11]["Type"]==$column[5] && $array[11]["PhoneType"]==$column[7] && (int)$array[11]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[11]["Layer"];
                               $markername1=$array[11]["Marker"];
                               $Icon=$array[11]["Icon"];
                               $IconMouseover=$array[11]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i12+=1;
                               $i=$i12;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            }  	

                       //Bucket 13
                               
                            if($array[12]["Type"]==$column[5] && $array[12]["PhoneType"]==$column[7] && (int)$array[12]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[12]["Layer"];
                               $markername1=$array[12]["Marker"];
                               $Icon=$array[12]["Icon"];
                               $IconMouseover=$array[12]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i13+=1;
                               $i=$i13;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            } 							
                            
                       //Bucket 14
                               
                            if($array[13]["Type"]==$column[5] && $array[13]["PhoneType"]==$column[7] && (int)$array[13]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[13]["Layer"];
                               $markername1=$array[13]["Marker"];
                               $Icon=$array[13]["Icon"];
                               $IconMouseover=$array[13]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i14+=1;
                               $i=$i14;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            } 	

                       //Bucket 15
                               
                            if($array[14]["Type"]==$column[5] && $array[14]["LetterType"]==$column[20] && (int)$array[14]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[14]["Layer"];
                               $markername1=$array[14]["Marker"];
                               $Icon=$array[14]["Icon"];
                               $IconMouseover=$array[14]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i15+=1;
                               $i=$i15;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            } 							
       
                       //Bucket 16
                               
                            if($array[15]["Type"]==$column[5] && $array[15]["LetterType"]==$column[20] && (int)$array[15]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[15]["Layer"];
                               $markername1=$array[15]["Marker"];
                               $Icon=$array[15]["Icon"];
                               $IconMouseover=$array[15]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i16+=1;
                               $i=$i16;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            } 
							
                       //Bucket 17
                               
                            if($array[16]["Type"]==$column[5] && $array[16]["LetterType"]==$column[20] && (int)$array[16]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[16]["Layer"];
                               $markername1=$array[16]["Marker"];
                               $Icon=$array[16]["Icon"];
                               $IconMouseover=$array[16]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i17+=1;
                               $i=$i17;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            } 

                       //Bucket 18
                               
                            if($array[17]["Type"]==$column[5] && $array[17]["LetterType"]==$column[20] && (int)$array[17]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[17]["Layer"];
                               $markername1=$array[17]["Marker"];
                               $Icon=$array[17]["Icon"];
                               $IconMouseover=$array[17]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i18+=1;
                               $i=$i18;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            } 	

                       //Bucket 19
                               
                            if($array[18]["Type"]==$column[5] && (int)$array[18]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[18]["Layer"];
                               $markername1=$array[18]["Marker"];
                               $Icon=$array[18]["Icon"];
                               $IconMouseover=$array[18]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i19+=1;
                               $i=$i19;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            } 	

                       //Bucket 20
                               
                            if($array[19]["Type"]==$column[5] && (int)$array[19]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[19]["Layer"];
                               $markername1=$array[19]["Marker"];
                               $Icon=$array[19]["Icon"];
                               $IconMouseover=$array[19]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i20+=1;
                               $i=$i20;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            } 

					  //Bucket 21
                               
                            if($array[20]["Type"]==$column[5] && (int)$array[20]["bPhone"]==(int)$column[12] && $column[18]=="1" && (int)$column[21] > 1 && (int)$column[21] < 3 ){
                               $layername1=$array[20]["Layer"];
                               $markername1=$array[20]["Marker"];
                               $Icon=$array[20]["Icon"];
                               $IconMouseover=$array[20]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i21+=1;
                               $i=$i21;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            } 
							
					  //Bucket 22
                               
                            if($array[21]["Type"]==$column[5] && (int)$array[21]["bPhone"]==(int)$column[12] && $column[18]=="1" && (int)$column[21] > 2){
                               $layername1=$array[21]["Layer"];
                               $markername1=$array[21]["Marker"];
                               $Icon=$array[21]["Icon"];
                               $IconMouseover=$array[21]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i22+=1;
                               $i=$i22;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            } 	

					  //Bucket 23
                               
                            if($array[22]["Type"]==$column[5] && (int)$array[22]["bPhone"]==(int)$column[12] && $column[18]=="1" && (int)$column[21] > 1 && (int)$column[21] < 3 ){
                               $layername1=$array[22]["Layer"];
                               $markername1=$array[22]["Marker"];
                               $Icon=$array[22]["Icon"];
                               $IconMouseover=$array[22]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i23+=1;
                               $i=$i23;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            } 
							
					  //Bucket 24
                               
                            if($array[23]["Type"]==$column[5] && (int)$array[23]["bPhone"]==(int)$column[12] && $column[18]=="1" && (int)$column[21] > 2){
                               $layername1=$array[23]["Layer"];
                               $markername1=$array[23]["Marker"];
                               $Icon=$array[23]["Icon"];
                               $IconMouseover=$array[23]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i24+=1;
                               $i=$i24;
                               $this->codeinjector[] = $sngquote.'<tr><td><p><b>Unit:'.$column[13].'</b></p><img id="image'.$markername1.$i.'" style = "cursor:pointer" onclick="openInfowindow('.$escapesngquote.$markername1.$escapesngquote.','.$i.')" src="'.$Icon.'" onmouseover="'.$IconMouseover.'"/></td></tr>'.$sngquote.' +'; 							   
                            } 								
                            
                 
                        if ($HavePhone)
                            {
                                 $this->Phone($column,$layername1,$markername1,$i);                       
                            }
                        else
                            {
                                 $this->Home($column,$layername1,$markername1,$i);                       
                            }
                }    //end for
                   
                
                    $LatLng = $row[1].",".$row[2]; 
                    if($this->xy!=$LatLng){
                       if($index>0){$this->MultiHomeFooter($row,$total,$index);}
                       $this->xy=$LatLng; 
                       $this->header_latitude=$row[1];
                       $this->header_longitude=$row[2];
                       $total=0;
                       $index+=1;
                       $expand=0;
                       $this->MultiHomeHeader($layername,$row[3],$row[5],$expand);
                    }else{
                       $expand+=1; 
                       $this->MultiHomeBody($row[3],$expand); 
                    }
                   
                    $coordxy[1]= $row[1];
                    $coordxy[2]= $row[2];        

                }  //end while 
                if ($coordxy[1]!=""){
                $this->MultiHomeFooter($coordxy,$total,$index);}
                mysqli_stmt_free_result($stmt);
                $this->conn->next_result(); 
            }
            
			
            public function MapA($congregationnumber,$territory,$array)     
			{
                $sql="call territory('$congregationnumber','$territory')";
                //$stmt = sqlsrv_query($this->conn,$sql);
                $stmt = mysqli_query($this->conn,$sql);
               
//                if ( !$stmt )  
//                {  
//                    echo "Error in statement execution.\n";  
//                    die( print_r( sqlsrv_errors(), true));  
//                }  
                $i;
                $i1=0;
                $i2=0;
                $i3=0;
                $i4=0;
                $i5=0;
                $i6=0;
                $i7=0;
                $i8=0;
                $i9=0;
                $i10=0;	
                $i11=0;	
                $i12=0;	
                $i13=0;	
                $i14=0;	
                $i15=0;		
				$i16=0;	
				$i17=0;	
				$i18=0;		
				$i19=0;	
				$i20=0;	
				$i21=0;	
				$i22=0;	
                $i23=0;
                $i24=0;				
                $total=0;
                $coordxy = array(3);
                $index=0;
                $expand=0;
                $sngquote = "'" ;
                $escapesngquote = "\'" ;
//                while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC)) 
                while( $column = mysqli_fetch_array( $stmt, MYSQLI_NUM))
                {                                      
 
                       
                       //Bucket 1

                            if($array[0]["Type"]==$column[5] && (int)$array[0]["bPhone"]==(int)$column[12] && $column[18]=="0"){
                               $layername1=$array[0]["Layer"];
                               $markername1=$array[0]["Marker"];
                               $Icon=$array[0]["Icon"];
                               $IconMouseover=$array[0]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i1+=1;
                               $i=$i1;
                            } 
                       //Bucket 2

                            if($array[1]["Type"]==$column[5] && (int)$array[1]["bPhone"]==(int)$column[12] && $column[18]=="0"){
                               $layername1=$array[1]["Layer"];
                               $markername1=$array[1]["Marker"];
                               $Icon=$array[1]["Icon"];
                               $IconMouseover=$array[1]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i2+=1;
                               $i=$i2;
                            }                             
                       //Bucket 3
                       
                           if($array[2]["Type"]==$column[5] && (int)$array[2]["bPhone"]==(int)$column[12] && $column[18]=="1"  && (int)$column[21] < 2){
                                   $layername1=$array[2]["Layer"];
                                   $markername1=$array[2]["Marker"];
                                   $Icon=$array[2]["Icon"];
                                   $IconMouseover=$array[2]["IconMouseover"];
                                   $HavePhone=false;
                                   $total+=1;
                                   $i3+=1;
                                   $i=$i3;                               
                           }
                           
                       //Bucket 4
                               
                            if($array[3]["Type"]==$column[5] && (int)$array[3]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[3]["Layer"];
                               $markername1=$array[3]["Marker"];
                               $Icon=$array[3]["Icon"];
                               $IconMouseover=$array[3]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i4+=1;
                               $i=$i4;
                            }
                            
                       //Bucket 5
                               
                            if($array[4]["Type"]==$column[5] && (int)$array[4]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[4]["Layer"];
                               $markername1=$array[4]["Marker"];
                               $Icon=$array[4]["Icon"];
                               $IconMouseover=$array[4]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i5+=1;
                               $i=$i5;
                            }   
                            
                       //Bucket 6
                           if($array[5]["Type"]==$column[5] && (int)$array[5]["bPhone"]==(int)$column[12] && $column[18]=="1" && (int)$column[21] < 2){
                                   $layername1=$array[5]["Layer"];
                                   $markername1=$array[5]["Marker"];
                                   $Icon=$array[5]["Icon"];
                                   $IconMouseover=$array[5]["IconMouseover"];                                   
                                   $HavePhone=true;
                                   $total+=1;
                                   $i6+=1;
                                   $i=$i6;                                
                           }
                           
                       //Bucket 7
                               
                            if($array[6]["Type"]==$column[5] && (int)$array[6]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[6]["Layer"];
                               $markername1=$array[6]["Marker"];
                               $Icon=$array[6]["Icon"];
                               $IconMouseover=$array[6]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i7+=1;
                               $i=$i7;
                            }                           
                                                      
                       //Bucket 8
                               
                            if($array[7]["Type"]==$column[5] && (int)$array[7]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[7]["Layer"];
                               $markername1=$array[7]["Marker"];
                               $Icon=$array[7]["Icon"];
                               $IconMouseover=$array[7]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i8+=1;
                               $i=$i8;
                            } 
                            
                       //Bucket 9
                               
                            if($array[8]["Type"]==$column[5]){
                               $layername1=$array[8]["Layer"];
                               $markername1=$array[8]["Marker"];
                               $Icon=$array[8]["Icon"];
                               $IconMouseover=$array[8]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i9+=1;
                               $i=$i9;
                            }  
							
                       //Bucket 10
                               
                            if($array[9]["Type"]==$column[5] && $array[9]["PhoneType"]==$column[7] && (int)$array[9]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[9]["Layer"];
                               $markername1=$array[9]["Marker"];
                               $Icon=$array[9]["Icon"];
                               $IconMouseover=$array[9]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i10+=1;
                               $i=$i10;
                            }  

                       //Bucket 11
                               
                            if($array[10]["Type"]==$column[5] && $array[10]["PhoneType"]==$column[7] && (int)$array[10]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[10]["Layer"];
                               $markername1=$array[10]["Marker"];
                               $Icon=$array[10]["Icon"];
                               $IconMouseover=$array[10]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i11+=1;
                               $i=$i11;
                            } 

                       //Bucket 12
                               
                            if($array[11]["Type"]==$column[5] && $array[11]["PhoneType"]==$column[7] && (int)$array[11]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[11]["Layer"];
                               $markername1=$array[11]["Marker"];
                               $Icon=$array[11]["Icon"];
                               $IconMouseover=$array[11]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i12+=1;
                               $i=$i12;
                            }  	

                       //Bucket 13
                               
                            if($array[12]["Type"]==$column[5] && $array[12]["PhoneType"]==$column[7] && (int)$array[12]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[12]["Layer"];
                               $markername1=$array[12]["Marker"];
                               $Icon=$array[12]["Icon"];
                               $IconMouseover=$array[12]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i13+=1;
                               $i=$i13;
                            } 							
                            
                       //Bucket 14
                               
                            if($array[13]["Type"]==$column[5] && $array[13]["PhoneType"]==$column[7] && (int)$array[13]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[13]["Layer"];
                               $markername1=$array[13]["Marker"];
                               $Icon=$array[13]["Icon"];
                               $IconMouseover=$array[13]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i14+=1;
                               $i=$i14;
                            } 	

                       //Bucket 15
                               
                            if($array[14]["Type"]==$column[5] && $array[14]["LetterType"]==$column[20] && (int)$array[14]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[14]["Layer"];
                               $markername1=$array[14]["Marker"];
                               $Icon=$array[14]["Icon"];
                               $IconMouseover=$array[14]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i15+=1;
                               $i=$i15;
                            } 							
       
                       //Bucket 16
                               
                            if($array[15]["Type"]==$column[5] && $array[15]["LetterType"]==$column[20] && (int)$array[15]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[15]["Layer"];
                               $markername1=$array[15]["Marker"];
                               $Icon=$array[15]["Icon"];
                               $IconMouseover=$array[15]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i16+=1;
                               $i=$i16;
                            } 
							
                       //Bucket 17
                               
                            if($array[16]["Type"]==$column[5] && $array[16]["LetterType"]==$column[20] && (int)$array[16]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[16]["Layer"];
                               $markername1=$array[16]["Marker"];
                               $Icon=$array[16]["Icon"];
                               $IconMouseover=$array[16]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i17+=1;
                               $i=$i17;
                            } 

                       //Bucket 18
                               
                            if($array[17]["Type"]==$column[5] && $array[17]["LetterType"]==$column[20] && (int)$array[17]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[17]["Layer"];
                               $markername1=$array[17]["Marker"];
                               $Icon=$array[17]["Icon"];
                               $IconMouseover=$array[17]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i18+=1;
                               $i=$i18;
                            } 	

                       //Bucket 19
                               
                            if($array[18]["Type"]==$column[5] && (int)$array[18]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[18]["Layer"];
                               $markername1=$array[18]["Marker"];
                               $Icon=$array[18]["Icon"];
                               $IconMouseover=$array[18]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i19+=1;
                               $i=$i19;
                            } 	

                       //Bucket 20
                               
                            if($array[19]["Type"]==$column[5] && (int)$array[19]["bPhone"]==(int)$column[12] && $column[18]=="1"){
                               $layername1=$array[19]["Layer"];
                               $markername1=$array[19]["Marker"];
                               $Icon=$array[19]["Icon"];
                               $IconMouseover=$array[19]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i20+=1;
                               $i=$i20;
                            } 

					  //Bucket 21
                               
                            if($array[20]["Type"]==$column[5] && (int)$array[20]["bPhone"]==(int)$column[12] && $column[18]=="1" && (int)$column[21] > 1 && (int)$column[21] < 3 ){
                               $layername1=$array[20]["Layer"];
                               $markername1=$array[20]["Marker"];
                               $Icon=$array[20]["Icon"];
                               $IconMouseover=$array[20]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i21+=1;
                               $i=$i21;
                            } 
							
					  //Bucket 22
                               
                            if($array[21]["Type"]==$column[5] && (int)$array[21]["bPhone"]==(int)$column[12] && $column[18]=="1" && (int)$column[21] > 2){
                               $layername1=$array[21]["Layer"];
                               $markername1=$array[21]["Marker"];
                               $Icon=$array[21]["Icon"];
                               $IconMouseover=$array[21]["IconMouseover"];                               
                               $HavePhone=false;
                               $total+=1;
                               $i22+=1;
                               $i=$i22;
                            } 							
                            
					  //Bucket 23
                               
                            if($array[22]["Type"]==$column[5] && (int)$array[22]["bPhone"]==(int)$column[12] && $column[18]=="1" && (int)$column[21] > 1 && (int)$column[21] < 3 ){
                               $layername1=$array[22]["Layer"];
                               $markername1=$array[22]["Marker"];
                               $Icon=$array[22]["Icon"];
                               $IconMouseover=$array[22]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i23+=1;
                               $i=$i23;							   
                            } 
							
					  //Bucket 24
                               
                            if($array[23]["Type"]==$column[5] && (int)$array[23]["bPhone"]==(int)$column[12] && $column[18]=="1" && (int)$column[21] > 2){
                               $layername1=$array[23]["Layer"];
                               $markername1=$array[23]["Marker"];
                               $Icon=$array[23]["Icon"];
                               $IconMouseover=$array[23]["IconMouseover"];                               
                               $HavePhone=true;
                               $total+=1;
                               $i24+=1;
                               $i=$i24;							   
                            } 								
                        
                        if ($HavePhone)
                            {
                                 $this->Phone($column,$layername1,$markername1,$i);                       
                            }
                        else
                            {
                                 $this->Home($column,$layername1,$markername1,$i);                       
                            }
                }    //end while				
                mysqli_stmt_free_result($stmt);
                $this->conn->next_result(); 
            }
         
            private function Notes($notes_)
            {
                $sngquote = "'" ;
                $escapesngquote = "\'" ;
                
                //$notes = new SimpleXMLElement($notes_);
                $notes = new SimpleXMLElement(str_replace("\n", " ", $notes_));                
                $node = 0;
                foreach($notes->note as $note){
                     $node +=1;  
                                                            
                    if ($node==1) 
                    {                          
                          echo $sngquote.'<input type="hidden" id="N1_date" value="'.$note->date.'" readonly>'.$sngquote.' +',PHP_EOL;  
                          echo $sngquote.'<input type="hidden" id="N1_content" value="'.$note->content.'" readonly>'.$sngquote.' +',PHP_EOL;  
                          echo $sngquote.'<input type="hidden" id="N1_typedesc" value="'.$note->typedescription.'" readonly>'.$sngquote.' +',PHP_EOL;  
                          echo $sngquote.'<input type="hidden" id="N1_username" value="'.$note->username.'" readonly>'.$sngquote.' +',PHP_EOL;                           
                          if($note->content==""){
                                $value[] = '<p><h4><b>Posted: '.$note->date.'</b><br>['.$note->typedescription.']</h4><h5><div class="tooltip">'.$note->username.'<span class="tooltiptext">'.$this->userinfo->getUsername($note->username).'</span></div></h5></p>';
                          }else {
                                $value[] = '<p><h4><b>Posted: '.$note->date.'</b><br>['.$note->typedescription.']</h4>'.$note->content.'<h5><div class="tooltip">'.$note->username.'<span class="tooltiptext">'.$this->userinfo->getUsername($note->username).'</span></div></h5></p>';
                          }                      
                    }
                    if ($node==2)
                    {
                          echo $sngquote.'<input type="hidden" id="N2_date" value="'.$note->date.'" readonly>'.$sngquote.' +',PHP_EOL;  
                          echo $sngquote.'<input type="hidden" id="N2_content" value="'.$note->content.'" readonly>'.$sngquote.' +',PHP_EOL;  
                          echo $sngquote.'<input type="hidden" id="N2_typedesc" value="'.$note->typedescription.'" readonly>'.$sngquote.' +',PHP_EOL;  
                          echo $sngquote.'<input type="hidden" id="N2_username" value="'.$note->username.'" readonly>'.$sngquote.' +',PHP_EOL;                              
                          if($note->content==""){
                                $value[] = '<p><h4><b>Posted: '.$note->date.'</b><br>['.$note->typedescription.']</h4><h5><div class="tooltip">'.$note->username.'<span class="tooltiptext">'.$this->userinfo->getUsername($note->username).'</span></div></h5></p>';
                          }else {
                                $value[] = '<p><h4><b>Posted: '.$note->date.'</b><br>['.$note->typedescription.']</h4>'.$note->content.'<h5><div class="tooltip">'.$note->username.'<span class="tooltiptext">'.$this->userinfo->getUsername($note->username).'</span></div></h5></p>';
                          }   
                    }
                    if ($node==3)
                    {
                          echo $sngquote.'<input type="hidden" id="N3_date" value="'.$note->date.'" readonly>'.$sngquote.' +',PHP_EOL;  
                          echo $sngquote.'<input type="hidden" id="N3_content" value="'.$note->content.'" readonly>'.$sngquote.' +',PHP_EOL;  
                          echo $sngquote.'<input type="hidden" id="N3_typedesc" value="'.$note->typedescription.'" readonly>'.$sngquote.' +',PHP_EOL;  
                          echo $sngquote.'<input type="hidden" id="N3_username" value="'.$note->username.'" readonly>'.$sngquote.' +',PHP_EOL;                              
                          if($note->content==""){
                                $value[] = '<p><h4><b>Posted: '.$note->date.'</b><br>['.$note->typedescription.']</h4><h5><div class="tooltip">'.$note->username.'<span class="tooltiptext">'.$this->userinfo->getUsername($note->username).'</span></div></h5></p>';
                          }else {
                                $value[] = '<p><h4><b>Posted: '.$note->date.'</b><br>['.$note->typedescription.']</h4>'.$note->content.'<h5><div class="tooltip">'.$note->username.'<span class="tooltiptext">'.$this->userinfo->getUsername($note->username).'</span></div></h5></p>';
                          }      
                    } 
                    if ($node==4) 
                    {
                          echo $sngquote.'<input type="hidden" id="N4_date" value="'.$note->date.'" readonly>'.$sngquote.' +',PHP_EOL;  
                          echo $sngquote.'<input type="hidden" id="N4_content" value="'.$note->content.'" readonly>'.$sngquote.' +',PHP_EOL;  
                          echo $sngquote.'<input type="hidden" id="N4_typedesc" value="'.$note->typedescription.'" readonly>'.$sngquote.' +',PHP_EOL;  
                          echo $sngquote.'<input type="hidden" id="N4_username" value="'.$note->username.'" readonly>'.$sngquote.' +',PHP_EOL;                              
                          if($note->content==""){
                                $value[] = '<p><h4><b>Posted: '.$note->date.'</b><br>['.$note->typedescription.']</h4><h5><div class="tooltip">'.$note->username.'<span class="tooltiptext">'.$this->userinfo->getUsername($note->username).'</span></div></h5></p>';
                          }else {
                                $value[] = '<p><h4><b>Posted: '.$note->date.'</b><br>['.$note->typedescription.']</h4>'.$note->content.'<h5><div class="tooltip">'.$note->username.'<span class="tooltiptext">'.$this->userinfo->getUsername($note->username).'</span></div></h5></p>';
                          }    
                    }
                    if ($node==5)
                    {
                          echo $sngquote.'<input type="hidden" id="N5_date" value="'.$note->date.'" readonly>'.$sngquote.' +',PHP_EOL;  
                          echo $sngquote.'<input type="hidden" id="N5_content" value="'.$note->content.'" readonly>'.$sngquote.' +',PHP_EOL;  
                          echo $sngquote.'<input type="hidden" id="N5_typedesc" value="'.$note->typedescription.'" readonly>'.$sngquote.' +',PHP_EOL; 
                          echo $sngquote.'<input type="hidden" id="N5_username" value="'.$note->username.'" readonly>'.$sngquote.' +',PHP_EOL;                              
                          if($note->content==""){
                                $value[] = '<p><h4><b>Posted: '.$note->date.'</b><br>['.$note->typedescription.']</h4><h5><div class="tooltip">'.$note->username.'<span class="tooltiptext">'.$this->userinfo->getUsername($note->username).'</span></div></h5></p>';
                          }else {
                                $value[] = '<p><h4><b>Posted: '.$note->date.'</b><br>['.$note->typedescription.']</h4>'.$note->content.'<h5><div class="tooltip">'.$note->username.'<span class="tooltiptext">'.$this->userinfo->getUsername($note->username).'</span></div></h5></p>';
                          }      
                    }
                    if ($node==6)
                    {
                          echo $sngquote.'<input type="hidden" id="N6_date" value="'.$note->date.'" readonly>'.$sngquote.' +',PHP_EOL;  
                          echo $sngquote.'<input type="hidden" id="N6_content" value="'.$note->content.'" readonly>'.$sngquote.' +',PHP_EOL;  
                          echo $sngquote.'<input type="hidden" id="N6_typedesc" value="'.$note->typedescription.'" readonly>'.$sngquote.' +',PHP_EOL;  
                          echo $sngquote.'<input type="hidden" id="N6_username" value="'.$note->username.'" readonly>'.$sngquote.' +',PHP_EOL;                              
                          if($note->content==""){
                                $value[] = '<p><h4><b>Posted: '.$note->date.'</b><br>['.$note->typedescription.']</h4><h5><div class="tooltip">'.$note->username.'<span class="tooltiptext">'.$this->userinfo->getUsername($note->username).'</span></div></h5></p>';
                          }else {
                                $value[] = '<p><h4><b>Posted: '.$note->date.'</b><br>['.$note->typedescription.']</h4>'.$note->content.'<h5><div class="tooltip">'.$note->username.'<span class="tooltiptext">'.$this->userinfo->getUsername($note->username).'</span></div></h5></p>';
                          }      
                    }                     

                }
                
                 echo $sngquote.'<div class="expand"><table class="formtable"><tr>'.$sngquote.' +',PHP_EOL;  
                 echo $sngquote.'<td></td><td class="formright" align="right" style="cursor:pointer" onclick="expandCollapse('.$escapesngquote.'showHide'.$escapesngquote.','.$escapesngquote.'expand'.$escapesngquote.');" id="expand">[+]'.$sngquote.' +',PHP_EOL;  
                 if ($node>1){
                     echo $sngquote.$node.' Posted Notes</td>'.$sngquote.' +',PHP_EOL;  
                 }else{
                     echo $sngquote.$node.' Posted Note</td>'.$sngquote.' +',PHP_EOL;  
                 }
                 
                 echo $sngquote.'</tr></table></div>'.$sngquote.' +',PHP_EOL;  
              
                 echo $sngquote.'<div id="showHide" style="display:none;">'.$sngquote.' +',PHP_EOL;  
                 echo $sngquote.'<table><tr><td>'.$sngquote.' +',PHP_EOL;
                 echo $sngquote.$value[$node-1].$sngquote.' +',PHP_EOL;
//                 for($i=$node-1;$i>=0;$i--){
//                     echo $sngquote.$value[$i].$sngquote.' +',PHP_EOL;  
//                 }  
                 if ($node>1){                 
                    $comments= $node-1;
                    echo $sngquote.'<div class="expandnotes"><table class="formtable"><tr>'.$sngquote.' +',PHP_EOL;  
                    echo $sngquote.'<td class="formright" align="right" style="cursor:pointer" onclick="expandCollapse('.$escapesngquote.'showHidenotes'.$escapesngquote.','.$escapesngquote.'expandnotes'.$escapesngquote.');" id="expandnotes">[+]'.$sngquote.' +',PHP_EOL;                  
                    if ($node>2){
                        echo $sngquote.$comments.' more notes</td>'.$sngquote.' +',PHP_EOL;  
                    }else{
                        echo $sngquote.$comments.' more note</td>'.$sngquote.' +',PHP_EOL;  
                    }
                    echo $sngquote.'</tr></table></div>'.$sngquote.' +',PHP_EOL;  
                    echo $sngquote.'<div id="showHidenotes" style="display:none;">'.$sngquote.' +',PHP_EOL;  
                    echo $sngquote.'<table><tr><td>'.$sngquote.' +',PHP_EOL;
                    for($i=$node-2;$i>=0;$i--){
                        echo $sngquote.$value[$i].$sngquote.' +',PHP_EOL;  
                    }                                      
                    echo $sngquote.'</td></tr></table></div>'.$sngquote.' +',PHP_EOL; 
                 }
                 
                 echo $sngquote.'</td></tr></table></div>'.$sngquote.' +',PHP_EOL;                                                     
                 echo $sngquote.'<input style="border:none" type="hidden" id="N_total" value="'.$node.'" readonly>'.$sngquote.' +',PHP_EOL;  
                                                           
           } 
           
            private function MultiHomeHeader($layername,$headername,$buildingname,$expandid)
            {
                $sngquote = "'" ;
                $escapesngquote = "\'" ;
                $showHide = 'showHide'.$expandid;
                $expand = 'expand'.$expandid;
                $arrlength = count($this->codeinjector);

                $this->form[] = $layername.'.push(';
                $this->form[] = '['.$sngquote.'<form style="width: 350px">'.$sngquote.' +';   
                $this->form[] = $sngquote.'<h3><p><b>'.$buildingname.'</b></p></h3>'.$sngquote.' +';  
                $this->form[] = $sngquote.'<div class="expand"><table><tr>'.$sngquote.' +'; 
                $this->form[] = $sngquote.'<td></td><td style="cursor:pointer" onclick="expandCollapse('.$escapesngquote.$showHide.$escapesngquote.','.$escapesngquote.$expand.$escapesngquote.');" id="'.$expand.'">[+]'.$sngquote.' +';                 
                $this->form[] = $sngquote.'['.$arrlength.']'.$headername.'</td>'.$sngquote.' +'; 
                $this->form[] = $sngquote.'</tr></table></div>'.$sngquote.' +'; 
                                
                $this->form[] = $sngquote.'<div id="'.$showHide.'" style="display:none;">'.$sngquote.' +';
                $this->form[] = $sngquote.'<table>'.$sngquote.' +'; 
                
                 for($i=0;$i<count($this->codeinjector);$i++){
                     $this->form[]=$this->codeinjector[$i];                     
                 }
    
                 $this->form[] = $sngquote.'</table></div>'.$sngquote.' +';                 
                 $this->codeinjector = array();
                
            }
            
            private function MultiHomeBody($headername,$expandid)
            {
                $sngquote = "'" ;
                $escapesngquote = "\'" ; 
                $showHide = 'showHide'.$expandid;
                $expand = 'expand'.$expandid;
                $arrlength = count($this->codeinjector);
                
                $this->form[] = $sngquote.'<div class="expand"><table><tr>'.$sngquote.' +';
                $this->form[] = $sngquote.'<td></td><td style="cursor:pointer" onclick="expandCollapse('.$escapesngquote.$showHide.$escapesngquote.','.$escapesngquote.$expand.$escapesngquote.');" id="'.$expand.'">[+]'.$sngquote.' +';              
                $this->form[] = $sngquote.'['.$arrlength.']'.$headername.'</td>'.$sngquote.' +';   
                $this->form[] = $sngquote.'</tr></table></div>'.$sngquote.' +'; 
                                
                $this->form[] = $sngquote.'<div id="'.$showHide.'" style="display:none;">'.$sngquote.' +';
                $this->form[] = $sngquote.'<table>'.$sngquote.' +'; 
                
                 for($i=0;$i<count($this->codeinjector);$i++){
                     $this->form[]=$this->codeinjector[$i];                     
                 }
    
                 $this->form[] = $sngquote.'</table></div>'.$sngquote.' +';                 
                 $this->codeinjector = array();
            }
            
            private function MultiHomeFooter($column,$total,$index)
            {
                $sngquote = "'" ;
                $escapesngquote = "\'" ;  
                 
                foreach($this->form as $line){
                    echo $line,PHP_EOL; 
                } 
                //echo $sngquote.'<h3><p><b>['.$total.'] Total</b></p></h3>'.$sngquote.' +',PHP_EOL; 
//                echo $sngquote.'<input style="border:none" type="hidden" id="index" value="'.$index.'" readonly>'.$sngquote.','.$column[1].','.$column[2].']);',PHP_EOL; 
                 echo $sngquote.'<input style="border:none" type="hidden" id="index" value="'.$index.'" readonly>'.$sngquote.','.$this->header_latitude.','.$this->header_longitude.']);',PHP_EOL;                
                 $this->form = array();
            }
                       
            
            private function Home($column,$layername,$markername,$index)
            {
               $sngquote = "'" ;
               $escapesngquote = "\'" ; 
               echo $layername.'.push(',PHP_EOL; 
//           echo "[\"<form style='width: 350px'><div class='header'>\" +",PHP_EOL; 
               echo '['.$sngquote.'<form style="width: 350px">'.$sngquote.' +',PHP_EOL;          
//           echo '<img src='icons/House_header.png'/><h3><p><b>$column[4]</b></p></h3></div>\" +",PHP_EOL; 
               echo $sngquote.'<h3><p><b>'.$column[4].'</b></p></h3>'.$sngquote.' +',PHP_EOL;  
               
               if($column[13]!="") {
                   echo $sngquote.'<h3><p><b>Unit: '.$column[13].'</b></p></h3>'.$sngquote.' +',PHP_EOL;  
               }
               echo $sngquote.'<tr><td><input type="hidden" id="InitDate" value="'.$column[9].'"/></td> </tr>'.$sngquote.' +',PHP_EOL;  
               echo $sngquote.'<tr><td><input type="hidden" id="iSubmit" value="'.$column[21].'"/></td> </tr>'.$sngquote.' +',PHP_EOL; 			   
               echo $sngquote.'<table>'.$sngquote.' +',PHP_EOL;  
               echo $sngquote.'<tr><td><input type="hidden" id="AddressGUID" value="'.$column[0].'"/></td> </tr>'.$sngquote.' +',PHP_EOL;   
               echo $sngquote.'<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>'.$sngquote.' +',PHP_EOL;  
               echo $sngquote.'<tr><td><select id="Language">'.$sngquote.' +',PHP_EOL;     
           
                if ($column[8]=="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5")
                {
                    echo $sngquote.'<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>'.$sngquote.' +',PHP_EOL;  
                }

                else
                {
                    echo $sngquote.'<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5">English</option>'.$sngquote.' +',PHP_EOL;  
                }  


                if ($column[8]=="0537566C-1601-4CF7-953C-35CBA245085A")
                {
                    echo $sngquote.'<option value="0537566C-1601-4CF7-953C-35CBA245085A" selected>Spanish</option>'.$sngquote.' +',PHP_EOL;  
                }

                else
                {
                    echo $sngquote.'<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>'.$sngquote.' +',PHP_EOL;  
                }               


               echo $sngquote.'</select> </td></tr>'.$sngquote.' +',PHP_EOL;    
               echo $sngquote.'<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>'.$sngquote.' +',PHP_EOL;  
               echo $sngquote.'<tr><td><select id="Type">'.$sngquote.' +',PHP_EOL;  
               if ($column[5]=="DNC")
               {
                   echo $sngquote.'<option value="DNC" selected>Do Not Call</option>'.$sngquote.' +',PHP_EOL;  
               }
               
               else
               {
                   echo $sngquote.'<option value="DNC">Do Not Call</option>'.$sngquote.' +',PHP_EOL;  
               }
               
               if ($column[5]=="DNS")
               {
                   echo $sngquote.'<option value="DNS" selected>Danger Not Safe</option>'.$sngquote.' +',PHP_EOL;  
               }
               
               else
               {
                   echo $sngquote.'<option value="DNS">Danger Not Safe</option>'.$sngquote.' +',PHP_EOL;  
               }               
               
               if ($column[5]=="HH")
               {
                   echo $sngquote.'<option value="HH" selected>Home</option>'.$sngquote.' +',PHP_EOL;  
               }
               else
               {
                   echo $sngquote.'<option value="HH">Home</option>'.$sngquote.' +',PHP_EOL;  
               }
               
               if ($column[5]=="NH")
               {
                   echo $sngquote.'<option value="NH" selected>Not Home</option>'.$sngquote.' +',PHP_EOL;  
               }
               else
               {
                   echo $sngquote.'<option value="NH">Not Home</option>'.$sngquote.' +',PHP_EOL;  
               }               
  
               if ($column[5]=="NTR")
               {
                   echo $sngquote.'<option value="NTR" selected>No Trespassing/Gated</option>'.$sngquote.' +',PHP_EOL;  
               }
               else
               {
                   echo $sngquote.'<option value="NTR">No Trespassing/Gated</option>'.$sngquote.' +',PHP_EOL;  
               }    
                if($column[5]!="DNC"){               
                    if ($column[5]=="WL")
                    {
                        echo $sngquote.'<option value="WL" selected>Write Letter</option>'.$sngquote.' +',PHP_EOL;  
                    }
                    else
                    {
                        echo $sngquote.'<option value="WL">Write Letter</option>'.$sngquote.' +',PHP_EOL;  
                    } 
                }                               

               echo $sngquote.'</select> </td></tr>'.$sngquote.' +',PHP_EOL; 
               
               
          if($column[5]!="DNC"){                
                echo $sngquote.'<tr><td><input type="text" value="Letter:" style="border:none;" readonly></td></tr>'.$sngquote.' +',PHP_EOL;                 

                 if ($column[5]=="WL")
                 {
                      echo $sngquote.'<tr><td><select id="LetterType">'.$sngquote.' +',PHP_EOL;            
                 } 
                 else 
                 {
                      echo $sngquote.'<tr><td><select id="LetterType" disabled>'.$sngquote.' +',PHP_EOL;      
                 }  

                if ($column[20]=="LNS")
                {
                    echo $sngquote.'<option value="LNS" selected>Letter Not Sent</option>'.$sngquote.' +',PHP_EOL;  
                }               
                else
                {
                    echo $sngquote.'<option value="LNS">Letter Not Sent</option>'.$sngquote.' +',PHP_EOL;  
                }

                if ($column[20]=="LS")
                {
                    echo $sngquote.'<option value="LS" selected>Letter Sent</option>'.$sngquote.' +',PHP_EOL;  
                }
                else
                {
                    echo $sngquote.'<option value="LS">Letter Sent</option>'.$sngquote.' +',PHP_EOL;  
                }
                 echo $sngquote.'</select> </td></tr>'.$sngquote.' +',PHP_EOL;                  
          }
          else
          {
                echo $sngquote.'<tr><td><input type="hidden" id="LetterType" value="LNS"></td></tr>'.$sngquote.' +',PHP_EOL;          
          }
                
                echo $sngquote.'<input style="border:none" type="hidden" id="markername" value="'.$markername.'" readonly>'.$sngquote.' +',PHP_EOL;  
                echo $sngquote.'<input style="border:none" type="hidden" id="index" value="'.$index.'" readonly>'.$sngquote.' +',PHP_EOL;   
                echo $sngquote.'<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>'.$sngquote.' +',PHP_EOL;  
                echo $sngquote.'<tr><td><textarea id="Notes" rows="5" cols="40" value=""/></textarea></td></tr></table>'.$sngquote.' +',PHP_EOL;  
               
                if ($column[10]!="")
                {
                    $this->Notes($column[10]);
                    echo $sngquote.'<table>'.$sngquote.' +',PHP_EOL;                        
                }
                else 
                {   
                    echo $sngquote.'<table>'.$sngquote.' +',PHP_EOL;   
                    echo $sngquote.'<input style="border:none" type="hidden" id="N_total" value="0" readonly>'.$sngquote.' +',PHP_EOL;    
                }
                
                echo $sngquote.'<input style="border:none" type="hidden" id="bPhone" value="false" readonly>'.$sngquote.' +',PHP_EOL; 
                echo $sngquote.'<tr><td><input type="button" value="Submit Changes" onclick="saveData('.$escapesngquote.$markername.$escapesngquote.','.$index.',1)"/></td>'.$sngquote.' +',PHP_EOL;  
                echo $sngquote.'<td><input type="button" value="Close" onclick="closeInfowindow('.$escapesngquote.$markername.$escapesngquote.','.$index.')"/></td>'.$sngquote.' +',PHP_EOL; 
             //   echo '<td><div id='link'><a href='javascript:enable()'>Edit</a></div>\" +",PHP_EOL;
                echo $sngquote.'</td></tr></table>'.$sngquote.','.$column[2].','.$column[3].']);',PHP_EOL;                  

            }  
            
            
            
        private function Phone($column,$layername,$markername,$index)
        {
           $sngquote = "'" ;
           $escapesngquote = "\'" ; 
//           $phone = explode(";", $column[6]);
//   
//           
//           if ($phone[0]!=""){$phone[0]= str_ireplace(":",":<br>",$phone[0])."<br>";}
//           if ($phone[1]!=""){$phone[1]= str_ireplace(":",":<br>",$phone[1])."<br>";} 
//           if ($phone[2]!=""){$phone[2]= str_ireplace(":",":<br>",$phone[2])."<br>";}
//           if ($phone[3]!=""){$phone[3]= str_ireplace(":",":<br>",$phone[3]);}             
 
           echo $layername.'.push(',PHP_EOL;  
//           echo "[\"<form style='width: 350px'><div class='header'>\" +",PHP_EOL; 
           echo '['.$sngquote.'<form style="width: 350px">'.$sngquote.' +',PHP_EOL;            
//           echo '<img src='icons/House_header.png'/><h3><p><b>$column[4]</b></p></h3></div>\" +",PHP_EOL; 
           echo $sngquote.'<h3><p><b>'.$column[4].'</b></p></h3>'.$sngquote.' +',PHP_EOL;    
            if($column[13]!="") {
                echo $sngquote.'<h3><p><b>Unit: '.$column[13].'</b></p></h3>'.$sngquote.' +',PHP_EOL;  
            }           
           echo $sngquote.'<tr><td><input type="hidden" id="InitDate" value="'.$column[9].'"/></td> </tr>'.$sngquote.' +',PHP_EOL; 
           echo $sngquote.'<tr><td><input type="hidden" id="iSubmit" value="'.$column[21].'"/></td> </tr>'.$sngquote.' +',PHP_EOL; 		   
           echo $sngquote.'<table>'.$sngquote.' +',PHP_EOL;    
           echo $sngquote.'<tr><td><input type="hidden" id="AddressGUID" value="'.$column[0].'"/></td> </tr>'.$sngquote.' +',PHP_EOL;   
           echo $sngquote.'<tr><td><input type="text" value="Language:" style="border:none;" readonly></td></tr>'.$sngquote.' +',PHP_EOL;                 
           echo $sngquote.'<tr><td><select id="Language">'.$sngquote.' +',PHP_EOL;    
           
            if ($column[8]=="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5")
            {
                echo $sngquote.'<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5" selected>English</option>'.$sngquote.' +',PHP_EOL;  
            }

            else
            {
                echo $sngquote.'<option value="7FD97709-FD96-49DE-A6BB-23DDE04ED3B5">English</option>'.$sngquote.' +',PHP_EOL;  
            }  
            
//            if ($column[8]=="French")
//            {
//                echo $sngquote.'<option value="French" selected>French</option>'.$sngquote.' +',PHP_EOL;  
//            }
//
//            else
//            {
//                echo $sngquote.'<option value="French">French</option>'.$sngquote.' +',PHP_EOL;  
//            }   
//            
//            if ($column[8]=="Russian")
//            {
//                echo $sngquote.'<option value="Russian" selected>Russian</option>'.$sngquote.' +',PHP_EOL;  
//            }
//
//            else
//            {
//                echo $sngquote.'<option value="Russian">Russian</option>'.$sngquote.' +',PHP_EOL;  
//            }  
            
            if ($column[8]=="0537566C-1601-4CF7-953C-35CBA245085A")
            {
                echo $sngquote.'<option value="0537566C-1601-4CF7-953C-35CBA245085A" selected>Spanish</option>'.$sngquote.' +',PHP_EOL;  
            }

            else
            {
                echo $sngquote.'<option value="0537566C-1601-4CF7-953C-35CBA245085A">Spanish</option>'.$sngquote.' +',PHP_EOL;  
            }               
 
   
           echo $sngquote.'</select> </td></tr>'.$sngquote.' +',PHP_EOL;  
           echo $sngquote.'<tr><td><input type="text" value="House:" style="border:none;" readonly></td></tr>'.$sngquote.' +',PHP_EOL;             
           echo $sngquote.'<tr><td><select id="Type">'.$sngquote.' +',PHP_EOL; 
                       
            if ($column[5]=="DNC")
            {
                echo $sngquote.'<option value="DNC" selected>Do Not Call</option>'.$sngquote.' +',PHP_EOL;  
            }

            else
            {
                echo $sngquote.'<option value="DNC">Do Not Call</option>'.$sngquote.' +',PHP_EOL;  
            }
            
            if ($column[5]=="DNS")
            {
                echo $sngquote.'<option value="DNS" selected>Danger Not Safe</option>'.$sngquote.' +',PHP_EOL;  
            }

            else
            {
                echo $sngquote.'<option value="DNS">Danger Not Safe</option>'.$sngquote.' +',PHP_EOL;  
            }             

            if ($column[5]=="HH")
            {
                echo $sngquote.'<option value="HH" selected>Home</option>'.$sngquote.' +',PHP_EOL;  
            }
            else
            {
                echo $sngquote.'<option value="HH">Home</option>'.$sngquote.' +',PHP_EOL;  
            }

            if ($column[5]=="NH")
            {
                echo $sngquote.'<option value="NH" selected>Not Home</option>'.$sngquote.' +',PHP_EOL;  
            }
            else
            {
                echo $sngquote.'<option value="NH">Not Home</option>'.$sngquote.' +',PHP_EOL;  
            }   
            if ($column[5]=="NTR")
            {
                echo $sngquote.'<option value="NTR" selected>No Trespassing/Gated</option>'.$sngquote.' +',PHP_EOL;  
            }
            else
            {
                echo $sngquote.'<option value="NTR">No Trespassing/Gated</option>'.$sngquote.' +',PHP_EOL;  
            }                
            if ($column[5]=="PC")
            {
                echo $sngquote.'<option value="PC" selected>Phone Call</option>'.$sngquote.' +',PHP_EOL;  
            }
            else
            {
                echo $sngquote.'<option value="PC">Phone Call</option>'.$sngquote.' +',PHP_EOL;  
            }                  

            if ($column[5]=="WL")
            {
                echo $sngquote.'<option value="WL" selected>Write Letter</option>'.$sngquote.' +',PHP_EOL;  
            }
            else
            {
                echo $sngquote.'<option value="WL">Write Letter</option>'.$sngquote.' +',PHP_EOL;  
            }             


           echo $sngquote.'</select> </td></tr></table>'.$sngquote.' +',PHP_EOL;              
           echo $sngquote.'<table>'.$sngquote.' +',PHP_EOL;   
           echo $sngquote.'<tr><td><input type="text" value="Phone:" style="border:none;" readonly></td></tr>'.$sngquote.' +',PHP_EOL;   
           
           if ($column[5]=="PC")
           {
                echo $sngquote.'<tr><td><select id="PhoneType">'.$sngquote.' +',PHP_EOL;            
           } 
           else 
           {
                echo $sngquote.'<tr><td><select id="PhoneType" disabled>'.$sngquote.' +',PHP_EOL;      
           }
  
           
            if ($column[7]=="AP")
            {
                echo $sngquote.'<option value="AP" selected>Answered Phone</option>'.$sngquote.' +',PHP_EOL;  
            }
            else
            {
                echo $sngquote.'<option value="AP">Answered Phone</option>'.$sngquote.' +',PHP_EOL;  
            }  
                                   
            if ($column[7]=="PD")
            {
                echo $sngquote.'<option value="PD" selected>Disconnected</option>'.$sngquote.' +',PHP_EOL;  
            }
            else
            {
                echo $sngquote.'<option value="PD">Disconnected</option>'.$sngquote.' +',PHP_EOL;  
            } 
            
            if ($column[7]=="NA")
            {
                echo $sngquote.'<option value="NA" selected>No Answer</option>'.$sngquote.' +',PHP_EOL;  
            }
            else
            {
                echo $sngquote.'<option value="NA">No Answer</option>'.$sngquote.' +',PHP_EOL;  
            }             
            
            if ($column[7]=="NC")
            {
                echo $sngquote.'<option value="NC" selected>Not Called</option>'.$sngquote.' +',PHP_EOL;  
            }
            else
            {
                echo $sngquote.'<option value="NC">Not Called</option>'.$sngquote.' +',PHP_EOL;  
            } 
            
            if ($column[7]=="VM")
            {
                echo $sngquote.'<option value="VM" selected>Voice Message</option>'.$sngquote.' +',PHP_EOL;  
            }
            else
            {
                echo $sngquote.'<option value="VM">Voice Message</option>'.$sngquote.' +',PHP_EOL;  
            }              
           
           echo $sngquote.'</select> </td>'.$sngquote.' +',PHP_EOL;   
           echo $sngquote.'<td>'.$sngquote.' +',PHP_EOL;  
           
           if ($column[5]=="PC")
           {      
                $phonenumber=str_replace("-","",$column[16]);
				$phonenumber=str_replace(" ","",$phonenumber);
				$phonenumber=str_replace("(","",$phonenumber);	
				$phonenumber=str_replace(")","",$phonenumber);
				
                echo $sngquote.'<div class="tooltip"><a href="tel:+1'.$phonenumber.'"><img src = "icons/Phone_Small.png"></a>'.$sngquote.' +',PHP_EOL; 
           }
           else
           {
                echo $sngquote.'<div class="tooltip"><img src = "icons/Phone_Small_Disabled.png">'.$sngquote.' +',PHP_EOL;               
           }
           
           echo $sngquote.'<span class="tooltiptext">'.$sngquote.' +',PHP_EOL;   
           echo $sngquote.$column[6].'<br>'.$column[16].$sngquote.' +',PHP_EOL; 
//           echo $sngquote.$phone[0].$sngquote.' +',PHP_EOL;  
//           echo $sngquote.$phone[1].$sngquote.' +',PHP_EOL;  
//           echo $sngquote.$phone[2].$sngquote.' +',PHP_EOL;  
//           echo $sngquote.$phone[3].$sngquote.' +',PHP_EOL;  
           echo $sngquote.'</span></div></td></tr></table>'.$sngquote.' +',PHP_EOL;             
           echo $sngquote.'<table>'.$sngquote.' +',PHP_EOL;            
           echo $sngquote.'<tr><td><input type="text" value="Letter:" style="border:none;" readonly></td></tr>'.$sngquote.' +',PHP_EOL;                 

             if ($column[5]=="WL")
             {
                  echo $sngquote.'<tr><td><select id="LetterType">'.$sngquote.' +',PHP_EOL;            
             } 
             else 
             {
                  echo $sngquote.'<tr><td><select id="LetterType" disabled>'.$sngquote.' +',PHP_EOL;      
             }               
            if ($column[20]=="LNS")
            {
                echo $sngquote.'<option value="LNS" selected>Letter Not Sent</option>'.$sngquote.' +',PHP_EOL;  
            }

            else
            {
                echo $sngquote.'<option value="LNS">Letter Not Sent</option>'.$sngquote.' +',PHP_EOL;  
            }

            if ($column[20]=="LS")
            {
                echo $sngquote.'<option value="LS" selected>Letter Sent</option>'.$sngquote.' +',PHP_EOL;  
            }
            else
            {
                echo $sngquote.'<option value="LS">Letter Sent</option>'.$sngquote.' +',PHP_EOL;  
            }

             echo $sngquote.'</select> </td></tr>'.$sngquote.' +',PHP_EOL; 
                             

           echo $sngquote.'<input style="border:none" type="hidden" id="markername" value="'.$markername.'" readonly>'.$sngquote.' +',PHP_EOL;  
           echo $sngquote.'<input style="border:none" type="hidden" id="index" value="'.$index.'" readonly>'.$sngquote.' +',PHP_EOL;   
           echo $sngquote.'<tr><td><input type="text" value="Add Note:" style="border:none;" readonly></td></tr>'.$sngquote.' +',PHP_EOL;                 
           echo $sngquote.'<tr><td><textarea id="Notes" rows="5" cols="40" value=""/></textarea></td></tr></table>'.$sngquote.' +',PHP_EOL;     
           
            if ($column[10]!="")
            {
                $this->Notes($column[10]);
                echo $sngquote.'<table>'.$sngquote.' +',PHP_EOL;    
                
            }
            else 
            {    
                echo $sngquote.'<table>'.$sngquote.' +',PHP_EOL;  
                echo $sngquote.'<input style="border:none" type="hidden" id="N_total" value="0" readonly>'.$sngquote.' +',PHP_EOL;   
                  
            }
            echo $sngquote.'<input style="border:none" type="hidden" id="bPhone" value="true" readonly>'.$sngquote.' +',PHP_EOL;
            echo $sngquote.'<tr><td><input type="button" value="Submit Changes" onclick="saveData('.$escapesngquote.$markername.$escapesngquote.','.$index.',1)"/></td>'.$sngquote.' +',PHP_EOL;   
            echo $sngquote.'<td><input type="button" value="Close" onclick="closeInfowindow('.$escapesngquote.$markername.$escapesngquote.','.$index.')"/></td>'.$sngquote.' +',PHP_EOL;             
          //  echo '<td><div id='link'><a href='javascript:enable()'>Edit</a></div>\" +",PHP_EOL;
            echo $sngquote.'</td></tr></table>'.$sngquote.','.$column[2].','.$column[3].']);',PHP_EOL;     
            
       }
       
       
     }   
     
     
