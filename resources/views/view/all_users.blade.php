@extends('layouts.sidebar')

@section('the_sidebar')
    @include('content.the_sidebar')
@endsection

@section('content')
    <div id="vue-view-users" class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>@{{ subview.title }}</h2>
            </div>
            @if(Auth::user()->role_id <= 2)
                <div class="col-md-4">
                    <a class="btn btn-default active pull-right" href="{{route('register')}}" style="text-decoration:none">
                        <i class="fa fa-plus-circle"></i> Registra nuovo utente
                    </a>
                </div>
            @endif

            <div class="col-md-12" align="center" v-if="!ready">
                <i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw"></i>
                <span class="sr-only">Loading...</span>
            </div>
            <v-client-table :columns="columns" :data="users" :options="options" v-if="ready">
                <div slot="filter__department_name">
                    <input type="text" class="form-control" v-model="departmentQuery"
                           @keyup="filterDepartment()" placeholder="Filtra per Dipartimento">
                </div>
                <div slot="filter__register_number">
                    <input type="text" class="form-control" v-model="registerQuery"
                           @keyup="filterRegister()" placeholder="Cerca per Matricola">
                </div>
                <div v-if="subview.name === 'all'" slot="filter__role">
                    <input type="text" class="form-control" v-model="roleQuery"
                           @keyup="filterRole()" placeholder="Cerca per Ruolo">
                </div>
            </v-client-table>
        </div>
    </div>
@endsection

@include('content.jsvars')