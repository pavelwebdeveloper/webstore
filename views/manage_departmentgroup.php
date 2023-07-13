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
  <title>Manage Product Departments and Product Groups Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/online_store_styles.css" rel="stylesheet" media="screen">
  <link href="css/normalize.css" rel="stylesheet" media="screen">
 </head>
 <body>
 <header>
 <?php include $_SERVER[ 'DOCUMENT_ROOT' ].'/assignments/common/header.php'; ?>
 </header>
 <h1>Manage Product Departments and Product Groups</h1>
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
 
 // Query the product groups data
   $getProductGroups = $db->prepare('SELECT * FROM productgroup');
$getProductGroups->execute();
$productGroups = $getProductGroups->fetchAll(PDO::FETCH_ASSOC);
 // Build a dynamic drop-down select list using the $productGroups array
 $productGroupsList .= '<select name="productGroupId" id="productGroupId">';
 $productGroupsList .= '<option disabled selected>Choose a product group</option>';
 foreach ($productGroups as $productGroup) {
 /*$catList .= "<option value=".urlencode($category['categoryId']).">".urlencode($category['categoryName'])."</option>";*/
  $productGroupsList .= "<option value='$productGroup[id]'";
  if(isset($productGroupId)) {
   
   if($productGroup['id'] === $productGroupId){
    $productGroupsList .= ' selected ';
   }
  }
  
  $productGroupsList .= ">$productGroup[productgroupname]</option>";
 }
 $productGroupsList .= '</select>';
 
 ?>
 
 <div>
 <?php
   if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
   } elseif (isset($message)) {
    echo $message;
   }
   ?>
   <form action="manage_departmentgroup.php" method="post">
    <fieldset>
	<legend>Add product department</legend>
     <label for="departmentName">Department Name</label><br>
     <input type="text" name="departmentName" id="departmentName" pattern="[A-Za-z]{3,}" required><br><br>
     <input class="submitBtn" type="submit" value="Add Department">
     <!-- Add the action name - value pair -->
     <input type="hidden" name="NewDepartment" value="newDepartment">
    </fieldset>
   </form>
   
   <?php
if(isset($_POST['NewDepartment'])) {
	
	// Filter and store the data
	$departmentName = filter_input(INPUT_POST, 'departmentName', FILTER_SANITIZE_STRING);	
	  
   // validate the categoryName variable using a custom function from functions.php
   $pattern = '/^[A-Za-z]{3,}$/';
 $checkedDepartmentName = preg_match($pattern, $departmentName);   
   // Check for missing data
   if(empty($checkedDepartmentName)){
    $_SESSION['message'] = '<p class="message">Please, provide a new department name.</p>';
    header('location: manage_departmentgroup.php');
    exit;
   }   
   $stmt = $db->prepare('INSERT INTO productdepartment (productdepartmentname) VALUES (:departmentName)'); 
 $stmt->bindValue(':departmentName', $departmentName, PDO::PARAM_STR);
$stmt->execute();

   
   // Send the data to the model
   $adddepartmentOutcome = $stmt->rowCount();
   
   // Check and report the result
   if($adddepartmentOutcome === 1){
	   $_SESSION['message'] = "<p class='messagesuccess'>The new department " . $departmentName . " has successfully been added.</p>";
	   header('location: manage_departmentgroup.php');
   exit;
   } else {
    $_SESSION['message'] = "<p class='messagefailure'>Sorry, adding the new department " . $departmentName . " has failed. Please, try again.</p>";
            header('location: manage_departmentgroup.php');
    exit;
   }
}
	
	?>
   
  
   <form action="manage_departmentgroup.php" method="post">
    <fieldset>
	<legend>Remove product department</legend>
     <label for="departmentName">Department Name</label><br>
     <?php
	echo $departmentList;
 ?><br><br>
	 <input class="submitBtn" type="submit" value="Remove Department">
     <!-- Add the action name - value pair -->
     <input type="hidden" name="RemoveDepartment" value="removeDepartment">
    </fieldset>
   </form>
   
   <?php
