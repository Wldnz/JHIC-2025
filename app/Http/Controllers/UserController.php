<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function loginPage(Request $request){
        return view('login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'nis' => ['required'],
            'password' => ['required']
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withErrors([
            "message" => "Data yang diberikan tidak valid!"
        ])->onlyInput("nis");
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect()->route('login');
    }


    // Siswa Controller

    public function dashboard(){
        return view("dashboard");
    }

    public function about(){
        return view("about");
    }

    public function products(Request $request){
        $searchQuery = $request->query("search", null);
        $products = Product::with("images");

        if ($searchQuery) {
            $products = $products
                ->where("name", "like", "%$searchQuery%");
        }

        $products = $products->get();

        return view("products", compact("products"));
    }

    public function detailProduct(Product $product){
        $product->load("variants", "images");
        $recommendedProducts = Product::with("images")->whereRaw("SOUNDEX('$product->name') = SOUNDEX(products.name)", )->limit(4)->get();

        return view("detailProduct", compact("product", "recommendedProducts"));
    }

    public function cart(){
        $carts = Cart::with('product_variant_id')->get();
        $totalCost = $carts->sum(function($cart){
            return $cart->product_variant_id->price * $cart->quantity;
        });

        return view("cart", compact("carts", "totalCost"));
    }

    public function updateCart(UpdateCartRequest $request, Cart $cart){
        if ($request->quantity <= 0) {
            $cart->delete();
            return response()->json([
                "success" => true,
                "message" => "Cart item deleted",
                "deleted" => true,
            ]);
        } else if ($request->quantity > $cart->product_variant_id->stock) {
            return response()->json([
                "success" => false,
                "message" => "Unsufficient stock",
                "deleted" => false,
            ], Response::HTTP_BAD_REQUEST);
        }

        $cart->quantity = $request->quantity;
        $isSaved = $cart->save();

        if ($isSaved) {
            return response()->json([
                "success" => true,
                "message" => "Cart item updated",
                "deleted" => false,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Failed to update cart item",
                "deleted" => false,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteCart(Cart $cart){
        $isDeleted = $cart->delete();
        if ($isDeleted) {
            return response()->json([
                "success" => true,
                "message" => "Cart item deleted",
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Failed to delete cart item",
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function transactions(Request $request){
        $statusQuery = $request->query("status", null);
        $searchQuery = $request->query("search", null);

        $transactions = Transaction::with("orders");

        if ($statusQuery) {
            $transactions = $transactions
                ->where("transactions.status", "=", $statusQuery);
        }

        if ($searchQuery) {
            $transactions = $transactions
                ->join("orders", "transactions.id", "=", "orders.transaction_id")
                ->where("orders.name", "like", "%$searchQuery%")
                ->where("transactions.id", "like", "%$searchQuery%");
        }

        $transactions = $transactions->get();

        return view("transactions", compact("transactions"));
    }

    public function detailTransaction(Transaction $transaction){
        $transaction->load("orders");
        return view("detailTransaction", compact("transaction"));
    }
}
