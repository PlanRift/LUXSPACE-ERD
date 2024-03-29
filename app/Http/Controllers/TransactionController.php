<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\transactionItems;
use App\Models\transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        if (request()->ajax()) {
            $query = transactions::query();
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <a href="' . route('dashboard.transaction.show', $item->id) . '" class="bg-orange-500 hover:bg-pink-700 text-white font-bold mx-2 py-2 px-4 rounded shadow-lg">Show</a>
                    <a href="' . route('dashboard.transaction.edit', $item->id) . '" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-lg">Edit</a>
            ';
                })->editColumn('price', function ($item) {
                    return number_format($item->price);
                })->rawColumns(['action'])->make();
        }

        return view('pages.dashboard.transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(transactions $transaction)
    {
        if (request()->ajax()) {
            $query = transactionItems::with(['product'])->where('transaction_id',$transaction->id);
            return DataTables::of($query)
                ->editColumn('product.price', function ($item) {
                    return number_format($item->product->price);
                })->rawColumns(['action'])->make();
        }

        return view('pages.dashboard.transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(transactions $transaction)
    {
        return view('pages.dashboard.transaction.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransactionRequest $request, Transactions $transaction)
    {
        $transaction->update($request->all());

        return redirect()->route('dashboard.transaction.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
