<!DOCTYPE html>
<html>
<html lang="en">
<head>
  <title>Pay</title>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="https://lh3.googleusercontent.com/-HtZivmahJYI/VUZKoVuFx3I/AAAAAAAAAcM/thmMtUUPjbA/Blue_square_A-3.PNG" />
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="forcompany.css">
  <link rel="stylesheet" href="homepage.css">
  <link rel="stylesheet" href="AdminSignin.css">
  <script src="login.js"> </script>
  <script src="jump.js"> </script>
</head>
<body>
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="homepage.html"><span class="glyphicon glyphicon-home"></span> Home</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
                    <li id = "cart">
                        <a class="navbar-brand" href="cartshow.php"><span class="glyphicon glyphicon-shopping-cart"></span> Ticket</a>
                    </li>           
          <li class="dropdown" id = "new">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"> Sign in&nbsp;</span><span class="caret"></span>
            </a>
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
              <li><a href="signup.html">Register</a></li>
              
              <li class="dropdown-submenu">
              <a tabindex="-1" href="#">Sign in</a>
              <ul class="dropdown-menu">
                <li><a tabindex="-1" href="Adminpage.html">Manager Sign in</a></li>
                <li><a href="customersignin.html">Customer Sign in</a></li>
                
            
          </li>
              </ul>
              </li>
            
            </ul>
          </li>
            <li class="dropdown" id = "old">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" ><span class="glyphicon glyphicon-user" id="wuser">Welcom!</span>
            <span class="caret"></span>
            </a>
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
              <li><a href="showhistory.php">History</a></li>
              <li><a href="#" id="logout">Sign out</a></li>
            </ul>
            </li>
        </ul>
      </div>
    </div>
  </nav>
<div class="jumbotron text-center">
<h1>AFRO ORIENT  <br/>
			TRAVEL LTD</h1> 
      <p>We specialize in your air plan ticket!</p>
</div>

<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">

    </div>
    <div class="col-sm-8 text-left"> 
      <h4>Cheak  you phone to complete transaction</h4>
      </div>

    
    </div>
    
  </div>
</div>

 
<?php

$shortcode="174379"; //YOUR_SHORT_CODE_HERE
$initiatorname="apiop37"; //The initiator law
$initiatorpassword="Safaricom3021#";


$consumerkey    ="nwT6nTENgGR0DYIsSP9KiKckEli62uOG";//YOUR_CONSUMER_SECRET_HERE
$consumersecret ="pY8gtGPuYYzYMw6k"; //YOUR_CONSUMER_SECRET_HERE


$commandid='BusinessPayment';
$mobilenumber="254727596412"; //client mobile number
$amount="1"; //amount to be paid by client
$remarks='TEST BUSINESS DISBURSAL';
$occassion='JANUARY 2020';
$lipa_time = date('YmdHis');
$LipaNaMpesaOnlinePassKey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919"; //input your 


$QueueTimeOutURL="http://lagaster.com"; // in put your queue time out url here
$ResultURL="http://lagaster.com"; // input your response url here




$url1 = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

