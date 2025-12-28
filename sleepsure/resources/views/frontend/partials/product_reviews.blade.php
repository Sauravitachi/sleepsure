<div class="review-list">
@foreach($productModel->reviews as $review)
    <div class="single-review-card">
        <div class="review-header">
            <div class="review-rating-stars">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fa fa-star{{ $i <= $review->rate ? '' : '-o' }}" style="color: #ffc107;"></i>
                @endfor
                <span class="rate-num">{{ $review->rate }}.0</span>
            </div>
            @if(isset($review->verified) && $review->verified)
                <span class="verified-badge" title="Verified Purchase"><i class="fa fa-check-circle"></i> Verified</span>
            @endif
        </div>
        <div class="review-text">{{ $review->comments }}</div>
        <div class="review-footer">
            <span class="reviewer-info">
                @if($review->reviewer_id)
                    @if(!empty($review->reviewer) && !empty($review->reviewer->customer_name))
                        {{ $review->reviewer->customer_name }}
                    @else
                        User #{{ $review->reviewer_id }}
                    @endif
                @else
                    Guest
                @endif
            </span>
            <span class="review-date">• {{ \Carbon\Carbon::parse($review->date_time)->diffForHumans() }}</span>
        </div>
        @if(!empty($review->media))
                @php
                    $mediaFiles = is_array($review->media) ? $review->media : json_decode($review->media, true);
                @endphp
                @if(is_array($mediaFiles))
                    <div class="review-media-gallery" style="margin-top:10px; display:flex; gap:8px;">
                        @foreach($mediaFiles as $media)
                            <a href="{{ asset('storage/' . $media) }}" target="_blank">
                                <img src="{{ asset('storage/' . $media) }}" alt="Review photo" style="width:60px; height:60px; object-fit:cover; border-radius:6px; border:1px solid #eee;">
                            </a>
                        @endforeach
                    </div>
                @endif
        @endif
    </div>
@endforeach
</div>
