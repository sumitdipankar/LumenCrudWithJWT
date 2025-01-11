<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = Product::where('status',1)->get();
            return response()->json(['success' => true, 'code' => 200, 'message' => 'Product Lists', 'data' => $data]);
        }catch(Exception $ex){
            return response()->json(['success' => false, 'code' => 500, 'message' => 'Internal Server']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'  => 'required',
            'product_number'    => 'required|unique:products,product_number'
        ]);
        if($validator->fails()){
            return response()->json(['status' => false, 'code' => 400, 'message' => 'Validation error', 'error' => $validator->errors()]);
        }
        try{
            $product = Product::create($request->all());
            return response()->json(['success' => true, 'code' => 201, 'message' => 'product created successfully', 'data' => $product]);
        }catch(Exception $ex){
            return response()->json(['success' => false, 'code' => 500, 'message' => 'Internal Server']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $details = Product::find($id);
            return response()->json(['success' => true, 'code' => 200, 'message' => 'product details', 'data' => $details]);
        }catch(Exception $ex){
            return response()->json(['success' => false, 'code' => 500, 'message' => 'Internal Server']); 
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name'  => 'required',
            'product_number'    => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['status' => false, 'code' => 400, 'message' => 'Validation error']);
        }
        try{
            $product = Product::find($id);
            $product->update($request->all());
            return response()->json(['success' => true, 'code' => 200, 'message' => 'product updated successfully', 'error' => $validator->errors()]);
        }catch(Exception $ex){
            return response()->json(['success' => false, 'code' => 500, 'message' => 'Internal Server']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $details = Product::find($id);
            $details->delete();
            return response()->json(['success' => true, 'code' => 200, 'message' => 'product deleted successfully']);
        }catch(Exception $ex){
            return response()->json(['success' => false, 'code' => 500, 'message' => 'Internal Server']); 
        }
    }
}
