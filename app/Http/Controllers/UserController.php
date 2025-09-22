<?php

namespace App\Http\Controllers;

use App\AlertType;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Transaction;
use App\Utilities\AlertDataGenerator;
use Illuminate\Http\Request;
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
            return redirect()->route('admin.dashboard');
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
        $searchQuery = $request->query("search", null);
        $products = Product::with("images");

        if ($searchQuery) {
            $products = $products
                ->where("name", "like", "%$searchQuery%");
        }

        $products = $products->get();

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
        $carts = Cart::with('variantProduct')->get();
        $totalCost = $carts->sum(function ($cart) {
            return $cart->variantProduct->price * $cart->quantity;
        });

        return view("cart", compact("carts", "totalCost"));
    }

    public function storeCart(StoreCartRequest $request)
    {
        $validated = $request->validated();

        $cart = Cart::incrementOrCreate([
            "user_nis" => auth()->user()->nis,
            "product_variant_id" => $validated['product_variant_id']
        ], 'quantity', $validated['quantity'], $validated['quantity']);

        if (!$cart) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Produk gagal ditambahkan kedalam keranjang",
                "Produk dengan variant id {$request->product_variant_id} gagal ditambahkan kedalam keranjang",
                $request->session(),
            );
            return back();
        }

        if ($cart->variantProduct->stock < $validated['quantity']) {
            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Produk gagal ditambahkan kedalam keranjang",
                "Produk dengan variant id {$request->product_variant_id} gagal ditambahkan kedalam keranjang karena stok tidak mencukupi",
                $request->session(),
            );
            return back();
        }

        $cart->variantProduct->stock -= $validated['quantity'];
        $isSaved = $cart->variantProduct->save();

        if ($isSaved) {
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

        $oldQuantity = $cart->quantity;

        if ($validated['quantity'] <= 0) {
            $cart->variantProduct->stock += $oldQuantity;

            $isVariantProductSaved = $cart->variantProduct->save();
            if (!$isVariantProductSaved) {
                return response()->json([
                    "success" => false,
                    "message" => "Failed to variant product",
                    "deleted" => false,
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

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
            return response()->json([
                "success" => false,
                "message" => "Unsufficient stock",
                "deleted" => false,
            ], Response::HTTP_BAD_REQUEST);
        }

        $cart->variantProduct->stock += $oldQuantity - $validated['quantity'];
        $isVariantProductSaved = $cart->variantProduct->save();

        $cart->quantity = $validated['quantity'];
        $isCartSaved = $cart->save();

        if ($isVariantProductSaved && $isCartSaved) {
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
        $cart->variantProduct->stock += $cart->quantity;
        $isVariantProductSaved = $cart->variantProduct->save();

        if (!$isVariantProductSaved) {
            return response()->json([
                "success" => false,
                "message" => "Failed to update variant product",
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

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
        $transaction->load("orders");
        return view("detailTransaction", compact("transaction"));
    }

    public function profile()
    {
        $user = auth()->user();
        return view("profile", compact("user"));
    }
}
