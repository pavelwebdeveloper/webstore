
 
 <h1>This is View Cart Page</h1>
 
 <?php echo $productsInCart; ?>
 
 <div class="bottomNavigationLinks">
 <div>
 <form method="post" action="./index.php?action=browse_products">
<input class="navigationButton" type="submit" value="Browse Products">
</form>
</div>
<div>
 <form method="post" action="./index.php?action=check_out">
<input class="navigationButton" type="submit" value="Checkout">
</form>
</div>
</div>
 
 