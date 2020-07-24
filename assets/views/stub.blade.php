{{-- Parent layout --}}
@extends('layout')

{{-- Additional script --}}
@push('scripts')
@endpush

{{-- title --}}
@section('title', $title)

{{--content --}}
@section('content')
    @if(!empty($messages))
      @foreach($messages as $message)
      <p>{{$message}}</p>
      @endforeach
    @endif
@endsection
