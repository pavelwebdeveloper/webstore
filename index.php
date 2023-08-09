<?php

// Start the session
//session_destroy(); 
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

                     

                         if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['productID'])) {
                             
                             
                             
                                        $_SESSION['productID'] = $_POST['productID'];
                                        $_SESSION['productImage'] = $_POST['productImage'];
                                        $_SESSION['productName'] = $_POST['productName'];
                                        $_SESSION['productPrice'] = $_POST['productPrice'];
                                        $_SESSION['productDescription'] = $_POST['productDescription'];
                                        $_SESSION['productStock'] = $_POST['productStock'];
                                        $_SESSION['addedToCart'] = 0;

                                }

                         $productNumber = (int)$_SESSION['productID'];




                                if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['addToShoppingCart'])) {

                                        

                                        $numberOfProducts = count($_SESSION['shoppingCart']);
                                        $addProduct = true;

                                        if($numberOfProducts > 0) {


                                                for($i = 0; $i < $numberOfProducts; $i++) {
                                                         foreach ($_SESSION['shoppingCart'][$i] as $productItem){
                                                                if ($_SESSION['shoppingCart'][$i]['productID'] == $_SESSION['productID']) {

                                                                        
                                                                        $_SESSION['shoppingCart'][$i]['productStock'] -= 1;
                                                                        $_SESSION['shoppingCart'][$i]['addedToCart'] += 1;
                                                                        $_SESSION['productStock'] -= 1;
                                                                        $_SESSION['addedToCart'] += 1;

                                                                        $addProduct = false;
                                                                }
                                                                        break;
                                                                }
                                                        }
                                                        if($addProduct) {
                                                                $numberOfProducts = count($_SESSION['shoppingCart']);
                                                                $j = $numberOfProducts;
                                                                $_SESSION['shoppingCart'][$j]['productID'] = $_SESSION['productID'];
                                                                $_SESSION['shoppingCart'][$j]['productImage'] = $_SESSION['productImage'];
                                                                $_SESSION['shoppingCart'][$j]['productName'] = $_SESSION['productName'];
                                                                $_SESSION['shoppingCart'][$j]['productPrice'] = $_SESSION['productPrice'];
                                                                $_SESSION['shoppingCart'][$j]['productDescription'] = $_SESSION['productDescription'];
                                                                $_SESSION['shoppingCart'][$j]['productStock'] = $_SESSION['productStock'] - 1;
                                                                $_SESSION['shoppingCart'][$j]['addedToCart'] = $_SESSION['addedToCart'] + 1;
                                                                
                                                                        $_SESSION['productStock'] -= 1;
                                                                        $_SESSION['addedToCart'] += 1;
                                                        }
                                        } else {
                                                $numberOfProducts = count($_SESSION['shoppingCart']);
                                                                $j = $numberOfProducts;
                                                                $_SESSION['shoppingCart'][$j]['productID'] = $_SESSION['productID'];
                                                                $_SESSION['shoppingCart'][$j]['productImage'] = $_SESSION['productImage'];
                                                                $_SESSION['shoppingCart'][$j]['productName'] = $_SESSION['productName'];
                                                                $_SESSION['shoppingCart'][$j]['productPrice'] = $_SESSION['productPrice'];
                                                                $_SESSION['shoppingCart'][$j]['productDescription'] = $_SESSION['productDescription'];
                                                                $_SESSION['shoppingCart'][$j]['productStock'] = $_SESSION['productStock'] - 1;
                                                                $_SESSION['shoppingCart'][$j]['addedToCart'] = $_SESSION['addedToCart'] + 1;
                                                                
                                                                        $_SESSION['productStock'] -= 1;
                                                                        $_SESSION['addedToCart'] += 1;
                                        }
                                }
                                
                                
                                if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['returnedFromShoppingCart'])){
                                 
                                    $productFromCart = getProduct($_GET['productID']);
                                    
                                    $productDetails = showProductDetails($productFromCart, $productDepartmentID);
                                } else {
                                    $productDetails = showProductDetails($_SESSION, $productDepartmentID);
                                }
                                
                        
                        
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
                       
            
             if(isset($_GET['departmentId'])) {            

                   $productDepartmentID = filter_input(INPUT_GET, 'departmentId', FILTER_VALIDATE_INT);
                   $productGroupID = filter_input(INPUT_GET, 'groupId', FILTER_VALIDATE_INT);
                   $productDepartmentName = filter_input(INPUT_GET, 'productgroupname', FILTER_SANITIZE_STRING);

                   $productGroup = getProducts($productGroupID);                   
                   } 
            
            
            
            
            if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['returnToShoppingCart'])) {
		$_SESSION['orderCountry'] = $_POST['country'];
		$_SESSION['orderCity'] = $_POST['city'];
		$_SESSION['orderStreet'] = $_POST['street'];
		$_SESSION['orderHouseNumber'] = $_POST['houseNumber'];
		$_SESSION['orderZipCode'] = $_POST['zipCode'];
 }
 
 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['productID'])) {
		
		$_SESSION['productID'] = $_POST['productID'];
		$_SESSION['productImage'] = $_POST['productImage'];
		$_SESSION['productName'] = $_POST['productName'];
		$_SESSION['productPrice'] = $_POST['productPrice'];
		$_SESSION['productDescription'] = $_POST['productDescription'];
		$_SESSION['productStock'] = $_POST['productStock'];
		$_SESSION['addedToCart'] = $_POST['addedToCart'];
	}
	
        if(isset($_SESSION['productID'])){
            $productNumber = (int)$_SESSION['productID'];
        }
	
	if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['removeFromShoppingCart'])) {
				
		
		$numberOfProducts = count($_SESSION['shoppingCart']);
		
		
		if($numberOfProducts > 0) {
           
			
                        //echo $numberOfProducts;
			for($i = 0; $i < $numberOfProducts; $i++) {
                
                            
				 foreach ($_SESSION['shoppingCart'][$i] as $productItem){
                                     
					if ($_SESSION['shoppingCart'][$i]['productID'] == $_POST['productID']) {
						if ($_SESSION['shoppingCart'][$i]['addedToCart'] > 1) {
						
						$_SESSION['shoppingCart'][$i]['productStock'] += 1;
						$_SESSION['shoppingCart'][$i]['addedToCart'] -= 1;
						$_SESSION['productStock'] += 1;
						$_SESSION['addedToCart'] -= 1;
                                                /*if($_SESSION['addedToCart'] == 0){
                                                   unset($_SESSION['shoppingCart'][$i]); 
                                                }*/
						break;
						} else {
							unset($_SESSION['shoppingCart'][$i]);
							$_SESSION['shoppingCart2'] = array_values($_SESSION['shoppingCart']);
							$_SESSION['shoppingCart'] = $_SESSION['shoppingCart2'];
							
						$_SESSION['productStock'] += 1;
						$_SESSION['addedToCart'] -= 1;
                                                
                                                
                                                break;
						}
						
						
					}
						
					}
					//$numberOfProducts = count($_SESSION['shoppingCart']);
				}
			
		} 
		
		
        } elseif($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['removeFromShoppingCartCompletely'])){
            $numberOfProducts = count($_SESSION['shoppingCart']);
		
		
		if($numberOfProducts > 0) {
           
			
                        //echo $numberOfProducts;
			for($i = 0; $i < $numberOfProducts; $i++) {
                
                            
				 foreach ($_SESSION['shoppingCart'][$i] as $productItem){
                                     
                                     
                                     
					if ($_SESSION['shoppingCart'][$i]['productID'] == $_POST['productID']) {
                                            
                                           
                                            array_splice($_SESSION['shoppingCart'],$i,1);
                                        
                                            	$_SESSION['productStock'] += $_SESSION['addedToCart'];
						$_SESSION['addedToCart'] = 0;
                                            
                                            
                                        }
                                        
                                        break;
                                 }
                                 
                                 if(count($_SESSION['shoppingCart']) == 1){
                                                break;
                                            }
                        }
                }
        }
 
        $productsInCart = '';
        
        

        if (empty($_SESSION['shoppingCart'])) {
            cart:
                $productsInCart = "<h1>The Shopping Cart is empty</h1>";
        }

