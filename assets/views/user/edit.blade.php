{{-- 親レイアウト --}}
@extends('layout')

{{-- 追加スクリプト --}}
@push('scripts')
@endpush

{{-- タイトル --}}
@section('title', __('messages.user.edit.title'))

{{-- コンテンツ --}}
@section('content')
    <form method="POST" name="fm">
        @csrf
        {{-- id --}}
        <input type="hidden" name="id" id="id" value="{{old('id',$user->id)}}">

        {{-- account --}}
        <div class="form-group row">
            <label for="account" class="col-md-2 col-form-label">{{__('messages.user.edit.account')}}</label>
            <div class="col-md-10">
                <input type="text" name="account" id="account" class="form-control" value="{{old('account',$user->account)}}" readonly>
            </div>
        </div>
        {{-- password --}}
        <div class="form-group row">
            <label for="password" class="col-md-2 col-form-label">{{__('messages.user.edit.password')}}</label>
            <div class="col-md-10">
                <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}"
                    placeholder="{{__('messages.user.edit.hint_password')}}">
            </div>
        </div>
        {{-- password_confirmation --}}
        <div class="form-group row">
            <label for="password_confirmation" class="col-md-2 col-form-label">{{__('messages.user.edit.password_confirmation')}}</label>
            <div class="col-md-10">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="{{old('password_confirmation')}}"
                    placeholder="{{__('messages.user.edit.hint_password_confirmation')}}">
            </div>
        </div>
        {{-- email --}}
        <div class="form-group row">
            <label for="email" class="col-md-2 col-form-label">{{__('messages.user.edit.email')}}</label>
            <div class="col-md-10">
                <input type="text" name="email" id="email" class="form-control" value="{{old('email',$user->email)}}"
                    placeholder="{{__('messages.user.edit.hint_email')}}">
            </div>
        </div>
        {{-- note --}}
        <div class="form-group row">
            <label for="note" class="col-md-2 col-form-label">{{__('messages.user.edit.note')}}</label>
            <div class="col-md-10">
                <input type="text" name="note" id="note" class="form-control" value="{{old('note',$user->note)}}"
                    placeholder="{{__('messages.user.edit.hint_note')}}">
            </div>
        </div>
        {{-- version_no --}}
        <input type="hidden" name="version_no" id="version_no" value="{{old('version_no',$user->version_no)}}">

        {{-- button --}}
        <div class="mt-4">
            <button type="button" id="btn_back"   class="btn btn-secondary" onclick="location.href='{{route('users')}}'">{{__('messages.user.edit.btn_back')}}</button>
            <button type="post"   id="btn_delete" class="btn btn-secondary" onclick="return confirm('{{__('messages.user.edit.msg_delete')}}');" formaction="{{route("user/{$user->id}/delete")}}">{{__('messages.user.edit.btn_delete')}}</button>
            <button type="button" id="btn_cancel" class="btn btn-secondary" onclick="location.href='{{$_SERVER['REQUEST_URI']}}'">{{__('messages.user.edit.btn_cancel')}}</button>
            <button type="post"   id="btn_update" class="btn btn-secondary" formaction="{{route("user/{$user->id}/update")}}">{{__('messages.user.edit.btn_update')}}</button>
        </div>
    </form>
@endsection
