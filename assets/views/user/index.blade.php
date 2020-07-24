{{-- Parent layout --}}
@extends('layout')

{{-- Additional script --}}
@push('scripts')
<script type="text/javascript">
$(function(){
    $('tr[data-href]').on('click', function(){
        location.href = $(this).data('href');
    });
});
</script>
@endpush

{{-- title --}}
@section('title', __('messages.user.index.title'))

{{--content --}}
@section('content')
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>{{__('messages.user.index.id')}}</th>
                <th>{{__('messages.user.index.account')}}</th>
                <th>{{__('messages.user.index.email')}}</th>
                <th>{{__('messages.user.index.created_at')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr data-href="{{route("user/{$user->id}/edit")}}">
                <td>{{ $user->id }}</td>
                <td>{{ $user->account }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ViewHelper::formatDatetime($user->created_at) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<button type="button" id="btn_new" class="btn btn-secondary" onclick="location.href='{{route('user/create')}}'">{{__('messages.user.index.btn_new')}}</button>
@endsection
