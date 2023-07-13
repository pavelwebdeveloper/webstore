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
                   
                   $productsList = showProducts($productGroup); 

               $pageTitle = $productDepartmentName . ' product group';
               $page = 'productgroup';
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

                   // Check for missing data
                   if(empty($userEmail) || empty($userPassword)){
                    $_SESSION['message'] = "<p class='messagefailure'>Please, provide a valid email address and password.</p>";
                        header("Location: ./index?action=showLoginPage");
                    exit;
                   }

                   // Query the client data based on the email address
                   $getUserData = $db->prepare('SELECT id, username, email, password, userlevel FROM storeuser WHERE email=:userEmail');
                    $getUserData->bindValue(':userEmail', $userEmail, PDO::PARAM_STR);
                    $getUserData->execute();
                    $userData = $getUserData->fetch(PDO::FETCH_ASSOC);



                   // Compare the password just submitted against
                   // the hashed password for the matching client
                   $hashCheck = password_verify($userPassword, $userData['password']);


                   // If the hashes don't match create an error
                   // and return to the login view
                   if(!$hashCheck) {
                    $_SESSION['message'] = "<p class='messagefailure'>Please, check your password and try again.</p>";
                    header("Location: ./index?action=showLoginPage");
                    exit;
                   }
                    // A valid user exists, log them in
                   $_SESSION['loggedin'] = TRUE;
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
                    header("Location: ./index?action=showSignUpPage");
                exit;
               }


               // Hash the checked password
               $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);


               $stmt = $db->prepare('INSERT INTO storeuser (username, email, password, userlevel) VALUES (:username, :useremail, :userpassword, 1)'); 
               $stmt->bindValue(':username', $userName, PDO::PARAM_STR);
               $stmt->bindValue(':useremail', $userEmail, PDO::PARAM_STR);
               $stmt->bindValue(':userpassword', $hashedPassword, PDO::PARAM_STR);
               $stmt->execute();


            $signUpOutcome = $stmt->rowCount();


               // Check and report the result and create the cookie when the individual registers with the site
               if($signUpOutcome === 1){
                $_SESSION['message'] = "<p class='messagesuccess'>Thanks for registering. Please, use your email and password to login.</p>";
                header("Location: ./index?action=showLoginPage");
               exit;
               } else {
                $message = "<p class='messagefailure'>Sorry, but the registration failed. Please, try again.</p>";
                    header("Location: ./index?action=showSignUpPage");
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
             $productsList = showProducts($products, true); 
             include 'views/index.php';
             
        break;
	 }
 

?>
