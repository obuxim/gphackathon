<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingsController extends CrudController {

    public static function store(Request $request, $model, $id)
    {
        dd($request);
        return parent::store($request, $model, $id); // TODO: Change the autogenerated stub
    }
}
