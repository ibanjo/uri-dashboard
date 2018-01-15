@extends('layouts.sidebar')

@section('the_sidebar')
    {{-- FIXME the side color looks altered after first dropdown --}}
    <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
        <ul class="nav sidebar-nav">
            <li class="sidebar-brand">
                <a href="#">
                    {{config('app.name', 'Laravel')}}
                </a>
            </li>
            <li>
                <a href="{{route('home')}}"><i class="fa fa-fw fa-home"></i> Home</a>
            </li>
            @if(!Auth::guest() && Auth::user()->role_id < 5)
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-users"></i>
                        Utenti
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li class="dropdown-header">Cerca utenti</li>
                        <li><a href="{{ route('view.allusers') }}"><i class="fa fa-fw fa-user"></i> Tutti</a></li>
                        <li><a href="{{ route('view.students') }}"><i class="fa fa-fw fa-graduation-cap"></i>
                                Studenti</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-database"></i>
                        Dati
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li class="dropdown-header">Inserimento dati</li>
                        <li><a href="{{ route('entry.universities') }}"><i class="fa fa-fw fa-university"></i> Sedi straniere</a></li>
                        <li><a href="#"><i class="fa fa-fw fa-pencil"></i>Corsi di laurea</a></li>
                    </ul>
                </li>
            @endif
            <li>
                <a href="#" onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                    <i class="fa fa-fw fa-sign-out"></i> Esci</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </nav>
@endsection