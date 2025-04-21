@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Edit Your Review</h2>
                    <a href="{{ route('products.show', $review->product) }}" class="btn btn-secondary">Back to Product</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('reviews.update', $review) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <div class="rating-input">
                                @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" {{ $i == $review->rating ? 'checked' : '' }} required>
                                <label for="rating{{ $i }}"><i class="fas fa-star"></i></label>
                                @endfor
                            </div>
                            @error('rating')
                            <span class="text-danger">{{ $message }}</span> 
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="comment">Your Review</label>
                            <textarea name="comment" id="comment" rows="4" class="form-control @error('comment') is-invalid @enderror" required>{{ old('comment', $review->comment) }}</textarea>
                            @error('comment')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }

    .rating-input input {
        display: none;
    }

    .rating-input label {
        font-size: 2rem;
        color: #ddd;
        cursor: pointer;
        padding: 0 5px;
    }

    .rating-input input:checked~label,
    .rating-input input:checked~label~label {
        color: #ffc107;
    }

    .rating-input label:hover,
    .rating-input label:hover~label {
        color: #ffc107;
    }
</style>
@endsection