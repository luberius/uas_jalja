<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Barang as BarangModel;

use Illuminate\Http\Request;
use Validator;

class Barang extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = BarangModel::all();

        return $this->sendResponse($barang, 'Products retrieved successfully.');
    }

    public function type(Request $request, $type) {
        $barang = BarangModel::where('tipe', '=', $type)->get();

        return $this->sendResponse($barang, 'Products retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'nama' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $product = BarangModel::create($input);
        return $this->sendResponse($product, 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = BarangModel::find($id);
  
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
   
        return $this->sendResponse($product, 'Product retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'nama' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $product = BarangModel::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }

        $product->nama = $input['nama'];
        $product->deskripsi = $input['deskripsi'];
        $product->url_gambar = $input['url_gambar'];
        $product->tipe = $input['tipe'];
        $product->save();
   
        return $this->sendResponse($product, 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = BarangModel::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }

        $product->delete();
   
        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
