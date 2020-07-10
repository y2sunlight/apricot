{{-- 親レイアウト --}}
@extends('error.layout')

{{-- コンテンツ --}}
@section('content')
    <div class="flex-row message">
        <div class="mb">{{$message}}</div>
        <div><a href='{{route('')}}'>{{__('auth.basic.back')}}</a></div>
    </div>
@endsection
