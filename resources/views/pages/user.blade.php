@extends('layouts.app')

@section('content')
    <br>

    <div class="row bg-light">
        <div class="col-sm-4 text-center border-right border-dark" >

            <img class="p-4 bg-white" src="/images/r0GpwEmcKFE.jpg" width="250" height="250" >
            <h5 class="font-weight-normal">{{ $user->name }} {{ $user->surname }}</h5>
            <p>University : <b>{{ $user->university }}</b></p>
            <a class="btn btn-outline-secondary text-dark" href="/friends?id={{$user->id}}">Friends</a>
            <br>
            <div class="text-center mt-3">
            @if(\App\Friend::where('id_user1',$user->id)->where('id_user2',Auth::user()->id)->first() == null &&
            \App\Friend::where('id_user2',$user->id)->where('id_user1',Auth::user()->id)->first() == null &&
            \App\Follow::where('id_follow',$user->id)->where('id_user',Auth::user()->id)->first() == null )
                <a href="addFollow?id={{$user->id}}&page=user" class="btn btn-success">+</a>
            @else
                <a href="deleteFriend?id={{ $user->id }}&page=user" class="btn btn-outline-danger">delete</a>
            @endif
            </div>
            <br>
            <br>
        </div>

        <div class="col-sm-8 bg-white " >

            @foreach( $blogs as $blog  )
                <div class="d-inline-block w-100">
                    <div class="flex flex-between">

                        <img class="float-left" src="../images/r0GpwEmcKFE.jpg" width="38" height="38">

                        <div class="float-left flex itm-center d-block">
                            <div class="flex flex-column ml-1">
                                <a class="font-weight-normal" href="user?id={{$user->id}}">{{ $user->name }} {{ $user->surname }}</a>
                                <br>
                                <span>{{ $blog->published_at }}</span>
                            </div>
                        </div>

                        <a type="button" href="/addNews?id={{$blog->id}}" class="btn text-dark float-right" >+</a>
                    </div>
                    <p  class="modal-content">&nbsp;{{ $blog->news }}</p >
                    <hr>
                </div>
                <br>
            @endforeach
            @if(count($blogs) == 0)
                <p class="font-italic text-center">No blogs</p>
            @endif

        </div>
    </div>

@stop