$headers = array(  
    'Content-Type: application/json; charset=utf-8'
  );
  // Request
  $ch = curl_init($url1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  //curl_setopt($ch, CURLOPT_HEADER, TRUE); // Includes the header in the output
  curl_setopt($ch, CURLOPT_HEADER, FALSE); // excludes the header in the output
  curl_setopt($ch, CURLOPT_USERPWD, $consumerkey . ":" . $consumersecret); // HTTP Basic Authentication
  $result = curl_exec($ch);  
if(curl_errno($ch)){
    echo 'Request Error:' . curl_error($ch);
    exit();
}
$result = json_decode($result);
$access_token=$result->access_token;

 $_SESSION['access_token'] = $access_token ;

curl_close($ch);

$url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
  
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token )); //setting custom header


  $SecurityCredential  = base64_encode($shortcode . $LipaNaMpesaOnlinePassKey . $lipa_time);
  
  
  $curl_post_data = array(
    //Fill in the request parameters with valid values
    "BusinessShortCode"=> $shortcode,
    "Password"=> $SecurityCredential,
    "Timestamp"=> $lipa_time,
    "TransactionType"=> "CustomerPayBillOnline",
    "Amount"=> $amount,
    "PartyA"=> $mobilenumber,
    "PartyB"=> $shortcode,
    "PhoneNumber"=> $mobilenumber,
    "CallBackURL"=> "http://lagaster.com",
    "AccountReference"=> "Payment request",
    "TransactionDesc"=> "Payment request"
  );
  
  $data_string = json_encode($curl_post_data);
  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  
  $curl_response = curl_exec($curl);
 

  $curl_response = json_decode($curl_response);


?> 
      <?php

$shortcode="174379"; //YOUR_SHORT_CODE_HERE
$initiatorname="apiop37"; //The initiator law
$initiatorpassword="Safaricom3021#";


$consumerkey    ="nwT6nTENgGR0DYIsSP9KiKckEli62uOG";//YOUR_CONSUMER_SECRET_HERE
$consumersecret ="pY8gtGPuYYzYMw6k"; //YOUR_CONSUMER_SECRET_HERE


$commandid='BusinessPayment';
$mobilenumber="254727596412"; //client mobile number
$amount="1"; //amount to be paid by client
$remarks='TEST BUSINESS DISBURSAL';
$occassion='JANUARY 2020';
$lipa_time = date('YmdHis');
$LipaNaMpesaOnlinePassKey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919"; //input your 


$QueueTimeOutURL="http://lagaster.com"; // in put your queue time out url here
$ResultURL="http://lagaster.com"; // input your response url here




$url1 = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

$headers = array(  
    'Content-Type: application/json; charset=utf-8'
  );
  // Request
  $ch = curl_init($url1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  //curl_setopt($ch, CURLOPT_HEADER, TRUE); // Includes the header in the output
  curl_setopt($ch, CURLOPT_HEADER, FALSE); // excludes the header in the output
  curl_setopt($ch, CURLOPT_USERPWD, $consumerkey . ":" . $consumersecret); // HTTP Basic Authentication
  $result = curl_exec($ch);  
if(curl_errno($ch)){
    echo 'Request Error:' . curl_error($ch);
    exit();
}
$result = json_decode($result);
$access_token=$result->access_token;

 $_SESSION['access_token'] = $access_token ;

curl_close($ch);

$url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
  
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token )); //setting custom header


  $SecurityCredential  = base64_encode($shortcode . $LipaNaMpesaOnlinePassKey . $lipa_time);
  
  
  $curl_post_data = array(
    //Fill in the request parameters with valid values
    "BusinessShortCode"=> $shortcode,
    "Password"=> $SecurityCredential,
    "Timestamp"=> $lipa_time,
    "TransactionType"=> "CustomerPayBillOnline",
    "Amount"=> $amount,
    "PartyA"=> $mobilenumber,
    "PartyB"=> $shortcode,
    "PhoneNumber"=> $mobilenumber,
    "CallBackURL"=> "http://lagaster.com",
    "AccountReference"=> "Payment request",
    "TransactionDesc"=> "Payment request"
  );
  
  $data_string = json_encode($curl_post_data);
  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  
  $curl_response = curl_exec($curl);
 

  $curl_response = json_decode($curl_response);


?> 
      <?php

$shortcode="174379"; //YOUR_SHORT_CODE_HERE
$initiatorname="apiop37"; //The initiator law
$initiatorpassword="Safaricom3021#";


$consumerkey    ="nwT6nTENgGR0DYIsSP9KiKckEli62uOG";//YOUR_CONSUMER_SECRET_HERE
$consumersecret ="pY8gtGPuYYzYMw6k"; //YOUR_CONSUMER_SECRET_HERE


