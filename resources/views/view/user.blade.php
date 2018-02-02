@extends('layouts.sidebar')

@section('the_sidebar')
    @include('content.the_sidebar')
@endsection

@section('content')
    <el-container>
        <el-main>
            <el-row>
                <el-col :span="24">
                    <h2>Dettagli su @{{ full_name }}</h2>
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="24" v-if="ready">
                    <div class="panel" :class="{'panel-info': has_mobilities, 'panel-default': !has_mobilities}">
                        <div class="panel-heading">
                            <div class="pull-right" v-if="!has_mobilities">
                                <el-button type="primary" @click="newMobilityVisible = true">
                                    <i class="fa fa-plus-circle"></i> Nuova
                                </el-button>
                            </div>
                            <h4>Mobilità</h4>
                        </div>
                        <div v-if="!has_mobilities" class="panel-body">
                            <p>
                                Nessuna mobilità in corso
                            </p>
                        </div>
                        <div v-if="has_mobilities" class="panel-body">
                            <el-tabs tab-position="top" type="border-tab">
                                <el-tab-pane v-for="mobility in mobilities" :key="mobility.id"
                                             :label="mobility.academic_year">
                                    {{-- TODO tab label icon and color for closed/aborted mobilities --}}
                                    <mobility-tracker
                                            :mobility="mobility" :semesters="semesters"
                                            :mobility-statuses="mobility_statuses"
                                            :university-branches="university_branches"
                                            abort-action="{{ route('mobility.abort') }}"
                                            edit-action="{{ route('edit.mobility') }}"
                                            edit-status-action="{{ route('edit.mobility.status') }}"
                                            document-retrieve-action="{{ route('document.retrieve') }}"
                                            document-delete-action="/document/delete"
                                            document-upload-action="{{ route('document.upload') }}"
                                            attachment-retrieve-action="{{ route('file.retrieve') }}"
                                            attachment-delete-action="/file/delete"
                                            attachment-upload-action="{{ route('file.upload') }}">
                                    </mobility-tracker>
                                </el-tab-pane>
                            </el-tabs>
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
                                <el-button type="primary" @click="newBankAccountVisible = true">
                                    <i class="fa fa-plus-circle"></i> Nuovo
                                </el-button>
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
@endsection

@section('modals')
    <el-dialog
            title="Nuova mobilità"
            :visible.sync="newMobilityVisible"
            width="50%">
        <mobility-form action="{{ route('new.mobility') }}"
                       :university-branches="university_branches"
                       :user-id="user.id"
                       :countries="countries"
                       :semesters="semesters"
                       @canceled="newMobilityVisible = false"
                       @mobility-created="onMobilityCreated">
        </mobility-form>
    </el-dialog>

    <el-dialog
            title="Nuovo account bancario"
            :visible.sync="newBankAccountVisible"
            width="50%">
        <bank-account-form
                action="{{ route('new.bank.account') }}"
                :user-id="user.id"
                @canceled="newBankAccountVisible = false"
                @bank-account-created="onBankAccountCreated">
        </bank-account-form>
    </el-dialog>
@endsection

@include('content.jsvars')