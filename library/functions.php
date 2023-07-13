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

function showProducts($products, $showDifferently = false){  
    $productsList = "";
            foreach ($products as $product)
        {
            if($showDifferently){
                if($product["id"]%3 == 0){
                    $productsList .= showProduct($product);
                 }
            } else {
                $productsList .= showProduct($product);
            }
    } 
    return $productsList;
}    

	
function showProduct($product){      
            /*$productDisplay = '<section class="product-item"><h2>'.$product["product"].'</h2><article><div><img style="width:30%;height:50%;" src='.$product["image"].'></div><div><p class="price"><span>Price: </span>'.$product["price"].
            '</p><p><span>Description: </span>'.$product["productdescription"].'</p><p><span>Stock: </span>'.$product["stock"].
            '</p><form method="post" action="product_details.php"><input type="hidden" name="product" value="'.$product["product"].
            '"><input type="hidden" name="image" value="'.$product["image"].'"><input type="hidden" name="price" value="'.$product["price"].
            '"><input type="hidden" name="productdescription" value="'.$product["productdescription"].'"><input type="hidden" name="stock" value="'.$product["stock"].
            '"><input type="hidden" name="id" value="'.$product["id"].
            '"><input type="submit" name="productDetails" value="Product details"></form></div></article></section>';*/
    
    $productDisplay = '<section><h2>'.$product["product"].'</h2><article><div><img src='.$product["image"].'></div><div><p class="price"><span>Price: </span>'.$product["price"].
	'</p><p><span>Description: </span>'.$product["productdescription"].'</p><p><span>Stock: </span>'.$product["stock"].
	'</p><form method="post" action="product_details.php"><input type="hidden" name="product" value="'.$product["product"].
	'"><input type="hidden" name="image" value="'.$product["image"].'"><input type="hidden" name="price" value="'.$product["price"].
	'"><input type="hidden" name="productdescription" value="'.$product["productdescription"].'"><input type="hidden" name="stock" value="'.$product["stock"].
	'"><input type="hidden" name="id" value="'.$product["id"].
	'"><input type="submit" name="productDetails" value="Product details"></form></div></article></section>';
            
            return $productDisplay;
}      
     