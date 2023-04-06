<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{

   

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

     
    
    public function index()
    {
        //
    }

    
    public function createProduct(Request $request,ProductService $productService)
    {
        $validatedData = $request->validate([
            'productName' => 'required',
            'productCode' => 'required',
            'vendorName' => 'nullable',
            'productActive' => 'nullable',
            'manufacturer' => 'nullable',
            'productCategory' => 'nullable',
            'salesStartDate' => 'nullable',
            'salesEndDate' => 'nullable',
            'supportStartDate' => 'nullable',
            'unitPrice' => 'nullable',
            'commissionRate' => 'nullable',
            'usageUnit' => 'nullable',
            'qtyOrdered' => 'nullable',
            'quantityinStock' => 'nullable',
            'reorderLevel' => 'nullable',
            'handler' => 'nullable',
            'quantityinDemand'=> 'nullable',
            'description' => 'nullable',
        ]);
        
        $result = $this->productService->addProduct($validatedData);
    
        return response()->json(['success' => true, 'message' => 'Product added successfully']);
        
    }
   
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

        Log::channel('update_product')->info(' update_product  has been successfull. updated product data: '.$product);


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

        Log::channel('deleted_product')->info(' Product  has been deleted successfull. delete product data: '.$product);


        return response()->json(['message' => 'Product deleted'], 200);
    }
}
