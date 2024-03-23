<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * Display user's reversed books
     */
    public function reversed()
    {
        abort_if(auth()->user()->is_admin, 404);
        $orders = Order::with('book')->where('user_id',auth()->id())->where('status','accepted')->where('type','reverse')->latest()->get();
        return inertia("Order/Reversed", compact('orders'));
    }
    /**
     * Display user's borrowed books
     */
    public function borrowed()
    {
        abort_if(auth()->user()->is_admin, 404);
        $orders = Order::with('book')->where('user_id',auth()->id())->where('status','accepted')->where('type','borrow')->latest()->get();
        return inertia("Order/Borrowed", compact('orders'));
    }

    /**
     * Display user's rejected orders
     */
    public function rejected()
    {
        abort_if(auth()->user()->is_admin, 404);
        $orders = Order::with('book')->where('user_id',auth()->id())->where('status','rejected')->latest()->get();
        return inertia("Order/Rejected", compact('orders'));
    }

    /**
     * Display user's pending orders
     */
    public function pending()
    {
        abort_if(auth()->user()->is_admin, 404);
        $orders = Order::with('book')->where('user_id',auth()->id())->where('status','pending')->latest()->get();
        return inertia("Order/Pending", compact('orders'));
    }
    /**
     * Display a listing of the resource for the admin.
     */
    public function index()
    {
        $orders = Order::with('user', 'book')->where('status','pending')->latest()->get();
        return inertia("Order/Index", compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Book  $book, ?String $type='borrow')
    {
        abort_if(auth()->user()->is_admin, 403);
        if(in_array($type, ['borrow', 'reverse'])){
            auth()->user()->orders()->create(['book_id' => $book->id, 'type' => $type]);
            return redirect()->back()->with('success', __('Done Successfully.'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        abort_unless(auth()->user()->is_admin, 403);
        if(in_array($request->status,['accepted','rejected'])){
            $order->update(['status' => $request->status]);
            return redirect()->back()->with('success', __('Done Successfully.'));
        }
    }

    /**
     * Update order type to reverse
     */
    public function reverse(Request $request, Order $order)
    {
        abort_if(auth()->user()->is_admin, 403);
        $order->update(['status' => 'pending', 'type' => 'reverse']);
        return redirect()->back()->with('success', __('Done Successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        abort_if(auth()->user()->is_admin, 403);
        auth()->user()->orders()->where('book_id', $book->id)->where('status', 'pending')->where('type', 'borrow')?->delete();
        return redirect()->back()->with('success', __('Done Successfully.'));
    }
}