if(isset($_POST['RemoveDepartment'])) {
	
	// Filter and store the data
	$departmentId = filter_input(INPUT_POST, 'departmentId', FILTER_SANITIZE_NUMBER_INT);	
	
	 
	 $getName = $db->prepare('SELECT productdepartmentname FROM productdepartment WHERE id=:departmentId'); 
 $getName->bindValue(':departmentId', $departmentId, PDO::PARAM_INT);
$getName->execute();
$departmentName = $getName->fetch(PDO::FETCH_ASSOC);


// Check for missing data
   if(empty($departmentId)){
    $_SESSION['message'] = '<p class="message">Please, choose a department name for removal.</p>';
    header('location: manage_departmentgroup.php');
    exit;
   }   
   $stmt = $db->prepare('DELETE FROM productdepartment WHERE id=:departmentId'); 
 $stmt->bindValue(':departmentId', $departmentId, PDO::PARAM_INT);
$stmt->execute();

  
   // Send the data to the model
   $deleteDepartmentOutcome = $stmt->rowCount();
   
   
   
   // Check and report the result
   if($deleteDepartmentOutcome === 1){
	   $_SESSION['message'] = "<p class='messagesuccess'>The department " . $departmentName['productdepartmentname'] . " has successfully been deleted.</p>";
   header('location: manage_departmentgroup.php');
   exit;
   } else {
    $_SESSION['message'] = "<p class='messagefailure'>Sorry, deleting the department " . $departmentName['productdepartmentname'] . " has failed. Please, try again.</p>";
            header('location: manage_departmentgroup.php');
    exit;
   }
   
}
	
	?>
   
   <form action="manage_departmentgroup.php" method="post">
    <fieldset>
	<legend>Add product group</legend>
	<?php
	echo $departmentList;
 ?><br><br>
     <label for="productGroupName">New Product Group Name</label><br>
     <input type="text" name="productGroupName" id="productGroupName" pattern="[A-Z][a-z]{3,}" required><br><br>
	 <label for="imageFilePath">Image File Path for the New Product Group Name</label><br>
     <input type="text" name="imageFilePath" id="imageFilePath" pattern="[A-Za-z/_.]{3,}" value="/images/product_subgroup_images/" required><br><br>
     <input class="submitBtn" type="submit" value="Add Product Group">
     <!-- Add the action name - value pair -->
     <input type="hidden" name="AddNewProductGroup" value="addNewProductGroup">
    </fieldset>
   </form>
   
   <?php
