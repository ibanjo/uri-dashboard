@extends('layouts.sidebar')

@section('the_sidebar')
    @include('content.the_sidebar')
@endsection

@section('content')
    <div id="vue-view-user" class="container">
        <el-container>
            <el-main>

                <el-col :span="24">
                    <h2>Dettagli su @{{ full_name }}</h2>
                </el-col>

                <el-row>
                    <el-col :span="24" v-if="ready">
                        <div class="panel" :class="{'panel-info': has_mobilities, 'panel-default': !has_mobilities}">
                            <div class="panel-heading">
                                <h4>Mobilità</h4>
                            </div>
                            <div v-if="has_mobilities" class="panel-body">
                                <mobility-tracker :mobility="user.mobilities[0]" :semesters="semesters"
                                                  :attachments="attachments"
                                                  :mobility-statuses="mobility_statuses"
                                                  :university-branches="university_branches"></mobility-tracker>
                            </div>

                            <div v-if="!has_mobilities" class="panel-body">
                                <p>
                                    Nessuna mobilità in corso
                                    <a class="btn btn-default active pull-right"
                                       href="{{route('entry.mobility', compact('user_id'))}}"
                                       style="text-decoration:none">
                                        <i class="fa fa-plus-circle"></i> Nuova
                                    </a>
                                </p>
                            </div>
                        </div>
                    </el-col>
                </el-row>

                <el-row :gutter="20">
                    <el-col :span="8" v-if="ready">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4>Riepilogo utente</h4>
                            </div>
                            <div class="panel-body">
                                <user-summary :user="user" :accordion="true"></user-summary>
                            </div>
                        </div>
                    </el-col>
                    <el-col :span="16" v-if="ready">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="pull-right">
                                    <a class="btn btn-default active pull-right"
                                       href="{{route('entry.bank.account', compact('user_id'))}}"
                                       style="text-decoration:none">
                                        <i class="fa fa-plus-circle"></i> Nuovo
                                    </a>
                                </div>
                                <h4>Informazioni bancarie</h4>
                            </div>
                            <div class="panel-body">
                                <p v-if="!has_bank_account">
                                    Dati bancari non registrati
                                </p>
                                <v-client-table v-else :columns="bankTableColumns" :options="bankTableOptions"
                                                :data="user.bank_accounts" @row-click="changeActiveBankAccount">

                                </v-client-table>
                            </div>
                        </div>
                    </el-col>
                </el-row>

            </el-main>
        </el-container>
    </div>
@endsection

@include('content.jsvars')