
<form id="reviewForm" method="POST" action="{{ route('product.review.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
    <div class="form-group">
        <label for="rate">Rating</label>
        <div id="starRating" style="font-size:2em; color:#ffc107;">
            @for($i=1; $i<=5; $i++)
                <span class="star" data-value="{{ $i }}" style="cursor:pointer;">&#9733;</span>
            @endfor
        </div>
        <input type="hidden" name="rate" id="rate" required>
    </div>
    <div class="form-group">
        <label for="comments">Comments</label>
        <textarea name="comments" id="comments" rows="3" required></textarea>
    </div>
    <div class="form-group">
        <label for="media">Upload Photos (optional)</label>
        <input type="file" name="media[]" id="media" accept="image/*" multiple style="margin-bottom:8px;">
        <div id="selectedImages" style="display:flex; gap:8px; flex-wrap:wrap; margin-top:8px;"></div>
    </div>
    <button type="submit" class="btn btn-primary">Submit Review</button>
</form>
<script>
    // Star rating logic
    const stars = document.querySelectorAll('#starRating .star');
    const rateInput = document.getElementById('rate');
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const val = this.getAttribute('data-value');
            rateInput.value = val;
            stars.forEach(s => s.style.color = '#ffc107');
            for(let i=0; i<stars.length; i++) {
                stars[i].style.color = i < val ? '#ffc107' : '#e0e0e0';
            }
        });
    });

    // Multiple image preview
    document.getElementById('media').addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        const preview = document.getElementById('selectedImages');
        preview.innerHTML = '';
        files.forEach(file => {
            if(file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    const img = document.createElement('img');
                    img.src = ev.target.result;
                    img.style.width = '48px';
                    img.style.height = '48px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '6px';
                    img.style.border = '1px solid #eee';
                    preview.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        });
    });

    document.getElementById('reviewForm').onsubmit = function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Review submitted successfully!');
                location.reload();
            } else {
                alert(data.message || 'Error submitting review.');
            }
        })
        .catch(() => alert('Error submitting review.'));
    };
</script>
