@extends('layouts.sidebar')

@section('the_sidebar')
    @include('content.the_sidebar')
@endsection

@section('content')
    <!--suppress RequiredAttributes -->
    <div id="vue-entry-user" class="container">
        <div class="row">
            <form-wizard title="Registrazione nuovo utente" subtitle="Inserisci i tuoi dati" @on-complete="registerUser"
                         next-button-text="Avanti" back-button-text="Indietro" finish-button-text="Invia">
                <tab-content title="Dati Anagrafici">
                    <el-form :model="user.registry" :rules="rules.registry" label-width="200px">
                        {{-- TODO profile picture upload and form validation --}}
                        <el-form-item label="Nome" prop="name">
                            <el-input v-model="user.registry.name" placeholder="Nome"/>
                        </el-form-item>
                        <el-form-item label="Secondo nome">
                            <el-input v-model="user.registry.middle_name" placeholder="Secondo nome"/>
                        </el-form-item>
                        <el-form-item label="Cognome" prop="surname">
                            <el-input v-model="user.registry.surname" placeholder="Cognome"/>
                        </el-form-item>
                        <el-form-item label="Codice fiscale" prop="fiscal_code">
                            <el-input v-model="user.registry.fiscal_code" placeholder="Codice fiscale"/>
                        </el-form-item>
                        <el-form-item label="Email" prop="email">
                            <el-input v-model="user.registry.email" placeholder="Email"/>
                        </el-form-item>
                        <el-form-item label="Telefono">
                            <el-input v-model="user.registry.telephone" placeholder="Telefono"/>
                        </el-form-item>

                        <el-form-item label="Password" prop="password">
                            <el-input type="password" v-model="user.registry.password"
                                      auto-complete="off"/>
                        </el-form-item>
                        <el-form-item label="Conferma password" prop="password_confirm">
                            <el-input type="password" v-model="user.registry.password_confirm"
                                      auto-complete="off"/>
                        </el-form-item>
                    </el-form>
                </tab-content>

                <tab-content title="Dati Accademici">
                    <el-form :model="user.academic" :rules="rules.academic" label-width="200px">
                        <el-form-item label="Ruolo" prop="candidate_role_id">
                            <el-select v-model="user.academic.candidate_role_id" placeholder="Ruolo">
                                <el-option
                                        v-for="role in roles"
                                        :key="role.id"
                                        :label="role.description"
                                        :value="role.id">
                                </el-option>
                            </el-select>
                        </el-form-item>

                        <el-form-item label="Corso di Laurea" prop="degree_course_id">
                            <el-select v-model="user.academic.degree_course_id" filterable
                                       placeholder="Corso di laurea">
                                <el-option
                                        v-for="deg in degree_courses"
                                        :key="deg.id"
                                        :label="deg.name_ita"
                                        :value="deg.id">
                                </el-option>
                            </el-select>
                        </el-form-item>

                        <el-form-item label="Dipartimento">
                            <el-select v-model="user.academic.department_id" placeholder="Dipartimento">
                                <el-option
                                        v-for="dep in departments"
                                        :key="dep.id"
                                        :label="dep.name"
                                        :value="dep.id"/>
                            </el-select>
                        </el-form-item>

                        <el-form-item label="Numero di matricola">
                            <el-input v-model="user.academic.number" placeholder="Numero di matricola"/>
                        </el-form-item>

                        <el-form-item label="Descrizione">
                            <el-input v-model="user.academic.description"
                                      placeholder="Breve descrizione (p. es. &quot;Laurea Triennale&quot;"/>
                        </el-form-item>

                    </el-form>
                </tab-content>

                <tab-content title="Dati Bancari">
                    <el-form :model="user.bank" label-width="200px">
                        <el-form-item>
                            <el-checkbox v-model="user.bank.has_bank_account">Inserisci coordinate bancarie
                            </el-checkbox>
                        </el-form-item>

                        <el-form-item label="Banca">
                            <el-input :disabled="!user.bank.has_bank_account" v-model="user.bank.bank_name"
                                      placeholder="Nome istituto bancario"/>
                        </el-form-item>

                        <el-form-item label="Codice IBAN">
                            <el-input :disabled="!user.bank.has_bank_account" v-model="user.bank.iban"
                                      placeholder="IBAN completo"/>
                        </el-form-item>

                        <el-form-item>
                            <el-checkbox :disabled="!user.bank.has_bank_account" v-model="user.bank.user_is_holder">
                                L'utente coincide con l'intestatario
                            </el-checkbox>
                        </el-form-item>

                        <el-form-item label="Nome">
                            <el-input :disabled="user.bank.user_is_holder || !user.bank.has_bank_account"
                                      v-model="user.bank.holder_name" placeholder="Nome dell'intestatario"/>
                        </el-form-item>
                        <el-form-item label="Secondo nome">
                            <el-input :disabled="user.bank.user_is_holder || !user.bank.has_bank_account"
                                      v-model="user.bank.holder_middle_name"
                                      placeholder="Secondo nome dell'intestatario"/>
                        </el-form-item>
                        <el-form-item label="Cognome">
                            <el-input :disabled="user.bank.user_is_holder || !user.bank.has_bank_account"
                                      v-model="user.bank.holder_surname" placeholder="Cognome dell'intestatario"/>
                        </el-form-item>
                    </el-form>
                </tab-content>

                <tab-content title="Riepilogo">
                    {{-- TODO use element here--}}
                    <h3>Riepilogo</h3>

                </tab-content>
            </form-wizard>
        </div>
    </div>
@endsection

@include('content.jsvars')