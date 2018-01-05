@extends('layouts.sidebar')

@section('the_sidebar')
    @include('content.the_sidebar')
@endsection

@section('content')
    <!--suppress RequiredAttributes -->
    <div id="vue-home" class="container">
        <div class="row">
            <div class="col-md-8 col-md-push-2 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Benvenuto, {{ Auth::user()['name'] }}!</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <el-row type="flex" justify="space-around" align="middle" v-if="nothingToBeDone">
                            <el-col>
                                <el-alert
                                        :title="nothingToBeDoneMessage"
                                        type="success"
                                        :closable="false"
                                        show-icon>
                                </el-alert>
                            </el-col>
                        </el-row>


                        <el-row type="flex" justify="space-around" align="middle" v-if="toApprove.length > 0">
                            <el-col :span="12">
                                <el-badge :value="toApprove.length" class="item">
                                    <el-alert
                                            :title="toApproveMessage"
                                            type="info"
                                            :closable="false"
                                            show-icon>
                                    </el-alert>
                                </el-badge>
                            </el-col>
                            <el-col :span="12">
                                <el-button @click="showUnapproved">
                                    Approva utenti
                                </el-button>
                            </el-col>
                        </el-row>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('content.jsvars')