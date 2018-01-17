@extends('layouts.sidebar')

@section('the_sidebar')
    @include('content.the_sidebar')
@endsection

@section('content')
    <el-row style="margin-bottom: 20px;" :gutter="20" type="flex" justify="center">
        <el-col :span="4">
            <el-button type="primary" @click="openNewUniversityDialog">
                <i class="fa fa-plus-circle"></i> Nuova sede
            </el-button>
        </el-col>
        <el-col :span="4">
            <el-button type="primary" @click="newCountryVisible = true">
                <i class="fa fa-plus-circle"></i> Nuovo Paese
            </el-button>
        </el-col>
    </el-row>

    <el-row :gutter="20" type="flex" justify="center">
        <el-col :span="24">
            <v-client-table :columns="columns" :data="university_branches" :options="options" v-if="ready"
                            @row-click="openEditUniversityDialog">
                <div slot="filter__country_name">
                    <input type="text" class="form-control" v-model="tableFilters.countryFilter"
                           @keyup="filterByCountry()" placeholder="Filtra per Paese">
                </div>
            </v-client-table>
        </el-col>
    </el-row>
@endsection

@section('modals')
    <el-dialog
            title="Sede universitaria"
            :visible.sync="newUniversityBranchVisible"
            width="50%" @close="closeBranchModal">
        <university-branch-form
                post-action="{{ route('new.university') }}" edit-action="{{ route('edit.university') }}"
                :countries="countries" :original-data="universityBranchBuffer" ref="branchForm"
                :degree-course-types="degree_course_types" :mode="universityMode"
                @university-branch-added="addUniversity" @university-branch-edited="editUniversity" />
    </el-dialog>

    <el-dialog
            title="Nuovo Paese"
            :visible.sync="newCountryVisible"
            width="50%">
        <country-form action="{{ route('new.country') }}" @country-added="addCountry"/>
    </el-dialog>
@endsection

@include('content.jsvars')