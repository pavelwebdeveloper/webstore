<?php
// Start the session
session_start();
if(!($_SESSION['loggedin'])){header('Location: home.php');}
// Create an array for the shopping cart in the session
if (!isset($_SESSION['shoppingCart'])) {
 $_SESSION['shoppingCart'] = array();
 $_SESSION['products'] = array();
 }
?>
<!DOCTYPE html>
<html lang="en-us" id="logInRegister">
 <head>
  <title>Update Account Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/online_store_styles.css" rel="stylesheet" media="screen">
  <link href="css/normalize.css" rel="stylesheet" media="screen">
 </head>
 <body>
 <header>
 <?php include $_SERVER[ 'DOCUMENT_ROOT' ].'/assignments/common/header.php'; ?>
 </header>
 <h1>Account Update</h1>
 <main>
 
 
 
 <?php
 // Get the database connection file
 require_once '../library/connections.php';
 ?>
 
 <div>
 <?php
   if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
   }
   ?>
 <form method="post" action="update_account.php">
<label for="userName">Full name:</label><br>

<input type="text" id="userName" name="userName" pattern="[A-Za-z ]{2,}" value="<?php if(isset($_SESSION['userData']['username'])){echo $_SESSION['userData']['username'];} ?>" required><br>
<label for="userEmail">E-mail:</label><br>
<input type="email" id="userEmail" name="userEmail" placeholder="someone@gmail.com" pattern="[a-z0-9._%+-]+@[a-z0-9.]+\.[a-z]{2,}$" value="<?php if(isset($_SESSION['userData']['email'])){echo $_SESSION['userData']['email'];} ?>" required><br><br>
<input type="submit" value="Update Account">
<input type="hidden" name="updateAccount" value="updateAccount">
<input type="hidden" name="userId" value="<?php if(isset($_SESSION['userData']['id'])){echo $_SESSION['userData']['id'];} ?>">
</form>
<h2>Change Password</h2>
   <p>You can use this form to update your password. Entering and submitting a new password in this field you will change the current password.</p>
<form method="post" action="update_account.php">
<label for="userPassword">Password:</label><br>
<span class="passworddescription">Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter, 1 lower case letter and 1 special character</span><br>
<input type="password" name="userPassword" id="userPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required><br><br>
<input type="submit" value="Change Password">
<input type="hidden" name="updatePassword" value="updatePassword">
<input type="hidden" name="userId" value="<?php if(isset($_SESSION['userData']['id'])){echo $_SESSION['userData']['id'];} ?>">
</form>
 </div>
 
 <?php
  
if(isset($_POST['updateAccount'])) {
	
	// Filter and store the data
   $userName = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_STRING);
   $userEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_EMAIL);
   $userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_NUMBER_INT);
   
    // Check if the email address is different than the one in the session
   if($userEmail != $_SESSION['userData']['email']) {
     //  checking for an existing email address
   $alreadyexistingEmail = $db->prepare('SELECT email FROM storeuser WHERE email=:userEmail');
$alreadyexistingEmail->bindValue(':userEmail', $userEmail, PDO::PARAM_STR);
$alreadyexistingEmail->execute();
$findEmail = $alreadyexistingEmail->fetch(PDO::FETCH_ASSOC);
   }
// Ask if the array is empty or not
 if(empty($findEmail)) {
  $findEmail = 0;  
 } else {
  $findEmail = 1;
 }
   // Check for existing email address in the table
   if($findEmail) {
    $_SESSION['message'] = "<p>Sorry. Such an email address already exists.</p>";
    header("Location: update_account.php");
   exit;
   }
   
   // Check for missing data
   if(empty($userName) || empty($userEmail)){
    $_SESSION['message'] = '<p class="message">Please, provide information correctly for all form fields.</p>';
    header("Location: update_account.php");
    exit;
   }
  $updateAccount = $db->prepare('UPDATE storeuser SET username = :username, email = :useremail WHERE id = :userId'); 
 $updateAccount->bindValue(':username', $userName, PDO::PARAM_STR);
$updateAccount->bindValue(':useremail', $userEmail, PDO::PARAM_STR);
 $updateAccount->bindValue(':userId', $userId, PDO::PARAM_INT);
$updateAccount->execute();
$updateAccountOutcome = $updateAccount->rowCount();
   
   // Check and report the result
   if($updateAccountOutcome === 1){
    // Query the client data based on the client ID
   $getUserUpdatedData = $db->prepare('SELECT id, username, email FROM storeuser WHERE id=:userId');
$getUserUpdatedData->bindValue(':userId', $userId, PDO::PARAM_INT);
$getUserUpdatedData->execute();
$userUpdatedData = $getUserUpdatedData->fetch(PDO::FETCH_ASSOC);
   // Store the array into the session
   $_SESSION['userData'] = $userUpdatedData;
   // setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
    $_SESSION['message'] = "<p class='messagesuccess'>Your account information has been successfully updated.</p>";
    header("Location: manage_account.php");
   exit;
   } else {
    $message = "<p class='messagefailure'>Sorry, but the account update failed. Please, try again.</p>";
            header("Location: manage_account.php");
    exit;
   }
   
} elseif (isset($_POST['updatePassword'])) {
	// Filter and store the password data
   $userPassword = filter_input(INPUT_POST, 'userPassword', FILTER_SANITIZE_STRING);
   $userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_NUMBER_INT);
   
   // Check for missing data
   if(empty($userPassword)){
    $_SESSION['message'] = '<p class="messagefailure">Please, provide the new password information correctly.</p>';
    header("Location: update_account.php");
    exit;
   }
   
   // Hash the checked password
   
   $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
   
   // Send the data to the model
   $passwordUpdate = $db->prepare('UPDATE storeuser SET password = :password WHERE id = :userId'); 
    $passwordUpdate->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
 $passwordUpdate->bindValue(':userId', $userId, PDO::PARAM_INT);
$passwordUpdate->execute();
$passwordUpdateOutcome = $passwordUpdate->rowCount();

  

 // Check and report the result
   if($passwordUpdateOutcome){
    $_SESSION['message'] = "<p class='messagesuccess'>Your password has been successfully updated.</p>";
    header("Location: manage_account.php");
   exit;
   } else {
    $_SESSION['message'] = "<p class='messagefailure'>Sorry, but the password update failed. Please, try again.</p>";
            header("Location: update_account.php");
    exit;
   }
}
 ?>
 
 </main>
 <footer>
 <?php include $_SERVER[ 'DOCUMENT_ROOT' ].'/assignments/common/footer.php'; ?>
 </footer>
 </body>
</html>
