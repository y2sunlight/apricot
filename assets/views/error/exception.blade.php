{{-- Parent layout--}}
@extends('error.layout')

{{-- content --}}
@section('content')
    @php
        switch ($status_code) {
            case 400:
                $message = 'Bad Request';
                break;
            case 401:
                $message = 'Unauthorized';
                break;
            case 403:
                $message = 'Forbidden';
                break;
            case 404:
                $message = 'Not Found';
                break;
            case 405:
                $message = 'Method Not Allowed';
                break;
            case 408:
                $message = 'Request Timeout';
                break;
            case 414:
                $message = 'URI Too Long';
                break;
            case 419:
                $message = 'Page Expired';
                break;
            case 500:
                $message = 'Internal Server Error';
                break;
            case 503:
                $message = 'Service Unavailable';
                break;
            default:
                $message = 'Error';
                break;
        }
    @endphp

    <div class="code">{{$status_code}}</div>
    <div class="message" style="padding: 10px;">{{ $message }}</div>
@endsection

