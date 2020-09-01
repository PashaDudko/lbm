@extends('layouts.app')

@section('content')
    <div class="container">
        @if((auth()->user()->id ?? null ) == $wager->user_id)
            This is your wager. You can see results
            @foreach($options as $option)
                <li>
                    {{$option->text}}, &nbsp; number of bets: &nbsp; {{count($option->bets)}}
                </li>
            @endforeach
        @else
            @if(!$betWasPlaced)
                <div>
                    I bet you {{$wager->rate}}, that {{$wager->condition}}.
                </div>
                <ul>
            @foreach($options as $option)
                    <li>
                        <a href="{{route('betting.bet', [$wager->id, $option->id ])}}">{{$option->text}}</a>
                    </li>
            @endforeach
                </ul>
                Comments:
                <ul>
                    @foreach($comments as $comment)
{{--                        тут выводить комменты, у которых визибл = тру--}}
                        <li>
                            {{$comment->text}}
                        </li>
                    @endforeach
                </ul>
            @else
                Your bet was accepted. You can add some comment if you want!
                <form action="{{route('betting.add.comment')}}" method="POST">
                    @csrf
                    text
                    <label for="text">Comment Text</label>
                    <input id="text" name='comment' type="text" class="@error('comment') is-invalid @enderror">
                    <br>
                    @error('comment')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <input type="hidden" name="wager_id" type="text" value="{{$wager->id}}">
                    <input type="submit" value="Submit">
                </form>
            @endif
        @endif
    </div>
    <a href="{{ url('/') }}">Back</a>
@endsection
