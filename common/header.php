
<?php $_SESSION['loggedin'] = false;
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
</div>
<div id="lowerblock">
    
<?php if(!($_SESSION['loggedin'])){
	echo '<div>
</div><div id="logInOrSignUp">
<a href="./index.php?action=showLoginPage" title="a link to log in">Log In</a>
<a href="./index.php?action=showSignUpPage" title="a link to sign up">Sign Up</a>
</div>';
} else {
	echo '<div><p>You are logged in as ' . $_SESSION['userData']['username'] . '</p>
</div><div id="logInOrSignUp">
<a href="manage_account.php" title="a link to account update page">Manage account</a>
<a href="home.php?action=Logout" title="a link to log out">Log Out</a>
</div>';
}
?>


</div>
