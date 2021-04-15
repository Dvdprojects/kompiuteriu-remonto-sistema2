@extends('layouts.app')

@section('content')
   <div class="container">
       <div class="row">
           <div class="col-md-3">
           </div>
           <div class="col-md-9">
               <div class="row">
                   <div class="clearfix">
                       <div class="text-center" style="width: auto;">
                           <h5>Klauskite specialisto</h5>
                       </div>
                       <div class="float-right" style="width: auto; float: right">
                           <a href="/forum-post-add"
                              data-mdb-toggle="modal"
                              data-mdb-placement="top"
                              title="Pridėti forumo įrašą">
                               <i class="fas fa-plus"></i>
                           </a>
                       </div>
                   </div>
               </div>
               <hr>
               @if(1 == 1)

                   <div class="row">
                       <div class="text-center">
                           Nėra įrašų.
                       </div>
                   </div>

               @else

               <div class="row">

               </div>

               @endif
       </div>
   </div>
@endsection
