<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:500'],
        ]);

        $review = new Review();
        $review->user_id = Auth::id();
        $review->product_id = $product->id;
        $review->rating = $validated['rating'];
        $review->comment = $validated['comment'];
        $review->save();

        return redirect()->back()
            ->with('success', __('Review added successfully'));
    }

    /**
     * Show the form for editing the specified review.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\View\Response
     */
    public function edit(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:500'],
        ]);

        $review->update($validated);

        return redirect()->route('products.show', $review->product)
            ->with('success', __('Review updated successfully'));
    }

    /**
     * Remove the specified review from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();

        return redirect()->back()
            ->with('success', __('Review deleted successfully'));
    }
}
