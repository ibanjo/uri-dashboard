@extends('layouts.sidebar')

@section('the_sidebar')
    @include('content.the_sidebar')
@endsection

@section('content')
    <el-container>
        <el-main>
            <el-row>
                <el-col :span="24">
                    <h2>Consultazione ed esportazione Mobilità</h2>
                </el-col>
            </el-row>

            <el-row>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4>Parametri</h4>
                    </div>
                    <div class="panel-body">
                        <query-mobilities action="{{ route('export.mobilities') }}"
                                          download-action="{{route('export.download', ['identifier' => 'identifier', 'name' => 'filename'])}}"
                                          file-name="export.xlsx" :available-filters="availableFilters"/>
                    </div>
                </div>
            </el-row>
        </el-main>
    </el-container>
@endsection

@include('content.jsvars')