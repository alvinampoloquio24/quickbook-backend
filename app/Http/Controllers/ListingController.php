<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    /**
     * Store a newly created listing in storage.
     */
    public function addListing(Request $request)
    {
        try {
            // Check authentication using Tymon JWT
            if (!Auth::check()) {
                return response()->json([
                    'message' => 'Unauthorized. Please log in first.'
                ], 401);
            }

            // Validate incoming request
            $validated = $request->validate([
                'name'        => 'required|string|max:255',
                'location'    => 'required|string|max:255',
                'images'      => 'nullable|array',
                'images.*'    => 'url', // each entry must be a valid URL
                'description' => 'nullable|string',
                'price'       => 'required|numeric|min:0',
                'capacity'    => 'required|integer|min:1',
            ]);

            // Create the listing
            $listing = Listing::create($validated);

            // Return a successful JSON response
            return response()->json([
                'message' => 'Listing created successfully',
                'listing' => $listing
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'message' => 'Validation failed.',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong while creating the listing.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
