<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Follow;
use App\Friend;
use App\Message;
use App\User;
use Carbon\Carbon;
use Request;
use Auth;

class UserController extends Controller
{

    public function getDeleteBlog(){
        Auth::user()->update(['last_active' => Carbon::now()]);

        Blog::find( Request::get('id') )->delete();

        return redirect('/home');;
    }

    public function postAddBlog()
    {
        Auth::user()->update(['last_active' => Carbon::now()]);

        $news = Request::get('news');
        $user_id = Auth::user()->id;
        if($news)
            Blog::create([
                'id_user' => $user_id ,
                'news' => $news
            ]);
        return redirect('/home');
    }

    public  function getAddFollow(){
        Auth::user()->update(['last_active' => Carbon::now()]);

        $id  = Request::get('id');
        $page = Request::get('page');
        $fol = Follow::where('id_follow',Auth::user()->id)->where('id_user',$id)->first();
        if( $fol == null )
            Follow::create(['id_user'=>Auth::user()->id,'id_follow'=>$id]);
        else{
            $fol->delete();
            Friend::create(['id_user1'=>Auth::user()->id,'id_user2'=>$id]);
        }
        if($page != 'friends'){
            $page .= '?id='.$id;
        }
        return redirect($page);
    }

    public  function getDeleteFollow(){
        Auth::user()->update(['last_active' => Carbon::now()]);

        $id  = Request::get('id');
        $page = Request::get('page');
        Follow::where('id_user',Auth::user()->id)->where('id_follow',$id)->first()->delete();
        return redirect($page);
    }

    public  function getLostInFollow(){
        Auth::user()->update(['last_active' => Carbon::now()]);

        $id  = Request::get('id');
        $page = Request::get('page');
        Follow::where('id_follow',Auth::user()->id)->where('id_user',$id)->first()->update(['request' => false]);
        return redirect($page);
    }

    public  function getDeleteFriend(){
        Auth::user()->update(['last_active' => Carbon::now()]);

        $id  = Request::get('id');
        $page = Request::get('page');
        $friend = Friend::where('id_user1',Auth::user()->id)->where('id_user2',$id)->first();
        if($friend == null)
            $friend = Friend::where('id_user2',Auth::user()->id)->where('id_user1',$id)->first();
        if($friend == null)
            $friend = Follow::where('id_follow',$id)->where('id_user',Auth::user()->id)->first();
        $friend->delete();
        if($page != 'friends'){
            $page .= '?id='.$id;
        }
        return redirect($page);
    }

    public function postSendMessage(){
        $friend_id = Request::get('id_friend');
        $message = Request::get('message');

        if( $message == null)
            return redirect('/message?id='.$friend_id);

        $friend = Friend::where( ['id_user1' => Auth::user()->id , 'id_user2' => $friend_id ] )->first();
        if( $friend == null)
            $friend = Friend::where( ['id_user2' => Auth::user()->id , 'id_user1' => $friend_id ] )->first();

        $insert = [
            'id_friend' => $friend->id,
            'id_send' => Auth::user()->id,
            'text' => $message
        ];

        Message::create($insert);

        return redirect('/message?id='.$friend_id);
    }

}
