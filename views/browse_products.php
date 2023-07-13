 
 <div id="flexlayout">
  <div id="flexlayoutleft">
  
  <?php  
        echo $productDepartmentsNavList; 
 ?>
  </div>
   <div id="flexlayoutright">
<h1>This is Browse Products Page</h1>
 
 <?php
if (!empty($productsList)) {
    
    echo $productsList;
    } else {
	 echo "<h1>Sorry, no product found. Please, try to find a product with a differenet name</h1>";
 } 
 ?>
 
 </div>
  </div>
 
 
 