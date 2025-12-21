@extends('layouts.main')

@section('content')
    <div class="mx-4">
        <div class="row justify-content-center">
            <form class="form-inline col-md-6 justify-content-center" action="{{ route('video.search') }}" method="GET">
                <input type="text" class="form-control-sm mx-sm-3 mb-2" name="term">
                <button type="submit" class="btn btn-primary mb-2">ابحث</button>
            </form>
        </div>
        <hr>
        <br>

        <p class="my-4">{{$title}}</p>
        <div class="row">
            @forelse($videos as $video)
                @if($video->processed)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="card">
                            <div class="card-icons">
                                @php
                                    $hours_add_zero = sprintf("%02d", $video->hours);
                                @endphp
                                @php
                                    $minutes_add_zero = sprintf("%02d", $video->minutes);
                                @endphp
                                @php
                                    $seconds_add_zero = sprintf("%02d", $video->seconds);
                                @endphp
                                <a href="/videos/{{$video->id}}">
                                    <div class="image-container">
                                    <img src="{{ Storage::url($video->image_path) }}" class="card-img-top" alt="...">
                                    <div class="play-icon-overlay">
                                        <time>{{ ($video->hours) > 0 ? $hours_add_zero .':' : ''}}{{$minutes_add_zero}}:{{$seconds_add_zero}}</time>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-play-circle-fill fa-play" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M6.79 5.093A.5.5 0 0 0 6 5.5v5a.5.5 0 0 0 .79.407l3.5-2.5a.5.5 0 0 0 0-.814z"/>
                                    </svg>
                                    </div>
                                    </div>
                                    
                                </a>
                            </div>
                            <a href="/videos/{{$video->id}}">
                                <div class="card-body p-0">
                                    <p class="card-title">{{ Str::limit($video->title, 60) }}</p>
                                </div>
                            </a>
                            <div class="card-footer">
                                <small class="text-muted">
                                    @foreach ($video->views as $view)
                                         <span class="d-block"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                        </svg>{{$view->views_number??0}} 10مشاهدة</span>
                                    @endforeach
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                                    </svg> <span>{{$video->created_at->diffForHumans()}}  </span>

                                    @auth
                                        @if ($video->user_id == auth()->user()->id || auth()->user()->administration_level > 0)
                                            @if (!auth()->user()->block)
                                            <div class="container ">
                                                <div class="row g-4">

                                                <div class="col-md-3">
                                                <form method="POST" action="{{ route('videos.destroy',$video->id)}}" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف مقطع الفيديو هذا؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="float-left btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                                    </svg>
                                                    </button>
                                                </form>
                                                </div>
                                                <div class="col-md-3">

                                                <form method="GET" action="{{ route('videos.edit',$video->id)}}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="float-left btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                    </svg>
                                                </button>
                                                </form> 
                                                </div>
                                                </div>
                                            </div>

                                            @endif
                                        @endif
                                    @endauth
                                </small>
                            </div>
                        </div>
                    </div>             
                @endif
            @empty
                <div class="mx-auto col-8">
                    <div class="alert alert-primary text-center" role="alert">
                         لا يوجد فيديوهات      
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection