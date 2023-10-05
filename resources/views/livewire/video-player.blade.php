<div>
    <div>
        <iframe src="https://player.vimeo.com/video/{{ $video->vimeo_id }}" webkitallowfullscreen mozallowfullscreen
                allowfullscreen></iframe>
        <h3>{{ $video->title }} ({{ $video->getReadableDuration() }})</h3>
        <p>{{ $video->description }}</p>
    </div>

    <ul>
        @foreach($courseVideos as $courseVideo)
            <li>
                <a href="{{route('pages.course-videos', $courseVideo)}}">{{$courseVideo->title}}</a>
                {{ $courseVideo->title }}
            </li>
        @endforeach
    </ul>
</div>
