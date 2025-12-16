<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Display a listing of the reviews.
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'product']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('comment', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function ($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%')
                                ->orWhere('email', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('product', function ($productQuery) use ($request) {
                      $productQuery->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status == 'approved');
        }

        // Filter by rating
        if ($request->has('rating') && $request->rating) {
            $query->where('rating', $request->rating);
        }

        // Filter by product
        if ($request->has('product_id') && $request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        $reviews = $query->latest()->paginate(15);

        // Statistics
        $totalReviews = Review::count();
        $approvedReviews = Review::where('status', true)->count();
        $pendingReviews = Review::where('status', false)->count();
        $averageRating = Review::where('status', true)->avg('rating');

        // Get products for filter
        $products = Product::select('id', 'name')->orderBy('name')->get();

        return view('admin.reviews.index', compact(
            'reviews',
            'totalReviews',
            'approvedReviews',
            'pendingReviews',
            'averageRating',
            'products'
        ));
    }

    /**
     * Display the specified review.
     */
    public function show(Review $review)
    {
        $review->load(['user', 'product']);
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit(Review $review)
    {
        $review->load(['user', 'product']);
        return view('admin.reviews.edit', compact('review'));
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, Review $review)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'status' => 'required|boolean',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully!');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review)
    {
        // Delete associated photos
        if ($review->photos) {
            foreach ($review->photos as $photo) {
                if (Storage::disk('public')->exists($photo)) {
                    Storage::disk('public')->delete($photo);
                }
            }
        }

        // Delete associated videos
        if ($review->videos) {
            foreach ($review->videos as $video) {
                if (Storage::disk('public')->exists($video)) {
                    Storage::disk('public')->delete($video);
                }
            }
        }

        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully!');
    }

    /**
     * Toggle review status (approve/reject)
     */
    public function toggleStatus(Review $review)
    {
        $review->update([
            'status' => !$review->status
        ]);

        $status = $review->status ? 'approved' : 'rejected';
        
        return redirect()->back()
            ->with('success', "Review {$status} successfully!");
    }

    /**
     * Delete a photo from review
     */
    public function deletePhoto(Review $review, Request $request)
    {
        $request->validate([
            'photo_path' => 'required|string'
        ]);

        $photos = $review->photos ?? [];
        $photoPath = $request->photo_path;

        // Remove photo from array
        $photos = array_filter($photos, function($photo) use ($photoPath) {
            return $photo !== $photoPath;
        });

        // Delete file from storage
        if (Storage::disk('public')->exists($photoPath)) {
            Storage::disk('public')->delete($photoPath);
        }

        $review->update(['photos' => array_values($photos)]);

        return response()->json([
            'success' => true,
            'message' => 'Photo deleted successfully!'
        ]);
    }

    /**
     * Delete a video from review
     */
    public function deleteVideo(Review $review, Request $request)
    {
        $request->validate([
            'video_path' => 'required|string'
        ]);

        $videos = $review->videos ?? [];
        $videoPath = $request->video_path;

        // Remove video from array
        $videos = array_filter($videos, function($video) use ($videoPath) {
            return $video !== $videoPath;
        });

        // Delete file from storage
        if (Storage::disk('public')->exists($videoPath)) {
            Storage::disk('public')->delete($videoPath);
        }

        $review->update(['videos' => array_values($videos)]);

        return response()->json([
            'success' => true,
            'message' => 'Video deleted successfully!'
        ]);
    }
}
