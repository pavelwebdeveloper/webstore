
 
 
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
 