@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h4>{{ __('Dashboard') }}</h4></div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            <h1>{{ session('status') }}</h1>
                        </div>
                    @endif

                    <h3>
                        Welcome to PSM tools project 👨‍🔬 👩‍🔬

                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
