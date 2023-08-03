

 <h1>This is Checkout Page</h1>
 <p>Please, input the information about your address. It is required to fill out all the fields.</p>
 <form method="post" action="./index.php?action=purchase_confirmation">
<label class="address" for="country">Country: <input type="text" name="country" <?php if(isset($country)){ echo "value='$country'"; } else {echo "value=''"; } ?> required></label><br>
<label class="address" for="city">City: <input type="text" name="city" <?php if(isset($city)){ echo "value='$city'"; } else {echo "value=''"; } ?> required></label><br>
<label class="address" for="street">Street: <input type="text" name="street" <?php if(isset($street)){ echo "value='$street'"; } else {echo "value=''"; } ?> required></label><br>
<label class="address" for="houseNumber">House number: <input type="text" name="houseNumber" <?php if(isset($houseNumber)){ echo "value='$houseNumber'"; } else {echo "value=''"; } ?> required></label><br>
<label class="address" for="zipCode">Zipcode: <input type="text" name="zipCode" <?php if(isset($zipCode)){ echo "value='$zipCode'"; } else {echo "value=''"; } ?> required></label><br>

<input class="submitBtn completePurchase" type="submit" name="completePurchase" value="Complete the purchase"><br>
<input id="js-returnToShoppingCartButton" class="submitBtn" type="submit" name="returnToShoppingCart" value="Return to Shopping Cart" formaction="./index.php?action=view_cart&returntoshoppingcart=true">

</form>


