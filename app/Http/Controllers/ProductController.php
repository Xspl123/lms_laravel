<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        //
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
    public function createProduct(Request $request)
    {
        $productOwner = Auth::user()->uname;
         //print_r($productOwner); die;
        $userId = Auth::id();
       // print_r($userId); die;
        $rules = [
            'productName' => 'required',
            'productCode' => 'required',
            'vendorName' => 'required',
            'productActive' => 'required',
            'manufacturer' => 'required',
            'productCategory' => 'required',
            'salesStartDate' => 'required',
            'salesEndDate' => 'required',
            'supportStartDate' => 'required',
            'unitPrice' => 'required',
            'commissionRate' => 'required',
            'usageUnit' => 'required',
            'qtyOrdered' => 'required',
            'quantityinStock' => 'required',
            'reorderLevel' => 'required',
            'handler' => 'required',
            'quantityinDemand'=> 'required',
            'description' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product =  new Product;
        $product->productOwner = $productOwner;
        $product->productName = $request->productName;
        $product->productCode = $request->productCode;
        $product->vendorName = $request->vendorName;
        $product->productActive = $request->productActive;
        $product->manufacturer = $request->manufacturer;
        $product->productCategory = $request->productCategory;
        $product->salesStartDate = $request->salesStartDate;
        $product->salesEndDate = $request->salesEndDate;
        $product->supportStartDate = $request->supportStartDate;
        $product->unitPrice = $request->unitPrice;
        $product->commissionRate = $request->commissionRate;
        $product->usageUnit = $request->usageUnit;
        $product->qtyOrdered = $request->qtyOrdered;
        $product->quantityinStock = $request->quantityinStock;
        $product->reorderLevel = $request->reorderLevel;
        $product->handler = $request->handler;
        $product->quantityinDemand = $request->quantityinDemand;
        $product->description = $request->description;
        $product->user_id = $userId;
        $product->save();
        //print_r($product);die;

        return response()->json(['message' => 'Product Added successfully'], 201); 

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function showProductList(Product $product)
    {
        // $userId = Auth::user()->id;
        // $product = Product::join('users', 'products.user_id', '=', 'users.id')
        //            ->select('products.*')
        //            ->where('users.id', $userId)
        //            ->orderBy('id', 'desc')
        //            ->get();
        $data_list = AllInOneController::tabledetails_col("products","*");       
        return response([
            'data_list'=>$data_list,
            'status'=>'success'
        ], 200);
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
    public function updateProduct(Request $request, $id )
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update($request->all());

        return response()->json(['message' => 'Product updated', 'product' => $product], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function deleteProduct(Product $product, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted'], 200);
    }
}
