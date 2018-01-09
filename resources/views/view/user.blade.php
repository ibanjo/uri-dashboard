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
                                <el-row style="margin-bottom: 20px">
                                    <el-col :span="24">
                                        <el-card class="box-card">
                                            <div slot="header" class="clearfix">
                                                <span>Informazioni generali</span>
                                            </div>
                                            <div class="text item">
                                                <el-form :inline="true">
                                                    {{-- FIXME only one mobility can be active at a time --}}
                                                    <el-form-item label="Sede estera:">
                                                        <el-select v-model="user.mobilities[0].university_branch_id"
                                                                   placeholder="Sede estera" :disabled="!editMobility"
                                                                   :style="university_branch_style" filterable>
                                                            <el-option
                                                                    v-for="branch in university_branches"
                                                                    :key="branch.id"
                                                                    :label="branch.name"
                                                                    :value="branch.id">
                                                            </el-option>
                                                        </el-select>
                                                    </el-form-item>
                                                    <el-form-item label="CFU previsti da esami:">
                                                        <el-input-number
                                                                v-model="user.mobilities[0].estimated_cfu_exams"
                                                                :disabled="!editMobility" controls-position="right"
                                                                :min="0" style="width: 100px"></el-input-number>
                                                    </el-form-item>
                                                    <el-form-item label="CFU previsti da tesi:">
                                                        <el-input-number
                                                                v-model="user.mobilities[0].estimated_cfu_thesis"
                                                                :disabled="!editMobility" controls-position="right"
                                                                :min="0" style="width: 100px"></el-input-number>
                                                    </el-form-item>
                                                    <br>
                                                    <el-form-item label="Semestre:">
                                                        {{-- TODO change to select as in mobility entry --}}
                                                        <el-select v-model="user.mobilities[0].semester_id"
                                                                   placeholder="Semestre" :disabled="!editMobility"
                                                                   :style="semester_style">
                                                            <el-option
                                                                    v-for="semester in semesters"
                                                                    :key="semester.id"
                                                                    :label="semester.name_ita"
                                                                    :value="semester.id">
                                                            </el-option>
                                                        </el-select>
                                                    </el-form-item>
                                                    <el-form-item label="Inizio contratto:">
                                                        <el-date-picker
                                                                v-model="user.mobilities[0].estimated_in"
                                                                type="date" :disabled="!editMobility"
                                                                format="dd-MM-yyyy"
                                                                placeholder="Inizio contratto">
                                                        </el-date-picker>
                                                    </el-form-item>
                                                    <el-form-item label="Fine contratto:">
                                                        <el-date-picker
                                                                v-model="user.mobilities[0].estimated_out"
                                                                type="date" :disabled="!editMobility"
                                                                format="dd-MM-yyyy"
                                                                placeholder="Fine contratto">
                                                        </el-date-picker>
                                                    </el-form-item>
                                                </el-form>
                                                <el-button type="primary" @click="editMobility = !editMobility">
                                                    Modifica
                                                </el-button>
                                                <el-button type="success" @click="">
                                                    Salva
                                                </el-button>
                                                <el-button type="warning" @click="">
                                                    Ripristina
                                                </el-button>
                                            </div>
                                        </el-card>
                                    </el-col>
                                </el-row>

                                <el-row style="margin-bottom: 20px">
                                    <el-col :span="24">
                                        <el-steps :active="mobilityStatusActiveTab" finish-status="success"
                                                  align-center>
                                            <el-step v-for="mob in mobility_statuses" title=""
                                                     :description="mob.name" :key="mob.id"></el-step>
                                        </el-steps>
                                    </el-col>
                                </el-row>

                                <el-row type="flex" justify="space-around" style="margin-bottom: 20px">
                                    <el-col :span="1">
                                        <el-button @click="mobilityNextStep">Avanti</el-button>
                                    </el-col>
                                </el-row>

                                <el-row type="flex" justify="space-between" align="middle">
                                    <el-col :span="8">
                                        <el-upload
                                                action="/file/attach"
                                                ref="attachmentUploader"
                                                :data="attachment_additions.data"
                                                :headers="attachment_additions.headers"
                                                name="attachment"
                                                :show-file-list="false"
                                                :multiple="false"
                                                :auto-upload="false"
                                                :on-change="onAttachmentSelected"
                                                :on-success="onAttachmentUploaded">
                                            <el-button slot="trigger" size="small" type="primary">Scegli allegato
                                            </el-button>
                                            <el-button size="small" type="success" @click="uploadAttachment">
                                                Carica file
                                            </el-button>
                                            <div slot="tip" class="el-upload__tip">Massima dimensione: 10Mb</div>
                                        </el-upload>
                                    </el-col>
                                    <el-col :span="8">
                                        <upload-preview v-if="attachment_buffer.length > 0"
                                                        :name="attachment_buffer[0].name"/>
                                    </el-col>
                                    <el-col :span="8">
                                        <el-input placeholder="Descrizione dell'allegato (opzionale)"
                                                  v-model="attachment_description"></el-input>
                                    </el-col>
                                </el-row>

                                <el-row>
                                    <el-table :data="attachments" style="width: 100%" @cell-click="onAttachmentClicked">
                                        <el-table-column label="Download">
                                            <template slot-scope="scope">
                                                <i class="fa fa-fw fa-file-pdf-o"></i>
                                            </template>
                                        </el-table-column>

                                        <el-table-column label="Nome" prop="name" sortable>
                                        </el-table-column>

                                        <el-table-column label="Descrizione" prop="description" sortable>
                                        </el-table-column>

                                        <el-table-column label="Data" prop="created_at" sortable>
                                            {{--<template slot-scope="scope">--}}
                                            {{--@{{ scope.row.created_at | moment('dd/mm/YYY, hh:mm') }}--}}
                                            {{--</template>--}}
                                            {{-- TODO integrate momentJs in webpack to format dates --}}
                                        </el-table-column>

                                        <el-table-column label="Elimina">
                                            <template slot-scope="scope">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </template>
                                        </el-table-column>
                                    </el-table>

                                </el-row>
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
                                <user-summary :user="user"></user-summary>
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