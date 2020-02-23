<?php

namespace App\Http\Controllers;

use http\Exception\BadQueryStringException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Password;
use Route;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Models\PrescriptionModel;
use App\Models\OrdersModel;
use App\Models\ShippingModel;
use App\Models\StatesModel;

class AccountController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, SendsPasswordResetEmails, RegistersUsers;

    public function __construct()
    {

        $route = Route::current();
        switch($route->uri){
            case "account/register":
                break;
            case "account/login":
                break;
            case "account/forgotpassword":
                break;
            case "account/logout":
                break;
            case "account/resetpassword":
                break;    
            default:
                $this->middleware('auth');
                break;
        }


    }

    public function resetpassword(Request $request){
        
        $password = $request['password'];
        
        dd("*");
    }

    public function forgotpassword(Request $request){

        $passwordReset = false;
        if ($_POST) {
            $this->sendResetLinkEmail($request);
            $passwordReset = true;
        }
        $checkout = true;
        return view('account.passwords-reset', compact( 'checkout', 'passwordReset'));

    }

    public function logout(Request $request){

        Auth::logout();
        return redirect('account/login')->with('notloggedin', true);
    }

    public function login(Request $request){

        if($_POST ){
            if (Auth::attempt(['email' => $request->input('login.username'), 'password' => $request->input('login.password')])) {
                // Authentication passed...

                //$this->adminUser = Auth::user()->isAdmin();
                //dd($this->adminUser);
                return redirect()->intended('checkout');
            }else{
                $data['loginfail'] = true;
            }
        }

        $data['checkout'] = true;
        return view('account.login')->with($data);
    }

    public function details(){

        $data['account'] = true; 
        $user = Auth::user();
        $data['firstname'] = $user->firstname;
        $data['lastname'] = $user->lastname;
        $data['email'] = $user->email;
        $shipping = ShippingModel::where('user_id', $user->id)->get();
        $data['street1'] = $shipping[0]->street1;
        $data['street2'] = $shipping[0]->street2;
        $data['company'] = $shipping[0]->company;
        $data['postcode'] = $shipping[0]->postcode;
        $data['city'] = $shipping[0]->city;
        $data['region_id'] = $shipping[0]->region_id;
        $data['country_id'] = $shipping[0]->country_id;
        $data['telephone'] = $shipping[0]->telephone;

        return view('account.details')->with($data);

    }
    
    public function editshipping(){
        
        $data['account'] = true;
        $user = Auth::user();
        $shipping = ShippingModel::where('user_id', $user->id)->get();
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
        $data['states'] = array();
        $data['states'] = StatesModel::all();
        return view('account.edit-shipping')->with($data);
        
    }

    public function edit(){

        $data['account'] = true;
        $user = Auth::user();
        $data['firstname'] = $user->firstname;
        $data['lastname'] = $user->lastname;
        $data['email'] = $user->email;
        return view('account.edit-personaldetails')->with($data);

    }

    public function uploadPrescription(Request $request){
        
        if($request->isMethod('post')){
            $file = $request->file('rx-image');
            $extension = $file->extension();
            $path = $file->store('rx-image');
            if($file->isValid()){
                $prescriptionData['user_id'] = Auth::user()->id;
                $prescriptionData['filename'] = $path;
                $prescriptionModel = new PrescriptionModel();
                $prescriptionModel->updateOrCreate(['user_id' => $prescriptionData['user_id']], $prescriptionData);
                echo json_encode("uploaded");
                exit;
            }
            

        }

    }

    public function history(Request $request, $orderId = null)
    {

        if(!empty($orderId)){
            $data = $this->getOrderById($orderId);
            $data['account'] = true;
            return view('account.ordersummary')->with($data);
        }else{
            $data['orders'] = OrdersModel::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
            $data['account'] = true;
            
        }
        
        return view('account.orderhistory')->with($data);

    }

    private function getOrderById($orderId){

        if(!empty($orderId)){
            $orderData = OrdersModel::find($orderId);
            if(!empty($orderData)){
                $cart = $orderData->cart;
                $data['cartDetails'] = unserialize($cart);
                foreach($data['cartDetails'] as $key => $value){
                    
                        //TODO get product url here
                        //OrdersModel::find ($value['item_id']);
                        if(is_numeric($key))
                        $temp[$key]['productURL'] = "testing";
                }
                
                foreach($temp as $key => $value){
                    $data['cartItems'][$key] = (object) ($data['cartDetails'][$key] + $value);
                }
                $data['cartShipping'] = $data['cartDetails']['shipping'];
                $data['cartTotal'] = $data['cartDetails']['total'];
                $data['cartSubtotal'] = $data['cartDetails']['subtotal'];
                $data['cartTax'] = $data['cartDetails']['tax'];
                $data['orderid'] = $orderId;
                return $data;
                
            }
            
        }

    }

    public function prescriptions(Request $request){

        $data['account'] = true;
        return view('account.prescriptions')->with($data);

    }


}
