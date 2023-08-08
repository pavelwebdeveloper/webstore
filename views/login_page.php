

 
 
 <div id="centerLoginForm">
 <?php
   if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
   }
   ?>
 <form method="post" action="./index.php?action=login">
<label for="userEmail">E-mail:</label><br>
<input class="formInput" type="email" id="userEmail" name="userEmail" placeholder="someone@gmail.com" pattern="[a-z0-9\._%+-]+@[a-z0-9.]+\.[a-z]{2,}$" <?php if(isset($userEmail)){echo "value='$userEmail'";} ?> required><br>
<label for="userPassword">Password:</label><br>
<input class="formInput" type="password" name="userPassword" id="userPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required><br><br>
<input class="submitBtn greenSubmitButton" class="submitButton" type="submit" value="Log in">
<input type="hidden" name="LogIn" value="logIn">
<br>

</form>
 </div>
 
 
 