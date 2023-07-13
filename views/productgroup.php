
 <div id="flexlayout">
  <div id="flexlayoutleft">
  
  <?php  
    echo $productDepartmentsNavList; 
 ?>
  </div>
   <div id="flexlayoutright">
   <?php
   


if (isset($productGroup)) {
	foreach ($productGroup as $product) {
  echo '<section><h2>'.$product["product"].'</h2><article><div><img src='.$product["image"].'></div><div><p class="price"><span>Price: </span>'.$product["price"].
	'</p><p><span>Description: </span>'.$product["productdescription"].'</p><p><span>Stock: </span>'.$product["stock"].
	'</p><form method="post" action="product_details.php"><input type="hidden" name="product" value="'.$product["product"].
	'"><input type="hidden" name="image" value="'.$product["image"].'"><input type="hidden" name="price" value="'.$product["price"].
	'"><input type="hidden" name="productdescription" value="'.$product["productdescription"].'"><input type="hidden" name="stock" value="'.$product["stock"].
	'"><input type="hidden" name="id" value="'.$product["id"].
	'"><input type="submit" name="productDetails" value="Product details"></form></div></article></section>';
	}
}
 
   
?>
  </div>
  </div>
 
 