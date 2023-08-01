/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */


document.getElementById("js-returnToShoppingCartButton").addEventListener("click", returnToShoppingCart);

function returnToShoppingCart(){
    window.location.assign("./index.php?action=view_cart");
    
}


