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
use mPDF;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Foundation\Application;

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
            $asoc['company']= $job->company()->get();
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
       $tagIds = $request->tag_ids;
        $arr = explode(";", $tagIds);
        $res = array();
        foreach ($arr as $tagId) {
            $tagAds = TagAd::where('tag_id', '=', $tagId)->get();
            foreach ($tagAds as $tagAd) {
                $ad = $tagAd->ad()->first();
                if(!in_array($ad, $res)) {
                    array_push($res, $ad);
                }
            }
        }

        return response()->json(['jobs' => $res]);
    }

    public function generatePdf()
    {
        $htmlString =  file_get_contents(storage_path("testHtml.html"),'r');
        $htmlString = str_replace("%TEXT%", 'RADIII', $htmlString);
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($htmlString);
        $mpdf->Output('test.pdf', 'F');

        return response()->json(['jobs' => "jea"]);
    }

    public function getCompanyById($id)
    {;
        $com = Company::find($id);
        return response()->json(['company' => $com->toArray()]);

    }

    public function getBestUsersForAd($id)
    {
        $match = 0;
        $users = User::all();
        $ad = Ad::find($id);
        $companyExp = $ad->experience()->get();
        foreach ($users as $user) {
            $userExp = $user->experrience()->get();
            $matchesExp = 0;
            foreach ($userExp as $uExp) {
                foreach ($companyExp as $cExp) {
//                    if(strpos($uExp->))
                }
            }
        }
    }



}
