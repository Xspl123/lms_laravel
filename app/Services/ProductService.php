<?php

namespace App\Services;
use App\Models\Product;
use App\Models\History;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService{
    public function getProduct($id){
        $product = \App\Model\Product::find($id);
        return $product;
    }

    public function getProducts($limit = 10, $offset = 0){
        $products = \App\Model\Product::find($limit, $offset);
        return $products;
    }

    public function addProduct($data){
        
        $product = new Product();
        $product->uuid = $uuid = mt_rand(10000000, 99999999); // changed $meetings to $meeting and removed duplicate assignment of $uuid
        $product->Owner = Auth::User()->uname;
        $product->productName = $data['productName'];
        $product->productCode = $data['productCode'];
        $product->vendorName = $data['vendorName'];
        $product->productActive = $data['productActive'];
        $product->manufacturer = $data['manufacturer'];
        $product->productCategory = $data['productCategory'];
        $product->salesStartDate = $data['salesStartDate'];
        $product->salesEndDate = $data['salesEndDate'];
        $product->supportStartDate = $data['supportStartDate'];
        $product->unitPrice = $data['unitPrice'];
        $product->commissionRate = $data['commissionRate'];
        $product->usageUnit = $data['usageUnit'];
        $product->qtyOrdered = $data['qtyOrdered'];
        $product->quantityinStock = $data['quantityinStock'];
        $product->reorderLevel = $data['reorderLevel'];
        $product->handler = $data['handler'];
        $product->quantityinDemand = $data['quantityinDemand'];
        $product->description = $data['description'];
        $product->user_id = Auth::User()->id;
        $product->save();
        Log::channel('add_product')->info('A new product has been created. product data: '.$product);
        return $product;

    }

    public function createHistory($product, $feedback, $status)
        {
            $history = new History;
            $history->uuid = $product->uuid;
            $history->process_name  = 'Product';
            $history->created_by = $product->Owner;
            $history->feedback = $feedback;
            $history->status = $status;
            $history->save();
            $history->save();
        }

    public function updateProduct($id, $data){
        $product = Product::find($id);
        $product->fill($data);
        return $product->save();
    }

    public function deleteProduct($id){
        $product = Product::find($id);
        return $product->delete();
    }
}