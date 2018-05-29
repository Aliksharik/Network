@extends('layouts.app')

@section('content')

        <div class="row bg-white">
            <div class="col-sm-4 text-center border-right border-dark" >

                <img class="p-4 bg-white" src="../images/r0GpwEmcKFE.jpg" width="250" height="250" >
                <h5 class="font-weight-normal">{{Auth::user()->name }} {{ Auth::user()->surname}}</h5>
                <p>University : <b>{{ Auth::user()->university }}</b></p>

                <div>

                    <br>
                    <h5 class="float-left font-italic font-weight-normal">New follows</h5>
                    <br><hr>
                    @foreach($user_r as $user)
                        <div class="d-inline-block w-100">
                            <img class="float-left" src=" ../images/r0GpwEmcKFE.jpg" width="38" height="38">
                            <a class="float-left font-weight-normal" href="user?id={{$user->id}}">&nbsp;{{$user->name}} {{$user->surname}}</a>

                            <a class=" btn float-right btn-outline-danger" href="lostInFollow?id={{$user->id}}&page=home" >-</a>
                            <a class=" btn float-right btn-outline-success" href="addFollow?id={{$user->id}}&page=home" >+</a>

                        </div>
                    @endforeach

                </div>

                <div>

                    <br>
                    <h5 class="float-left font-italic font-weight-normal">Follows</h5>
                    <br><hr>

                    @foreach($user_l as $user)
                        <div class="d-inline-block w-100">
                            <img class="float-left" src=" {{ $user->img  }} " width="38" height="38">
                            <a class="float-left font-weight-normal" href="user?id={{$user->id}}">&nbsp;{{$user->name}} {{$user->surname}}</a>
                            <a class=" btn float-right btn-outline-success" href="addFollow?id={{$user->id}}&page=home" >+</a>
                        </div>
                    @endforeach

                </div>
            </div>

            <div class="col-sm-8 " >
                {!! Form::open([ 'url' => '/addBlog' , 'class' => 'd-inline-block w-100 p-3'] )  !!}
                    <textarea class="modal-content w-75 float-left"  placeholder="New blog" name="news" ></textarea>
                    <input class="float-left btn btn-group-toggle m-2 ml-5" type="submit" value="add blog">
                {{Form::close()}}

                <div class="list-group">
                @foreach( $blogs as $blog  )
                    <div class="d-inline-block w-100 pt-3">
                        <div class="flex flex-between">

                            <img class="float-left" src="../images/r0GpwEmcKFE.jpg" width="38" height="38">

                            <div class="float-left flex itm-center d-block">
                                <div class="flex flex-column ml-1">
                                    <a class="font-weight-normal" href="#">{{ Auth::user()->name }} {{ Auth::user()->surname }}</a>
                                    <br>
                                    <span>{{ $blog->published_at }}</span>
                                </div>
                            </div>

                            <a href="/deleteBlog?id={{$blog->id}}" class="btn btn-outline-light border-dark text-dark float-right " >delete</a>
                        </div>
                        <p  class="modal-content">&nbsp;{{ $blog->news }}</p >

                    </div>

                @endforeach
                </div>
            </div>
        </div>

@stop