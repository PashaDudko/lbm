@extends('layouts.app')

@section('content')
<div class="container">
{{--    <a href="{{ url('/wagers') }}">See Wagers</a>--}}
    <a href="{{ route('wagers.index') }}">See Wagers</a>
    <br>
    <a href="{{ route('wagers.create') }}">Create Wager</a>
    <br>
    <a href="{{ route('betting.start', ['wager' => 1]) }}">To Wager</a>
    <br>
    <a href="{{ route('betting.finish', ['wager' => 1]) }}">See wager result</a>
</div>
@endsection
