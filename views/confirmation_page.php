<?php
// Start the session
session_start();
// Create an array for the shopping cart in the session
/*
if (!isset($_SESSION['shoppingCart'])) {
 $_SESSION['shoppingCart'] = array();
 $_SESSION['products'] = array();
 }
 */
?>
<!DOCTYPE html>
<html lang="en-us">
 <head>
  <title>Confirmation Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/online_store_styles.css" rel="stylesheet" media="screen">
  <link href="css/normalize.css" rel="stylesheet" media="screen">
 </head>
 <body>
 <header>
 <?php include $_SERVER[ 'DOCUMENT_ROOT' ].'/assignments/common/header.php'; ?>
 </header>
 <main>
 <h1>This is Confirmation Page</h1>
 <?php

// define variables and set to empty values
$country = $city = $street = $houseNumber = $zipCoce = "";



//var_dump($major);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$country = htmlspecialchars($_POST["country"]);
	// Check if name contains only letters and whitespace
	$city = htmlspecialchars($_POST["city"]);
	$street = htmlspecialchars($_POST["street"]);
	$houseNumber = htmlspecialchars($_POST["houseNumber"]);
	$zipCode = htmlspecialchars($_POST["zipCode"]);

	
}

if (empty($_SESSION['shoppingCart'])) {
	 echo "<h1>The Shopping Cart is empty</h1>";
 } else {
	 echo "<h1>These are the products that you have purchased</h1><br><br>";
	  

foreach ($_SESSION['shoppingCart'] as $product) {
	echo '<section><h2>'.$product["title"].'</h2><article><div><img src='.$product["image"].'></div><div><p class="price"><span>Price per item: </span>'.$product["price"].
	'</p><p><span>Description: </span>'.$product["productdescription"].'</p><p><span>Purchased: </span>'.$product["addedToCart"].'</p></div></article></section>';
	
	
 };
 
 echo "<h1>The products that you have purchased will be shipped to the following address</h1><br><br>";
echo "<div id='customerInformation'><span><b>Country:</b></span> ".$country."<br>";
echo "<span><b>City:</b></span> ".$city."<br>";
echo "<span><b>Street:</b></span> ".$street."<br>";
echo "<span><b>House number:</b></span> ".$houseNumber."<br>";
echo "<span><b>Zip code:</b></span> ".$zipCode."<br></div>";

$_SESSION['purchaseCompleted'] = true;
 }

//echo "Hello";

//var_dump($_POST);


?>
 
 
 
 </main>

  
  <footer>
  <?php include $_SERVER[ 'DOCUMENT_ROOT' ].'/assignments/common/footer.php'; ?>
  </footer>
 </body>
</html>