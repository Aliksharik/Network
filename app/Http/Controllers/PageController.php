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

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Home(){
        Auth::user()->update(['last_active' => Carbon::now()]);

        $blogs = Blog::where('id_user' ,Auth::user()->id)->latest()->get();
        $follow = Follow::where('id_follow',Auth::user()->id)->get();
        $user_r = array();
        $user_l = array();
        foreach ($follow as $follow){
            if( $follow->request )
                array_push($user_r , User::find($follow->id_user));
            else
                array_push($user_l,User::find($follow->id_user));
        }
        return view('pages.home',compact('blogs','user_r','user_l'));
    }

    public function UserPage(){
        $id = Request::get('id');
        $blogs = Blog::where('id_user' ,$id)->latest()->get();
        $user = User::find($id);
        return view('pages.user',compact('user','blogs'));
    }

    public function Friend(){
        Auth::user()->update(['last_active' => Carbon::now()]);

        $online = Request::get('online');
        if($online == null && session('online') == null )
            $online = 'false';
        elseif ( session('online') != null && $online == null )
            $online = session('online');
        session(['online' => $online]);

        //$finishTime->diffInSeconds($startTime)

        $uni = User::where('university',Auth::user()->university)->get();
        $user1 = Friend::where('id_user1',Auth::user()->id)->select('id_user2 as id')->get();
        $user2 = Friend::where('id_user2',Auth::user()->id)->select('id_user1 as id')->get();

        $friends = array();
        foreach ($user2 as $id){
            $friend = User::find($id->id);
            if(session('online') == "true")
                $friend = User::where('last_active', '>', Carbon::now()->subMinutes(1)->toDateTimeString())->find($id->id);

            if($friend != null)
                array_push($friends , $friend);
        }
        foreach ($user1 as $id) {
            $friend = User::find($id->id);
            if(session('online') == "true")
                $friend = User::where('last_active', '>', Carbon::now()->subMinutes(1)->toDateTimeString())->find($id->id);

            if($friend != null)
                array_push($friends, User::find($id->id));
        }
        $id = Request::get('id');
        $user = User::find($id);
        $user_friends = array();
        if($id){
            $user1 = Friend::where('id_user1',$id)->select('id_user2 as id')->get();
            $user2 = Friend::where('id_user2',$id)->select('id_user1 as id')->get();
            foreach ($user2 as $id){
                array_push($user_friends , User::find($id->id));
            }
            foreach ($user1 as $id) {
                array_push($user_friends, User::find($id->id));
            }
        }

        //return $friends;
        return view('pages.friends',compact('uni','friends','user','user_friends'));
    }

    public function Message(){
        Auth::user()->update(['last_active' => Carbon::now()]);

        $id = Request::get('id');

        $user1 = Friend::where('id_user1',Auth::user()->id)->select('id' ,'id_user2 as id_user')->get();
        $user2 = Friend::where('id_user2',Auth::user()->id)->select('id' ,'id_user1 as id_user')->get();

        $friendsDoNotHaveMessage = array();
        $friendsHaveNewMessage = array();
        $id_friend = null;

        $user = User::find($id);

        foreach ($user2 as $user3){
            if( Message::where(['id_friend' => $user3->id , 'isRead' => false , 'id_send' => $user3->id_user ])->first() != null )
                array_push($friendsHaveNewMessage , User::find($user3->id_user));
            else
                array_push($friendsDoNotHaveMessage , User::find($user3->id_user));
            if( $user != null && $user3->id_user == $user->id )
                $id_friend = $user3->id;
        }
        foreach ( $user1 as $user3) {
            if( Message::where(['id_friend' => $user3->id , 'isRead' => false , 'id_send' => $user3->id_user ])->first() != null )
                array_push($friendsHaveNewMessage , User::find($user3->id_user));
            else
                array_push($friendsDoNotHaveMessage , User::find($user3->id_user));
            if( $user != null && $user3->id_user == $user->id )
                $id_friend = $user3->id;
        }


        $messages = Message::where('id_friend' , $id_friend)->get();

        return view('pages.message',compact('friendsHaveNewMessage','user' ,'messages' ,'friendsDoNotHaveMessage'));
    }

    public  function News(){

        $user1 = Friend::where('id_user1',Auth::user()->id)->select('id_user2 as id')->get();
        $user2 = Friend::where('id_user2',Auth::user()->id)->select('id_user1 as id')->get();

        $news = Blog::where('id_user' ,Auth::user()->id)->latest()->get();


        foreach ($user1 as $id){
            $newsF = Blog::where(['id_user' => $id->id])->get();
            $news = array_collapse([$news , $newsF]);
        }

        foreach ($user2 as $id){
            $newsF = Blog::where(['id_user' => $id->id])->get();
            $news = array_collapse([$news , $newsF]);
        }


        $blog = array_values(array_sort($news, function ($value) {
            $diffTime = time() - Carbon::parse($value['published_at'])->timestamp;
            return $diffTime;
        }));

//        return $news;
        return view('pages.news',compact('blog'));
    }


}
