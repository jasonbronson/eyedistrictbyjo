<?php

namespace App;
use Cart;

class ShoppingCart
{

    private $cartCount = 0;
    private $cartContent = array();
    private $cartSubtotal = 0;
    private $cartTotal = 0;
    private $cartTax = 0;
    private $cartShipping = 0;
    private $cart;

    public function addCart($data){
		$id = $data['sku'];
		$name = $data['name'];
        $qty = $data['qty'];
        $price = $data['price'];
        $size = $data['size'];
        Cart::add(['id' => $id, 'name' => $name, 'qty' => $qty, 'price' => $price, 'options' => ['size' => $size]]);
       
        
    }

    public function removeCartItem($rowId){
        Cart::remove($rowId);
    }

    public function shoppingCart()
    {

        $this->cartCount = !empty(Cart::content()->count())?Cart::content()->count():$this->cartCount;
        $this->cartTotal = Cart::total();
        $this->cartTax = Cart::tax();
        $this->cartSubtotal = Cart::subtotal();
        $this->cartShipping = Cart::shipping();
        $this->cartContent = Cart::Content();
        
        //echo "<pre>"; var_dump($this->cartContent); exit;

    }

    public function getCartCount(){
		return $this->cartCount;
	}

	public function setCartCount($cartCount){
		$this->cartCount = $cartCount;
	}

	public function getCartContent(){
		return $this->cartContent;
	}

	public function setCartContent($cartContent){
		$this->cartContent = $cartContent;
	}

	public function getCartSubtotal(){
		return $this->cartSubtotal;
	}

	public function setCartSubtotal($cartSubtotal){
		$this->cartSubtotal = $cartSubtotal;
	}

    public function getStripeTotal(){
        $this->stripeTotal = str_replace(".", "", $this->cartTotal);
        return $this->stripeTotal;
    }

	public function getCartTotal(){
		return $this->cartTotal;
    }
    
    public function setCartTotal($cartTotal){
		$this->cartTotal = $cartTotal;
	}

	public function getCartTax(){
		return $this->cartTax;
	}

	public function setCartTax($cartTax){
		$this->cartTax = $cartTax;
	}

	public function getCartShipping(){
		return $this->cartShipping;
	}

	public function setCartShipping($cartShipping){
		$this->cartShipping = $cartShipping;
	}

	public function getCart(){
		return $this->cart;
	}

	public function setCart($cart){
		$this->cart = $cart;
	}
    

}
