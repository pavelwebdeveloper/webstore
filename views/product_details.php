 
<?php


// Start the session
session_start();

 if($_SESSION['purchaseCompleted'] == true){  
 // remove all session variables
session_unset();
 }
?>
<!DOCTYPE html>
<html lang="en-us">
 <head>
  <title>Product Details Page</title>
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
 
 
 <h1>This is Product Details Page</h1>
 
 <?php
 /*
 var_dump($_SESSION);
 echo "<br>";
 echo "<br>";
 echo "<br>";
 
 echo "<br>";
 
 var_dump($_SESSION);
 echo "<br>";
 echo "<br>";
 
 echo "<br>";
 echo "POST";
 var_dump($_POST);
 echo "<br>";
 echo "<br>";
 echo "<br>";

 */
 

  $product = array();
  
 /*
 echo "<br>";
 echo "<br>";
 echo "<br>";
 */
 /*
 $product["title"] = $_POST["title"];
 $product["image"] = $_POST["image"];
 $product["price"] = $_POST["price"];
 $product["description"] = $_POST["description"];
 $product["stock"] = $_POST["stock"];
 */
 
 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['id'])) {
	
		$_SESSION['productNumber'] = $_POST['id'];
		$_SESSION['image'] = $_POST['image'];
		$_SESSION['product'] = $_POST['product'];
		$_SESSION['price'] = $_POST['price'];
		$_SESSION['description'] = $_POST['productdescription'];
		$_SESSION['stock'] = $_POST['stock'];
		$_SESSION['addedToCart'] = 0;
		
	}
 
 $productNumber = (int)$_SESSION['productNumber'];
 
 

	
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['addToShoppingCart'])) {
		
		/*
		$_SESSION['products'][0][$productNumber - 1]['stock'] -= 1;
		$_SESSION['products'][0][$productNumber - 1]['addedToCart'] += 1;
		
		
		$quantity = count($_SESSION['shoppingCart']);
		$i = $quantity - 1;
		*/
		
		$numberOfProducts = count($_SESSION['shoppingCart']);
		$addProduct = true;
		
		if($numberOfProducts > 0) {
			
	
			for($i = 0; $i < $numberOfProducts; $i++) {
				 foreach ($_SESSION['shoppingCart'][$i] as $productItem){
					if ($_SESSION['shoppingCart'][$i]['numberOfProduct'] == $_SESSION['productNumber']) {
						
						//$_SESSION['products'][0][$productNumber - 1]['stock'] -= 1;
						//$_SESSION['products'][0][$productNumber - 1]['addedToCart'] += 1;
						$_SESSION['shoppingCart'][$i]['stock'] -= 1;
						$_SESSION['shoppingCart'][$i]['addedToCart'] += 1;
						$_SESSION['stock'] -= 1;
						$_SESSION['addedToCart'] += 1;
						
						$addProduct = false;
					}
						break;
					}
				}
				if($addProduct) {
					$numberOfProducts = count($_SESSION['shoppingCart']);
					$j = $numberOfProducts;
					$_SESSION['shoppingCart'][$j]['numberOfProduct'] = $_SESSION['productNumber'];
					$_SESSION['shoppingCart'][$j]['image'] = $_SESSION['image'];
					$_SESSION['shoppingCart'][$j]['product'] = $_SESSION['product'];
					$_SESSION['shoppingCart'][$j]['price'] = $_SESSION['price'];
					$_SESSION['shoppingCart'][$j]['productdescription'] = $_SESSION['description'];
					$_SESSION['shoppingCart'][$j]['stock'] = $_SESSION['stock'] - 1;
					$_SESSION['shoppingCart'][$j]['addedToCart'] = $_SESSION['addedToCart'] + 1;
					//$_SESSION['products'][0][$productNumber - 1]['stock'] -= 1;
						//$_SESSION['products'][0][$productNumber - 1]['addedToCart'] += 1;
						//$_SESSION['shoppingCart'][$j]['stock'] -= 1;
						//$_SESSION['shoppingCart'][$j]['addedToCart'] += 1;
						$_SESSION['stock'] -= 1;
						$_SESSION['addedToCart'] += 1;
				}
		} else {
			$numberOfProducts = count($_SESSION['shoppingCart']);
					$j = $numberOfProducts;
					$_SESSION['shoppingCart'][$j]['numberOfProduct'] = $_SESSION['productNumber'];
					$_SESSION['shoppingCart'][$j]['image'] = $_SESSION['image'];
					$_SESSION['shoppingCart'][$j]['product'] = $_SESSION['product'];
					$_SESSION['shoppingCart'][$j]['price'] = $_SESSION['price'];
					$_SESSION['shoppingCart'][$j]['productdescription'] = $_SESSION['description'];
					$_SESSION['shoppingCart'][$j]['stock'] = $_SESSION['stock'] - 1;
					$_SESSION['shoppingCart'][$j]['addedToCart'] = $_SESSION['addedToCart'] + 1;
					//$_SESSION['products'][0][$productNumber - 1]['stock'] -= 1;
						//$_SESSION['products'][0][$productNumber - 1]['addedToCart'] += 1;
						//$_SESSION['shoppingCart'][$j]['stock'] -= 1;
						//$_SESSION['shoppingCart'][$j]['addedToCart'] += 1;
						$_SESSION['stock'] -= 1;
						$_SESSION['addedToCart'] += 1;
			
		}
		
		
		
		
	}
	
	
	/*
	echo "<section><h2>".$_SESSION['title']."</h2><article><div><img src=".$_SESSION['image']."></div><div><p class='price'><span>Price: </span>".
	$_SESSION['price']."</p><p><span>Description: </span>".$_SESSION['description']."</p><p><span>Stock: </span>".$_SESSION['stock'].
	"</p><form action='product_details.php' method='post'><input type='submit' name='addToShoppingCart' value='Add to Shopping Cart'></form></div></article></section>";
	*/
	
	echo "<section><h2>".$_SESSION['product']."</h2><article><div><img src=".$_SESSION['image']."></div><div><p class='price'><span>Price: </span>".
	$_SESSION['price']."</p><p><span>Description: </span>".$_SESSION['description']."</p><p><span>Stock: </span>".$_SESSION['stock'].
	"</p><input type='hidden' name='productNumber' value='".$_SESSION['productNumber']."'><form action='product_details.php' method='post'><input type='submit' name='addToShoppingCart' value='Add to Shopping Cart'></form></div></article></section>";
	
 
 /*
 echo "<br>";
	echo "<br>";
	echo "<br>";
	echo "Post";
	echo $_POST;
	echo "<br>";
	echo "<br>";
	echo "PostAddToShoppingCart";
	echo $_POST['addToShoppingCart'];
	echo "<br>";
	echo "<br>";
	echo "sessionstock";
	echo "<br>";
	echo "<br>";
	echo $_SESSION['stock'];
	echo "<br>";
	echo "<br>";
	echo "sessionproduct";
	echo "<br>";
	echo "<br>";
	echo $_SESSION['product'];
	echo "<br>";
	echo "<br>";
	echo "<br>";
 */
 
 // Upade product stock
