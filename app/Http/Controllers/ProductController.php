<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Http\Requests\ProductRequest;
use App\Models\Products;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (request()->ajax()) {
            $query = Products::query();
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <a href="' . route('dashboard.product.gallery.index', $item->id) . '" class="bg-orange-500 hover:bg-pink-700 text-white font-bold mx-2 py-2 px-4 rounded shadow-lg">Gallery</a>
            <a href="' . route('dashboard.product.edit', $item->id) . '" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-lg">Edit</a>
            <form class="inline-block" method="POST" action="' . route('dashboard.product.destroy', $item->id) . '">
                    ' . method_field('delete') . csrf_field() . '
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold ms-1 py-1.5 px-3 rounded shadow-lg">
                    Delete
                    </button>
            </form>
            ';
                })->editColumn('price', function ($item) {
                    return number_format($item->price);
                })->rawColumns(['action'])->make();
        }

        return view('pages.dashboard.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        Products::create($data);

        return redirect()->route('dashboard.product.index');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $product)
    {
        return view('pages.dashboard.product.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $product)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        $product->update($data);

        return redirect()->route('dashboard.product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $product)
    {
        $product->delete();

        return redirect()->route('dashboard.product.index');
    }
}
