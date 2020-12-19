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
        $entries = $model::all();
        return self::generate_response($model, $entries);
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
            return self::generate_response($model, $entry, false, 201);
        }catch (\Exception $error){
            return self::generate_response($model, $error->getMessage(), true, 409);
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
    public static function generate_response($model, $data, $error = false, $status = 200)
    {
        $response = new \stdClass();
        $response->status = $status;
        $response->error = $error;
        $response->model = $model;
        $response->data = is_countable($data) ? $data : [$data];
        return response()->json($response, $status);
    }
}