if(isset($_POST['addToShoppingCart'])) {
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

	// Filter and store the data
	/*
	echo "<section><h2>".$_SESSION['products'][0][$productNumber - 1]['title']."</h2><article><div><img src=".$_SESSION['products'][0][$productNumber - 1]['image']."></div><div><p class='price'><span>Price: </span>".
	$_SESSION['products'][0][$productNumber - 1]['price']."</p><p><span>Description: </span>".$_SESSION['products'][0][$productNumber - 1]['description']."</p><p><span>Stock: </span>".$_SESSION['products'][0][$productNumber - 1]['stock'].
	"</p><input type='hidden' name='productNumber' value='".$_SESSION['products'][0][$productNumber - 1]['numberOfProduct']."'><form action='product_details.php' method='post'><input type='submit' name='addToShoppingCart' value='Add to Shopping Cart'></form></div></article></section>";
	*/
	
// echo 
	
	
	/*
	function addToShoppingCart(){
		global $product;
		global $productNumber;
		$product[0] = $productNumber;
		$product[1] = $_SESSION['image'];
		$cars = array("BMW", "Mercedez");
		$_SESSION['shoppingCart'][] = $cars;
	}*/
	
	/*
	echo "<br>";
	echo "<br>";
	echo "<br>";
	var_dump($_SESSION);
	
	
	echo "<br>";
	echo "<br>";
	echo "<br>";
	//echo $_SESSION["productNumber"];
	echo $productNumber;
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
	echo "<br>";
	echo "<br>";
	echo "<br>";
	var_dump($numberOfProducts);
	*/
 
 ?>
 
 </main>

  
  <footer>
  <?php include $_SERVER[ 'DOCUMENT_ROOT' ].'/assignments/common/footer.php'; ?>
  </footer>
 </body>
</html>
</html>