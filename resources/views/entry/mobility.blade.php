@extends('layouts.sidebar')

@section('the_sidebar')
    @include('content.the_sidebar')
@endsection

@section('content')
    <div id="vue-entry-mobility">
        <el-container class="container">
            <el-main>
                <el-row :gutter="10">
                    <el-col :span="16">
                        <el-card class="box-card">
                            <div slot="header" class="clearfix">
                                <span>Nuova mobilità</span>
                            </div>
                            <div class="text item">
                                <mobility-form action="/entry/mobility"
                                               :university-branches="university_branches"
                                               :user-id="user.id"
                                               :countries="countries"
                                               :semesters="semesters">
                                </mobility-form>
                            </div>
                        </el-card>
                    </el-col>
                    <el-col :span="8">
                        <el-card class="box-card">
                            <div slot="header" class="clearfix">
                                <span>Riepilogo utente</span>
                            </div>
                            <div class="text item">
                                <user-summary :user="user" default-tab="registry"></user-summary>
                            </div>
                        </el-card>
                    </el-col>
                </el-row>
            </el-main>
        </el-container>
    </div>
@endsection

@include('content.jsvars')