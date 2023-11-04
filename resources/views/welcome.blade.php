@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">

                        </div>
                    </div>
                <div class="card">
                    <div class="card-header">
                        <form action="{{url('psms')}}">
                            <div class="row">
                                <div class="col">
                                    <select name="sample" class="form-control" >
                                        <option value="">Samples</option>
                                        @foreach(\App\Models\Sample::take(20)->inRandomOrder()->get() as $sm)
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
    </div>
@endsection
@section('scripts')
    @parent
@endsection