$commandid='BusinessPayment';
$mobilenumber="254727596412"; //client mobile number
$amount="1"; //amount to be paid by client
$remarks='TEST BUSINESS DISBURSAL';
$occassion='JANUARY 2020';
$lipa_time = date('YmdHis');
$LipaNaMpesaOnlinePassKey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919"; //input your 


$QueueTimeOutURL="http://lagaster.com"; // in put your queue time out url here
$ResultURL="http://lagaster.com"; // input your response url here




$url1 = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

$headers = array(  
    'Content-Type: application/json; charset=utf-8'
  );
  // Request
  $ch = curl_init($url1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  //curl_setopt($ch, CURLOPT_HEADER, TRUE); // Includes the header in the output
  curl_setopt($ch, CURLOPT_HEADER, FALSE); // excludes the header in the output
  curl_setopt($ch, CURLOPT_USERPWD, $consumerkey . ":" . $consumersecret); // HTTP Basic Authentication
  $result = curl_exec($ch);  
if(curl_errno($ch)){
    echo 'Request Error:' . curl_error($ch);
    exit();
}
$result = json_decode($result);
$access_token=$result->access_token;

 $_SESSION['access_token'] = $access_token ;

curl_close($ch);

$url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
  
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token )); //setting custom header


  $SecurityCredential  = base64_encode($shortcode . $LipaNaMpesaOnlinePassKey . $lipa_time);
  
  
  $curl_post_data = array(
    //Fill in the request parameters with valid values
    "BusinessShortCode"=> $shortcode,
    "Password"=> $SecurityCredential,
    "Timestamp"=> $lipa_time,
    "TransactionType"=> "CustomerPayBillOnline",
    "Amount"=> $amount,
    "PartyA"=> $mobilenumber,
    "PartyB"=> $shortcode,
    "PhoneNumber"=> $mobilenumber,
    "CallBackURL"=> "http://lagaster.com",
    "AccountReference"=> "Payment request",
    "TransactionDesc"=> "Payment request"
  );
  
  $data_string = json_encode($curl_post_data);
  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  
  $curl_response = curl_exec($curl);
 

  $curl_response = json_decode($curl_response);


?> 
      <?php

$shortcode="174379"; //YOUR_SHORT_CODE_HERE
$initiatorname="apiop37"; //The initiator law
$initiatorpassword="Safaricom3021#";


$consumerkey    ="nwT6nTENgGR0DYIsSP9KiKckEli62uOG";//YOUR_CONSUMER_SECRET_HERE
$consumersecret ="pY8gtGPuYYzYMw6k"; //YOUR_CONSUMER_SECRET_HERE


$commandid='BusinessPayment';
$mobilenumber="254727596412"; //client mobile number
$amount="1"; //amount to be paid by client
$remarks='TEST BUSINESS DISBURSAL';
$occassion='JANUARY 2020';
$lipa_time = date('YmdHis');
$LipaNaMpesaOnlinePassKey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919"; //input your 


$QueueTimeOutURL="http://lagaster.com"; // in put your queue time out url here
$ResultURL="http://lagaster.com"; // input your response url here




$url1 = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

