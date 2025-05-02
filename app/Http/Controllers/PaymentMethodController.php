<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user = Auth::user();
        $paymentMethods = $user->paymentMethods;

        return view('payment_methods.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new payment method.
     */
    public function create(): View
    {
        return view('payment_methods.create');
    }

    /**
     * Store a newly created payment method in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Log incoming request data for debugging
        Log::info('Payment method store request received', [
            'data' => $request->all(),
            'user' => Auth::id()
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:credit_card,debit_card,bank_transfer',
            'card_number' => 'required_if:type,credit_card,debit_card|string|max:19',
            'expiry_month' => 'required_if:type,credit_card,debit_card|string|size:2',
            'expiry_year' => 'required_if:type,credit_card,debit_card|string|size:2',
            'cvv' => 'required_if:type,credit_card,debit_card|string|min:3|max:4',
            'card_holder' => 'required_if:type,credit_card,debit_card|string|max:255',
            'bank_name' => 'required_if:type,bank_transfer|string|max:255',
            'account_number' => 'required_if:type,bank_transfer|string|max:30',
            'account_holder' => 'required_if:type,bank_transfer|string|max:255',
        ]);

        $user = Auth::user();

        // Prepare the payment details based on the type
        $encryptedDetails = [];

        if (in_array($request->type, ['credit_card', 'debit_card'])) {
            $encryptedDetails = [
                'card_number' => $request->card_number,
                'expiry_month' => $request->expiry_month,
                'expiry_year' => $request->expiry_year,
                'cvv' => $request->cvv,
                'card_holder' => $request->card_holder,
            ];
        } elseif ($request->type === 'bank_transfer') {
            $encryptedDetails = [
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'account_holder' => $request->account_holder,
            ];
        }

        // Make this method the default if it's the first one
        $isDefault = $user->paymentMethods()->count() === 0;

        // Create payment method
        $paymentMethod = new PaymentMethod([
            'user_id' => $user->id,
            'name' => $request->name,
            'type' => $request->type,
            'encrypted_details' => json_encode($encryptedDetails),
            'is_default' => $isDefault,
        ]);
          $paymentMethod->save();

        Log::info('Payment method saved successfully', [
            'user_id' => $user->id,
            'payment_method_id' => $paymentMethod->id,
            'type' => $request->type
        ]);

        return redirect()->route('payment-methods.index')
            ->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    /**
     * Remove the specified payment method from storage.
     */
    public function destroy(PaymentMethod $paymentMethod): RedirectResponse
    {
        // Check if this payment method belongs to the authenticated user
        if ($paymentMethod->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // If the deleted method was default, set another one as default
        if ($paymentMethod->is_default) {
            $newDefault = Auth::user()->paymentMethods()
                ->where('id', '!=', $paymentMethod->id)
                ->first();

            if ($newDefault) {
                $newDefault->is_default = true;
                $newDefault->save();
            }
        }

        $paymentMethod->delete();

        return redirect()->route('payment-methods.index')
            ->with('success', 'Payment method deleted successfully.');
    }

    /**
     * Set a payment method as default.
     */
    public function setDefault(PaymentMethod $paymentMethod): RedirectResponse
    {
        // Check if this payment method belongs to the authenticated user
        if ($paymentMethod->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Update the current default method
        Auth::user()->paymentMethods()
            ->where('is_default', true)
            ->update(['is_default' => false]);

        // Set the new default
        $paymentMethod->is_default = true;
        $paymentMethod->save();

        return redirect()->route('payment-methods.index')
            ->with('success', 'Default payment method updated successfully.');
    }
}
