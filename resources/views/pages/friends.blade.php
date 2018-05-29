@extends('layouts.app')

@section('content')

    <div class="row bg-white">

        <div class="col-sm-3 text-center border-right border-dark" >

            <br>
            <h5 class="font-italic font-weight-normal d-inline-block mt-1">Search parameter</h5>
            <hr>

            <form class="justify-content-center d-inline-block " >

                <span class="m-auto">
                    University :
                    <select class="form-control-sm ">
                        <option>All</option>
                        <option>IITU</option>
                        <option>SDU</option>
                        <option>KBTU</option>
                        <option>KazUU</option>
                        <option>KazNTU</option>
                    </select><br>
                </span>

                <br>

                <div class="pl-5">
                    <input class=" form-control float-left w-50 " type="text"   name="search">
                    <input class=" btn float-left btn-outline-success " type="button"  value="search">
                </div>
            </form>

            <hr>

            <div class="list-group">
            @foreach($uni as $un )
                @if($un->id != Auth::user()->id &&
                \App\Friend::where('id_user1',Auth::user()->id)->where('id_user2',$un->id)->first() == null &&
                \App\Friend::where('id_user2',Auth::user()->id)->where('id_user1',$un->id)->first() == null )
                    <br>
                    <div class="d-inline-block m-0 bg-light" >

                        <img class="float-left" src="{{$un->img}}" width="38" height="38">
                        <a class="float-left font-weight-normal" href="user?id={{$un->id}}">&nbsp;{{ $un->name }} {{ $un->surname }}</a>
                        @if(\App\Follow::where('id_user',Auth::user()->id)->where('id_follow',$un->id)->first() == null)
                            <a class=" btn float-right btn-outline-success" href="addFollow?id={{$un->id}}&page=friends" >+</a>
                        @else
                            <a class=" btn float-right btn-outline-danger" href="deleteFollow?id={{$un->id}}&page=friends" >-</a>
                        @endif
                    </div>
                    <br>
                @endif
            @endforeach
            </div>
        </div>

        <div class="col-sm-6 border-right border-dark d-inline-block" >
            <br>
            <div>
                <a class="btn btn-outline-primary {{ session('online')=='false'?'active':'hover' }}" href="friends?online=false">All</a>
                <a class="btn btn-outline-success {{ session('online')=='true'?'active':'hover' }}" href="friends?online=true">Online</a>
            </div>
            <hr>
            <div class="list-group">
            @foreach($friends as $friend)

                    <div class="w-100 h-25 m-2 bg-light">
                        <img class="float-left" src="r0GpwEmcKFE.jpg" width="38" height="38">
                        <a class="float-left font-weight-normal" href="user?id={{$friend->id}}">&nbsp;{{$friend->name}} {{$friend->surname}}</a>

                        <ul class="navbar-nav ml-auto float-right">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                     <span class="caret font-weight-bold">. . . </span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="friends?id={{ $friend->id }}">show friends</a>

                                    <a class="dropdown-item" href="message?id={{$friend->id}}">write message</a>

                                    <a class="dropdown-item" href="deleteFriend?id={{ $friend->id }}&page=friends">delete</a>

                                </div>
                            </li>
                        </ul>
                    </div>

            @endforeach
            </div>
        </div>

        <div class="col-sm-3 text-center" >
            <br>
            @if($user != null)

                <h6>Friend's {{ $user->name }} {{ $user->surname }}</h6>
                <hr>

                <div class="list-group">

                @foreach($user_friends as $friend)
                    <div class="w-100 h-25 m-2 bg-light">
                        <img class="float-left" src="r0GpwEmcKFE.jpg" width="38" height="38">
                        @if($friend->id != Auth::user()->id )
                            <a class="float-left font-weight-normal" href="user?id={{$friend->id}}">&nbsp;{{$friend->name}} {{$friend->surname}}</a>
                        @else
                            <a class="float-left font-weight-normal" href="home">&nbsp;{{$friend->name}} {{$friend->surname}}</a>
                        @endif
                    </div>

                @endforeach

                </div>
            @endif
        </div>
    </div>

@stop