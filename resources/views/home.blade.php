@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h1>Admin Control Panel</h1>
                    </div>
                    <div class="card">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        Welcome to PSM tools project 👨‍🔬 👩‍🔬


                        PSM: {{$psm}}
                        <br>
                        Protein: {{$Protein}}
                        <br>
                        Peptide: {{$Peptide}}
                        <br>
                        Project: {{$Project}}
                        <br>
                        Sample: {{$Sample}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection
