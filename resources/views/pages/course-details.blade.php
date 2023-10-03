<h2>{{$course->title}}</h2>
<h2>{{$course->tagline}}</h2>
<h2>{{$course->description}}</h2>
<p>{{$course->videos_count}} Videos</p>

<ul>
    @foreach($course->learnings as $learning)
        <li>{{$learning}}</li>
    @endforeach
</ul>
<img src="{{asset("images/$course->image_name")}}" alt="Image of the course {{$course->title}}">
