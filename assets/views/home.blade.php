{{-- 親レイアウト --}}
@extends('layout')

{{-- 追加スクリプト --}}
@push('scripts')
@endpush

{{-- タイトル --}}
@section('title')
@endsection

{{-- コンテンツ --}}
@section('content')
    <h1 class="text-center">{{__('messages.home.title')}} <span class="small">{{env('APP_VERSION')}}</span></h1>
    <div class="text-center">
        <img src="{{url_ver('img/apricot.jpg')}}" width="300">
    </div>
    <div class="text-center mt-2">{{$message}}</div>
@endsection
