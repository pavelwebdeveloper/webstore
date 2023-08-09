
<?php //$_SESSION['loggedin'] = false;
?>


<div id="upperblock">
    <nav>
<a href="./index.php" title="a link to Home page">Home</a>
<a href="./index.php?action=products" title="a link to Browse Products page">Products</a>
</nav>
<form method="post" action="./index.php?action=products">
        <label for="name"></label>
        <input type="text" id="name" name="searchProduct" 
               <?php if(empty($searchValue)){
                   echo 'placeholder="Product name" value=""';
               } else {
                   echo 'placeholder="'.$searchValue.'" value="'.$searchValue.'"';
               }
                       ?>>
        <input type="submit" value="Search">
    </form>
    <div>
        <nav>
            <a href="./index.php?action=view_cart&departmentId=<?php if(isset($productDepartmentID)){echo $productDepartmentID;} ?>&groupId=<?php if(isset($productGroupID)){echo $productGroupID;} ?>&productgroupname=<?php if(isset($productDepartmentName)){echo $productDepartmentName;} ?>" title="a link to Shopping Cart page">Shopping Cart</a>
        </nav>
    </div>
</div>
<div id="lowerblock">
    
<?php if(!isset($_SESSION['loggedin'])){
	echo '<div>
</div><div id="logInOrSignUp">
<a href="./index.php?action=showLoginPage" title="a link to log in">Log In</a>

</div>';
} else {
	echo '<div><p>You are logged in as ' . $_SESSION['userData']['username'] . '</p>
</div><div id="logInOrSignUp">
<a href="./index.php?action=manage_account" title="a link to account update page">Manage account</a>
<a href="./index.php?action=Logout" title="a link to log out">Log Out</a>
</div>';
}
?>


</div>
