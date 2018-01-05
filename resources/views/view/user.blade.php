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

                <el-col :span="24" align="center" v-if="!ready">
                    <i class="fa fa-circle-o-notch fa-spin fa-5x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
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
                                                        @{{ user.mobilities[0].university_branch.name }}
                                                    </el-form-item>
                                                    <el-form-item label="CFU previsti da esami:">
                                                        @{{ user.mobilities[0].estimated_cfu_exams }}
                                                    </el-form-item>
                                                    <el-form-item label="CFU previsti da tesi:">
                                                        @{{ user.mobilities[0].estimated_cfu_thesis }}
                                                    </el-form-item>
                                                    <br>
                                                    <el-form-item label="Semestre:">
                                                        @{{ user.mobilities[0].semester.name_ita }}
                                                    </el-form-item>
                                                    <el-form-item label="Inizio contratto:">
                                                        @{{ user.mobilities[0].estimated_in }}
                                                    </el-form-item>
                                                    <el-form-item label="Fine contratto:">
                                                        @{{ user.mobilities[0].estimated_out }}
                                                    </el-form-item>
                                                </el-form>
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
                                                :file-list="attachments"
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
                                        <i :class="pre_upload_icon"></i>
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

                                        <el-table-column label="Nome">
                                            <template slot-scope="scope">
                                                @{{ scope.row.name }}
                                            </template>
                                        </el-table-column>

                                        <el-table-column label="Descrizione">
                                            <template slot-scope="scope">
                                                @{{ scope.row.description }}
                                            </template>
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
                                <h4>Dati anagrafici</h4>
                            </div>
                            <div class="panel-body">
                                <el-collapse v-model="activeTab" accordion>
                                    <el-collapse-item title="Dati anagrafici" name="registry">
                                        <dl>
                                            <dt>Nome</dt>
                                            <dd>@{{ user.name }}</dd>
                                            <dt>Secondo nome</dt>
                                            <dd>@{{ user.middle_name }}</dd>
                                            <dt>Cognome</dt>
                                            <dd>@{{ user.surname }}</dd>
                                            <dt>Codice fiscale</dt>
                                            <dd>@{{ user.fiscal_code }}</dd>
                                            <dt>Email</dt>
                                            <dd>@{{ user.email }}</dd>
                                            <dt>Telefono</dt>
                                            <dd>@{{ user.telephone }}</dd>
                                        </dl>
                                    </el-collapse-item>

                                    <el-collapse-item title="Dati accademici" name="academic">
                                        <dt>Ruolo</dt>
                                        <dd>@{{ user.role.description }}</dd>
                                        <dt>Dipartimento</dt>
                                        <dd>@{{ user.department.name }}</dd>
                                        {{-- TODO handle multiple register numbers --}}
                                        <dt>Numero di matricola</dt>
                                        <dd v-for="reg in user.registers">@{{ reg.number }}</dd>
                                        <dt>Tipo corso di laurea</dt>
                                        <dd>@{{ user.degree_course.degree_course_type.name_ita }}</dd>
                                        <dt>Corso di laurea</dt>
                                        <dd>@{{ user.degree_course.name_ita }}</dd>
                                    </el-collapse-item>
                                </el-collapse>
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