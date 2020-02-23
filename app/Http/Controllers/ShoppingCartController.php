<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Route;
use Auth;
use App\ShoppingCart;
use Illuminate\Http\Request;
use App\Models\ShippingModel;
use App\Prescription;
use Log;
use App\Models\PaymentsModel;
use Stripe\{Stripe, Charge, Customer};
use App\Models\OrdersModel;
use App\Models\ProductsModel;
use App\Models\StatesModel;
use Cart;

class ShoppingCartController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    

    public function __construct()
    {
        $this->cart = new ShoppingCart();
        
        
    }

    public function view(Request $request)
    {
        $this->cart->shoppingCart();
        $data = array("firstname"=>'', "lastname"=>'');
        foreach($data as $key => $value){
            if( !empty($request->$key) ){
                $data[$key] = $request->$key;
            }else{
                $data[$key] = $value;
            }
        }
        $route = Route::current();
        $checkout = true;
        switch($route->uri){
            case "cartremove":
                $this->cart->removeCartItem($request->input('id'));
                return redirect('cart');
                break;
            default:
                $viewName = 'shoppingcart';
                break;

        }
        $shoppingCartData = $this->getShoppingCart();
        $data['checkout'] = $checkout;
        $data = array_merge($data, $shoppingCartData);
        
        //$data['isCart'] = $isCart;

        return view($viewName)->with($data);

    }

    public function checkout(){

        if( !Auth::check() ){
            return redirect('account/login')->with('checkout', true);
        }
        
        $data['checkout'] = true;
        $user = Auth::user();
        $shipping = ShippingModel::where('user_id', $user->id)->get();
        //dd($shipping);
        $data['firstname'] = $shipping[0]->firstname;
        $data['lastname'] = $shipping[0]->lastname;
        $data['street1'] = $shipping[0]->street1;
        $data['street2'] = $shipping[0]->street2;
        $data['company'] = $shipping[0]->company;
        $data['postcode'] = $shipping[0]->postcode;
        $data['city'] = $shipping[0]->city;
        $data['region_id'] = $shipping[0]->region_id;
        $data['country_id'] = $shipping[0]->country_id;
        $data['telephone'] = $shipping[0]->telephone;

        $this->cart->shoppingCart();
        $shoppingCartData = $this->getShoppingCart();
        $data = array_merge($data, $shoppingCartData);
        $data['states'] = StatesModel::all();
        //$data['states'] = StatesModel::get();

        return view('checkout')->with($data);


    }

    public function addCart($sku){

            $product = ProductsModel::where('sku', $sku)->get();
            if(!empty($product) && isset($product[0]->sku)){
                $cart['sku'] = $product[0]->sku;
                $cart['category'] = $product[0]->category;
                $cart['size'] = "";
                $cart['name'] = $product[0]->name;
                $cart['qty'] = 1;
                $cart['price'] = $product[0]->price;
                $cart['options'] = @unserialize($product[0]->details);
                $this->cart->addCart($cart);
            }
            
            return redirect('cart')->with('cartItemAdded', true);

    }

    /**
     * Save the shipping information to session
     */
    public function shipping(Request $request){
        
        if( !Auth::check() ){
            return redirect('account/login')->with('notloggedin', true);
        }

        $account = true;
        $viewName = 'checkout';
        $shippingData = $request->shipping;
        $shippingData['user_id'] = Auth::user()->id;

        //save shipping data
        try{
            $shippingModel = new ShippingModel();
            $shippingModel->updateOrCreate(['user_id' => $shippingData['user_id']], $shippingData);
        }catch(\Illuminate\Database\QueryException $e){
            Log::info('Error saving shipping model '.$e->getMessage());
            return redirect()->back()->withInput($shippingData);
        }
        
        return redirect('checkout/prescription');
        
    }

    public function prescription(Request $request){
 
        if( !Auth::check() ){
            return redirect('account/login')->with('notloggedin', true);
        }

        $account = true;
        $viewName = 'prescription';
        
        
        return view($viewName, compact('account'));

    }

    public function payment(Request $request){
        
        if( !Auth::check() ){
            return redirect('account/login')->with('notloggedin', true);
        }
               //dd($request);
               $this->cart->shoppingCart();
               $viewName = 'payment';
               $data = $this->getShoppingCart();
               $data['account'] = true;
               $data['email'] = Auth::user()->email;
               if($request->post() && request('stripeToken')){
                    Stripe::setApiKey(config('services.stripe.secret'));
                    $customer = Customer::create([
                        'email' => request('stripeEmail'),
                        'source' => request('stripeToken')
                    ]);
                    Charge::create([
                        'customer' => $customer->id,
                        'amount' => $this->cart->getStripeTotal(),
                        'currency' => 'usd'
                    ]);

                    $paymentData['user_id'] = Auth::user()->id;
                    $paymentData['stripe_customer_id'] = $customer->id;
                    $paymentData['token'] = request('stripeToken');
                    $paymentData['amount'] = $this->cart->getCartTotal();
                    $response = PaymentsModel::create($paymentData);
                    $order = $this->saveOrder($paymentData['token'], $paymentData['user_id']);
                    
                    return redirect('checkout/ordercomplete')->with('order_id', $order->id);
                    
               }
               return view($viewName)->with($data); 
       
    }

    public function OrderComplete(){

        $data['account'] = true;
        Cart::destroy();
        return view('order-complete')->with($data);
    }

    private function getShoppingCart(){
        
        $data['cartCount'] = $this->cart->getCartCount();
        $data['cartContent'] = $this->cart->getCartContent();
        $data['cartTotal'] = $this->cart->getCartTotal();
        $data['stripeTotal'] = $this->cart->getStripeTotal();
        $data['cartSubtotal'] = $this->cart->getCartSubtotal();
        $data['cartShipping'] = $this->cart->getCartShipping();
        $data['cartTax'] = $this->cart->getCartTax();
        
        return $data;
    }

    private function saveOrder($token, $userId){

        $items = $this->cart->getCartContent();
        foreach($items as $item){
            $data['item_id'] = $item->id;
            $data['qty'] = $item->qty;
            $data['name'] = $item->name;
            $data['price'] = $item->price;
            $options = null;
            foreach($item->options as $key=>$value){
                $options[$key] = $value;
            }
            $data['options'] = $options;
            $data['taxrate'] = $item->taxrate;
            $cart[] = $data;
        }
        $cart['user_id'] = $userId;
        $cart['token'] = $token;
        $shoppingcart = $this->getShoppingCart();
        $cart['total'] = $shoppingcart['cartTotal'];
        $cart['subtotal'] = $shoppingcart['cartSubtotal'];
        $cart['shipping'] = $shoppingcart['cartShipping'];
        $cart['tax'] = $shoppingcart['cartTax'];
        $order['cart'] = serialize($cart);
        $order['user_id'] = $userId;
        return OrdersModel::create($order);

    }


}
