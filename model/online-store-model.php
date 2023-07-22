<?php

/* 
 * This is the Online-store Model
 */

function getProductDepartments() {
 // Create a connection object from the acme connection function
 $db = onlineStoreConnect();
 // The SQL statement to be used with the database 
 $sql = 'SELECT * FROM productdepartment';
 // The next line creates the prepared statement using the acme connection
 $stmt = $db->prepare($sql);
 // The next line runs the prepared statement 
 $stmt->execute();
 // The next line gets the data from the database and 
 // stores it as an array in the $categories variable 
 $productDepartments = $stmt->fetchAll();
 // The next line closes the interaction with the database 
 $stmt->closeCursor();
 // The next line sends the array of data back to where the function 
 // was called (this should be the controller)
 return $productDepartments;
}

function getProducts($groupId = 0) {
 // Create a connection object from the acme connection function
 $db = onlineStoreConnect();
 // The SQL statement to be used with the database 
 if($groupId == 0){
 $sql = 'SELECT * FROM product';
 } else {
     $sql = 'SELECT * FROM product WHERE productgroupId = :groupId';
 }
 // The next line creates the prepared statement using the acme connection
 $stmt = $db->prepare($sql);
 if($groupId ==! 0){
 $stmt->bindValue(':groupId', $groupId, PDO::PARAM_INT);
 }
 // The next line runs the prepared statement 
 $stmt->execute();
 // The next line gets the data from the database and 
 // stores it as an array in the $categories variable 
 $products = $stmt->fetchAll();
 // The next line closes the interaction with the database 
 $stmt->closeCursor();
 // The next line sends the array of data back to where the function 
 // was called (this should be the controller)
 return $products;
}

function findProducts($product) {
 $db = onlineStoreConnect();
 $stmt = $db->prepare("SELECT * FROM product WHERE product LIKE CONCAT( '%', :product, '%')");
            $stmt->bindValue(':product', $product, PDO::PARAM_STR);
            $stmt->execute();
            $foundproducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $foundproducts;
}


function getProductsGroups($productDepartmentID){
    $db = onlineStoreConnect();
 $sql = 'SELECT * FROM productgroup WHERE productdepartmentID = :productDepartmentID';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':productDepartmentID', $productDepartmentID, PDO::PARAM_INT);
  $stmt->execute();
  $productsGroups = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $productsGroups;
}

function changeProductStock(){
    
        $productStock = $_SESSION['stock'];
	$productId = $_SESSION['productNumber'];
	
        $db = onlineStoreConnect();
	// Update the product stock data when adding a product to the shopping cart
        $updateProductStock = $db->prepare('UPDATE product SET stock = :productstock WHERE id = :productid;');
        $updateProductStock->bindValue(':productid', $productId, PDO::PARAM_INT);
        $updateProductStock->bindValue(':productstock', $productStock, PDO::PARAM_INT);
        $updateProductStock->execute();
        $updateProductStockOutcome = $updateProductStock->rowCount();
}