<?php

namespace App\Models;

class ShoppingCartModel
{

    public $cartCount = 0;
    public $cartContent = array();
    public $cartSubtotal = 0;
    public $cartTotal = 0;
    public $cartTax = 0;
    public $cartShipping = 0;
	public $cart;
	public $stripeTotal = 0;    

}
