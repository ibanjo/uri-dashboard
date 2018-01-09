@extends('layouts.sidebar')

@section('the_sidebar')
    @include('content.the_sidebar')
@endsection

@section('content')
    <el-container id="vue-entry-bank" class="container">
        <el-main>
            <el-row :gutter="10">
                <el-col :span="16">
                    <el-form :model="bank" label-position="left" label-width="100px" :rules="rules"
                             ref="bankAccountForm">
                        <el-form-item label="Banca" prop="bank_name">
                            <el-input v-model="bank.bank_name" placeholder="Nome istituto bancario"></el-input>
                        </el-form-item>

                        <el-form-item label="IBAN" prop="iban">
                            <el-input v-model="bank.iban" placeholder="IBAN completo"></el-input>
                        </el-form-item>

                        <el-form-item>
                            <el-checkbox v-model="bank.user_is_holder">L'utente coincide con l'intestatario
                            </el-checkbox>
                        </el-form-item>

                        <el-form-item label="Nome">
                            <el-col :span="12">
                                <el-input :disabled="bank.user_is_holder" v-model="bank.holder_name"
                                          placeholder="Nome dell'intestatario"></el-input>
                            </el-col>
                            <el-col :span="12">
                                <el-input :disabled="bank.user_is_holder" v-model="bank.holder_middle_name"
                                          placeholder="Secondo nome dell'intestatario"></el-input>
                            </el-col>
                        </el-form-item>
                        <el-form-item label="Cognome">
                            <el-input :disabled="bank.user_is_holder" v-model="bank.holder_surname"
                                      placeholder="Cognome dell'intestatario"></el-input>
                        </el-form-item>

                        <el-form-item>
                            <el-checkbox v-model="bank.set_primary">Imposta come conto principale</el-checkbox>
                        </el-form-item>

                        <el-form-item>
                            <el-button type="primary" @click="onSubmit">Crea conto</el-button>
                            <el-button @click="onCancel">Annulla</el-button>
                        </el-form-item>
                    </el-form>
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