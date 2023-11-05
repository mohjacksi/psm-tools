@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
           Uplode Progress
        </div>

        <div class="card-body">

           <center>
               @php
                   $m=($psm->totalJobs-$psm->pendingJobs)+$psm->failedJobs;
                   $percent=   $m /$psm->totalJobs *100  ;

               @endphp

               <span><strong>PSM FILE {{$percent}} %</strong></span>
            <div class="progress" style="margin-bottom: 25px;">
                <div class="progress-bar" role="progressbar" style="width: {{$percent}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
               @if($peptide != null)
                   @php
                       $m2=($peptide->totalJobs-$peptide->pendingJobs)+$peptide->failedJobs;
                       $percent2=   $m2 /$peptide->totalJobs *100  ;

                   @endphp
                   <span><strong>Peptide FILE {{$percent2}} %</strong></span>
                   <div class="progress" style="margin-bottom: 25px;">
                       <div class="progress-bar" role="progressbar" style="width: {{$percent2}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                   </div>


               @endif

               @if($protein != null)
                   @php
                     $m3=($protein->totalJobs-$protein->pendingJobs)+$protein->failedJobs;
                     $percent3=   $m3 /$protein->totalJobs *100  ;

                   @endphp

                   <span><strong>Protein FILE {{$percent3}}%</strong></span>
                   <div style="margin-bottom: 25px;" class="progress">
                       <div class="progress-bar" role="progressbar" style="width: {{$percent3}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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


    <script>
        setInterval(function () {
            window.location.href='{{url()->current()}}';
        }, 1000 * 5);
    </script>

@endsection