@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
           Uplode Progress
        </div>

        <div class="card-body">

           <center>
               <span><strong>{{$batch->progress()}} %</strong></span>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: {{$batch->progress()}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
               <div class="form-group" style="margin-top: 50px;">
               <a class="btn btn-success" href="{{url(url()->current())}}">
                   Refresh
               </a>
               </div>
           </center>
        </div>
    </div>

    <script>
        setInterval(function () {
            window.location.href='{{url()->current()}}';
        }, 1000 * 5);
    </script>

@endsection