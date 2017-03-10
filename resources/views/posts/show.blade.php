@extends('layouts/app')

@section('content')
	<h1>{{$post->title}}</h1>

	{!!Markdown::convertToHtml(e($post->content))!!}
	<p>{{$post->user->name}}</p>
@if(auth()->check()) 
	@if(!auth()->user()->isSubscribedTo($post))
	    {{!! Form::open(['route'=>['posts.subscribe',$post],'method'=>'POST']) !!}}	
            <button type="submit">Suscribirse al post</button>
        {!!Form::close()!!}
    @elseif (auth()->check() && auth()->user()->isSubscribedTo($post))
        {{!! Form::open(['route'=>['posts.unsubscribe',$post],'method'=>'DELETE']) !!}}	
            <button type="submit">Desuscribirse del post</button>
        {!!Form::close()!!}
    @endif
@endif

	<h4>Comentarios</h4>

	{!! Form::open(['route'=>['comments.store',$post],'method'=>'POST'])!!}
		{!!Field::textarea('comment')!!}

		<button type='submit'>Publicar comentario</button>

	{!!Form::close()!!}

	@foreach($post->lastestComments as $comment)
	    <div data="{{$comment->answer}}" class="{{$comment->answer?'answer':''}}">
	    {{ $comment->comment}}
	    {{-- @can('accept',$comment) --}}
		@if(Gate::allows('accept',$comment) && !$comment->answer)
	    {{!! Form::open(['route'=>['comments.accept',$comment],'method'=>'POST']) !!}}
	        <button type="submit">Aceptar respuesta</button>
	    {{!!Form::close()!!}}
	    {{-- @endcan --}}
	    @endif
	    </div>
	@endforeach
@endsection