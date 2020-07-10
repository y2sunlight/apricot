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

    @stack('scripts')

</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="{{route()}}">{{__('messages.app.title')}}</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="{{route('users')}}">{{__('messages.app.menu.menu1')}}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('stub/2')}}">{{__('messages.app.menu.menu2')}}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('stub/3')}}">{{__('messages.app.menu.menu3')}}</a></li>
                <li class="nav-item"><a class="nav-link" href="http://y2sunlight.com/ground/doku.php?id=apricot:top" target="_blank">{{__('messages.app.menu.about_me')}}</a></li>
            </ul>

            @if(app('auth.menu',false))
            <ul class="navbar-nav ml-auto">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{AuthUser::getUser()->account}} <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{route('logout')}}">{{__('messages.app.menu.logout')}}</a>
                </div>
            </ul>
            @endif

        </div>
    </nav>

    <main class="mt-3 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h1>@yield('title')</h1>
                    @yield('content')

                    {{-- error --}}
                    @if($errors->count())
                    <div class="alert alert-danger mt-3">
                        @foreach($errors as $key=>$value)
                             {{$value}}<br>
                        @endforeach
                    </div>
                    @endif

                    {{-- msg --}}
                    @if(Flash::has('msg'))
                    <div class="alert alert-info mt-3">
                        {{Flash::get('msg')}}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <footer class="fixed-bottom bg-secondary text-center text-light py-1">{{env('APP_NAME')}} &copy; 2020 y2sunlight</footer>
    {!! DebugBar::render() !!}
</body>
</html>
