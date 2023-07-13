<?php
// Start the session
session_start();

if($_SESSION['purchaseCompleted'] == true){  
 // remove all session variables
session_unset();
 }
 
// Create an array for the shopping cart in the session
/*
if (!isset($_SESSION['shoppingCart'])) {
 $_SESSION['shoppingCart'] = array();
 $_SESSION['products'] = array();
 }/*/
?>
<!DOCTYPE html>
<html lang="en-us">
 <head>
  <title>View Cart Page</title>
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
 
 <h1>This is View Cart Page</h1>
 
 <?php
 
 /*
 echo "<br><h1>1</h1>";
 var_dump($_SESSION);
 echo "<br>";
 echo "<br>";
 echo "<br>";
 
 
 echo "<br>";
 
 echo "<br><h1>2</h1>";
 var_dump($_SESSION);
 echo "<br>";
 echo "<br>";
 echo "<br>";
 
 
 

 echo "<br><h1>3</h1>";
 var_dump($_SESSION);
 echo "<br>";
 echo "<br>";
 echo "<br>";
 */
 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['returnToShoppingCart'])) {
		$_SESSION['orderCountry'] = $_POST['country'];
		$_SESSION['orderCity'] = $_POST['city'];
		$_SESSION['orderStreet'] = $_POST['street'];
		$_SESSION['orderHouseNumber'] = $_POST['houseNumber'];
		$_SESSION['orderZipCode'] = $_POST['zipCode'];
 }
 
 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['number'])) {
		
		$_SESSION['productNumber'] = $_POST['number'];
		$_SESSION['image'] = $_POST['image'];
		$_SESSION['title'] = $_POST['title'];
		$_SESSION['price'] = $_POST['price'];
		$_SESSION['description'] = $_POST['description'];
		$_SESSION['stock'] = $_POST['stock'];
		$_SESSION['addedToCart'] = $_POST['addedToCart'];
	}
	
	$productNumber = (int)$_SESSION['productNumber'];
	
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['removeFromShoppingCart'])) {
				
		
		$numberOfProducts = count($_SESSION['shoppingCart']);
		//$addProduct = true;
		
		if($numberOfProducts > 0) {
			
	
			for($i = 0; $i < $numberOfProducts; $i++) {
				 foreach ($_SESSION['shoppingCart'][$i] as $productItem){
					if ($_SESSION['shoppingCart'][$i]['numberOfProduct'] == $_POST['number']) {
						if ($_SESSION['shoppingCart'][$i]['addedToCart'] > 1) {
						//$_SESSION['products'][0][$productNumber - 1]['stock'] += 1;
						//$_SESSION['products'][0][$productNumber - 1]['addedToCart'] -= 1;
						$_SESSION['shoppingCart'][$i]['stock'] += 1;
						$_SESSION['shoppingCart'][$i]['addedToCart'] -= 1;
						$_SESSION['stock'] += 1;
						$_SESSION['addedToCart'] -= 1;
						break;
						} else {
							unset($_SESSION['shoppingCart'][$i]);
							$_SESSION['shoppingCart2'] = array_values($_SESSION['shoppingCart']);
							$_SESSION['shoppingCart'] = $_SESSION['shoppingCart2'];
							//$_SESSION['products'][0][$productNumber - 1]['stock'] += 1;
						//$_SESSION['products'][0][$productNumber - 1]['addedToCart'] -= 1;
						$_SESSION['stock'] += 1;
						$_SESSION['addedToCart'] -= 1;
						}
						
						//break;
					}
						
					}
					
				}
				/*
				if($addProduct) {
					$_SESSION['shoppingCart'][] = $_SESSION['products'][0][$productNumber - 1];
					$_SESSION['products'][0][$productNumber - 1]['stock'] -= 1;
						$_SESSION['products'][0][$productNumber - 1]['addedToCart'] += 1;
						$_SESSION['shoppingCart'][$i]['stock'] -= 1;
						$_SESSION['shoppingCart'][$i]['addedToCart'] += 1;
						$_SESSION['stock'] -= 1;
						$_SESSION['addedToCart'] += 1;
				}*/
		} /*else {
			$_SESSION['shoppingCart'][] = $_SESSION['products'][0][$productNumber - 1];
			
			$_SESSION['products'][0][$productNumber - 1]['stock'] -= 1;
			$_SESSION['products'][0][$productNumber - 1]['addedToCart'] += 1;
			$_SESSION['shoppingCart'][0]['stock'] -= 1;
			$_SESSION['shoppingCart'][0]['addedToCart'] += 1;
			$_SESSION['stock'] -= 1;
			$_SESSION['addedToCart'] += 1;
			
		}*/
		
		
		
		
		
		
		
		
		
		
		
		/*
		$_SESSION['products'][0][$productNumber - 1]['stock'] += 1 ;
		$_SESSION['products'][0][$productNumber - 1]['addedToCart'] -= 1 ;
		if ($_SESSION['products'][0][$productNumber - 1]['addedToCart'] == 0) {
		unset($_SESSION['shoppingCart'][$i]);
		} else {
			$_SESSION['shoppingCart'][$i]['stock'] += 1;
		$_SESSION['shoppingCart'][$i]['addedToCart'] -= 1;
		}*/
		
		
	}
 
 
 if (empty($_SESSION['shoppingCart'])) {
	 echo "<h1>The Shopping Cart is empty</h1>";
 }
 
 foreach ($_SESSION['shoppingCart'] as $product) {
	echo '<section><h2>'.$product["title"].'</h2><article><div><img src='.$product["image"].'></div><div><p class="price"><span>Price: </span>'.$product["price"].
	'</p><p><span>Description: </span>'.$product["productdescription"].'</p><p><span>Stock: </span>'.$product["stock"].
	'</p><p><span>Added to Cart: </span>'.$product["addedToCart"].
	'</p><form method="post" action="view_cart.php"><input type="hidden" name="title" value="'.$product["title"].
	'"><input type="hidden" name="image" value="'.$product["image"].'"><input type="hidden" name="price" value="'.$product["price"].
	'"><input type="hidden" name="description" value="'.$product["description"].'"><input type="hidden" name="stock" value="'.$product["stock"].
	'"><input type="hidden" name="number" value="'.$product["numberOfProduct"].
	'"><input type="hidden" name="addedToCart" value="'.$product["addedToCart"].'"><input type="submit" name="removeFromShoppingCart" value="Remove from Shopping Cart"></form></div></article></section>';
 };
 
 
  // Upade product stock
