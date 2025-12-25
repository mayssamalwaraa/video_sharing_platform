@extends('layouts.main')
 
@section('content')
<div class="container">
    <div class="row">
        <div class="mx-auto col-9"> 
            <input id="videoId" type="hidden" value="{{$video->id}}">

            <div class='vidcontainer'>
                @foreach($video->convertedvideos as $video_converted)
                    <video id="videoPlayer" controls style= '{{ $video->Longitudinal == "0" ? "width: 100%; height: 90%;" : "width: 900px; height: 510px;"}}'>
                        @if($video->quality == 1080)
                            <source id="webm_source" src="{{ Storage::url($video_converted->webm_Format_1080) }}" type="video/webm">   
                            <source id="mp4_source" src="{{ Storage::url($video_converted->mp4_Format_1080) }}" type="video/mp4">
                        @elseif($video->quality == 720)
                            <source id="webm_source" src="{{ Storage::url($video_converted->webm_Format_720) }}" type="video/webm">
                            <source id="mp4_source" src="{{ Storage::url($video_converted->mp4_Format_720) }}" type="video/mp4">
                        @elseif($video->quality == 480)
                            <source id="webm_source" src="{{ Storage::url($video_converted->webm_Format_480) }}" type="video/webm">
                            <source id="mp4_source" src="{{ Storage::url($video_converted->mp4_Format_480) }}" type="video/mp4">
                        @elseif($video->quality == 360)
                            <source id="webm_source" src="{{ Storage::url($video_converted->webm_Format_360) }}" type="video/webm"> 
                            <source id="mp4_source" src="{{ Storage::url($video_converted->mp4_Format_360) }}" type="video/mp4">
                        @else
                            <source id="webm_source" src="{{ Storage::url($video_converted->webm_Format_240) }}" type="video/webm"> 
                            <source id="mp4_source" src="{{ Storage::url($video_converted->mp4_Format_240) }}" type="video/mp4">
                        @endif
                    </video>
                @endforeach
            </div>
            <select id='qualityPick'>
                <option value="1080" {{ $video->quality == 1080 ? 'selected' : ''}} {{ $video->quality < 1080 ? 'hidden' : ''}}>1080p</option>
                <option value="720" {{ $video->quality == 720 ? 'selected' : ''}} {{ $video->quality < 720 ? 'hidden' : ''}}>720p</option>
                <option value="480" {{ $video->quality == 480 ? 'selected' : ''}} {{ $video->quality < 480 ? 'hidden' : ''}}>480p</option>
                <option value="360" {{ $video->quality == 360 ? 'selected' : ''}} {{ $video->quality < 360 ? 'hidden' : ''}}>360p</option>
                <option value="240" {{ $video->quality == 240 ? 'selected' : ''}}>240p</option> 
            </select>
            <div class="title mt-3">
                <h5>
                    {{$video->title}}
                </h5>
            </div>

            <div class="interaction text-center mt-5">
                <a href="#" class="like ml-3">
                    @if($userLike)
                        @if ($userLike->like == 1)
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up liked" viewBox="0 0 16 16">
                        <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2 2 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a10 10 0 0 0-.443.05 9.4 9.4 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a9 9 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.2 2.2 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.9.9 0 0 1-.121.416c-.165.288-.503.56-1.066.56z"/>
                        </svg> <span id="likeNumber">{{$countLike}}</span>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
                            <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2 2 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a10 10 0 0 0-.443.05 9.4 9.4 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a9 9 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.2 2.2 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.9.9 0 0 1-.121.416c-.165.288-.503.56-1.066.56z"/>
                            </svg><span id="likeNumber">{{$countLike}}</span>
                        @endif
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
                            <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2 2 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a10 10 0 0 0-.443.05 9.4 9.4 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a9 9 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.2 2.2 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.9.9 0 0 1-.121.416c-.165.288-.503.56-1.066.56z"/>
                            </svg> <span id="likeNumber">{{$countLike}}</span>
                    @endif
                    
                </a> | 
                <a href="#" class="like mr-3">
                    @if($userLike)
                        @if ($userLike->like == 0)
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-down liked" id="like_down" viewBox="0 0 16 16">
                            <path d="M8.864 15.674c-.956.24-1.843-.484-1.908-1.42-.072-1.05-.23-2.015-.428-2.59-.125-.36-.479-1.012-1.04-1.638-.557-.624-1.282-1.179-2.131-1.41C2.685 8.432 2 7.85 2 7V3c0-.845.682-1.464 1.448-1.546 1.07-.113 1.564-.415 2.068-.723l.048-.029c.272-.166.578-.349.97-.484C6.931.08 7.395 0 8 0h3.5c.937 0 1.599.478 1.934 1.064.164.287.254.607.254.913 0 .152-.023.312-.077.464.201.262.38.577.488.9.11.33.172.762.004 1.15.069.13.12.268.159.403.077.27.113.567.113.856s-.036.586-.113.856c-.035.12-.08.244-.138.363.394.571.418 1.2.234 1.733-.206.592-.682 1.1-1.2 1.272-.847.283-1.803.276-2.516.211a10 10 0 0 1-.443-.05 9.36 9.36 0 0 1-.062 4.51c-.138.508-.55.848-1.012.964zM11.5 1H8c-.51 0-.863.068-1.14.163-.281.097-.506.229-.776.393l-.04.025c-.555.338-1.198.73-2.49.868-.333.035-.554.29-.554.55V7c0 .255.226.543.62.65 1.095.3 1.977.997 2.614 1.709.635.71 1.064 1.475 1.238 1.977.243.7.407 1.768.482 2.85.025.362.36.595.667.518l.262-.065c.16-.04.258-.144.288-.255a8.34 8.34 0 0 0-.145-4.726.5.5 0 0 1 .595-.643h.003l.014.004.058.013a9 9 0 0 0 1.036.157c.663.06 1.457.054 2.11-.163.175-.059.45-.301.57-.651.107-.308.087-.67-.266-1.021L12.793 7l.353-.354c.043-.042.105-.14.154-.315.048-.167.075-.37.075-.581s-.027-.414-.075-.581c-.05-.174-.111-.273-.154-.315l-.353-.354.353-.354c.047-.047.109-.176.005-.488a2.2 2.2 0 0 0-.505-.804l-.353-.354.353-.354c.006-.005.041-.05.041-.17a.9.9 0 0 0-.121-.415C12.4 1.272 12.063 1 11.5 1"/>
                            </svg> <span id="dislikeNumber">{{$countDislike}}</span>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-down" id="like_down" viewBox="0 0 16 16">
                        <path d="M8.864 15.674c-.956.24-1.843-.484-1.908-1.42-.072-1.05-.23-2.015-.428-2.59-.125-.36-.479-1.012-1.04-1.638-.557-.624-1.282-1.179-2.131-1.41C2.685 8.432 2 7.85 2 7V3c0-.845.682-1.464 1.448-1.546 1.07-.113 1.564-.415 2.068-.723l.048-.029c.272-.166.578-.349.97-.484C6.931.08 7.395 0 8 0h3.5c.937 0 1.599.478 1.934 1.064.164.287.254.607.254.913 0 .152-.023.312-.077.464.201.262.38.577.488.9.11.33.172.762.004 1.15.069.13.12.268.159.403.077.27.113.567.113.856s-.036.586-.113.856c-.035.12-.08.244-.138.363.394.571.418 1.2.234 1.733-.206.592-.682 1.1-1.2 1.272-.847.283-1.803.276-2.516.211a10 10 0 0 1-.443-.05 9.36 9.36 0 0 1-.062 4.51c-.138.508-.55.848-1.012.964zM11.5 1H8c-.51 0-.863.068-1.14.163-.281.097-.506.229-.776.393l-.04.025c-.555.338-1.198.73-2.49.868-.333.035-.554.29-.554.55V7c0 .255.226.543.62.65 1.095.3 1.977.997 2.614 1.709.635.71 1.064 1.475 1.238 1.977.243.7.407 1.768.482 2.85.025.362.36.595.667.518l.262-.065c.16-.04.258-.144.288-.255a8.34 8.34 0 0 0-.145-4.726.5.5 0 0 1 .595-.643h.003l.014.004.058.013a9 9 0 0 0 1.036.157c.663.06 1.457.054 2.11-.163.175-.059.45-.301.57-.651.107-.308.087-.67-.266-1.021L12.793 7l.353-.354c.043-.042.105-.14.154-.315.048-.167.075-.37.075-.581s-.027-.414-.075-.581c-.05-.174-.111-.273-.154-.315l-.353-.354.353-.354c.047-.047.109-.176.005-.488a2.2 2.2 0 0 0-.505-.804l-.353-.354.353-.354c.006-.005.041-.05.041-.17a.9.9 0 0 0-.121-.415C12.4 1.272 12.063 1 11.5 1"/>
                        </svg> <span id="dislikeNumber">{{$countDislike}}</span>
                        @endif
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-down" id="like_down" viewBox="0 0 16 16">
                        <path d="M8.864 15.674c-.956.24-1.843-.484-1.908-1.42-.072-1.05-.23-2.015-.428-2.59-.125-.36-.479-1.012-1.04-1.638-.557-.624-1.282-1.179-2.131-1.41C2.685 8.432 2 7.85 2 7V3c0-.845.682-1.464 1.448-1.546 1.07-.113 1.564-.415 2.068-.723l.048-.029c.272-.166.578-.349.97-.484C6.931.08 7.395 0 8 0h3.5c.937 0 1.599.478 1.934 1.064.164.287.254.607.254.913 0 .152-.023.312-.077.464.201.262.38.577.488.9.11.33.172.762.004 1.15.069.13.12.268.159.403.077.27.113.567.113.856s-.036.586-.113.856c-.035.12-.08.244-.138.363.394.571.418 1.2.234 1.733-.206.592-.682 1.1-1.2 1.272-.847.283-1.803.276-2.516.211a10 10 0 0 1-.443-.05 9.36 9.36 0 0 1-.062 4.51c-.138.508-.55.848-1.012.964zM11.5 1H8c-.51 0-.863.068-1.14.163-.281.097-.506.229-.776.393l-.04.025c-.555.338-1.198.73-2.49.868-.333.035-.554.29-.554.55V7c0 .255.226.543.62.65 1.095.3 1.977.997 2.614 1.709.635.71 1.064 1.475 1.238 1.977.243.7.407 1.768.482 2.85.025.362.36.595.667.518l.262-.065c.16-.04.258-.144.288-.255a8.34 8.34 0 0 0-.145-4.726.5.5 0 0 1 .595-.643h.003l.014.004.058.013a9 9 0 0 0 1.036.157c.663.06 1.457.054 2.11-.163.175-.059.45-.301.57-.651.107-.308.087-.67-.266-1.021L12.793 7l.353-.354c.043-.042.105-.14.154-.315.048-.167.075-.37.075-.581s-.027-.414-.075-.581c-.05-.174-.111-.273-.154-.315l-.353-.354.353-.354c.047-.047.109-.176.005-.488a2.2 2.2 0 0 0-.505-.804l-.353-.354.353-.354c.006-.005.041-.05.041-.17a.9.9 0 0 0-.121-.415C12.4 1.272 12.063 1 11.5 1"/>
                        </svg>
                        <span id="dislikeNumber">{{$countDislike}}</span>
                    @endif
                </a> 

                {{-- @foreach ($video->views as $view)
                    <span class="float-right">عدد المشاهدات <span class="viewsNumber">{{$view->views_number}}</span></span>
                @endforeach

                <div class="loginAlert mt-5">
                    
                </div> --}}
            </div> 

            {{-- <div class="mt-4 px-2">
                <div class="comments">
                    <div class="mb-3">
                        <span>التعليقات</span>
                    </div>
                    <div>
                        <textarea class="form-control" id="comment" name="comment" rows="4" placeholder="إضافة تعليق عام"></textarea>
                        <button type="submit" class="btn btn-info mt-3 saveComment">تعليق</button>
                        
                        <div class="commentAlert mt-5">
                    
                        </div>

                        <div class="commentBody">
                            @foreach($comments as $comment)
                                <div class="card mt-5 mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="{{$comment->user->profile_photo_url}}" width="150px" class="rounded-full"/>
                                            </div>
                                            <div class="col-10">
                                                @if (Auth::check())
                                                    @if ($comment->user_id == auth()->user()->id || auth()->user()->administration_level > 0)
                                                        @if (!auth()->user()->block)
                                                            <form method="GET" action="{{route('comment.destroy', $comment->id)}}" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف التعليق هذا؟')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="float-left"><i class="far fa-trash-alt text-danger fa-lg"></i></button>
                                                            </form>

                                                            <form method="GET" action="{{route('comment.edit', $comment->id)}}">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="float-left"><i class="far fa-edit text-success fa-lg ml-3"></i></button>
                                                            </form>
                                                        @endif   
                                                    @endif
                                                @endif
                                                <p class="mt-3 mb-2"><strong>{{$comment->user->name}}</strong></p> 
                                                <i class="far fa-clock"></i> <span class="comment_date text-secondary">{{$comment->created_at->diffForHumans()}}</span>
                                                <p class="mt-3" >{{$comment->body}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>
</div>

@endSection

@section('script')
 <script>
    document.getElementById("qualityPick").onchange = function() {changeQulity()};
    function changeQulity() {
        var video = document.getElementById("videoPlayer");
        curTime = video.currentTime;
        var selected = document.getElementById("qualityPick").value;

        if (selected == '1080') {
            source = document.getElementById("webm_source").src = "{{ Storage::url($video_converted->webm_Format_1080) }}";
            source = document.getElementById("mp4_source").src = "{{ Storage::url($video_converted->mp4_Format_1080) }}";
        }
        
        else if (selected == '720') {
            source = document.getElementById("webm_source").src = "{{ Storage::url($video_converted->webm_Format_720) }}";
            source = document.getElementById("mp4_source").src = "{{ Storage::url($video_converted->mp4_Format_720) }}";
        }
            
        else if (selected == '480') {
            source = document.getElementById("webm_source").src = "{{ Storage::url($video_converted->webm_Format_480) }}";
            source = document.getElementById("mp4_source").src = "{{ Storage::url($video_converted->mp4_Format_480) }}";
        }
        else if (selected == '360') {
            source = document.getElementById("webm_source").src = "{{ Storage::url($video_converted->webm_Format_360) }}";
            source = document.getElementById("mp4_source").src = "{{ Storage::url($video_converted->mp4_Format_360) }}";
        }
        else if (selected == '240') {
            source = document.getElementById("webm_source").src = "{{ Storage::url($video_converted->webm_Format_240) }}";
            source = document.getElementById("mp4_source").src = "{{ Storage::url($video_converted->mp4_Format_240) }}";
        }
        
        video.load();
        video.play();
        video.currentTime = curTime;
        
    }
</script>
{{-- 
<script>
    $('.like').on('click', function(event) {
        var token = '{{ Session::token() }}';
        var urlLike = '{{ route('like') }}';

        var videoId = 0;

        var AuthUser = "{{{ (Auth::user()) ? 0 : 1 }}}";
        var blocked = "{{{ (Auth::user()) ? (Auth::user()->block) ? 1 : 0 : 2}}}";

        if (AuthUser == '1') {
            event.preventDefault();
            var html='<div class="alert alert-danger">\
                        <ul>\
                            <li class="loginAlert">يجب تسجيل الدخول لكي تستطيع الإعجاب بالفيديو</li>\
                        </ul>\
                    </div>';
            $(".loginAlert").html(html);
        } 
        else if (blocked == '1') {
            event.preventDefault();
            var html='<div class="alert alert-danger">\
                        <ul>\
                            <li class="loginAlert">أنت ممنوع من الإعجاب</li>\
                        </ul>\
                    </div>';
            $(".loginAlert").html(html);
           
        }
        else {
            event.preventDefault();
            videoId = $("#videoId").val(); 
            var isLike = event.target.parentNode.previousElementSibling == null;
            $.ajax({
                method: 'POST',
                url: urlLike,
                data: {
                    isLike: isLike, 
                    videoId: videoId, 
                    _token: token
                },
                success : function(data) {
                    if ($(event.target).hasClass('fa-thumbs-up')) {
                        if($(event.target).hasClass('liked')) {
                            $(event.target).removeClass("liked");
                        }
                        else {
                            $(event.target).addClass("liked");
                        }

                        $('#likeNumber').html(data.countLike);
                        $('#dislikeNumber').html(data.countDislike);
                    }
                    
                    if ($(event.target).hasClass('fa-thumbs-down')) {
                        if($(event.target).hasClass('liked')) {
                            $(event.target).removeClass("liked");
                        }
                        else {
                            $(event.target).addClass("liked");
                        }  
                        $('#likeNumber').html(data.countLike);
                        $('#dislikeNumber').html(data.countDislike);
                    }
                    if (isLike) {
                        $(".fa-thumbs-down").removeClass("liked");   
                    } else {
                        $(".fa-thumbs-up").removeClass("liked");
                    }

                }
            }) 
        }       
    });
</script>

<script>
	$('#videoPlayer').on('ended', function(e) {
		var token = '{{ Session::token() }}';
        var urlComment = '{{ route('view') }}';
        event.preventDefault();
        videoId = $("#videoId").val();
        
        $.ajax({
                method: 'POST',
                url: urlComment,
                data: {
                    videoId: videoId, 
                    _token: token
                },
                success : function(data) {
                    $(".viewsNumber").html(data.viewsNumbers);
                }
        }) 
	});
</script>

<script>
    $('.saveComment').on('click', function(event) {
        var token = '{{ Session::token() }}';
        var urlComment = '{{ route('comment') }}';

        var videoId = 0;

        var AuthUser = "{{{ (Auth::user()) ? 0 : 1 }}}";
        var blocked = "{{{ (Auth::user()) ? (Auth::user()->block) ? 1 : 0 : 2}}}";

        if (AuthUser == '1') {
            event.preventDefault();
            var html='<div class="alert alert-danger">\
                    <ul>\
                        <li>يجب تسجيل الدخول لكي تستطيع التعليق على الفيديو</li>\
                    </ul>\
                </div>';
            $(".commentAlert ").html(html);
        }
        else if (blocked == '1') {
            var html='<div class="alert alert-danger">\
                        <ul>\
                            <li class="commentAlert">أنت ممنوع من التعليق</li>\
                        </ul>\
                    </div>';
            $(".commentAlert ").html(html);
           
        }
        else if ($('#comment').val().length == 0) {
            var html='<div class="alert alert-danger">\
                    <ul>\
                        <li>الرجاء كتابة تعليق</li>\
                    </ul>\
                </div>';
            $(".commentAlert ").html(html);  
        }
        else {
            $(".commentAlert ").html('');
            event.preventDefault();
            videoId = $("#videoId").val();
            comment = $("#comment").val();

            $.ajax({
                method: 'POST',
                url: urlComment,
                data: {
                    comment: comment, 
                    videoId: videoId, 
                    _token: token
                },
                success : function(data) { 
                    $("#comment").val('');

                    destroyUrl = "{{route('comment.destroy', 'des_id')}}";
                    destroy = destroyUrl.replace('des_id', data.commentId);

                    editUrl = "{{route('comment.edit', 'id')}}";
                    url = editUrl.replace('id', data.commentId);

                    var html='  <div class="card mt-5 mb-3">\
                                    <div class="card-body">\
                                        <div class="row">\
                                            <div class="col-2">\
                                                <img src="'+data.userImage+'" width="150px" class="rounded-full"/>\
                                            </div>\
                                            <div class="col-10">\
                                                <form method="GET" action="'+destroy+'">\
                                                    @csrf\
                                                    @method('DELETE')\
                                                    <button type="submit" class="float-left"><i class="far fa-trash-alt text-danger fa-lg"></i></button>\
                                                </form>\
                                                <form method="GET" action="'+url+'">\
                                                    @csrf\
                                                    @method('PATCH')\
                                                    <button type="submit" class="float-left"><i class="far fa-edit text-success fa-lg ml-3"></i></button>\
                                                </form>\
                                                <p class="mt-3 mb-2"><strong>'+data.userName+'</strong></p>\
                                                <i class="far fa-clock"></i> <span class="comment_date text-secondary">'+data.commentDate+'</span>\
                                                <p class="mt-3" >'+comment+'</p>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>';

                    $(".commentBody").prepend(html);
                    
                      
                }
            })  
        }      
    });
</script>  --}}
@endSection