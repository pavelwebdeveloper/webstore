
 
 <h1>This is View Cart Page</h1>
 
 <?php
 
 
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
		
		
		if($numberOfProducts > 0) {
			
	
			for($i = 0; $i < $numberOfProducts; $i++) {
				 foreach ($_SESSION['shoppingCart'][$i] as $productItem){
					if ($_SESSION['shoppingCart'][$i]['numberOfProduct'] == $_POST['number']) {
						if ($_SESSION['shoppingCart'][$i]['addedToCart'] > 1) {
						
						$_SESSION['shoppingCart'][$i]['stock'] += 1;
						$_SESSION['shoppingCart'][$i]['addedToCart'] -= 1;
						$_SESSION['stock'] += 1;
						$_SESSION['addedToCart'] -= 1;
						break;
						} else {
							unset($_SESSION['shoppingCart'][$i]);
							$_SESSION['shoppingCart2'] = array_values($_SESSION['shoppingCart']);
							$_SESSION['shoppingCart'] = $_SESSION['shoppingCart2'];
							
						$_SESSION['stock'] += 1;
						$_SESSION['addedToCart'] -= 1;
						}
						
						//break;
					}
						
					}
					
				}
				
		} 
		
		
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
	changeProductStock();
}


	
 
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
 
 