//echo var_dump($_SESSION['shoppingCart']);
        

        foreach ($_SESSION['shoppingCart'] as $product) {
            
            //echo var_dump($product);
            //if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['returnToShoppingCart'])) {
            if(($_SERVER['REQUEST_METHOD'] == "GET" and isset($_GET['returnToShoppingCart'])) || ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['returnToShoppingCart']))) {
               $productsInCart .= showProductsInCart($product);
               } else {
                   $productsInCart .= showProductsInCart($product, $productDepartmentID, $productGroupID, $productDepartmentName);
               }
        };


         // Upade product stock
       if(isset($_POST['removeFromShoppingCart']) || isset($_POST['removeFromShoppingCartCompletely'])) {
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
                   echo $_SESSION['loggedin'].'?????????????????????';
                   
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
            
            
            showDefaultPage($products, $productDepartmentsNavList);
            
        break;
 
        case 'showSignUpPage':
           
           unset($_SESSION['message']);
            
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
        
        case 'manage_account':
            
        // Start the session
        
        if(!($_SESSION['loggedin'])){header('Location: home.php');}
        // Create an array for the shopping cart in the session
        if (!isset($_SESSION['shoppingCart'])) {
         $_SESSION['shoppingCart'] = array();
         $_SESSION['products'] = array();
         }
         
         $pageTitle = 'Manage Account';
         $page = 'manage_account';
         include 'views/index.php';  
            
        break;
        
        case 'update_account':
            
        // Start the session
        
        
            
        break;
    
        case 'check_out':
            
            if(empty($_SESSION['shoppingCart'])){
                goto cart;
            }
            
            
            if(isset($_SESSION['orderCountry'])){
            $country = $_SESSION['orderCountry'];
            }
            if(isset($_SESSION['orderCity'])){
		$city = $_SESSION['orderCity'];
            }
            if(isset($_SESSION['orderStreet'])){
		$street = $_SESSION['orderStreet'];
            }
            if(isset($_SESSION['orderHouseNumber'])){
		$houseNumber = $_SESSION['orderHouseNumber'];
            }
            if(isset($_SESSION['orderZipCode'])){
		$zipCode = $_SESSION['orderZipCode'];
            }
            
            $pageTitle = 'Check Out';
         $page = 'check_out';
         include 'views/index.php';  
            
        break;
        
        case 'purchase_confirmation':
            
            
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
                    
                    $purchasedProducts = '';

                    if (empty($_SESSION['shoppingCart'])) {
                             $purchasedProducts = "<h1>The Shopping Cart is empty</h1>";
                     } else {
                             $purchasedProducts = "<h1>These are the products that you have purchased</h1><br><br>";


                    foreach ($_SESSION['shoppingCart'] as $product) {
                            $purchasedProducts .= '<section><h2>'.$product["productName"].'</h2><article><div><img src='.$product["productImage"].'></div><div><p class="price"><span>Price per item: </span>'.$product["productPrice"].
                            '</p><p><span>Description: </span>'.$product["productDescription"].'</p><p><span>Purchased: </span>'.$product["addedToCart"].'</p></div></article></section>';


                     };

                     $purchasedProducts .= "<h1>The products that you have purchased will be shipped to the following address</h1><br><br>";
                    $purchasedProducts .= "<div id='customerInformation'><span><b>Country:</b></span> ".$country."<br>";
                    $purchasedProducts .= "<span><b>City:</b></span> ".$city."<br>";
                    $purchasedProducts .= "<span><b>Street:</b></span> ".$street."<br>";
                    $purchasedProducts .= "<span><b>House number:</b></span> ".$houseNumber."<br>";
                    $purchasedProducts .= "<span><b>Zip code:</b></span> ".$zipCode."<br></div>";

                    $_SESSION['purchaseCompleted'] = true;
                     }
            
                     unset($_SESSION['shoppingCart']);
                     
            $pageTitle = 'Purchase Confirmation';
         $page = 'purchase_confirmation';
         include 'views/index.php';  
            
        break;

        default:
            
            
            showDefaultPage($products, $productDepartmentsNavList);
             
        break;
	 }
 

?>
