

 
 
 <div>
 <?php
   if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
   }
   ?>
 <form method="post" action="login_page.php">
<label for="userEmail">E-mail:</label><br>
<input type="email" id="userEmail" name="userEmail" placeholder="someone@gmail.com" pattern="[a-z0-9\._%+-]+@[a-z0-9.]+\.[a-z]{2,}$" <?php if(isset($userEmail)){echo "value='$userEmail'";} ?> required><br>
<label for="userPassword">Password:</label><br>
<input type="password" name="userPassword" id="userPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required><br><br>
<input class="submitButton" type="submit" value="Log in">
<input type="hidden" name="LogIn" value="logIn">
<br>
<p id="login">Not registered yet?</p>
<button type="button"><a id="aregister" href="signup_page.php" title="a link to a sign_up page">Sign Up</a></button>
</form>
 </div>
 
 <?php
 


 ?>
 
 
 