@extends('layouts.sidebar')

@section('the_sidebar')
    @include('content.the_sidebar')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-push-2 col-xs-12">
            <el-carousel ref="usersCarousel" :autoplay="false" indicator-position="outside" trigger="click"
                         height="600px" v-if="users.length > 0">
                <el-carousel-item v-for="user in users" :key="user.id">
                    <el-row type="flex" justify="center">
                        <el-col :span="18">
                            <user-summary :user="user" :accordion="true" default-tab="registry"></user-summary>
                        </el-col>
                    </el-row>
                    <el-row type="flex" justify="center">
                        <el-col :span="1">
                            <el-button type="success" @click="approveUser(user.id)">
                                Approva
                            </el-button>
                        </el-col>
                    </el-row>
                </el-carousel-item>
            </el-carousel>
            <el-row type="flex" justify="space-around" align="middle" v-else>
                <el-col>
                    <el-alert
                            :title="nothingToBeDoneMessage"
                            type="success"
                            :closable="false"
                            show-icon>
                    </el-alert>
                </el-col>
            </el-row>
        </div>
    </div>
@endsection

@include('content.jsvars')