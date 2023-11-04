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
                    PSM: {{$Psm??0}}
                    <br>
                    Protein: {{$Protein??0}}
                    <br>
                    Peptide: {{$Peptide??0}}
                    <br>
                    Project: {{$Project??0}}
                    <br>
                    Sample: {{$Sample??0}}

                </div>

                <form style="padding: 10px;" action="{{url('psms')}}">
                    <div class="row">
                        <div class="col">
                            <select name="sample" class="form-control" >
                                <option value="">Samples</option>
                                @foreach(\App\Models\Sample::take(90)->inRandomOrder()->get() as $sm)
                                    <option value="{{$sm->name}}">{{$sm->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select name="tissue" class="form-control" >
                                <option value="">Tissue</option>
                                @foreach(\App\Models\Tissue::all() as $sm)
                                    <option value="{{$sm->id}}">{{$sm->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
