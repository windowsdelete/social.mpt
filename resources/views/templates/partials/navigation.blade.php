<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a href="{{ route('home') }}" class="navbar-brand">SocialMPT</a>
        </div>
        <div class="collapse navbar-collapse">
            @if (Auth::check())
                     <ul class="nav navbar-nav">
                         <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Лента</a></li>
                         <li><a href="{{ route('friend.index') }}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Друзья</a></li>
                     </ul>
                <form action="{{ route('search.results') }}" class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" name="query" class="form-control" placeholder="Поиск">
                    </div>
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Поиск</button>
                </form>
                     @endif
                <ul class="nav navbar-nav navbar-right">
                    @if( Auth::check() )
                    <li><a href="{{ route('profile.index', ['username' => Auth::user()->username]) }}">{{ Auth::user()->getNameOrUsername() }}</a></li>
                    <li><a href="{{ route('profile.edit') }}"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Настройки</a></li>
                    <li><a href="{{ route('auth.signout') }}"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Выйти</a></li>
                    @else
                    <li><a href="{{ route('auth.signup') }}">Зарегистрироваться</a></li>
                    <li><a href="{{ route('auth.signin') }}">Войти</a></li>
                    @endif
                </ul>
        </div>
    </div>
</nav>