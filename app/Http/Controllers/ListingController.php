<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
    public function updateListing(Request $request, Listing $listing)
    {
        try {
            // Ensure the user is authenticated
            if (!auth()->check()) {
                return response()->json([
                    'message' => 'Unauthorized. Please log in first.'
                ], 401);
            }

            // Validate the request
            $validated = $request->validate([
                'name'        => 'sometimes|string|max:255',
                'location'    => 'sometimes|string|max:255',
                'images'      => 'nullable|array',
                'images.*'    => 'url', // validate each URL
                'description' => 'nullable|string',
                'price'       => 'sometimes|numeric|min:0',
                'capacity'    => 'sometimes|integer|min:1',
            ]);

            // Update the listing
            $listing->update($validated);

            // Return success response
            return response()->json([
                'message' => 'Listing updated successfully',
                'listing' => $listing
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Listing not found. Please check the ID.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getListing($id)
    {
        try {
            // Manually find the listing by ID
            $listing = Listing::findOrFail($id);

            return response()->json([
                'message' => 'Listing retrieved successfully',
                'listing' => $listing
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Listing not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong while retrieving the listing.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
