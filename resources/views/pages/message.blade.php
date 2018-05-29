@extends('layouts.app')

@section('content')

<div class="row bg-white">
    <div class="col-sm-3 border-right border-dark" >

        <br><br><br>
        <h5 class="float-left font-italic font-weight-normal">Dialogs</h5>
        <br><hr>

        <div class="list-group">
            @foreach($friendsHaveNewMessage as $friend)

                <div class="w-100 h-25 m-2 bg-light">
                    <img class="float-left" src="r0GpwEmcKFE.jpg" width="38" height="38">
                    <a class="float-left font-weight-normal " href="message?id={{$friend->id}}">&nbsp;{{$friend->name}} {{$friend->surname}}</a>
                </div>

            @endforeach

                @foreach($friendsDoNotHaveMessage as $friend)

                    <div class="w-100 h-25 m-2 bg-light">
                        <img class="float-left" src="r0GpwEmcKFE.jpg" width="38" height="38">
                        <a class="float-left font-weight-normal text-dark" href="message?id={{$friend->id}}">&nbsp;{{$friend->name}} {{$friend->surname}}</a>
                    </div>

                @endforeach

        </div>

    </div>
    @if( $user != null )
        <div class="col-sm-9">

            <div>
                <div class="d-inline-block w-100 pt-2">
                    <img class="float-left" src=" {{ $user->img  }} " width="38" height="38">
                    <a class="float-left d-block" href="user?id={{$user->id}}">&nbsp;{{ $user->name }} {{ $user->surname }}</a>
                </div>
            </div>

            <div class="modal-content " >
                <div class="list-group h-100 p-3">

                    @foreach( $messages as $message)

                        <div class="d-inline-block w-100 ">
                            <span class=" {{ ( $message->id_send == $user->id ) ? "float-left":"float-right " }}{{ $message->isRead?"":" bg-light "}} text-right">
                                {{ $message->text }}
                            </span >
                        </div>

                        @if( $message->id_send == $user->id )
                            <?php $message->update(['isRead' => true]) ?>
                        @endif
                    @endforeach

                    @if(count($messages) == 0)
                        <h6 class="text-center font-italic">No messages</h6>
                    @endif

                </div>

                <div >
                    {!!  Form::open([ 'url' => '/message']) !!}
                        <input type="hidden" name="id_friend" value="{{$user->id}}">
                        <textarea type="text" class="w-75 form-control float-left" name = "message"></textarea>
                        <input type="submit" class="float-left w-25 form-control btn-outline-info mt-2">
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    @else
        <div class="col-sm-9">
            <div class="container text-center m-auto">
                <span>Choose friend</span>
            </div>
        </div>
    @endif
</div>

@stop