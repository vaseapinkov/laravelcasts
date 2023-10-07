<x-guest-layout page-title="{{config('app.name') . ' - Home'}}">
    @guest()
        <a href="{{route('login')}}">Log In</a>
    @else
        <form method="POST" action="{{route('logout')}}">
            @csrf
            <button type="submit">Log Out</button>
        </form>
    @endguest

    @foreach($courses as $course)
        <a href="{{route('pages.course-details', $course)}}">
            <h1>{{$course->title}}</h1>
        </a>
        <p>{{$course->description}}</p>
    @endforeach
</x-guest-layout>
