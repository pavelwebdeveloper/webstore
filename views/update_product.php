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
  <title>Update Product Page</title>
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
$productId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$getProductInfo = $db->prepare('SELECT * FROM product WHERE id = ' . $productId . ''); 
$getProductInfo->execute();
$productInfo = $getProductInfo->fetch(PDO::FETCH_ASSOC);
}   
   ?>
   
   
   
   <form action="update_product.php" method="post">
    <fieldset>
	<legend>Update product</legend>
     <label for="productName">Product Name</label><br>
     <input type="text" name="productName" id="productName" pattern="[A-Za-z0-9 ]{3,}" <?php if(isset($productInfo['product'])){echo "value='$productInfo[product]'";} ?> required><br><br>
	 <label for="productDescription">Product Description:</label><br>
<textarea name="productDescription" id="productDescription" rows="10" cols="100"><?php if(isset($productInfo['productdescription'])){echo "$productInfo[productdescription]";} ?></textarea><br><br>
<label for="imageFilePath">Image File Path for the New Product</label><br>
     <input type="text" name="imageFilePath" id="imageFilePath" pattern="[A-Za-z/_.]{3,}" <?php if(isset($productInfo['image'])){echo "value='$productInfo[image]'";} ?> required><br><br>
	 <label for="productPrice">Product Price</label><br>
	 <input type="number" name="productPrice" id="productPrice" <?php if(isset($productInfo['price'])){echo "value='$productInfo[price]'";} ?>><br><br>
	 <label for="productStock">Product Stock</label><br>
	 <input type="number" name="productStock" id="productStock" <?php if(isset($productInfo['stock'])){echo "value='$productInfo[stock]'";} ?>><br><br>
	 <input class="submitBtn" type="submit" value="Update product">
     <!-- Add the action name - value pair -->
	 <input type="hidden" name="productId" <?php if(isset($productInfo['id'])){echo "value='$productInfo[id]'";} ?>>
	 <input type="hidden" name="departmentId" <?php if(isset($productInfo['productdepartmentid'])){echo "value='$productInfo[productdepartmentid]'";} ?>>
	 <input type="hidden" name="productGroupId" <?php if(isset($productInfo['productgroupid'])){echo "value='$productInfo[productgroupid]'";} ?>>
     <input type="hidden" name="UpdateProduct" value="updateProduct">
    </fieldset>
   </form>
   
   
   <?php

if(isset($_POST['UpdateProduct'])) {
	// Filter and store the data
	
	$prodId = filter_input(INPUT_POST, 'productId', FILTER_SANITIZE_NUMBER_INT);
	$productName = filter_input(INPUT_POST, 'productName', FILTER_SANITIZE_STRING);
	$productGroupId = (int)(filter_input(INPUT_POST, 'productGroupId', FILTER_SANITIZE_NUMBER_INT));	
	$departmentId = (int)(filter_input(INPUT_POST, 'departmentId', FILTER_SANITIZE_NUMBER_INT));		
	$imageFilePath = filter_input(INPUT_POST, 'imageFilePath', FILTER_SANITIZE_STRING);	
	$productDescription = filter_input(INPUT_POST, 'productDescription', FILTER_SANITIZE_STRING);
$productPrice = (int)(filter_input(INPUT_POST, 'productPrice', FILTER_SANITIZE_NUMBER_INT));
$productStock = (int)(filter_input(INPUT_POST, 'productStock', FILTER_SANITIZE_NUMBER_INT));


// Check for missing data

   if(empty($productName) || empty($productGroupId) || empty($imageFilePath) || empty($productDescription) || empty($productPrice) || empty($productStock)){
    $_SESSION['message'] = '<p class="message">Please, specify the information for all fields.</p>';
    header('location: add_product.php');
    exit;
   }  
   
   
   $stmt = $db->prepare('UPDATE product SET product = :productName, productgroupId = :productGroupId, productdepartmentId = :departmentId, productdescription = :productDescription, image = :imageFilePath, price = :productPrice, stock = :productStock WHERE id = :prodId');
  $stmt->bindValue(':prodId', $prodId, PDO::PARAM_INT);
 $stmt->bindValue(':productName', $productName, PDO::PARAM_STR);
 $stmt->bindValue(':productGroupId', $productGroupId, PDO::PARAM_INT);
 $stmt->bindValue(':departmentId', $departmentId, PDO::PARAM_INT);
 $stmt->bindValue(':productDescription', $productDescription, PDO::PARAM_STR);
 $stmt->bindValue(':imageFilePath', $imageFilePath, PDO::PARAM_STR);
 $stmt->bindValue(':productPrice', $productPrice, PDO::PARAM_INT);
 $stmt->bindValue(':productStock', $productStock, PDO::PARAM_INT);
 $stmt->execute();


   
   // Send the data to the model
   $updateProductOutcome = $stmt->rowCount();
   
      
   // Check and report the result
   
   if($updateProductOutcome === 1){
	   $_SESSION['message'] = "<p class='messagesuccess'>The product " . $productName . " has successfully been updated.</p>";
   header('location: manage_products.php');
   exit;
   } else {
    $message = "<p class='messagefailure'>Sorry, updating the product " . $productName . " has failed. Please, try again.</p>";
            header('location: update_product.php');
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