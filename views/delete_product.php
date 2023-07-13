<?php
// Start the session
session_start();
if(!($_SESSION['loggedin'])){header('Location: home.php');}
if(!$_SESSION['userData']['userlevel'] > 1) {header('Location: manage_account.php');}
// Create an array for the shopping cart in the session
if (!isset($_SESSION['shoppingCart'])) {
 $_SESSION['shoppingCart'] = array();
 $_SESSION['products'] = array();
 }
?>
<!DOCTYPE html>
<html lang="en-us">
 <head>
  <title>Delete Product Page</title>
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
 // Get the database connection file
 require_once '../library/connections.php';
 
 ?>
 
 <?php
   if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
   } elseif (isset($message)) {
    echo $message;
   }
   
if(!empty($_GET)) {
	if(isset($_GET['id'])) {
		$_SESSION['message'] = "";
	$message = "";
	}	
	$productId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$getProductInfo = $db->prepare('SELECT * FROM product WHERE id = ' . $productId . ''); 
$getProductInfo->execute();
$productInfo = $getProductInfo->fetch(PDO::FETCH_ASSOC);
}
?>
   <?php
   echo "<h3>Please, confirm that you really want to delete the product " . $productInfo['product'] . ". After deletion you will not be able to undo it.</h3>"
   ?>
   
   
   <form action="delete_product.php" method="post">
    <fieldset>
	<legend>Delete product</legend>
     <label for="productName">Product Name</label><br>
     <input type="text" name="productName" id="productName" pattern="[A-Za-z0-9 ]{3,}" <?php if(isset($productInfo['product'])){echo "value='$productInfo[product]'";} ?> required><br><br>
	 <input class="submitBtn" type="submit" value="Delete product">
     <!-- Add the action name - value pair -->
	 <input type="hidden" name="productId" <?php if(isset($productInfo['id'])){echo "value='$productInfo[id]'";} ?>>
	 <input type="hidden" name="DeleteProduct" value="deleteProduct">
    </fieldset>
   </form>
   
   
   <?php

if(isset($_POST['DeleteProduct'])) {
	
	// Filter and store the data
	
	$prodId = filter_input(INPUT_POST, 'productId', FILTER_SANITIZE_NUMBER_INT);
	$productName = filter_input(INPUT_POST, 'productName', FILTER_SANITIZE_STRING);
	 
   
   
   $stmt = $db->prepare('DELETE FROM product WHERE id = :prodId');
  $stmt->bindValue(':prodId', $prodId, PDO::PARAM_INT);
 $stmt->execute();


   
   // Send the data to the model
   $deleteProductOutcome = $stmt->rowCount();
   
     
   // Check and report the result
   
   if($deleteProductOutcome === 1){
	   $_SESSION['message'] = "<p class='messagesuccess'>The product " . $productName . " has successfully been deleted.</p>";
   header('location: manage_products.php');
   exit;
   } else {
    $_SESSION['message'] = "<p class='messagefailure'>Sorry, deleting the product " . $productName . " has failed. Please, try again.</p>";
            header('location: manage_products.php');
    exit;
   }
	
	
}

   ?>
   
 
 </main>
 <footer>
  <?php include $_SERVER[ 'DOCUMENT_ROOT' ].'/assignments/common/footer.php'; ?>
  </footer>
 </body>
</html>