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

<a href="#!" class="paddle_button" data-product="{{$course->paddle_product_id}}">Buy Now!</a>

<script src="https://cdn.paddle.com/paddle/paddle.js"></script>
<script type="text/javascript">
    Paddle.Environment.set('sandbox')
    Paddle.Setup({ vendor: {{config('services.paddle.vendor-id')}} });
</script>
