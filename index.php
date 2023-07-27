<?php

// Start the session

session_start();
// Create an array for the shopping cart in the session
if (!isset($_SESSION['shoppingCart'])) {
 $_SESSION['shoppingCart'] = array();
 $_SESSION['products'] = array();
 }
// Create an array for the shopping cart in the session
// Get the value from the action name - value pair
 $action = filter_input(INPUT_POST, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
 }
 
 
 require_once 'library/connections.php';
 require_once 'library/functions.php';
 // Get the online store model for use as needed
 require_once 'model/online-store-model.php';
 $productdepartments = getProductDepartments();
 $products = getProducts();
 
 
 $productDepartmentsNavList = buildProductDepartmentsNavList($productdepartments);
 
 
 
 
 switch ($action){
     
        case 'products':
         
            if(isset($_POST['searchProduct'])) {            

               $product = filter_input(INPUT_POST, 'searchProduct', FILTER_SANITIZE_STRING);

               $searchValue = $product;

               $foundproducts = findProducts($product);

               if (empty($foundproducts)) {
                       $productsList = "";
                   
               } else {
                   $productsList = showProducts($foundproducts); 
               }
            } else {
                $productsList = showProducts($products); 
            }

           $pageTitle = 'All products';
           $page = 'browse_products';
           
           include 'views/index.php';
        break;
        
        case 'showProductGroups':
         
                if(isset($_GET['departmentId'])) {            

                   $productDepartmentID = filter_input(INPUT_GET, 'departmentId', FILTER_VALIDATE_INT);
                   $productDepartmentName = filter_input(INPUT_GET, 'productdepartmentname', FILTER_SANITIZE_STRING);

                   $productGroups = getProductsGroups($productDepartmentID);                   
                   } 
                   
                   $productDepartmentsNavList = buildProductDepartmentsNavList($productdepartments, $productDepartmentID, true);

               $pageTitle = $productDepartmentName . ' product group';
               $page = 'productgroups';
               include 'views/index.php';
        break;
        
        case 'showProductGroup':
         
                if(isset($_GET['departmentId'])) {            

                   $productDepartmentID = filter_input(INPUT_GET, 'departmentId', FILTER_VALIDATE_INT);
                   $productGroupID = filter_input(INPUT_GET, 'groupId', FILTER_VALIDATE_INT);
                   $productDepartmentName = filter_input(INPUT_GET, 'productgroupname', FILTER_SANITIZE_STRING);

                   $productGroup = getProducts($productGroupID);                   
                   } 
                   
                   $productDepartmentsNavList = buildProductDepartmentsNavList($productdepartments, $productDepartmentID, true);
                   
                   $productsList = showProducts($productGroup, $productDepartmentID); 

               $pageTitle = $productDepartmentName . ' product group';
               $page = 'productgroup';
               include 'views/index.php';
        break;
        
        case 'showProductDetails':
         
                if(isset($_GET['departmentId'])) {            

                   $productDepartmentID = filter_input(INPUT_GET, 'departmentId', FILTER_VALIDATE_INT);
                   $productGroupID = filter_input(INPUT_GET, 'groupId', FILTER_VALIDATE_INT);
                   $productDepartmentName = filter_input(INPUT_GET, 'productgroupname', FILTER_SANITIZE_STRING);

                   $productGroup = getProducts($productGroupID);                   
                   } 
                   
                   $productDepartmentsNavList = buildProductDepartmentsNavList($productdepartments, $productDepartmentID, true);
                   
                   $productsList = showProducts($productGroup, $productDepartmentID); 
                   
                   
                   
                   
                   
                   
                                            
               
                        

                        
                         $product = array();

                     

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

                                        

                                        $numberOfProducts = count($_SESSION['shoppingCart']);
                                        $addProduct = true;

                                        if($numberOfProducts > 0) {


                                                for($i = 0; $i < $numberOfProducts; $i++) {
                                                         foreach ($_SESSION['shoppingCart'][$i] as $productItem){
                                                                if ($_SESSION['shoppingCart'][$i]['numberOfProduct'] == $_SESSION['productNumber']) {

                                                                        
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
                                                                
                                                                        $_SESSION['stock'] -= 1;
                                                                        $_SESSION['addedToCart'] += 1;
                                        }
                                }
                                $productDetails = "<section><h2>".$_SESSION['product']."</h2><article><div><img src=".$_SESSION['image']."></div><div><p class='price'><span>Price: </span>".
                                $_SESSION['price']."</p><p><span>Description: </span>".$_SESSION['description']."</p><p><span>Stock: </span>".$_SESSION['stock'].
                                "</p><input type='hidden' name='productNumber' value='".$_SESSION['productNumber']."'><form action='./index.php?action=showProductDetails&departmentId=$productDepartmentID' method='post'><input type='submit' name='addToShoppingCart' value='Add to Shopping Cart'></form></div></article></section>";
                        
                        
                        // Upade product stock
                        if(isset($_POST['addToShoppingCart'])) {
                                changeProductStock();
                        }
                            
                   
                   
                   
                   

               $pageTitle = $productDepartmentName . ' product group';
               $page = 'product_details';
               include 'views/index.php';
        break;
        
        case 'addProductToShoppingCart':
         
                if(isset($_GET['departmentId'])) {            

                   $productDepartmentID = filter_input(INPUT_GET, 'departmentId', FILTER_VALIDATE_INT);
                   $productGroupID = filter_input(INPUT_GET, 'groupId', FILTER_VALIDATE_INT);
                   $productDepartmentName = filter_input(INPUT_GET, 'productgroupname', FILTER_SANITIZE_STRING);

                   $productGroup = getProducts($productGroupID);                   
                   } 
                   
                   $productDepartmentsNavList = buildProductDepartmentsNavList($productdepartments, $productDepartmentID, true);
                   
                   $productsList = showProducts($productGroup); 

               $pageTitle = $productDepartmentName . ' product group';
               $page = 'product_details';
               include 'views/index.php';
        break;
        
        case 'view_cart':
            
            
            
            
            
            
            
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
           
			
                        //echo $numberOfProducts;
			for($i = 0; $i < $numberOfProducts; $i++) {
                
                            
				 foreach ($_SESSION['shoppingCart'][$i] as $productItem){
                                     
					if ($_SESSION['shoppingCart'][$i]['numberOfProduct'] == $_POST['number']) {
						if ($_SESSION['shoppingCart'][$i]['addedToCart'] > 1) {
						
						$_SESSION['shoppingCart'][$i]['stock'] += 1;
						$_SESSION['shoppingCart'][$i]['addedToCart'] -= 1;
						$_SESSION['stock'] += 1;
						$_SESSION['addedToCart'] -= 1;
                                                /*if($_SESSION['addedToCart'] == 0){
                                                   unset($_SESSION['shoppingCart'][$i]); 
                                                }*/
						break;
						} else {
							unset($_SESSION['shoppingCart'][$i]);
							$_SESSION['shoppingCart2'] = array_values($_SESSION['shoppingCart']);
							$_SESSION['shoppingCart'] = $_SESSION['shoppingCart2'];
							
						$_SESSION['stock'] += 1;
						$_SESSION['addedToCart'] -= 1;
                                                
                                                
                                                break;
						}
						
						
					}
						
					}
					//$numberOfProducts = count($_SESSION['shoppingCart']);
				}
			
		} 
		
		
	}
 
 $productsInCart = '';
        
 if (empty($_SESSION['shoppingCart'])) {
	 $productsInCart = "<h1>The Shopping Cart is empty</h1>";
 }
 
 
 
 foreach ($_SESSION['shoppingCart'] as $product) {
	$productsInCart .= '<section><h2>'.$product["product"].'</h2><article><div><img src='.$product["image"].'></div><div><p class="price"><span>Price: </span>'.$product["price"].
	'</p><p><span>Description: </span>'.$product["productdescription"].'</p><p><span>Stock: </span>'.$product["stock"].
	'</p><p><span>Added to Cart: </span>'.$product["addedToCart"].
	'</p><form method="post" action="./index.php?action=view_cart"><input type="hidden" name="title" value="'.$product["product"].
	'"><input type="hidden" name="image" value="'.$product["image"].'"><input type="hidden" name="price" value="'.$product["price"].
	'"><input type="hidden" name="description" value="'.$product["productdescription"].'"><input type="hidden" name="stock" value="'.$product["stock"].
	'"><input type="hidden" name="number" value="'.$product["numberOfProduct"].
	'"><input type="hidden" name="addedToCart" value="'.$product["addedToCart"].'"><input type="submit" name="removeFromShoppingCart" value="Remove from Shopping Cart"></form></div></article></section>';
 };
 
 
  // Upade product stock
if(isset($_POST['removeFromShoppingCart'])) {
	changeProductStock();
}


	
            
            
            
            
            
            
            
            
            
            
            
         
           $pageTitle = 'View Cart Page';
           $page = 'view_cart';
           include 'views/index.php';   
            
        break;
         
        case 'showLoginPage':
         
           $pageTitle = 'LogIn Page';
           $page = 'login_page';
           include 'views/index.php';   
            
        break;
    
        case 'login':
            
            if(isset($_POST['LogIn'])) {
                        // Filter and store the data
                   $userEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_EMAIL);
                   $userPassword = filter_input(INPUT_POST, 'userPassword', FILTER_SANITIZE_STRING);

                   echo $userEmail;
                   echo $userPassword;
                   
                   // Check for missing data
                   if(empty($userEmail) || empty($userPassword)){
                    $_SESSION['message'] = "<p class='messagefailure'>Please, provide a valid email address and password.</p>";
                        header("Location: ./index.php?action=showLoginPage");
                    exit;
                   }
                   
                   

                   $userData = loginUser($userEmail);

                   

                   // Compare the password just submitted against
                   // the hashed password for the matching client
                   $hashCheck = password_verify($userPassword, $userData['password']);


                   // If the hashes don't match create an error
                   // and return to the login view
                   if(!$hashCheck) {
                    $_SESSION['message'] = "<p class='messagefailure'>Please, check your password and try again.</p>";
                    header("Location: ./index.php?action=showLoginPage");
                    exit;
                   }
                    // A valid user exists, log them in
                   $_SESSION['loggedin'] = TRUE;
                   echo $_SESSION['loggedin'];
                   exit;
                   // Remove the password from the array
                   // the array_splice function removes the specified
                   // element from an array

                   array_splice($userData,3,1);


                   // Store the array into the session
                   $_SESSION['userData'] = $userData;
                   $_SESSION['message'] = '';
                   // Send them to the admin view
                   header("Location: ./index.php");
                   exit;

                }
         
           $pageTitle = 'LogIn Page';
           $page = 'login_page';
           include 'views/index.php';   
            
        break;
         
        case 'Logout':
         
            $_SESSION = [];
            session_destroy();   
            
        break;
 
        case 'showSignUpPage':
         
           $pageTitle = 'SignUp Page';
           $page = 'signup_page';
           include 'views/index.php';   
            
        break;
    
        
        case 'signUp':
            
               if(isset($_POST['SignUp'])) {
                    // Filter and store the data
               $userName = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_STRING);
               $userEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_EMAIL);
               $userPassword = filter_input(INPUT_POST, 'userPassword', FILTER_SANITIZE_STRING);
                // Check for missing data
               if(empty($userName) || empty($userEmail) || empty($userPassword)){
                $message = '<p class="messagefailure">Please, provide information correctly for all form fields.</p>';
                    header("Location: index.php?action=showSignUpPage");
                exit;
               }


               // Hash the checked password
               $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);


               $signUpOutcome = addUser($userName, $userEmail, $hashedPassword);


               // Check and report the result and create the cookie when the individual registers with the site
               if($signUpOutcome === 1){
                $_SESSION['message'] = "<p class='messagesuccess'>Thanks for registering. Please, use your email and password to login.</p>";
                header("Location: index.php?action=showLoginPage");
               exit;
               } else {
                $message = "<p class='messagefailure'>Sorry, but the registration failed. Please, try again.</p>";
                    header("Location: index.php?action=showSignUpPage");
                exit;
               }

            }
         
           $pageTitle = 'SignUp Page';
           $page = 'signup_page';
           include 'views/index.php';   
            
        break;

        default:
            $pageTitle = 'Home page';
             $page = 'home';  
             $productsList = showProducts($products, 0, true); 
             include 'views/index.php';
             
        break;
	 }
 

?>
