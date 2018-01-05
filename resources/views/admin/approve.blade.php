@extends('layouts.sidebar')

@section('the_sidebar')
    @include('content.the_sidebar')
@endsection

@section('content')
    <div id="vue-approve-users" class="container">
        <div class="row">
            <div class="col-md-8 col-md-push-2 col-xs-12">
                <el-carousel ref="usersCarousel" :autoplay="false" indicator-position="outside" trigger="click" height="600px" v-if="users.length > 0">
                    <el-carousel-item v-for="user in users" :key="user.id">
                        <el-row type="flex" justify="center">
                            <el-col :span="18">
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
                                        <dd>@{{ user.candidate_role.description }}</dd>
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
    </div>
@endsection

@include('content.jsvars')