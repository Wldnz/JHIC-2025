<?php

namespace App\Http\Controllers;

use App\AlertType;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\StoreTransactionUserRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Cart;
use App\Models\OrderTransaction;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Transaction;
use App\Utilities\AlertDataGenerator;
use Exception;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Midtrans\CoreApi;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * Login page for users.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function loginPage(Request $request)
    {
        return view('login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nis' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();
            $redirectUri = $request->query('redirect_uri');
            logger($redirectUri);

            return $redirectUri ? redirect($redirectUri) : redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withErrors([
            "message" => "Data yang diberikan tidak valid!"
        ])->onlyInput("nis");
    }

    /**
     * Logout the current user.
     *
     * This function will invalidate the current user session,
     * regenerate a new session and redirect the user to the login page.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect()->route('login');
    }

    /**
     * Dashboard page for users.
     *
     * This function will render the dashboard page view.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view("dashboard");
    }

    /**
     * About page for users.
     *
     * This function will render the about page view.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view("about");
    }

    /**
     * List all products.
     *
     * This function will render the products page view.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function products(Request $request)
    {
        $products = Product::with(["images" => function ($query) {
            $query->where('product_images.thumbnail', '=', true)->limit(1);
        }, "variants"])->get();

        return view("products", compact("products"));
    }

    /**
     * Detail product page for users.
     *
     * This function will render the detail product page view with the given product and recommended products.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\View\View
     */
    public function detailProduct(Product $product)
    {
        $product->load("variants", "images");
        $recommendedProducts = Product::with("images")
        ->whereRaw("SOUNDEX('$product->name') = SOUNDEX(products.name)", )
        ->limit(4)
            ->get();

        return view("detailProduct", compact("product", "recommendedProducts"));
    }

    /**
     * Display the cart page.
     *
     * This function will render the cart page view with all the items in the cart and the total cost.
     *
     * @return \Illuminate\View\View
     */
    public function cart()
    {
        $carts = Auth::user()->carts;
        $carts->load([
            'variantProduct',
            'variantProduct.product',
            'variantProduct.product.images' => function ($query) {
                $query->where('product_images.thumbnail', '=', true)->limit(1);
            }]
        );

        $totalCost = $carts->sum(function ($cart) {
            return $cart->variantProduct->price * $cart->quantity;
        });

        return view("cart", compact("carts", "totalCost"));
    }

    public function storeCart(StoreCartRequest $request)
    {
        $validated = $request->validated();

        $variantProduct = ProductVariant::find($validated['product_variant_id']);
        if ($variantProduct->stock < $validated['quantity']) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Produk gagal ditambahkan kedalam keranjang",
                "Produk dengan variant id {$request->product_variant_id} gagal ditambahkan kedalam keranjang karena stok tidak mencukupi",
                $request->session(),
            );
            return back();
        }

        $cart = Cart::incrementOrCreate([
            "user_nis" => auth()->user()->nis,
            "product_variant_id" => $validated['product_variant_id']
        ], 'quantity', $validated['quantity'], $validated['quantity']);

        if ($cart) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::SUCCESS,
                "Produk berhasil ditambahkan kedalam keranjang",
                "Produk dengan variant id {$request->product_variant_id} berhasil ditambahkan kedalam keranjang",
                $request->session(),
            );
        } else {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Produk gagal ditambahkan kedalam keranjang",
                "Produk dengan variant id {$request->product_variant_id} gagal ditambahkan kedalam keranjang",
                $request->session(),
            );
        }

        return back();
    }

    /**
     * Update the quantity of a cart item.
     *
     * This function will update the quantity of a cart item. If the quantity is 0 or less, it will delete the cart item.
     * If the quantity is greater than the stock of the product variant, it will return an error response.
     *
     * @param  \App\Http\Requests\UpdateCartRequest $request
     * @param  \App\Models\Cart $cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCart(UpdateCartRequest $request, Cart $cart)
    {
        $validated = $request->validated();

        if ($validated['quantity'] <= 0) {
            $isCartDeleted = $cart->delete();
            if (!$isCartDeleted) {
                return response()->json([
                    "success" => false,
                    "message" => "Failed to delete cart item",
                    "deleted" => false,
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return response()->json([
                "success" => true,
                "message" => "Cart item deleted",
                "deleted" => true,
            ]);
        } else if ($validated['quantity'] > $cart->variantProduct->stock) {
            $cart->quantity = $validated['quantity'] > $cart->quantity ? $cart->quantity : $validated['quantity'];
            return response()->json([
                "success" => false,
                "message" => "Unsufficient stock",
                "deleted" => false,
            ], Response::HTTP_BAD_REQUEST);
        }

        $cart->quantity = $validated['quantity'];
        $isCartSaved = $cart->save();

        if ($isCartSaved) {
            return response()->json([
                "success" => true,
                "message" => "Cart item updated",
                "deleted" => false,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Failed to update cart item or variant product",
                "deleted" => false,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Delete a cart item.
     *
     * This function will delete a cart item. If the deletion is successful, it will return a JSON response with a success message.
     * If the deletion fails, it will return a JSON response with an error message and a 500 status code.
     *
     * @param  \App\Models\Cart $cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCart(Cart $cart)
    {
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

    /**
     * Display the checkout page.
     *
     * This function will render the checkout page view with all the selected cart items.
     * If no cart items are selected, it will redirect back to the cart page with an error message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function checkout(Request $request)
    {
        $cartIds = $request->query("cart_ids", "");
        $querySelectedCarts = explode(",", $cartIds);
        $selectedCarts = Auth::user()->carts()->findMany($querySelectedCarts, ['id', 'product_variant_id', 'quantity']);

        if ($selectedCarts->isEmpty()) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal membuat transaksi",
                "Anda belum memilih produk",
                $request->session(),
            );
            return redirect()->route('student.cart');
        }

        $selectedCarts->load([
            'variantProduct' => function ($query) {
                $query->select(['id', 'product_id', 'name', 'price', 'type']);
            },
            'variantProduct.product' => function ($query) {
                $query->select(['id', 'name']);
            },
            'variantProduct.product.images' => function ($query) {
                $query
                    ->where('product_images.thumbnail', '=', true)
                    ->select(['id', 'product_id', 'url'])
                    ->limit(1);
            },
        ]);

        $totalPrice = $selectedCarts->sum(function($cart){
            return $cart->variantProduct->price * $cart->quantity;
        });

        $paymentTypes = PaymentType::query()
            ->where('is_enable', '=', true)
            ->get(['code_name', 'display_name', 'icon_url']);

        return view("checkout", compact("selectedCarts", "totalPrice", "paymentTypes"));
    }


    /**
     * This function will render the checkout success page view.
     *
     * It will display a message indicating that the transaction was successful.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function checkoutSuccess(Request $request)
    {
        $transactionId = $request->query('transaction_id');
        $transaction = Auth::user()->transactions()->find($transactionId);

        if (!$transaction) {
            return redirect()->route('student.cart');
        }

        $transaction->load("orders", "orders.product_variant", "orders.product_variant.product");
        return view("checkoutSuccess", compact("transaction"));
    }

    /**
     * This function will render the transactions page view with all the transactions and the total cost.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function transactions(Request $request)
    {
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

    /**
     * This function will render the detail transaction page view with all the orders in the transaction.
     *
     * @param  \App\Models\Transaction $transaction
     * @return \Illuminate\View\View
     */
    public function detailTransaction(Transaction $transaction)
    {
        $transaction->load([
            "orders" => function ($query) {
                $query->select(['id', 'transaction_id', 'product_variant_id', 'price', 'quantity', 'received_quantity', 'status']);
            },
            "orders.product_variant" => function ($query) {
                $query->select(['id', 'product_id', 'name', 'type', 'price', 'stock']);
            },
            "orders.product_variant.product" => function ($query) {
                $query->select(['id', 'name', 'category']);
            },
            "orders.product_variant.product.images" => function ($query) {
                $query
                    ->where('product_images.thumbnail', '=', true)
                    ->where('product_images.visible', '=', true)
                    ->select(['id', 'product_id', 'url'])
                    ->limit(1);
            },
        ]);
        $transaction->setVisible(['id', 'payment_method', 'orders']);

        return view("detailTransaction", compact("transaction"));
    }

    // TODO: add transaction process integrated with midtrans
    public function storeTransaction(StoreTransactionUserRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $paymentMethod = $request->safe()->input("payment_method", "gopay");
            $note = $request->safe()->input("note");
            $cart_ids = $request->safe()->input("carts", []);
            $carts = $user->carts()->findMany($cart_ids);

            if (count($carts) < 1) {
                throw new Exception("Anda belum memilih produk");
            }

            $totalQuantity = $carts->sum("quantity");
            $totalPrice = $carts->sum(function($cart){
                return $cart->variantProduct->price * $cart->quantity;
            });

            $transaction = Transaction::create([
                'user_nis' => $user->nis,
                'received_email' => $user->email,
                'received_phone' => $user->phone,
                'total_product' => $totalQuantity,
                'total_price' => $totalPrice,
                'payment_method' => $paymentMethod,
                'expired_at' => now()->addDays(1),
                'status' => 'pending',
                'note' => $note,
            ]);

            if (!$transaction) {
                throw new Exception("Terjadi kesalahan saat membuat transaksi");
            }

            $carts->load("variantProduct", "variantProduct.product");

            foreach ($carts as $cart) {
                $orderTransaction = OrderTransaction::create([
                    'transaction_id' => $transaction->id,
                    'product_variant_id' => $cart->variantProduct->id,
                    'price' => $cart->variantProduct->price,
                    'quantity' => $cart->quantity,
                    'status' => 'pending',
                    'received_quantity' => 0
                ]);

                if (!$orderTransaction) {
                    throw new Exception("Terjadi kesalahan saat membuat pesanan transaksi dengan produk {$cart->variantProduct->product->name} ( {$cart->variantProduct->name} {$cart->variantProduct->type} )");
                }

            }

            $user->carts()
                ->whereIn("id", $cart_ids)
                ->delete();

            $explodedUserName = explode(" ", $user->name, 2);
            $mdtResponse = \Midtrans\Snap::createTransaction([
                'payment_method' => $paymentMethod,
                'transaction_details' => [
                    'order_id' => "BITU-TRX $transaction->id",
                    'gross_amount' => $totalPrice,
                    // 'gross_amount' => 10,
                ],
                'customer_details' => [
                    'first_name' => $explodedUserName[0],
                    'last_name' => $explodedUserName[1] ?? '',
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
                'item_details' => $carts->map(function($cart){
                    return [
                        'id' => $cart->variantProduct->id,
                        'name' => "{$cart->variantProduct->product->name} ( {$cart->variantProduct->name} {$cart->variantProduct->type} )",
                        'price' => $cart->variantProduct->price,
                        'quantity' => $cart->quantity,
                    ];
                })->toArray(),
                'callbacks' => [
                    'finish' => route("student.checkout-success", ["transaction_id" => $transaction->id]),
                    'error' => back()->getTargetUrl(),
                ],
            ]);

            $mdtRedirectUrl = $mdtResponse->redirect_url;
            if (!$mdtRedirectUrl) {
                throw new Exception("Redirect url dari midtrans tidak ditemukan");
            }

            DB::commit();

            return redirect($mdtRedirectUrl);

        } catch (\Throwable $th) {
            DB::rollback();
            report($th);
            logger()->error($th);

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Gagal menambahkan transaksi",
                $th->getMessage(),
                $request->session(),
                false,
            );

            return back();

        }
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
        $transactions = $user
            ->transactions()
            ->get(['id']);

        $user->setVisible(['nis', 'fullname', 'email']);

        $transactions->load([
            'orders' => function ($query) {
                $query->select(['id', 'transaction_id', 'product_variant_id', 'price', 'quantity'])->limit(2);
            },
            'orders.productVariant' => function ($query) {
                $query->select(['id', 'product_id', 'name', 'type']);
            },
            'orders.productVariant.product' => function ($query) {
                $query->select(['id', 'name']);
            },
            'orders.productVariant.product.images' => function ($query) {
                $query->select(['id', 'product_id', 'url'])->where('thumbnail', '=', true)->limit(1);
            },
        ]);

        return view("profile", compact("user", "transactions"));
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

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user = Auth::user();
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
