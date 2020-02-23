<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;
use App\Models\ProductsModel;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function __construct(Request $request){

        if($request->path() == "admin/login"){
            $this->middleware('guest');
        }else{
            $this->middleware('admin');
        }
        

    }

    public function index(Request $request)
    {
        $route = Route::current();
        $viewName = 'admin.home';
        $data = array();
        $data['home'] = true;

        $search = isset($request['search'])?$request['search']:null;
        $filter = isset($request['filter'])?$request['filter']:null;
        if($filter){
            $data['products'] = ProductsModel::where('category', $filter)->get();
        }elseif($search && !empty($search)){
            $data['products'] = ProductsModel::where('name', 'like', "%$search%")->get();
        }else{
            $data['products'] = ProductsModel::all();
        }
        $data['filter'] = $filter;
        $data['search'] = $search;

        return view($viewName)->with($data);
    }

    public function login(Request $request)
    {
         
        $route = Route::current();
        $viewName = 'admin.login';
        
        if ($request->post() && Auth::attempt(['email' => $request['email'], 'password' => $request['password'] ])) {
             
            // Authentication passed...
            return redirect()->intended('/admin/');
        }
        

        return view($viewName);
    }

    public function add(Request $request)
    {

        $route = Route::current();
        $viewName = 'admin.home';
        $data = array();
        $data['home'] = false;
        
        return view($viewName)->with($data);
    }

    public function save(Request $request)
    {
        $fields = array("name", "description", "qty", "price");
        foreach($fields as $field){
            $$field = $request[$field];
        }
        if(!empty($request['id'])){
            //update
            $productsModel = ProductsModel::find($request['id']);
        }else{
            //insert
            $productsModel = new ProductsModel();
            $productsModel->sku = $request['sku'];
        }
        //upload image here
        if(!empty($request['image'])){
            $productsModel->image = $this->uploadImage($request);    
        }
        //set sku as image
        $productsModel->image = $request['sku'];

        foreach($fields as $field){
            $value = !empty($request[$field])?$request[$field]:"";
            $productsModel->$field = $value;
        }
        $productsModel->save();

        
         
        return "true";
    }

    public function delete(Request $request)
    {
        
        if(!empty($request['id'])){
            //update
            $deletedRows = ProductsModel::where('id', $request['id'])->delete();
        }
        

        //upload image here
         
        return "$deletedRows";
    }

    private function uploadImage($request){

        $file = $request->file('image');
        $path = $file->store('files', 'public');
        
        if($file->isValid()){
            return "/storage/".$path;
        }
         
        return false;

    }

}
