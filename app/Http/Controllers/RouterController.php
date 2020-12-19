<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RouterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //
    public function serve(Request $request, $model, $action, $id = null){
        $model_name = Str::ucfirst(Str::camel($model));
        $model_path = "App\\Models\\".$model_name;
        if(!class_exists($model_path))
        {
            return CrudController::generate_response($model_path, "The specified model not found! Please check for typos", true, 406);
        }
        else {
            $model = $model_path;
        }
        $controller_name_singular = Str::ucfirst(Str::camel($model)).'Controller';
        $controller_name_plural = Str::ucfirst(Str::plural(Str::camel($model))).'Controller';
        $controller_path = 'App\\Http\\Controllers\\';
        if(class_exists($controller_path.$controller_name_plural))
        {
            $controller_path = $controller_path.$controller_name_plural;
        }
        else if(class_exists($controller_path.$controller_name_singular))
        {
            $controller_path = $controller_path.$controller_name_singular;
        }
        else {
            $controller_path = $controller_path.'CrudController';
        }
        if($request->method() == 'GET' && $action == 'index')
        {
            return CrudController::index($request, $model, $id);
        }
        else if($request->method() == 'POST' && $action == 'show')
        {
            if(!$id){
                return CrudController::generate_response($model, "Please provide an id after /show/", true, 400);
            }
            return CrudController::show($request, $model, $id);
        }
        else if($request->method() == 'POST' && $action == 'store')
        {
            return CrudController::store($request, $model, $id);
        }
        else if($action == 'update')
        {
            if(!$id){
                return CrudController::generate_response($model, "Please provide an id after /show/", true, 400);
            }
            switch ($request->method()){
                case 'PUT':
                case 'PATCH':
                    return CrudController::update($request, $model, $id);
                default:
                    return CrudController::generate_response($model, "Please send request as PUT/PATCH method", true, 405);
            }
        }
        else if($action == 'destroy')
        {
            if(!$id){
                return CrudController::generate_response($model, "Please provide an id after /show/", true, 400);
            }else if($request->method() == 'DELETE'){
                return CrudController::destroy($request, $model, $id);
            }else{
                return CrudController::generate_response($model, "Please send request as PUT/PATCH method", true, 405);
            }
        }
        else{
            return CrudController::$action($request, $model, $id);
        }
    }
}
