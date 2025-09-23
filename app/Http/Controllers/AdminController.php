<?php

namespace App\Http\Controllers;

use App\AlertType;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Activity;
use App\Models\Major;
use App\Models\Product;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use App\Utilities\AlertDataGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    protected $limitPagination = 8;

    /**
     * Dashboard page for admin.
     *
     * This function will render the dashboard page view for admin.
     * It will display the total transaction, success transaction, ongoing transaction, fail transaction,
     * total product, available product, almost sold product, sold out product, total account, and total activity.
     *
     * @return \Illuminate\View\View
     */
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

    /**
     * List all products.
     *
     * This function will render the products page view.
     * It will display all products with pagination.
     * The search query will be used to filter the products.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function products(Request $request)
    {
        $searchQuery = $request->query("search", null);
        $currentPage = $request->query("page", 1);
        $products = Product::with("variants");

        if ($searchQuery) {
            $products = $products->where("name", "like", "%$searchQuery%");
        }

        $products = $products
            ->limit($this->limitPagination)
            ->offset(($currentPage - 1) * $this->limitPagination)
            ->get();

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

    /**
     * Show the add product page.
     *
     * This function will render the add product page view.
     *
     * @return \Illuminate\View\View
     */
    public function storeProductPage()
    {
        return view('admin.addProduct');
    }

    /**
     * Update product page.
     *
     * This function will render the update product page view.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProduct(Product $product, Request $request)
    {
        AlertDataGenerator::generateAsFlashToSession(
            AlertType::SUCCESS,
            "Produk berhasil diupdate",
            "Produk dengan id {$product->id} berhasil diupdate",
            $request->session(),
        );

        return redirect()->route("admin.detail-product", ["product" => $product]);
    }

    /**
     * Detail product page for admin.
     *
     * This function will render the detail product page view with the given product and recommended products.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\View\View
     */
    public function detailProduct(Product $product)
    {
        $product->load("variants", "images");
        return view("admin.detailProduct", compact("product"));
    }

    /**
     * Transactions page for admin.
     *
     * This function will render the transactions page view with all the transactions.
     * The transactions can be filtered by search query and status query.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
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
                ->orWhere("transactions.id", "=", $searchQuery);
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

    /**
     * Detail transaction page for admin.
     *
     * This function will render the detail transaction page view with the given transaction.
     *
     * @param  \App\Models\Transaction $transaction
     * @return \Illuminate\View\View
     */
    public function detailTransaction(Transaction $transaction)
    {
        $transaction->load("user", "orders", "orders.product_variant", "orders.product_variant.product");
        return view("admin.detailTransaction", compact("transaction"));
    }

    /**
     * Show all the accounts.
     *
     * This function will render the accounts page view with all the accounts, total accounts, total student accounts, and total admin accounts.
     *
     * @return \Illuminate\View\View
     */
    public function accounts()
    {
        $accounts = User::all(["id", "fullname", "email", "role"]);

        $totalAccount = $accounts->count();
        $totalStudent = $accounts->where("role", "=", "siswa")->count();
        $totalAdmin = $accounts->where("role", "=", "admin")->count();

        return view("admin.accounts", compact("accounts", "totalAccount", "totalStudent", "totalAdmin"));
    }

    /**
     * Detail account page for admin.
     *
     * This function will render the detail account page view with the given account.
     *
     * @param  string                $account
     * @return \Illuminate\View\View
     */
    public function detailAccount(string $nis)
    {
        $account = User::find($nis, ['nis', 'fullname', 'email', 'role', 'email_verified_at', 'created_at', 'updated_at']);

        $account->load("activities");
        $account->activities->setVisible(["id", "action", "created_at", "updated_at"]);

        if ($account->role == "siswa") {
            $account->load("student");
        }

        return view("admin.detailAccount", compact("account"));
    }

    public function createAccount()
    {
        return view("admin.addAccount");
    }

    public function storeAccount(StoreAccountRequest $request)
    {
        $user = User::create(array_merge($request->safe()->only([
            'nis',
            'fullname',
            'email',
            'role',
        ], [
            'password' => Hash::make($request->safe()->input("password")),
        ])));

        if (!$user) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal membuat akun",
                "Gagal membuat akun dengan NIS {$request->nis}",
                $request->session(),
            );
            return redirect()->route("admin.accounts");
        }

        if ($user->role != "siswa") {
            return redirect()->route("admin.accounts");
        }

        $major = Major::findOrFail($request->safe()->input("major_id"));
        $student = Student::create(array_merge($request->safe()->only([
            'nis',
            'no_telp',
            'gender',
            'address',
            'birthdate',
            'class',
            'major_id',
        ]), [
            'major_name' => $major->name
        ]));

        if ($student) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil membuat akun",
                "Berhasil membuat akun dengan NIS {$request->nis}",
                $request->session(),
            );
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal membuat akun",
                "Gagal membuat akun dengan NIS {$request->nis}",
                $request->session(),
            );
        }

        return redirect()->route("admin.accounts");
    }

    public function updateAccount(UpdateAccountRequest $request, User $account)
    {
        $validated = $request->validated();
        $isUpdated = $account->update($validated);

        if ($isUpdated) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil mengupdate akun",
                "Berhasil mengupdate akun dengan NIS {$account->nis}",
                $request->session(),
            );
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal mengupdate akun",
                "Gagal mengupdate akun dengan NIS {$account->nis}",
                $request->session(),
            );
        }

        return back();
    }

    public function deleteAccount(User $account, Request $request)
    {
        $isDeleted = $account->delete();

        if ($isDeleted) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil menghapus akun",
                "Berhasil menghapus akun dengan NIS {$account->nis}",
                $request->session(),
            );
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menghapus akun",
                "Gagal menghapus akun dengan NIS {$account->nis}",
                $request->session(),
            );
        }

        return redirect()->route("admin.accounts");
    }

    /**
     * Render the profile page view with the currently authenticated user.
     *
     * This function will render the profile page view with the currently authenticated user.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();
        return view("admin.profile", compact("user"));
    }

    /**
     * Update the currently authenticated user's profile information.
     *
     * This function will update the user's profile information based on the validated request data.
     * If the request contains a password field, it will be hashed before being updated to the user model.
     * If the update is successful, it will generate a success alert and redirect the user back to the previous page.
     * If the update fails, it will generate a danger alert and redirect the user back to the previous page.
     *
     * @param  \App\Http\Requests\UpdateProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $validated = $request->validated();

        if ($request->has("password")) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user = auth()->user();
        $isUpdated = $user->update($validated);

        if ($isUpdated) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil mengupdate profile",
                "Berhasil mengupdate profile dengan NIS {$user->nis}",
                $request->session(),
            );
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal mengupdate profile",
                "Gagal mengupdate profile dengan NIS {$user->nis}",
                $request->session(),
            );
        }

        return back();
    }
}
