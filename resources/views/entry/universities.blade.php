@extends('layouts.sidebar')

@section('the_sidebar')
    @include('content.the_sidebar')
@endsection

@section('content')
    <div id="vue-entry-universities">
        <el-container class="container">
            <el-main>
                <el-row :gutter="10">
                    <el-col :span="12">
                        <el-card class="box-card">
                            <div slot="header" class="clearfix">
                                <p><i class="fa fa-fw fa-university"></i> Nuova Sede Universitaria</p>
                            </div>
                            <div class="text item">
                                <university-branch-form :countries="countries" action="{{ route('new.university') }}"
                                              @university-branch-added="addUniversity"/>
                            </div>
                        </el-card>
                    </el-col>
                    <el-col :span="12">
                        <el-card class="box-card">
                            <div slot="header" class="clearfix">
                                <p><i class="fa fa-fw fa-globe"></i> Nuovo Paese</p>
                            </div>
                            <div class="text item">
                                <country-form action="{{ route('new.country') }}" @country-added="addCountry"/>
                            </div>
                        </el-card>
                    </el-col>
                </el-row>
            </el-main>
        </el-container>
    </div>
@endsection

@include('content.jsvars')