$headers = array(  
    'Content-Type: application/json; charset=utf-8'
  );
  // Request
  $ch = curl_init($url1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  //curl_setopt($ch, CURLOPT_HEADER, TRUE); // Includes the header in the output
  curl_setopt($ch, CURLOPT_HEADER, FALSE); // excludes the header in the output
  curl_setopt($ch, CURLOPT_USERPWD, $consumerkey . ":" . $consumersecret); // HTTP Basic Authentication
  $result = curl_exec($ch);  
if(curl_errno($ch)){
    echo 'Request Error:' . curl_error($ch);
    exit();
}
$result = json_decode($result);
$access_token=$result->access_token;

 $_SESSION['access_token'] = $access_token ;

curl_close($ch);

$url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
  
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token )); //setting custom header


  $SecurityCredential  = base64_encode($shortcode . $LipaNaMpesaOnlinePassKey . $lipa_time);
  
  
  $curl_post_data = array(
    //Fill in the request parameters with valid values
    "BusinessShortCode"=> $shortcode,
    "Password"=> $SecurityCredential,
    "Timestamp"=> $lipa_time,
    "TransactionType"=> "CustomerPayBillOnline",
    "Amount"=> $amount,
    "PartyA"=> $mobilenumber,
    "PartyB"=> $shortcode,
    "PhoneNumber"=> $mobilenumber,
    "CallBackURL"=> "http://lagaster.com",
    "AccountReference"=> "Payment request",
    "TransactionDesc"=> "Payment request"
  );
  
  $data_string = json_encode($curl_post_data);
  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  
  $curl_response = curl_exec($curl);
 

  $curl_response = json_decode($curl_response);


?>
 
 <?php

$shortcode="174379"; //YOUR_SHORT_CODE_HERE
$initiatorname="apiop37"; //The initiator law
$initiatorpassword="Safaricom3021#";


$consumerkey    ="nwT6nTENgGR0DYIsSP9KiKckEli62uOG";//YOUR_CONSUMER_SECRET_HERE
$consumersecret ="pY8gtGPuYYzYMw6k"; //YOUR_CONSUMER_SECRET_HERE


$commandid='BusinessPayment';
$mobilenumber="254727596412"; //client mobile number
$amount="1"; //amount to be paid by client
$remarks='TEST BUSINESS DISBURSAL';
$occassion='JANUARY 2020';
$lipa_time = date('YmdHis');
$LipaNaMpesaOnlinePassKey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919"; //input your 


$QueueTimeOutURL="http://lagaster.com"; // in put your queue time out url here
$ResultURL="http://lagaster.com"; // input your response url here




$url1 = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

$headers = array(  
    'Content-Type: application/json; charset=utf-8'
  );
  // Request
  $ch = curl_init($url1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  //curl_setopt($ch, CURLOPT_HEADER, TRUE); // Includes the header in the output
  curl_setopt($ch, CURLOPT_HEADER, FALSE); // excludes the header in the output
  curl_setopt($ch, CURLOPT_USERPWD, $consumerkey . ":" . $consumersecret); // HTTP Basic Authentication
  $result = curl_exec($ch);  
if(curl_errno($ch)){
    echo 'Request Error:' . curl_error($ch);
    exit();
}
$result = json_decode($result);
$access_token=$result->access_token;

 $_SESSION['access_token'] = $access_token ;

curl_close($ch);

$url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
  
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token )); //setting custom header


  $SecurityCredential  = base64_encode($shortcode . $LipaNaMpesaOnlinePassKey . $lipa_time);
  
  
  $curl_post_data = array(
    //Fill in the request parameters with valid values
    "BusinessShortCode"=> $shortcode,
    "Password"=> $SecurityCredential,
    "Timestamp"=> $lipa_time,
    "TransactionType"=> "CustomerPayBillOnline",
    "Amount"=> $amount,
    "PartyA"=> $mobilenumber,
    "PartyB"=> $shortcode,
    "PhoneNumber"=> $mobilenumber,
    "CallBackURL"=> "http://lagaster.com",
    "AccountReference"=> "Payment request",
    "TransactionDesc"=> "Payment request"
  );
  
  $data_string = json_encode($curl_post_data);
  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  
  $curl_response = curl_exec($curl);
 

  $curl_response = json_decode($curl_response);


?>
<footer class="container-fluid text-center">
        <a href="#signUpPage" title="To Top">
            <span class="glyphicon glyphicon-chevron-up"></span>
        </a>
        <p>AFRO ORIENT  <br/>
			TRAVEL LTD</p> 	      
</footer>


</body>
</html>