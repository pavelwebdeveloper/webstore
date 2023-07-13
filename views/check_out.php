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
  <title>Check Out Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/online_store_styles.css" rel="stylesheet" media="screen">
  <link href="css/normalize.css" rel="stylesheet" media="screen">
 </head>
 <body>
 <header>
 <?php include $_SERVER[ 'DOCUMENT_ROOT' ].'/assignments/common/header.php'; ?>
 </header>
 <main>
 <?php
 
		$country = $_SESSION['orderCountry'];
		$city = $_SESSION['orderCity'];
		$street = $_SESSION['orderStreet'];
		$houseNumber = $_SESSION['orderHouseNumber'];
		$zipCode = $_SESSION['orderZipCode'];
		

 ?>
 <h1>This is Checkout Page</h1>
 <p>Please, input the information about your address. It is required to fill out all the fields.</p>
 <form method="post" action="confirmation_page.php">
<label class="address" for="country">Country: <input type="text" name="country" <?php if(isset($country)){ echo "value='$country'"; } else {echo "value=''"; } ?> required></label><br>
<label class="address" for="city">City: <input type="text" name="city" <?php if(isset($city)){ echo "value='$city'"; } else {echo "value=''"; } ?> required></label><br>
<label class="address" for="street">Street: <input type="text" name="street" <?php if(isset($street)){ echo "value='$street'"; } else {echo "value=''"; } ?> required></label><br>
<label class="address" for="houseNumber">House number: <input type="text" name="houseNumber" <?php if(isset($houseNumber)){ echo "value='$houseNumber'"; } else {echo "value=''"; } ?> required></label><br>
<label class="address" for="zipCode">Zipcode: <input type="text" name="zipCode" <?php if(isset($zipCode)){ echo "value='$zipCode'"; } else {echo "value=''"; } ?> required></label><br>

<input class="submitBtn completePurchase" type="submit" name="completePurchase" value="Complete the purchase"><br>
<input class="submitBtn" type="submit" name="returnToShoppingCart" value="Return to Shopping Cart" formaction="view_cart.php">

</form>


<!--
<div class="bottomNavigationLinks">
 <div>
 <form method="post" action="view_cart.php">
<input class="navigationButton" type="submit" value="Return to the Shopping Cart">
</form>
</div>
</div>
-->

<!--
<form method="post" action="view_cart.php">
<input type="submit" value="Return to the cart">
</form>
-->
 
 
 
 </main>

  
  <footer>
  <?php include $_SERVER[ 'DOCUMENT_ROOT' ].'/assignments/common/footer.php'; ?>
  </footer>
 </body>
</html>