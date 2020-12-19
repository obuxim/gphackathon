<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CrudController extends Controller
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

    // Index
    public static function index(Request $request, $model, $id)
    {

    }

    // Show
    public static function show(Request $request, $model, $id)
    {
        dd('Show', $model, $id, $request);
    }

    // Store
    public static function store(Request $request, $model, $id)
    {
        $entry = new $model();
        foreach ($request->all() as $name => $input){
            $entry->$name = $input;
        }
        try{
            $entry->save();
            return response($entry, 201);
        }catch (\Exception $error){
            return response($error->getMessage(), 409);
        }
    }

    // Update
    public static function update(Request $request, $model, $id)
    {
        dd('Update', $model, $id, $request);
    }

    // Destroy
    public static function destroy(Request $request, $model, $id)
    {
        dd('Destroy', $model, $id, $request);
    }

    /*
     * Helper Functions
     */

    // Generate Common Response

}
