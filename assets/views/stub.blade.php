{{-- 親レイアウト --}}
@extends('layout')

{{-- 追加スクリプト --}}
@push('scripts')
@endpush

{{-- タイトル --}}
@section('title', $title)

{{-- コンテンツ --}}
@section('content')
    @if(!empty($messages))
      @foreach($messages as $message)
      <p>{{$message}}</p>
      @endforeach
    @endif
@endsection
