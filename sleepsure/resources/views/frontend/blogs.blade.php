@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')

<div class="blog-list-page">

    <h1 class="page-title"><i class="fas fa-bed"></i> SleepSure Insights: Our Latest Articles</h1>

    <main class="blog-grid">

        @forelse($blogs as $blog)
        <article class="blog-card">

            <!-- Blog Thumbnail -->
            <img src="{{ $blog->image_url }}" 
                 alt="{{ $blog->title }}" 
                 class="blog-card-image">

            <div class="blog-card-content">

                <!-- Tags - Use first tag as category -->
                @php
                    $tagArray = explode(',', $blog->tags);
                    $category = trim($tagArray[0] ?? 'Blog');
                @endphp

                <span class="blog-card-category">{{ $category }}</span>

                <!-- Title -->
                <h2 class="blog-card-title">{{ $blog->title }}</h2>

                <!-- Short Excerpt from content (limit 150chars, strip HTML) -->
                <p class="blog-card-excerpt">
                    {{ \Illuminate\Support\Str::limit(strip_tags($blog->content), 150, '...') }}
                </p>

                <div class="blog-card-meta">

                    <!-- Date -->
                    <span class="date">
                        <i class="far fa-calendar-alt"></i>
                        {{ \Carbon\Carbon::parse($blog->created_date)->format('M d, Y') }}
                    </span>

                    <!-- Blog Details Link -->
                    <a href="{{ route('blog.details', $blog->id) }}" class="read-more-link">
                        Read More <i class="fas fa-arrow-right"></i>
                    </a>

                </div>
            </div>
        </article>

        @empty
        <p class="no-data">No blog articles available right now.</p>
        @endforelse

    </main>

</div>

@endsection
