<?php

function buildProductDepartmentsNavList($productdepartments, $productDepartmentID = 0, $showSubmenu = false){
    $productDepartmentsNavList = '<h2 id="departmentsMenuHeading">Product Groups</h2><ul>';
        foreach ($productdepartments as $productdepartment)
       {	
        $productDepartmentsNavList .= '<li><a href="./index.php?action=showProductGroups&departmentId=' . $productdepartment['id'] .'&productdepartmentname=' . $productdepartment['productdepartmentname'] . '">' . $productdepartment['productdepartmentname'] . '</a></li>';
         if ($showSubmenu && $productDepartmentID == $productdepartment['id']) {
             
             $productGroups = getProductsGroups($productDepartmentID);
             $productDepartmentsNavList .= '<ul>';
           foreach ($productGroups as $group) {
               
                
                $productDepartmentsNavList .= '<li><a href="./index.php?action=showProductGroup&departmentId=' . $productdepartment['id'] .'&groupId=' . $group["id"] .'&productgroupname='.$group['productgroupname'].'">' . $group['productgroupname'] . '</a></li>';
                
           }
           
           $productDepartmentsNavList .= '</ul>';
           
   }
       }
       $productDepartmentsNavList .= '</ul>';
    return $productDepartmentsNavList;
}

function showProducts($products, $productDepartmentID = 0, $showDifferently = false){  
    $productsList = "";
            foreach ($products as $product)
        {
            if($showDifferently){
                if($product["productID"]%3 == 0){
                    $productsList .= showProduct($product, $productDepartmentID);
                 }
            } else {
                $productsList .= showProduct($product, $productDepartmentID);
            }
    } 
    return $productsList;
}   

function showProductsInCart($product, $productDepartmentID = '', $productGroupID = '', $productDepartmentName = ''){
    $shoppingCartContents = '<section><h2>'.$product["productName"].'</h2><article><div><img src='.$product["productImage"].'></div><div><p class="price"><span>Price: </span>'.$product["productPrice"].
	'</p><p><span>Description: </span>'.$product["productDescription"].'</p><p><span>Stock: </span>'.$product["productStock"].
	'</p><p><span>Added to Cart: </span>'.$product["addedToCart"].
	'</p><form method="post" action="./index.php?action=view_cart&departmentId='.$productDepartmentID.'&groupId='.$productGroupID.'&productgroupname='.$productDepartmentName.'"><input type="hidden" name="productName" value="'.$product["productName"].
	'"><input type="hidden" name="productImage" value="'.$product["productImage"].'"><input type="hidden" name="productPrice" value="'.$product["productPrice"].
	'"><input type="hidden" name="productDescription" value="'.$product["productDescription"].'"><input type="hidden" name="productStock" value="'.$product["productStock"].
	'"><input type="hidden" name="productID" value="'.$product["productID"].
	'"><input type="hidden" name="addedToCart" value="'.$product["addedToCart"].
        '"><input class="remove-product-shopping-cart-button" type="submit" name="removeFromShoppingCart" value="Remove from Shopping Cart 1 Item">'.
        '<input class="remove-product-shopping-cart-button" type="submit" name="removeFromShoppingCartCompletely" value="Remove from Shopping Cart Completely">'.
        '</form><form method="post" action="./index.php?action=showProductDetails&productID='.$product["productID"].'&departmentId='.$productDepartmentID.'&groupId='.$productGroupID.'&productgroupname='.$productDepartmentName.'">'.
        '<input type="hidden" name="returnedFromShoppingCart" value="returnedFromShoppingCart">'.
        '<input class="product-shopping-cart-button" type="submit" name="returnToProductDetails" value="Return To Product Details">'.
        '</form></div></article></section>';

    return $shoppingCartContents;
}

	
function showProduct($product, $productDepartmentID){
    
    $productDisplay = '<section><h2>'.$product["productName"].'</h2><article><div><img src='.$product["productImage"].'></div><div><div class="productDescription"><p class="price"><span>Price: </span>'.$product["productPrice"].
	'</p><p><span>Description: </span>'.$product["productDescription"].'</p><p><span>Stock: </span>'.$product["productStock"].
	'</p></div><form method="post" action="./index.php?action=showProductDetails&departmentId='.$productDepartmentID.'"><input type="hidden" name="productName" value="'.$product["productName"].
	'"><input type="hidden" name="productImage" value="'.$product["productImage"].'"><input type="hidden" name="productPrice" value="'.$product["productPrice"].
	'"><input type="hidden" name="productDescription" value="'.$product["productDescription"].'"><input type="hidden" name="productStock" value="'.$product["productStock"].
	'"><input type="hidden" name="productID" value="'.$product["productID"].
	'"><input class="button" type="submit" name="productDetails" value="Product details"></form></div></article></section>';
            
            return $productDisplay;
}


function showProductDetails($product, $productDepartmentID){
    $productDetails = "<section class='productDetailsSection'><h2 class='productDetailsHeading'>".$product['productName']."</h2><article><div><img src=".$product['productImage']."></div><div><div class='productDetailsDescription'><p class='price'><span>Price: </span>".
                                $product['productPrice']."</p><p><span>Description: </span>".$product['productDescription']."</p><p><span>Stock: </span>".$product['productStock'].
                                "</p></div><form action='./index.php?action=showProductDetails&departmentId=$productDepartmentID' "
                                . "method='post'><input type='hidden' name='productName' value='".$product['productName'].
	"'><input type='hidden' name='productImage' value='".$product['productImage']."'><input type='hidden' name='productPrice' value='".$product['productPrice'].
	"'><input type='hidden' name='productDescription' value='".$product['productDescription']."'><input type='hidden' name='productStock' value='".$product['productStock'].
	"'><input type='hidden' name='productID' value='".$product['productID']."'><input class='add-to-shopping-cart-button' type='submit' name='addToShoppingCart' value='Add to Shopping Cart'></form></div></article></section>";
    return $productDetails;
}

function showDefaultPage($products, $productDepartmentsNavList){
             $pageTitle = 'Home page';
             $page = 'home';  
             $productsList = showProducts($products, 0, true); 
             include 'views/index.php';
}
     