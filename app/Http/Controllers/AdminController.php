<?php

namespace App\Http\Controllers;

use App\AlertType;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Activity;
use App\Models\Major;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use App\Utilities\AlertDataGenerator;
use App\Utilities\CloudinaryUtils;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    protected $limitPagination = 8;
    protected $newImagePrefixKey = 'added_image_';
    protected $newVariantPrefixKey = 'added_variant_';

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
        $initialTransactions = Transaction::get('status');
        $transaction = [
            'total' => $initialTransactions->count(),
            'success' => $initialTransactions->where('status', '=', 'success')->count(),
            'ongoing' => $initialTransactions->where('status', '=', 'ongoing')->count(),
            'fail' => $initialTransactions->where('status', '=', 'fail')->count(),
        ];

        $initialStockProducts = Product::query()
            ->select("product_variants.stock AS product_variants_stock")
            ->join("product_variants", "products.id", "=", "product_variants.product_id")
            ->groupBy("products.name", "product_variants.name")
            ->get();
        $product = [
            'total' => $initialStockProducts->count(),
            'available' => $initialStockProducts->where("product_variants_stock", ">", 0)->count(),
            'almost sold' => $initialStockProducts->where("product_variants_stock", "<", 5)->count(),
            'soldout' => $initialStockProducts->where("product_variants_stock", "<=", 0)->count(),
        ];

        $account = [
            'total' => User::query()->count(),
        ];

        $activity = [
            'total' => Activity::query()->count(),
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
        $searchStockQuery = $request->query("search_stock", null);
        $currentPage = $request->query("page", 1);
        $products = Product::with("variants")
            ->join("product_variants", "products.id", "=", "product_variants.product_id")
            ->groupBy("products.id");
        ;

        if ($searchQuery) {
            $searchQuery = "%$searchQuery%";
            $products = $products
                ->where("products.name", "like", $searchQuery)
                ->orWhere("product_variants.name", "like", $searchQuery);
        }

        if ($searchStockQuery) {
            $products = match ($searchStockQuery) {
                'available' => $products->havingRaw("SUM(product_variants.stock) > 0"),
                'low' => $products->havingRaw("SUM(product_variants.stock) < 5"),
                'empty' => $products->havingRaw("SUM(product_variants.stock) <= 0"),
                default => $products,
            };
        }

        $products = $products
            ->orderBy("products.id", "asc")
            ->limit($this->limitPagination)
            ->offset(($currentPage - 1) * $this->limitPagination)
            ->select("products.*")
            ->get();

        $initialStockProducts = Product::query()
            ->select("products.name AS product_name", "product_variants.name AS product_variant_name", "product_variants.stock AS product_variant_stock")
            ->join("product_variants", "products.id", "=", "product_variants.product_id")
            ->groupBy("products.name", "product_variants.name")
            ->get();

        $stats = [
            "total" => Product::query()->count(),
            "available" => $initialStockProducts->where("product_variant_stock", ">", 0)->count(),
            "low" => $initialStockProducts->where("product_variant_stock", "<", 5)->count(),
            "empty" => $initialStockProducts->where("product_variant_stock", "<=", 0)->count()
        ];

        $maxPage = intval($stats['total'] / $this->limitPagination + 1);

        return view('admin.products', compact("products", "stats", "currentPage", "maxPage"));
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

    public function storeProduct(StoreProductRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $product = Product::create([
                "name" => $validated["name"],
                "category" => $validated["category"],
                "description" => $validated["description"],
                "visible" => true,
            ]);

            if (!$product) {
                throw new Exception("Terjadi kesalahan saat menambahkan produk");
            }

            foreach ($validated["variants"] as $variant) {
                $variantProduct = ProductVariant::create([
                    "product_id" => $product->id,
                    "name" => $variant["name"],
                    "type" => $variant["type"],
                    "price" => $variant["price"],
                    "stock" => $variant["stock"],
                ]);

                if (!$variantProduct) {
                    throw new Exception("Terjadi kesalahan saat menambahkan variant produk dengan nama {$variant['name']}");
                }
            }

            foreach ($validated["images"] as $image) {
                $uploadedUrl = cloudinary()->uploadApi()->upload($image["file"]->getRealPath())['secure_url'];
                $productImage = ProductImage::create([
                    "product_id" => $product->id,
                    "url" => $uploadedUrl,
                    "visible" => true,
                    "thumbnail" => $image["thumbnail"],
                ]);

                if (!$productImage) {
                    throw new Exception("Terjadi kesalahan saat menambahkan foto produk");
                }
            }

            DB::commit();

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Produk berhasil ditambahkan",
                "Produk dengan nama {$product->name} berhasil ditambahkan",
                $request->session(),
            );

            return redirect()->route("admin.products");

        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
            logger()->error($th);

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menambahkan produk",
                $th->getMessage(),
                $request->session(),
                false,
            );

            return back();

        }
    }

    public function updateProduct(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $isUpdated = $product->update([
                "name" => $validated["name"],
                "category" => $validated["category"],
                "description" => $validated["description"],
            ]);

            if (!$isUpdated) {
                throw new Exception("Terjadi kesalahan saat mengupdate data produk");
            }

            $this->_handleProductVariantsInModifyProduct($request, $product, $validated["variants"]);
            $this->_handleProductImagesInModifyProduct($request, $product, $validated["images"]);

            DB::commit();

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Produk berhasil diupdate",
                "Produk dengan nama {$product->name} berhasil diupdate",
                $request->session(),
            );

            return redirect()->route("admin.products");
        } catch (\Throwable $th) {

            DB::rollback();
            report($th);
            logger()->error($th);

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal mengupdate produk",
                $th->getMessage(),
                $request->session(),
                false,
            );

            return back();
        }
    }

    public function deleteProduct(Product $product, Request $request)
    {
        DB::beginTransaction();

        try {
            foreach ($product->images as $productImage) {
                logger($productImage);
                $publicId = CloudinaryUtils::getPublicIdByCloudinaryUrl($productImage->url);
                if (!$publicId) {
                    throw new Exception("Terjadi kesalahan saat menghapus foto produk (public id tidak ditemukan)");
                }

                $response = cloudinary()->uploadApi()->destroy($publicId);
                if ($response['result'] !== 'ok') {
                    throw new Exception("Terjadi kesalahan saat menghapus foto produk (gagal menghapus dari cloud)");
                }
            }

            $isDeleted = $product->delete();
            if (!$isDeleted) {
                throw new Exception("Produk dengan id {$product->id} gagal dihapus");
            }

            DB::commit();

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Produk berhasil dihapus",
                "Produk dengan id {$product->id} berhasil dihapus",
                $request->session(),
            );

        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
            logger()->error($th);

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Produk gagal dihapus",
                $th->getMessage(),
                $request->session(),
                false,
            );

        } finally {
            return back();

        }
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

    public function storeTransactionPage()
    {
        $students = User::query()->whereRole("siswa")->get();
        $products = Product::with('variants')->get();

        $students->setVisible(['nis', 'fullname', 'email', 'created_at']);

        return view("admin.Addtransaction", compact("students", "products"));
    }

    public function deleteTransaction(Transaction $transaction, Request $request)
    {
        $isDeleted = $transaction->delete();

        if ($isDeleted) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Berhasil menghapus transaksi",
                "Berhasil menghapus transaksi dengan id {$transaction->id}",
                $request->session(),
            );
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menghapus transaksi",
                "Gagal menghapus transaksi dengan id {$transaction->id}",
                $request->session(),
            );
        }

        return back();
    }

    /**
     * Show all the accounts.
     *
     * This function will render the accounts page view with all the accounts, total accounts, total student accounts, and total admin accounts.
     *
     * @return \Illuminate\View\View
     */
    public function accounts(Request $request)
    {
        $currentPage = $request->get("page",1);
        $search_name = $request->query('search', null);
        $search_role = $request->query('search_role', 'siswa');
        $accounts = User::where('role', '=', $search_role);

        if ($search_name) {
            $accounts->where('fullname', 'like', '%' . $search_name . '%');
        }

        $accounts = $accounts->get(['nis', 'fullname', 'email', 'role']);

        $totalAccount = User::all()->count();
        $totalStudent = User::where("role", "=", "siswa")->get()->count();
        $totalAdmin = User::where("role", "=", "admin")->get()->count();

        $stats = [
            "account" => [
                'total' => $totalAccount,
            ],
            'siswa' => [
                'total' => $totalStudent,
            ],
            'admin' => [
                'total' => $totalAdmin
            ],
            "activity" => [
                'total' => Activity::get()->count()
            ]
        ];

        $maxPage = intval($stats['account']['total'] / $this->limitPagination + 1);

        return view("admin.accounts", compact("accounts", "stats", "maxPage", "currentPage", "search_role"));
    }

    /**
     * Detail account page for admin.
     *
     * This function will render the detail account page view with the given account.
     *
     * @param  string                $account
     * @return \Illuminate\View\View
     */
    public function detailAccount(Request $request ,string $nis)
    {
        $currentPage = $request->query('page', 1);
        $account = User::find($nis, ['nis', 'fullname', 'email', 'role', 'email_verified_at', 'created_at', 'updated_at']);

        $majors = Major::all();

        $account->load("activities");
        $account->activities->setVisible(["id", "action", "created_at", "updated_at"]);

        if ($account->role == "siswa") {
            $account->load("student");
        }

         $maxPage = intval(count($account['activities']) / $this->limitPagination + 1);

        return view("admin.detailAccount", compact("account", 'majors', 'currentPage', 'maxPage'));
    }

    public function createAccount()
    {
        $majors = Major::all();
        return view("admin.addAccount", compact('majors'));
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

    protected function _handleProductVariantsInModifyProduct(Request $request, Product $product, array $variants)
    {
        $currentIdsSet = new \Ds\Set();

        foreach ($variants as $key => $variant) {
            if (str_starts_with($key, $this->newVariantPrefixKey)) {
                $productVariant = ProductVariant::create([
                    "product_id" => $product->id,
                    "name" => $variant["name"],
                    "type" => $variant["type"],
                    "price" => $variant["price"],
                    "stock" => $variant["stock"],
                ]);

                if (!$productVariant) {
                    throw new Exception("Terjadi kesalahan saat menambahkan variant produk dengan nama {$variant['name']}");
                }

                $currentIdsSet->add($productVariant->id);
                continue;
            }

            $productVariant = ProductVariant::find($key);
            if (!$productVariant) {
                throw new Exception("Terjadi kesalahan saat mengupdate varian produk (data tidak ditemukan)");
            }

            $isUpdated = $productVariant->update([
                "name" => $variant["name"],
                "type" => $variant["type"],
                "price" => $variant["price"],
                "stock" => $variant["stock"],
            ]);
            if (!$isUpdated) {
                throw new Exception("Terjadi kesalahan saat mengupdate varian produk (gagal mengupdate data foto produk)");
            }

            $currentIdsSet->add($productVariant->id);

        }

        ProductVariant::query()
            ->where("product_id", $product->id)
            ->whereNotIn("id", $currentIdsSet->toArray())
            ->delete();
    }

    protected function _handleProductImagesInModifyProduct(Request $request, Product $product, array $images)
    {
        $currentIdsSet = new \Ds\Set();

        foreach ($images as $key => $image) {
            if (str_starts_with($key, $this->newImagePrefixKey)) {
                $uploadedUrl = cloudinary()->uploadApi()->upload($image["file"]->getRealPath())['secure_url'];
                $productImage = ProductImage::create([
                    "product_id" => $product->id,
                    "url" => $uploadedUrl,
                    "visible" => true,
                    "thumbnail" => $image["thumbnail"],
                ]);

                if (!$productImage) {
                    throw new Exception("Terjadi kesalahan saat menambahkan foto produk");
                }

                $currentIdsSet->add($productImage->id);
                continue;
            }

            $productImage = ProductImage::find($key);
            if (!$productImage) {
                throw new Exception("Terjadi kesalahan saat mengupdate foto produk (data tidak ditemukan)");
            }

            if (!array_key_exists("file", $image)) {
                $isUpdated = $productImage->update([
                    "thumbnail" => $image["thumbnail"],
                ]);
                if (!$isUpdated) {
                    throw new Exception("Terjadi kesalahan saat mengupdate foto produk (gagal mengupdate data foto produk)");
                }

                $currentIdsSet->add($productImage->id);
                continue;
            }

            $publicId = CloudinaryUtils::getPublicIdByCloudinaryUrl($productImage->url);
            if (!$publicId) {
                throw new Exception("Terjadi kesalahan saat mengupdate foto produk (public id tidak ditemukan)");
            }

            $response = cloudinary()->uploadApi()->destroy($publicId);
            if ($response['result'] !== 'ok') {
                throw new Exception("Terjadi kesalahan saat mengupdate foto produk (gagal menghapus dari cloud)");
            }

            $uploadedUrl = cloudinary()->uploadApi()->upload($image["file"]->getRealPath())['secure_url'];
            if (!$uploadedUrl) {
                throw new Exception("Terjadi kesalahan saat mengupdate foto produk (gagal mengupload ke cloud)");
            }

            $isUpdated = $productImage->update([
                "url" => $uploadedUrl,
                "thumbnail" => $image["thumbnail"],
            ]);
            if (!$isUpdated) {
                throw new Exception("Terjadi kesalahan saat mengupdate foto produk (gagal mengupdate data foto produk)");
            }

            $currentIdsSet->add($productImage->id);

        }

        $deletableProductImages = ProductImage::query()
            ->where("product_id", $product->id)
            ->whereNotIn("id", $currentIdsSet->toArray());

        foreach ($deletableProductImages->get() as $productImage) {

            $publicId = CloudinaryUtils::getPublicIdByCloudinaryUrl($productImage->url);
            if (!$publicId) {
                throw new Exception("Terjadi kesalahan saat menghapus foto produk (public id tidak ditemukan)");
            }

            $response = cloudinary()->uploadApi()->destroy($publicId);
            if ($response['result'] !== 'ok') {
                throw new Exception("Terjadi kesalahan saat menghapus foto produk (gagal menghapus dari cloud)");
            }

        }

        $deletableProductImages->delete();
    }
}
