<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $products = file_get_contents("products.json"); // get all products from json file
      return view('page')->with("products", json_decode($products));


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
      // We receive the response data
      $data = array(
       'productId' => md5( time() ),
       'productName' => $request->product_name,
       'quantity' => $request->quantity,
       'price' => $request->price,
       'datetime' => date("Y-m-d H:i:s")
      );

      // Update the json file
      $products = file_get_contents('products.json'); // Get all products
      $productsData = json_decode($products);
      array_push($productsData, $data); // We push the new data on json
      $productsU = json_encode($productsData); // We convert json format
      file_put_contents('products.json', $productsU); // we save the file

      //Return data to append on JavaScript
      return response()->json($data);
    }
}
