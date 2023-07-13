<?php
// Start the session
session_start();
if(!($_SESSION['loggedin'])){header('Location: home.php');}
// Create an array for the shopping cart in the session
if (!isset($_SESSION['shoppingCart'])) {
 $_SESSION['shoppingCart'] = array();
 $_SESSION['products'] = array();
 }
?>
<!DOCTYPE html>
<html lang="en-us" id="logInRegister">
 <head>
  <title>Manage Account Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/online_store_styles.css" rel="stylesheet" media="screen">
  <link href="css/normalize.css" rel="stylesheet" media="screen">
 </head>
 <body>
 <header>
 <?php include $_SERVER[ 'DOCUMENT_ROOT' ].'/assignments/common/header.php'; ?>
 </header>
 <h1>Manage Account</h1>
 <main>
 
 <?php
 // Get the database connection file
 require_once '../library/connections.php';
 ?>
 
 <div>
 <?php
   if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
   }
   ?>
 <?php 
   echo '<p> You are logged in as ' . $_SESSION['userData']['username'] . '<p>';
          
   echo  '<p> Your email: '.$_SESSION['userData']['email'].'<p>'
           ."<a class='adminlink' href='update_account.php?id=".urlencode($_SESSION['userData']['id'])."'> Update account information</a>";
		   
   if($_SESSION['userData']['userlevel'] > 1) {echo '<h2> As an administrator you can perform the following actions to manage the online store:</h2>'
   .'<a class="adminlink" href="manage_departmentgroup.php"> Add or remove a department, product group</a><br><br>'
   .'<a class="adminlink" href="manage_products.php"> Add, update or remove a product</a><br>';}
   
   ?> 
 </main>
 <footer>
  <?php include $_SERVER[ 'DOCUMENT_ROOT' ].'/assignments/common/footer.php'; ?>
  </footer>
 </body>
</html>