if(isset($_POST['removeFromShoppingCart'])) {
	$productStock = $_SESSION['stock'];
	$productId = $_SESSION['productNumber'];
	/*
	echo "<br>";
	echo "<br>";
	echo "In the if we have:";
	echo "<br>";
	echo "<br>";
	echo $productStock;
	echo "<br>";
	echo "<br>";
	echo $productName;
	echo "<br>";
	echo "<br>";
	echo "<br>";
	
	echo "In the update we have:";
	*/
	// Update the product stock data when adding a product to the shopping cart
   $updateProductStock = $db->prepare('UPDATE product SET stock = :productstock WHERE id = :productid;');
   $updateProductStock->bindValue(':productid', $productId, PDO::PARAM_INT);
 $updateProductStock->bindValue(':productstock', $productStock, PDO::PARAM_INT);
 $updateProductStock->execute();
$updateProductStockOutcome = $updateProductStock->rowCount();
}

/*
echo "<br>";
	echo "<br>";
	echo "<br>";
	echo "Hello";
	echo "<br>";
	echo "<br>";
	echo $productStock;
	echo "<br>";
	echo "<br>";
	echo $productId;
	echo "<br>";
	echo "<br>";
	echo $updateProductStockOutcome;
	echo "<br>";
	echo "<br>";
	echo "<br>";
	*/
	
 /*
 echo "<br>";
	echo "<br>";
	echo "<br>";
	echo "productNumber";
	var_dump((int)$_SESSION["productNumber"]);
	echo "<br>";
	echo "<br>";
	echo "<br>";
	//echo $_SESSION["productNumber"];
	var_dump($_POST);
	echo "<br>";
	echo "<br>";
	echo "<br>";
	var_dump($_SESSION['products'][0][$productNumber - 1]);
	echo "<br>";
	echo "<br>";
	echo "<br>";
	var_dump($_SESSION['products'][0][$productNumber - 1]['stock']);
	echo "<br>";
	echo "<br>";
	echo "<br>";
	var_dump($_SESSION['products'][0]);
	echo "<br>";
	echo "<br>";
	echo "<br>";
	var_dump($_SESSION['shoppingCart']);
	echo "<br>";
	echo "<br>";
	echo "<br>";
	var_dump($_SESSION["description"]);
	echo "<br>";
	echo "<br>";
	echo "<br>";
	var_dump($quantity);
	echo "<br>";
	echo "<br>";
	echo "<br>";
	var_dump($product);
	echo "<br>";
	echo "<br>";
	echo "<br>";
	var_dump($productNumber);
	*/
 
 ?>
 
 <div class="bottomNavigationLinks">
 <div>
 <form method="post" action="browse_products.php">
<input class="navigationButton" type="submit" value="Browse Products">
</form>
</div>
<div>
 <form method="post" action="check_out.php">
<input class="navigationButton" type="submit" value="Checkout">
</form>
</div>
</div>
 
 </main>

  
  <footer>
  <?php include $_SERVER[ 'DOCUMENT_ROOT' ].'/assignments/common/footer.php'; ?>
  </footer>
 </body>
</html>
