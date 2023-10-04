@guest()
    <a href="{{route('login')}}">Log In</a>
@else
    <form action="{{route('logout')}}">
        @csrf
        <button type="submit">Log Out</button>
    </form>
@endguest

@foreach($courses as $course)
    <h1>{{$course->title}}</h1>
    <p>{{$course->description}}</p>
@endforeach
