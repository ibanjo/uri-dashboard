@extends('layouts.sidebar')

@section('the_sidebar')
    @include('content.the_sidebar')
@endsection

@section('content')
    <el-container id="vue-entry-mobility" class="container">
        <el-main>
            <el-row :gutter="10">
                <el-col :span="16">
                    <el-card class="box-card">
                        <div slot="header" class="clearfix">
                            <span>Nuova mobilità</span>
                        </div>
                        <div class="text item">
                            <el-form :model="mobility" :rules="rules.mobility" label-width="200px">
                                <el-form-item label="Sede estera">
                                    <el-select v-model="mobility.university_branch_id" filterable
                                               placeholder="Sede estera">
                                        <el-option
                                                v-for="branch in university_branches"
                                                :key="branch.id"
                                                :label="branch.name"
                                                :value="branch.id">
                                        </el-option>
                                    </el-select>
                                </el-form-item>

                                <el-form-item label="CFU previsti da esami">
                                    <el-input-number v-model="mobility.estimated_cfu_exams"
                                                     controls-position="right" :min="0"></el-input-number>
                                </el-form-item>

                                <el-form-item label="CFU previsti da tesi">
                                    <el-input-number v-model="mobility.estimated_cfu_thesis"
                                                     controls-position="right" :min="0"></el-input-number>
                                </el-form-item>

                                <el-form-item label="Semestre">
                                    <el-select v-model="mobility.semester_id" placeholder="Semestre">
                                        <el-option
                                                v-for="semester in semesters"
                                                :key="semester.id"
                                                :label="semester.name_ita"
                                                :value="semester.id">
                                        </el-option>
                                    </el-select>
                                </el-form-item>

                                <el-form-item label="Inizio contratto">
                                    <el-date-picker
                                            v-model="mobility.estimated_in"
                                            type="date"
                                            format="dd-MM-yyyy"
                                            placeholder="Inizio contratto">
                                    </el-date-picker>
                                </el-form-item>

                                <el-form-item label="Fine contratto">
                                    <el-date-picker
                                            v-model="mobility.estimated_out"
                                            type="date"
                                            format="dd-MM-yyyy"
                                            placeholder="Fine contratto">
                                    </el-date-picker>
                                </el-form-item>

                                <el-form-item label="Anno accademico" prop="academic_year">
                                    <el-input
                                            v-model="mobility.academic_year"
                                            placeholder="Formato: 2015/16">
                                    </el-input>
                                </el-form-item>

                                <el-form-item label="Idoneo/Assegnatario">
                                    <el-switch
                                            style="display: block"
                                            v-model="mobility.granted"
                                            active-color="#13ce66"
                                            inactive-color="#ff4949"
                                            active-text="Assegnatario"
                                            inactive-text="Idoneo">
                                    </el-switch>
                                </el-form-item>

                                <el-form-item>
                                    <el-button type="primary" @click="onSubmit">Crea mobilità</el-button>
                                    <el-button @click="onCancel">Annulla</el-button>
                                </el-form-item>
                            </el-form>
                        </div>
                    </el-card>
                </el-col>
                <el-col :span="8">
                    <el-card class="box-card">
                        <div slot="header" class="clearfix">
                            <span>Riepilogo utente</span>
                        </div>
                        <div class="text item">
                            <user-summary :user="user"></user-summary>
                        </div>
                    </el-card>
                </el-col>
            </el-row>
        </el-main>
    </el-container>
@endsection

@include('content.jsvars')