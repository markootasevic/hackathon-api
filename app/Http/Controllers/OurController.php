<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Company;
use App\Jobs\Job;
use App\Tag;
use App\TagAd;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;

class OurController extends Controller
{
    public function signUp(Request $request)
    {

        $email = $request->email;
        $pass = $request->password;

        $user = new User();
        $user->email = $email;
        $user->password = $pass;
        if($user->save() === false){
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => true]);

    }

    public function signUpCom(Request $request)
    {

        $email = $request->email;
        $pass = $request->password;

        $user = new Company();
        $user->email = $email;
        $user->password = $pass;
        if($user->save() === false){
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => true]);

    }
    public function logInCom(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = Company::where('email', $email)->where('password', $password)->first();

        if ($user) {

            return response()->json(['success' => 'true', 'user' => $user->toArray()]);
        }
        return response()->json(["success" => "false"]);
    }
    public function logIn(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->where('password', $password)->first();

        if ($user) {

            return response()->json(['success' => 'true', 'user' => $user->toArray()]);
        }
        return response()->json(["success" => "false"]);
    }

    public function getAllJobs()
    {
        $jobs = Ad::all();
        $res = array();
        foreach ($jobs as $job) {
            $exp = $job->experience()->get();
            $asoc = $job->toArray();
            if (sizeof($exp) != 0) {
                $asoc['experience'] = $exp;
            } else {
                $asoc['experience'] = array();
            }

            $req = $job->requirements()->get();
            if (sizeof($req) != 0) {
                $asoc['requirements'] = $req;
            } else {
                $asoc['requirements'] = array();
            }
            array_push($res,$asoc);


        }
        return response()->json(['jobs' => $res]);

    }

    public function getJobsFilter(Request $request)
    {
        $query= DB::table('ad');
        if(($request->has('sex'))) {
            $query->where('sex','=',$request->sex);
        }
        $res = $query->get();
        return response()->json(['jobs' => $res]);
    }

    public function getTagsByName(Request $request)
    {
        $name = $request->name;
        $tags = Tag::where('name','LIKE','%'.$name.'%')->get();
        return response()->json(['tags' => $tags->toArray()]);

    }

    public function getJobsForTag(Request $request)
    {
       $tagId = $request->tag_id;
        $tagAds = TagAd::where('tag_id','=',$tagId)->get();
        $res = array();
        foreach ($tagAds as $tagAd) {
                $ad = $tagAd->ad()->first();
            array_push($res,$ad);
        }
        return response()->json(['jobs' => $res]);

    }

}
