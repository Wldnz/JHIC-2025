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
    protected $limitPagination = 8;
    public function dashboard()
    {
        $transaction = [
            'total' => count(Transaction::get()),
            'success' => count(Transaction::where('status', '=', 'success')->get()),
            'ongoing' => count(Transaction::where('status', '=', 'ongoing')->get()),
            'fail' => count(Transaction::where('status', '=', 'fail')->get()),
        ];
        $product = [
            'total' => count(Product::get()),
            'available' => 0,
            'almost sold' => 0,
            'soldout' => 0,
        ];
        $account = [
            'total' => count(User::get()),
        ];
        $activity = [
            'total' => count(Activity::get())
        ];
        return view("admin.dashboard", [
            "transaction" => $transaction,
            "product" => $product,
            "account" => $account,
            "activity" => $activity
        ]);
    }



    public function products(Request $request)
    {
        $searchQuery = $request->query("search", null);
        $currentPage = $request->query("page", 1);
        $products = Product::with("variants");

        if ($searchQuery) {
            $products = $products->where("name", "like", "%$searchQuery%");
        }

        $products = $products->limit($this->limitPagination)->offset(($currentPage - 1) * $this->limitPagination)->get();

        $initialStockProducts = Product::query()
            ->select("products.name AS product_name", "product_variants.name AS product_variant_name", "product_variants.stock AS product_variant_stock")
            ->join("product_variants", "products.id", "=", "product_variants.product_id")
            ->groupBy("products.name", "product_variants.name")
            ->get();

        $stats = [
            "total" => Product::get()->count(),
            "available" => $initialStockProducts->where("product_variant_stock", ">", 0)->count(),
            "low" => $initialStockProducts->where("product_variant_stock", "<", 5)->count(),
            "empty" => $initialStockProducts->where("product_variant_stock", "<=", 0)->count()
        ];

        $maxPage = intval($stats['total'] / $this->limitPagination + 1);

        return view('admin.products', compact("products", "stats", "currentPage", "maxPage"));
    }

    public function storeProductPage()
    {
        return view('admin.addProduct');
    }

    public function updateProduct(Request $request)
    {
        $files = $request->files;
        return view('testing-data', ['data' => $request]);
    }

    public function detailProduct(Product $product)
    {
        $product->load("variants", "images");
        return view("admin.detailProduct", compact("product"));
    }

    public function transactions(Request $request)
    {
        $searchQuery = $request->query("search", null);
        $statusQuery = $request->query("search_status", null);
        $currentPage = $request->query("page", 1);
        $transactions = Transaction::with("user");

        if ($searchQuery) {
            $transactions = $transactions
                ->join("users", "transactions.user_nis", "=", "users.nis")
                ->where("users.fullname", "like", "%$searchQuery%")
                ->orWhere("transactions.id", "=", "$searchQuery");
        }

        if ($statusQuery) {
            $transactions = $transactions
                ->where("transactions.status", "=", $statusQuery);
        }

        $transactions = $transactions->limit($this->limitPagination)->offset(($currentPage - 1) * $this->limitPagination)->get();

        $allTransactions = Transaction::all();

        $stats = [
            'total' => $allTransactions->count(),
            'success' => $allTransactions->where('status', '=', 'success')->count(),
            'pending' => $allTransactions->where('status', '=', 'ongoing')->count(),
            'on Going' => $allTransactions->where('status', '=', 'ongoing')->count(),
            'fail' => $allTransactions->where('status', '=', 'fail')->count()
        ];

        $maxPage = $searchQuery || $statusQuery ? $transactions->count() : $stats['total'];
        $maxPage = intval($maxPage / $this->limitPagination + 1);

        return view("admin.transactions", compact("transactions", "stats", 'currentPage', 'maxPage'));
    }

    public function detailTransaction(Transaction $transaction)
    {
        $transaction->load("user", "orders", "orders.product_variant", "orders.product_variant.product");
        return view("admin.detailTransaction", compact("transaction"));
    }

    public function accounts()
    {
        $accounts = User::all();

        $totalAccount = $accounts->count();
        $totalStudent = $accounts->where("role", "=", "siswa")->count();
        $totalAdmin = $accounts->where("role", "=", "admin")->count();

        return view("admin.accounts", compact("accounts", "totalAccount", "totalStudent", "totalAdmin"));
    }

    public function detailAccount(User $account)
    {
        return view("admin.detailAccount", compact("account"));
    }

    public function profile()
    {
        return view("admin.profile");
    }
}
