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
  <title>Manage Products Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/online_store_styles.css" rel="stylesheet" media="screen">
  <link href="css/normalize.css" rel="stylesheet" media="screen">
 </head>
 <body>
 <header>
 <?php include $_SERVER[ 'DOCUMENT_ROOT' ].'/assignments/common/header.php'; ?>
 </header>
 <h1>Manage Products Page</h1>
 <main>
 
 
 
 <?php
 // Get the database connection file
 require_once '../library/connections.php';
 // Query the product department data
   $getDepartment = $db->prepare('SELECT * FROM productdepartment');
$getDepartment->execute();
$departments = $getDepartment->fetchAll(PDO::FETCH_ASSOC);
 // Build a dynamic drop-down select list using the $departments array
 $departmentList .= '<select name="departmentId" id="departmentId">';
 $departmentList .= '<option disabled selected>Choose a department</option>';
 foreach ($departments as $department) {
 /*$catList .= "<option value=".urlencode($category['categoryId']).">".urlencode($category['categoryName'])."</option>";*/
  $departmentList .= "<option value='$department[id]'";
  if(isset($departmentId)) {
   
   if($department['id'] === $departmentId){
    $departmentList .= ' selected ';
   }
  }
  
  $departmentList .= ">$department[productdepartmentname]</option>";
 }
 $departmentList .= '</select>';
 ?>
 
 
 <?php
   if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
   } elseif (isset($message)) {
    echo $message;
   }
   
   ?>
   <div>
   <form action="add_product.php" method="post">
    <fieldset>
	<legend>Choose department in which you want to add a product</legend>
     <label for="departmentName">Department Name</label><br>
     <?php
	echo $departmentList;
 ?><br><br>
	 <input class="submitBtn" type="submit" value="Add product">
     <!-- Add the action name - value pair -->
     <!--<input type="hidden" name="AddProduct" value="addProduct">-->
    </fieldset>
   </form>
   </div>
   
   <br>
   <br>
   
   
   
   <?php
   
   
   
 $getProducts = $db->prepare('SELECT id, product, image FROM product ORDER BY product ASC'); 
$getProducts->execute();
$products = $getProducts->fetchAll(PDO::FETCH_ASSOC);
$prodList = '<table>';
    $prodList .= '<thead>';
    $prodList .= '<tr><th>Product Name</th><td>&nbsp;</td><td>&nbsp;</td></tr>';
    $prodList .= '</thead>';
    $prodList .= '<tbody>';
    foreach ($products as $product) {
     $prodList .= "<tr><td>$product[product]</td>";
     $prodList .= "<td><a class='tablelink' href='update_product.php?id=$product[id]' title='Click to modify'>Update</a></td>";
     $prodList .= "<td><a class='tablelink' href='delete_product.php?id=$product[id]' title='Click to delete'>Delete</a></td>";
    }
    $prodList .= '</tbody></table>';
 ?>
 
 <div>
 <h2>Product List</h2>
 
 <?php

echo $prodList;

 ?>
 
 </div>
 </main>
 <footer>
  <?php include $_SERVER[ 'DOCUMENT_ROOT' ].'/assignments/common/footer.php'; ?>
  </footer>
 </body>
</html>