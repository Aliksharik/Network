@extends('layouts.app')

@section('content')

    <div class="row bg-white">

        <div class=" col-sm-4 text-center border-right border-dark ">

            <br>
            <h5 class="font-italic font-weight-normal d-inline-block mt-1">Search parameter</h5>
            <hr>

            <form class="justify-content-center d-inline-block pl-5" >
                <input class=" form-control float-left " type="text"   name="search" placeholder="Seach by news">
                <input class=" btn btn-outline-success m-3 " type="button"  value="search">
            </form>

        </div>

        <div class=" col-sm-8">

            <div class="list-group">

                @foreach( $blog as $news)

                    <div class="d-inline-block w-100 pt-3">
                        <div class="flex flex-between">

                            <img class="float-left" src="../images/r0GpwEmcKFE.jpg" width="38" height="38">

                            <div class="float-left flex itm-center d-block">
                                <div class="flex flex-column ml-1">
                                    <a class="font-weight-normal" href="#">Alibek Berdaulet</a>
                                    <br>
                                    <span>2018-05-23 16:08:36</span>
                                </div>
                            </div>

                        </div>

                            <p  class="modal-content">&nbsp;{{ $news->news }} </p >

                    </div>

                @endforeach
            </div>


        </div>

    </div>

@stop