@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
           Uplode Progress
        </div>

        <div class="card-body">

           <center>

               <span><strong>PSM FILE {{$psm->progress()}} %</strong></span>
            <div class="progress" style="margin-bottom: 25px;">
                <div class="progress-bar" role="progressbar" style="width: {{$psm->progress()}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
               @if($peptide != null)

                   <span><strong>Peptide FILE {{$peptide->progress()}} %</strong></span>
                   <div class="progress" style="margin-bottom: 25px;">
                       <div class="progress-bar" role="progressbar" style="width: {{$peptide->progress()}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                   </div>


               @endif

               @if($protein != null)

                   <span><strong>Protein FILE {{$protein->progress()}} %</strong></span>
                   <div style="margin-bottom: 25px;" class="progress">
                       <div class="progress-bar" role="progressbar" style="width: {{$protein->progress()}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                   </div>


               @endif

               <div class="form-group" style="margin-top: 50px;">
                   <a class="btn btn-success" href="{{url(url()->current())}}">
                       Refresh
                   </a>
               </div>
           </center>
        </div>
    </div>

@endsection