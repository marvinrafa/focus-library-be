<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCheckout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookCheckoutController extends Controller
{
    public function checkoutBook($id)
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();
        $book = Book::find($id);

        if($book->base_stock <= $book->checkouts()->where('active', true)->count()) {
            return response()->json(['message' => 'Not available stock for the book'], 400);
        }

        if($user->activeBooks()->where('book_id', $id)->exists()) {
            return response()->json(['message' => 'This book already has active checkout'], 400);
        }

        $user->books()->attach([$id]);

        return response()->json(['message' => 'Success'], 201);
    }

    public function checkoutHistory()
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();

        $book_checkouts = $user->bookCheckouts()->with('book:id,title')->get();

        return response()->json(['history' => $book_checkouts], 201);
    }

    public function finishCheckout($checkout_id)
    {
        /** @var \App\Models\User $user **/
        $user = Auth::user();

        $book_checkout = BookCheckout::where('active', true)->findOrFail($checkout_id);
        $book_checkout->active = false;
        $book_checkout->save();

        return response()->json(['message' => 'Success'], 201);
    }
}
