
 <div id="flexlayout">
  <div id="flexlayoutleft">
  
  <?php  
    echo $productDepartmentsNavList; 
 ?>
  </div>
   <div id="flexlayoutright">
       <div class="display-productgroups-and-products">
   <?php
   


if (isset($productGroups)) {
	foreach ($productGroups as $group) {
  echo '<a href="./index.php?action=showProductGroup&departmentId=' . $productDepartmentID .'&groupId=' . $group["id"] . '"><article><div>' . $group["productgroupname"] . '</div><div><img id="productGroupImage" src=' . $group['image'] . '></div></article></a><br><br>';
	}
}
   
?>
       </div>
    </div>
  </div>
 
 
 
 
 