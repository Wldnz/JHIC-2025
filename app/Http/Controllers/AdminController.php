<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $transaction = [
            'total' => count(Transaction::get()),
            'success' => count(Transaction::where('status','=', 'success')->get()),
            'ongoing' => Transaction::where('status','=', 'ongoing')->get(),
            'fail' => count(Transaction::where('status','=', 'fail')->get()),
        ];
        $product = [
            'total' => count(Product::get()),
            'available' => 0,
            'almost-sold-out' => 0,
            'soldout' => 0,
        ];
        $account=[
            'total' => count(User::get()),
        ];
        $activity =[
            'total' => count(Activity::get())
        ];
        return view("admin.dashboard", [
            "title" => "Dashboard | Bina Tata Usaha",
            "transaction" => $transaction,
            "product" => $product,
            "account" => $account,
            "activity" => $activity
        ]);
    }



    public function products(Request $request){
        $searchQuery = $request->query("search", null);
        $products = Product::with("variants", "totalStock");

        if ($searchQuery) {
            $products = $products->where("name", "like", "%$searchQuery%");
        }

        $products = $products->get();
        $totalProducts = $products->count();
        $availableStockProducts = Product::query()
            ->select("products.*")
            ->join("product_variants", "products.id", "=", "product_variants.product_id")
            ->groupBy("product_variants.name")
            ->where("product_variants.stock", ">", 0)
            ->count();
        $lowStockProducts = Product::query()
            ->select("products.*")
            ->join("product_variants", "products.id", "=", "product_variants.product_id")
            ->groupBy("product_variants.name")
            ->where("product_variants.stock", "<", 5)
            ->count();
        $emptyStockProducts = Product::query()
            ->select("products.*")
            ->join("product_variants", "products.id", "=", "product_variants.product_id")
            ->groupBy("product_variants.name")
            ->where("product_variants.stock", "<=", 0)
            ->count();

        return view('admin.products', compact("products", "totalProducts", "availableStockProducts", "lowStockProducts", "emptyStockProducts"));
    }

    public function transactions(){
        return view("admin.transactions");
    }

    public function detailTransaction(Request $request, string $id){
        $transaction = Transaction::where('id', '=', $id)->first()->get();
        return view("admin.detailTransaction");
    }

    public function accounts(){
        return view("admin.accounts");
    }

    public function profile(){
        return view("admin.profile");
    }
}
