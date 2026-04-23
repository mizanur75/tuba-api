<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Appointment;
use App\Models\Package;
use App\Models\Step;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session as StripeCheckoutSession;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->query('date');

        if (!$date) {
            return response()->json([]);
        }

        $appointments = Appointment::where('date', $date)
            ->select('time')
            ->get();

        return response()->json($appointments);
    }
    /**
     * Display a listing of the resource.
     */
    public function videos()
    {
        $data = Video::where('status', 1)->get();

        return $data;
    }
    public function about()
    {
        $data = About::where('status', 1)->get();

        return $data;
    }
    public function steps()
    {
        $data = Step::where('status', 1)->get();

        return $data;
    }


    public function packages()
    {
        $data = Package::where('status', 1)->get();

        return $data;
    }

    public function checkoutSession(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|integer',
            'currency' => 'nullable|string|size:3',
            'customer_email' => 'required|email',
            'ui_mode' => 'nullable|string|in:hosted,embedded,embedded_page',
            'success_url' => 'nullable|url',
            'cancel_url' => 'nullable|url',
            'return_url' => 'nullable|url',
            'metadata' => 'nullable|array',
        ]);

        $package = Package::where('status', 1)->find($validated['package_id']);

        if (!$package) {
            return response()->json([
                'message' => 'Selected package not found or inactive.',
            ], 404);
        }

        $stripeSecret = config('services.stripe.secret');

        if (!$stripeSecret) {
            return response()->json([
                'message' => 'Stripe secret key is missing. Set STRIPE_SECRET (or STRIPE_SECRET_KEY) in backend .env, then run php artisan config:clear.',
            ], 500);
        }

        if (!str_starts_with($stripeSecret, 'sk_')) {
            return response()->json([
                'message' => 'Invalid Stripe secret key format. Use STRIPE_SECRET with a value starting with sk_.',
            ], 500);
        }

        $currency = strtolower($validated['currency'] ?? 'gbp');
        $unitAmount = (int) round(((float) $package->price) * 100);

        if ($unitAmount <= 0) {
            return response()->json([
                'message' => 'Invalid package price for checkout.',
            ], 422);
        }

        $uiMode = $validated['ui_mode'] ?? 'hosted';

        // Backward compatibility: Stripe replaced `embedded` with `embedded_page`.
        if ($uiMode === 'embedded') {
            $uiMode = 'embedded_page';
        }

        if ($uiMode === 'embedded_page' && empty($validated['return_url'])) {
            return response()->json([
                'message' => 'return_url is required for embedded checkout.',
            ], 422);
        }

        if ($uiMode === 'hosted' && (empty($validated['success_url']) || empty($validated['cancel_url']))) {
            return response()->json([
                'message' => 'success_url and cancel_url are required for hosted checkout.',
            ], 422);
        }

        $metadata = array_merge($validated['metadata'] ?? [], [
            'package_id' => (string) $package->id,
            'package_name' => (string) $package->name,
        ]);

        try {
            Stripe::setApiKey($stripeSecret);

            $sessionPayload = [
                'mode' => 'payment',
                'ui_mode' => $uiMode,
                'customer_email' => $validated['customer_email'],
                'line_items' => [[
                    'quantity' => 1,
                    'price_data' => [
                        'currency' => $currency,
                        'unit_amount' => $unitAmount,
                        'product_data' => [
                            'name' => $package->name,
                            'description' => $package->description,
                        ],
                    ],
                ]],
                'metadata' => $metadata,
            ];

            if ($uiMode === 'embedded_page') {
                $sessionPayload['return_url'] = $validated['return_url'];
            } else {
                $sessionPayload['success_url'] = $validated['success_url'];
                $sessionPayload['cancel_url'] = $validated['cancel_url'];
            }

            $session = StripeCheckoutSession::create($sessionPayload);

            return response()->json([
                'id' => $session->id,
                'url' => $session->url,
                'client_secret' => $session->client_secret,
            ]);
        } catch (ApiErrorException $e) {
            Log::error('Stripe checkout session creation failed', [
                'error' => $e->getMessage(),
                'package_id' => $validated['package_id'],
                'customer_email' => $validated['customer_email'],
            ]);

            return response()->json([
                'message' => 'Failed to create Stripe checkout session.',
            ], 500);
        }
    }

    public function appointments(Request $request)
    {
        Appointment::create($request->all());
        return response()->json([
            'status' => 'ok'
        ]);
    }
}
