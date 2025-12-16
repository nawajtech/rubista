<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Store a new review
     */
    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to submit a review.',
                'redirect' => route('frontend.login')
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max per image
            'videos.*' => 'nullable|mimes:mp4,mov,avi,wmv|max:20480', // 20MB max per video
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if user already reviewed this product
        $existingReview = Review::where('product_id', $request->product_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this product.',
            ], 422);
        }

        // Handle photo uploads
        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('reviews/photos', 'public');
                $photos[] = $path;
            }
        }

        // Handle video uploads
        $videos = [];
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                $path = $video->store('reviews/videos', 'public');
                $videos[] = $path;
            }
        }

        // Create review (admin can see all, but regular users see only approved)
        $review = Review::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'photos' => !empty($photos) ? $photos : null,
            'videos' => !empty($videos) ? $videos : null,
            'status' => false, // Require admin approval
        ]);

        // Calculate average rating for the product
        $averageRating = Review::where('product_id', $product->id)
            ->where('status', true)
            ->avg('rating');

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully! It will be visible after admin approval.',
            'review' => [
                'id' => $review->id,
                'user_name' => Auth::user()->name,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'photos' => $review->photos,
                'videos' => $review->videos,
                'created_at' => $review->created_at->format('M d, Y'),
                'created_at_human' => $review->created_at->diffForHumans(),
                'status' => $review->status,
            ],
            'average_rating' => round($averageRating, 1),
            'total_reviews' => Review::where('product_id', $product->id)
                ->where('status', true)
                ->count(),
        ]);
    }

    /**
     * Get reviews for a product
     */
    public function getReviews($productId)
    {
        $product = Product::findOrFail($productId);
        
        // If admin, show all reviews. Otherwise, show only approved
        $query = Review::where('product_id', $productId)
            ->with('user:id,name')
            ->orderBy('created_at', 'desc');

        if (!Auth::check() || !Auth::user()->isAdmin()) {
            $query->where('status', true);
        }

        $reviews = $query->get();

        $averageRating = Review::where('product_id', $productId)
            ->where('status', true)
            ->avg('rating');

        return response()->json([
            'success' => true,
            'reviews' => $reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'user_name' => $review->user->name,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'photos' => $review->photos ? array_map(function($photo) {
                        return Storage::url($photo);
                    }, $review->photos) : [],
                    'videos' => $review->videos ? array_map(function($video) {
                        return Storage::url($video);
                    }, $review->videos) : [],
                    'created_at' => $review->created_at->format('M d, Y'),
                    'created_at_human' => $review->created_at->diffForHumans(),
                    'status' => $review->status,
                ];
            }),
            'average_rating' => round($averageRating, 1),
            'total_reviews' => Review::where('product_id', $productId)
                ->where('status', true)
                ->count(),
        ]);
    }
}
