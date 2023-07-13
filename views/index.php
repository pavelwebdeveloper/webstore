<?php

 
if (!isset($_SESSION['shoppingCart'])) {
 $_SESSION['shoppingCart'] = array();
 $_SESSION['products'] = array();
 }
?>
<!DOCTYPE html>
<html lang="en-us" id="products">
 <head>
  <title><?php echo $pageTitle; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/online_store_styles.css" rel="stylesheet" media="screen">
  <link href="css/normalize.css" rel="stylesheet" media="screen">
 </head>
 <body>
 <header>
 <?php include $_SERVER[ 'DOCUMENT_ROOT' ].'/web-store/common/header.php'; ?>
 </header>
 <main>
  
 <?php include $_SERVER[ 'DOCUMENT_ROOT' ].'/web-store/views/'.$page.'.php'; ?>
 
 
 <footer>
  <?php include $_SERVER[ 'DOCUMENT_ROOT' ].'/web-store/common/footer.php'; ?>
  </footer>
 </main>
     
  
  
 </body>
</html>

