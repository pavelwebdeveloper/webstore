
 
 <h1>This is View Cart Page</h1>
 
 <?php echo $productsInCart; ?>
 
 <div class="bottomNavigationLinks">
 <div>
 <form method="post" action="browse_products.php">
<input class="navigationButton" type="submit" value="Browse Products">
</form>
</div>
<div>
 <form method="post" action="check_out.php">
<input class="navigationButton" type="submit" value="Checkout">
</form>
</div>
</div>
 
 