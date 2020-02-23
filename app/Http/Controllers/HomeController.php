<?php

namespace App\Http\Controllers;

use App\ShoppingCart;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ProductsModel;
use Artisan;

class HomeController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function __construct()
    {

        $this->cart = new ShoppingCart();

    }

    public function view(Request $request)
    {

        $route = Route::current();
        $data['isHome'] = false;

        switch($route->uri){
            case "locations":
                $viewName = 'locations';
            break;
            case "help":
                $viewName = 'help';
            break;
            default:
                $viewName = 'home';
                $data['isHome'] = true;
            break;
        }

        return view($viewName)->with($data);
    }
    public function ContactUs(Request $request){
    	$vars['sent'] = false;
    	if($request->post() && !empty($request->name) ){
    		$parameters = array('email', 'name', 'telephone', 'subject', 'comment');
    		foreach($parameters as $key => $value){
    		    $data[$key] = $request[$key];
    		}
    		mail("jasonbronson@gmail.com", "Contact Eyedistrictbyjo", print_r($data, true));
    	    $vars['sent'] = true;
    	}
    	
        return view('contactus')->with($vars);
            
    }
    
    public function ProductPages(Request $request){
        $route = Route::current();
        $uri = $request->url();
        if (preg_match("/women-optical/i", $uri)) {
            if(preg_match("/women-optical\/\d*/i", $uri) && !preg_match("/women-optical\/$/i", $uri) ){
                $sku = getItemByUri($uri);
                $data['products'] = ProductsModel::where('sku', $sku)->where('active', 1)->get();
            }else{
                $data['products'] = ProductsModel::where('category', 'WOMENOPTICAL')->where('active', 1)->take(100)->get();
            }
            $data['type'] = "women optical";
        }
        if (preg_match("/\/men-optical/i", $uri)) {
            if(preg_match("/men-optical\/\d*/i", $uri) && !preg_match("/men-optical\/$/i", $uri) ){
                $sku = getItemByUri($uri);
                $data['products'] = ProductsModel::where('sku', $sku)->where('active', 1)->get();    
            }else{
                $data['products'] = ProductsModel::where('category', 'MENOPTICAL')->where('active', 1)->take(100)->get();
            }
            $data['type'] = "men optical";
        }
        if (preg_match("/kids-optical/i", $uri)) {
            if(preg_match("/kids-optical\/\d*/i", $uri) && !preg_match("/kids-optical\/$/i", $uri) ){
                $sku = getItemByUri($uri);
                $data['products'] = ProductsModel::where('sku', $sku)->where('active', 1)->get();
            }else{
                $data['products'] = ProductsModel::where('category', 'KIDSOPTICAL')->where('active', 1)->take(100)->get();
            }
            $data['type'] = "kids optical";
        }
        if (preg_match("/\/men-sunglasses/i", $uri)) {
            if(preg_match("/men-sunglasses\/\d*/i", $uri) && !preg_match("/men-sunglasses\/$/i", $uri) ){
                $sku = getItemByUri($uri);
                $data['products'] = ProductsModel::where('sku', $sku)->where('active', 1)->get();    
            }else{
                $data['products'] = ProductsModel::where('category', 'MENSUNGLASSES')->where('active', 1)->take(100)->get();
            }
            $data['type'] = "men sunglasses";
        }
        if (preg_match("/\/women-sunglasses/i", $uri)) {
            if(preg_match("/women-sunglasses\/\d*/i", $uri) && !preg_match("/women-sunglasses\/$/i", $uri) ){
                $sku = getItemByUri($uri);
                $data['products'] = ProductsModel::where('sku', $sku)->where('active', 1)->get();    
            }else{
                $data['products'] = ProductsModel::where('category', 'WOMENSUNGLASSES')->where('active', 1)->take(100)->get();
            }
            $data['type'] = "women sunglasses";
        }
        if (preg_match("/\/kids-sunglasses/i", $uri)) {
            if(preg_match("/kids-sunglasses\/\d*/i", $uri) && !preg_match("/kids-sunglasses\/$/i", $uri) ){
                $sku = getItemByUri($uri);
                $data['products'] = ProductsModel::where('sku', $sku)->where('active', 1)->get();    
            }else{
                $data['products'] = ProductsModel::where('category', 'KIDSSUNGLASSES')->where('active', 1)->take(100)->get();
            }
            $data['type'] = "kids sunglasses";
        }
         
       
        return view('products')->with($data);
        
    }    

    private function getItemByUri($uri){
        $uriSplit = explode('/', $uri);
        $sku = $uriSplit[sizeof($uriSplit)-1];
        if(is_numeric($sku)){
            return $sku;
        }else{
            return 0;
        }
    }

    public function ProductDetail($sku, Request $request){
        $uri = $request->url();
        $data['productDetail'] = true;
        
        $data['sku'] = $sku;
        $product = ProductsModel::where('sku', $sku)->first();
        $data['details'] = @unserialize($product['details']);
        $data['details'] = is_array($data['details'])?$data['details']:array();
        $data['price'] = $product['price'];
        $data['pairs'] = $product['pairs'];
        $data['size'] = $product['size'];
        $data['image1'] = $product['image'];
        $data['material'] = $product['material'];
        $data['category'] = $product['category'];
        $data['breadcrumb'] = array($product['category'], 'optical', $sku);

        return view('productdetail')->with($data);
    }

    public function deploywebsite(Request $request){

        Artisan::call("deploy:website", ['seed' => $request['seed']]);
        echo nl2br(Artisan::output());
        exit;
    }

    public function temp(Request $request){
        

        $data['images'] = ProductsModel::where('active', 1)->get();
        
        /*$data['arrowup_x'] = -10;
        $data['arrowup_y'] = 200;
        $data['arrowside_x'] = 0;
        $data['arrowside_y'] = 200;*/
        
        return view('temp')->with($data);
        
    }    

    public function tempgetimage(Request $request){

        $id = $request->input('id');
        $item = ProductsModel::where('id', $id)->first();
        return $item;
    }

    public function tempsave(Request $request){
        
        //dd("k");
        $id = $request->input('id');
        $item = ProductsModel::where('id', $id)->first();        
        $item->arrowside_y = $request->input('arrowside_y');
        $item->arrowside_x = $request->input('arrowside_x');
        $item->rightside_y = $request->input('rightside_y');
        $item->rightside_x = $request->input('rightside_x');
        $item->save();

        
        /*$data['arrowup_x'] = -10;
        $data['arrowup_y'] = 200;
        $data['arrowside_x'] = 0;
        $data['arrowside_y'] = 200;*/
        
        return array("success");
        
    }    



}
