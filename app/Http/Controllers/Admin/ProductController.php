<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\Traits\UploadTrait;

class ProductController extends Controller
{
    private $product;
    use UploadTrait;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = auth()->user();

        if(!$user->store()->exists()){
            flash('Crie uma loja para acessar seus produtos!')->warning();
            return redirect()->route('admin.stores.index');
        }

        $products = $user->store->products()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = \App\Category::all(['id', 'name']);
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {   
        $data = $request->all();
        $categories = $request->get('categories', null);
        $store = Auth()->user()->store;
        $data['price'] = formatPriceToDatabase($data['price']);
        $product = $store->products()->create($data);
        $product->categories()->sync($categories);
        if($request->hasFile('photos')) {
            $images = $this->imageUpload($request->file('photos'), 'image');
            
            $product->photos()->createMany($images);
        }

        flash('Produto criado com sucesso')->success();
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($product)
    { 
        $categories = \App\Category::all(['id', 'name']);
        $product = $this->product->findOrFail($product);
        return view('admin.products.edit', compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $product)
    {
        $data = $request->all();
        $categories = $request->get('categories', null);
        $product = $this->product->find($product);
        $data['price'] = formatPriceToDatabase($data['price']);
        $product->update($data);
        if(! is_null($categories)){
            $product->categories()->sync($categories);
        }

        if($request->hasFile('photos')) {
            $images = $this->imageUpload($request->file('photos'), 'image');
            
            $product->photos()->createMany($images);
        }
        
        flash('Produto atualizado com sucesso')->success();
        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {
        $product = $this->product->find($product);
        $product->delete();

        flash('Produto deletado com sucesso')->success();
        return redirect()->route('admin.products.index');
    }
}
