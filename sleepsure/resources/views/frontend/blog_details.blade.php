@extends('layouts.app')

@section('title', $blog->meta_title ?? $blog->title)

@section('content')

<div class="article-container">

    <header class="article-header">
        <span class="article-category">
            @php
                $tags = explode(',', $blog->tags);
            @endphp
            {{ trim($tags[0] ?? 'Blog') }}
        </span>

        <h1 class="article-title">{{ $blog->title }}</h1>

        <div class="article-meta">
            <span class="author-name">
                <i class="fas fa-user-circle"></i> 
                {{ $blog->author_name ?? 'Admin' }}
            </span> |

            <span class="date">
                <i class="far fa-calendar-alt"></i>
                {{ \Carbon\Carbon::parse($blog->created_date)->format('F d, Y') }}
            </span> |

            <span class="read-time">
                <i class="far fa-clock"></i>
                {{ $blog->read_time ?? '5' }} min read
            </span>
        </div>
    </header>

    <figure class="article-hero">
        <img src="{{ $blog->image_url }}" 
             alt="{{ $blog->title }}" 
             class="article-image">
    </figure>

    <article class="article-content">
        {!! $blog->content !!}
    </article>

    @if(!empty($blog->author_name))
    <div class="author-box">
        <img src="{{ asset($blog->author_image ?? 'frontend/images/default-author.jpg') }}" 
             alt="{{ $blog->author_name }}"
             class="author-image">

        <div class="author-info">
            <strong>{{ $blog->author_name }}</strong>
            <small>{{ $blog->author_designation ?? '' }}</small>
            <p style="margin: 5px 0 0;">
                {{ $blog->author_bio ?? '' }}
            </p>
        </div>
    </div>
    @endif

</div>

@endsection