if(isset($_POST['AddNewProductGroup'])) {
	
	// Filter and store the data
	$departmentId = filter_input(INPUT_POST, 'departmentId', FILTER_SANITIZE_NUMBER_INT);	
	$productGroupName = filter_input(INPUT_POST, 'productGroupName', FILTER_SANITIZE_STRING);	
	$imageFilePath = filter_input(INPUT_POST, 'imageFilePath', FILTER_SANITIZE_STRING);	
	  
   // validate the categoryName variable using a custom function from functions.php
   $pattern = '/^[A-Za-z]{3,}$/';
 $checkedproductGroupName = preg_match($pattern, $productGroupName); 
// validate the categoryName variable using a custom function from functions.php
   $patternImagePath = '/^[A-Za-z/_.]{3,}$/';
 $checkedimageFilePath = preg_match($patternImagePath, $imageFilePath);    
   // Check for missing data
   if(empty($checkedproductGroupName) || empty($departmentId) || empty($imageFilePath)){
    $_SESSION['message'] = '<p class="message">Please, choose a department name and provide a new product group name.</p>';
    header('location: manage_departmentgroup.php');
    exit;
   }   
   $stmt = $db->prepare('INSERT INTO productgroup (productgroupname, productdepartmentId, image) VALUES (:productGroupName, :departmentId, :imageFilePath)'); 
 $stmt->bindValue(':productGroupName', $productGroupName, PDO::PARAM_STR);
 $stmt->bindValue(':departmentId', $departmentId, PDO::PARAM_INT);
 $stmt->bindValue(':imageFilePath', $imageFilePath, PDO::PARAM_STR);
$stmt->execute();

   
   // Send the data to the model
   $addProductGroupOutcome = $stmt->rowCount();
   
   // Check and report the result
   if($addProductGroupOutcome === 1){
	   $_SESSION['message'] = "<p class='messagesuccess'>The new product group " . $productGroupName . " has successfully been added.</p>";
   header('location: manage_departmentgroup.php');
   exit;
   } else {
    $_SESSION['message'] = "<p class='messagefailure'>Sorry, adding the new product group " . $productGroupName . " has failed. Please, try again.</p>";
            header('location: manage_departmentgroup.php');
    exit;
   }
}
?>
   
   <form action="delete_productgroup.php" method="post">
    <fieldset>
	<legend>Remove product group</legend>	
     <label for="productGroupName">Product Group Name</label><br>
	 <?php
	echo $productGroupsList;
 ?><br><br>
	 <input class="submitBtn" type="submit" value="Remove Product Group">
     <!-- Add the action name - value pair -->
     <!--<input type="hidden" name="RemoveProductGroup" value="removeProductGroup">-->
    </fieldset>
   </form>
   
   
   
   <form action="manage_departmentgroup.php" method="post" enctype="multipart/form-data">
   <fieldset>
	<legend>Upload a product group image</legend>
 <label for="invId">Product Group</label><br>
 <?php
	echo $productGroupsList;
 ?><br><br>
 <label for="uploadfile">Upload Image</label><br>
 <input id="uploadfile" type="file" name="file1"><br><br>
 <input type="submit" class="submitBtn" value="Upload">
 <input type="hidden" name="Upload" value="upload">
 </fieldset>
</form>
   
   <?php
if(isset($_POST['Upload'])) {
	// Filter and store the data
	$productGroupId = filter_input(INPUT_POST, 'productGroupId', FILTER_SANITIZE_NUMBER_INT);	
	
	$getImagePath = $db->prepare('SELECT image FROM productgroup WHERE id = :productGroupId'); 
	$getImagePath->bindValue(':productGroupId', $productGroupId, PDO::PARAM_INT);
$getImagePath->execute();
$imagePath = $getImagePath->fetch(PDO::FETCH_ASSOC);
	// directory name where uploaded images are stored
$image_dir = $imagePath['image'];
// The path is the full path from the server root
$image_dir_path = $_SERVER['DOCUMENT_ROOT'] . $image_dir;
	
	
  
  // Store the name of the uploaded image
  $imgName = $_FILES['file1']['name'];
  
    
  if(empty($productGroupId) || empty($imgName)) {
   $_SESSION['message'] = '<p class="warningmessage">You must select both a product and an image file for the product.</p>';
  } else {
 if (isset($_FILES['file1'])){
  // Gets the actual file name
  $filename = $_FILES['file1']['name'];
  if (empty($filename)) {
   return;
  }
  // Get the file from the temp folder on the server
 $source = $_FILES['file1']['tmp_name'];
 // Sets the new path - images folder in this directory
 $target = $image_dir_path . '/' . $filename;
 // Moves the file to the target folder
 $fileUploadResult = move_uploaded_file($source, $target);
 }
 }
    
   // Check and report the result
   if($fileUploadResult){
	   $_SESSION['message'] = "<p class='messagesuccess'>The upload succeeded.</p>";
   header('location: manage_departmentgroup.php');
   exit;
   } else {
    $_SESSION['message'] = "<p class='messagefailure'>Sorry, the upload failed.</p>";
            header('location: manage_departmentgroup.php');
    exit;
   }
}


?>
   
  
  </div> 
   
 
   
 </main>
 <footer>
  <?php include $_SERVER[ 'DOCUMENT_ROOT' ].'/assignments/common/footer.php'; ?>
  </footer>
 </body>
</html>