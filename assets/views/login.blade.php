<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{__('messages.app.title')}}</title>

    <!-- stylesheet -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="{{url_ver('css/main.css')}}" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="{{url_ver('js/main.js')}}"></script>
    {!! DebugBar::renderHead() !!}
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="{{route()}}">{{__('messages.app.title')}}</a>
    </nav>

    <main class="container mt-sm-5 mt-1">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('auth.login.title') }}</div>
                    <div class="card-body">
                        <form method="POST" name="fm">
                            @csrf

                            {{-- account --}}
                            <div class="form-group row">
                                <label for="account" class="col-md-3 col-form-label text-md-right">{{__('auth.login.account')}}</label>
                                <div class="col-md-8">
                                    <input type="text" name="account" id="account" class="form-control" value="{{old('account')}}">

                                    @if($errors->has('account',ValidatorErrorBag::BAG_KEY))
                                    <span class="text-danger">{{$errors->get('account',ValidatorErrorBag::BAG_KEY)}}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- password --}}
                            <div class="form-group row">
                                <label for="password" class="col-md-3 col-form-label text-md-right">{{__('auth.login.password')}}</label>
                                <div class="col-md-8">
                                    <input type="password" name="password" id="password" class="form-control">

                                    @if($errors->has('password',ValidatorErrorBag::BAG_KEY))
                                    <span class="text-danger">{{$errors->get('password',ValidatorErrorBag::BAG_KEY)}}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- remember me --}}
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-3">
                                    <div class="form-check my-md-0 my-3">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">{{ __('auth.login.remember') }}</label>
                                    </div>
                                </div>
                            </div>

                            {{-- button --}}
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-3">
                                    <button type="submit" class="btn btn-primary" formaction="{{ route('login') }}">{{ __('auth.login.btn_login') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if($errors->count(ErrorBag::DEFAULT_NAME))
                    <div class="card-footer">
                        <div class="text-danger">
                            @foreach($errors->all(ErrorBag::DEFAULT_NAME) as $key=>$value)
                                 {{$value}}<br>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </main>

    <footer class="fixed-bottom bg-secondary text-center text-light py-1">&copy; 2020 y2sunlight</footer>
    {!! DebugBar::render() !!}
</body>
</html>
