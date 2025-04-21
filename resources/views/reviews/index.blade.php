@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $product->name }} - Reviews</h2>
                    <a href="{{ route('products.show', $product) }}" class="btn btn-secondary">Back to Product</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($reviews->isEmpty())
                    <p>No reviews yet. Be the first to review this product!</p>
                    @else
                    <div class="reviews-list">
                        @foreach($reviews as $review)
                        <div class="review-item mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5>{{ $review->user->name }}</h5>
                                <div class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                </div>
                            </div>
                            <p class="text-muted">{{ $review->created_at->format('M d, Y') }}</p>
                            <p>{{ $review->comment }}</p>

                            @if(auth()->id() === $review->user_id)
                            <div class="review-actions">
                                <a href="{{ route('reviews.edit', $review) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                                </form>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @auth
                    <div class="mt-4">
                        <a href="{{ route('reviews.create', $product) }}" class="btn btn-primary">Write a Review</a>
                    </div>
                    @else
                    <div class="mt-4">
                        <p>Please <a href="{{ route('login') }}">login</a> to write a review.</p>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection