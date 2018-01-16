@extends('layouts.sidebar')

@section('the_sidebar')
    @include('content.the_sidebar')
@endsection

@section('content')
    <el-row :gutter="10">
        <el-col :span="12">
            <el-button type="primary" @click="newUniversityBranchVisible = true">
                <i class="fa fa-plus-circle"></i> Nuova sede
            </el-button>
        </el-col>
        <el-col :span="12">
            <el-button type="primary" @click="newCountryVisible = true">
                <i class="fa fa-plus-circle"></i> Nuovo Paese
            </el-button>
        </el-col>
    </el-row>

    <el-row :gutter="10" type="flex" justify="center">
        <el-col :span="20">
            <el-table :data="university_branches" style="width: 100%" @cell-click="">
                <el-table-column label="Nome" prop="name">
                </el-table-column>

                <el-table-column label="Nome internazionale" prop="name_eng">
                </el-table-column>

                <el-table-column label="Codice Erasmus" prop="erasmus_code">
                </el-table-column>

                {{-- TODO template to show country name --}}
                <el-table-column label="Paese" prop="country_id" sortable>
                </el-table-column>

                <el-table-column label="Modifica">
                    <template slot-scope="scope">
                        <i class="fa fa-fw fa-edit"></i>
                    </template>
                </el-table-column>

                <el-table-column label="Elimina">
                    <template slot-scope="scope">
                        <i class="fa fa-fw fa-trash"></i>
                    </template>
                </el-table-column>
            </el-table>
        </el-col>
    </el-row>
@endsection

@section('modals')
    <el-dialog
            title="Nuova sede"
            :visible.sync="newUniversityBranchVisible"
            width="50%">
        <university-branch-form
                :countries="countries" action="{{ route('new.university') }}"
                :degree-course-types="degree_course_types"
                @university-branch-added="addUniversity"/>
    </el-dialog>

    <el-dialog
            title="Nuovo Paese"
            :visible.sync="newCountryVisible"
            width="50%">
        <country-form action="{{ route('new.country') }}" @country-added="addCountry"/>
    </el-dialog>
@endsection

@include('content.jsvars')