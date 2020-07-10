{{-- 親レイアウト --}}
@extends('layout')

{{-- 追加スクリプト --}}
@push('scripts')
@endpush

{{-- タイトル --}}
@section('title', __('messages.user.create.title'))

{{-- コンテンツ --}}
@section('content')
    <form method="POST" name="fm">
        @csrf
        {{-- account --}}
        <div class="form-group row">
            <label for="account" class="col-md-2 col-form-label">{{__('messages.user.create.account')}}</label>
            <div class="col-md-10">
                <input type="text" name="account" id="account" class="form-control" value="{{old('account',$user->account)}}"
                    placeholder="{{__('messages.user.create.hint_account')}}">
            </div>
        </div>
        {{-- password --}}
        <div class="form-group row">
            <label for="password" class="col-md-2 col-form-label">{{__('messages.user.create.password')}}</label>
            <div class="col-md-10">
                <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}"
                    placeholder="{{__('messages.user.create.hint_password')}}">
            </div>
        </div>
        {{-- password_confirmation --}}
        <div class="form-group row">
            <label for="password_confirmation" class="col-md-2 col-form-label">{{__('messages.user.create.password_confirmation')}}</label>
            <div class="col-md-10">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="{{old('password_confirmation')}}"
                    placeholder="{{__('messages.user.create.hint_password_confirmation')}}">
            </div>
        </div>
        {{-- email --}}
        <div class="form-group row">
            <label for="email" class="col-md-2 col-form-label">{{__('messages.user.create.email')}}</label>
            <div class="col-md-10">
                <input type="text" name="email" id="email" class="form-control" value="{{old('email',$user->email)}}"
                    placeholder="{{__('messages.user.create.hint_email')}}">
            </div>
        </div>
        {{-- note --}}
        <div class="form-group row">
            <label for="note" class="col-md-2 col-form-label">{{__('messages.user.create.note')}}</label>
            <div class="col-md-10">
                <input type="text" name="note" id="note" class="form-control" value="{{old('note',$user->note)}}"
                    placeholder="{{__('messages.user.create.hint_note')}}">
            </div>
        </div>

        {{-- button --}}
        <div class="mt-4">
            <button type="button" id="btn_back"   class="btn btn-secondary" onclick="location.href='{{route('users')}}'">{{__('messages.user.create.btn_back')}}</button>
            <button type="button" id="btn_cancel" class="btn btn-secondary" onclick="location.href='{{$_SERVER['REQUEST_URI']}}'">{{__('messages.user.create.btn_cancel')}}</button>
            <button type="post"   id="btn_insert" class="btn btn-secondary" formaction="{{route("user/insert")}}">{{__('messages.user.create.btn_insert')}}</button>
        </div>

    </form>
@endsection
