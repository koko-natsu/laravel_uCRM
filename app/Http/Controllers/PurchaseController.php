<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;

class PurchaseController extends Controller
{
    public function index()
    {
        $orders = Order::groupBy('id')
            ->selectRaw('id,
                        customer_name,
                        status,
                        sum(subtotal) as total,
                        created_at')->paginate(50);

        return Inertia::render('Purchase/Index', [
            'orders' => $orders,
        ]);
    }


    public function create()
    {
        $items = Item::select('id', 'name', 'price')
        ->where('is_selling', true)
        ->get();

        return Inertia::render('Purchase/Create', [
            'items'     => $items,
        ]);
    }



    public function store(StorePurchaseRequest $request)
    {
        DB::beginTransaction();

        try {
            $purchase = Purchase::create([
              'customer_id' => $request->customer_id,
              'status'      => $request->status
            ]);
    
            foreach($request->items as $item) {
              $purchase->items()->attach($purchase->id, [
                  'item_id' => $item['id'],
                  'quantity' => $item['quantity'],
              ]);
            }

            DB::commit();

            return to_route('dashboard');
        } 
        catch (\Exception $e) {
            DB::rollback();
            /*TODO: logへの記載 */
        }

    }



    public function show(Purchase $purchase)
    {
        $items = Order::where('id', $purchase->id)->get();

        $order = Order::groupBy('id')
            ->where('id', $purchase->id)
            ->selectRaw('id,
                        customer_name, 
                        status,
                        sum(subtotal) as total,
                        created_at,
                        updated_at')->get();

        // dd($order);

        return Inertia::render('Purchase/Show', [
            'items' => $items,
            'order' => $order,
        ]);
    }



    public function edit(Purchase $purchase)
    {
        $purchase = Purchase::find($purchase->id);
        $allItems    = Item::select('id', 'name', 'price')->get();

        $items = [];
        foreach($allItems as $allItem) {
            $quanitity = 0;
            foreach($purchase->items as $item) {
                if ($allItem->id === $item->id) {
                    $quanitity = $item->pivot->quantity;
                }
            }
            
            array_push($items, [
                'id'       => $allItem->id,
                'name'     => $allItem->name,
                'price'    => $allItem->price,
                'quantity' => $quanitity,
            ]);
        }

        $order = Order::groupBy('id')
            ->where('id', $purchase->id)
            ->selectRaw('
                    id,
                    customer_name, 
                    status,
                    sum(subtotal) as total,
                    created_at,
                    updated_at')->get();

        return Inertia::render('Purchase/Edit', [
            'items' => $items,
            'order' => $order,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePurchaseRequest  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        // dd($request);
        
        try {
            DB::beginTransaction();
    
            $purchase->status = $request->status;
            $purchase->save();
    
            $items = [];
            foreach($request->items as $item) {
                $items = $items + [
                    $item['id'] => ['quantity' => $item['quantity']],
                ];
            }

            $purchase->items()->sync($items);

            DB::commit();

            return to_route('dashboard');

        } catch (\Exception $e) {
            DB::rollback();
            /*TODO: logへの記載 */
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
