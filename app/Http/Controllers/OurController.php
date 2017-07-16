<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Company;
use App\ExperienceCompany;
use App\Jobs\Job;
use App\Requirements;
use App\Tag;
use App\TagAd;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;
use mPDF;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Foundation\Application;
use DateTime;

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
            $job->experience=$job->experience()->get();
            $job->requirements=$job->requirements()->get();
            $job->company=$job->company()->get();
//            $exp = $job->experience()->get();
//            $asoc = $job;
//            $asoc->company= $job->company()->get();
//            if (sizeof($exp) != 0) {
//                $asoc->experience = $exp;
//            } else {
//                $asoc->experience = array();
//            }
//
//            $req = $job->requirements()->get();
//            if (sizeof($req) != 0) {
//                $asoc->requirements = $req;
//            } else {
//                $asoc->requirements = array();
//            }
//            array_push($res,$asoc->toArray());
        }
        return response()->json(['jobs' => $jobs]);

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

   public function cmpCompare($a, $b)
    {
        if ($a['finalMatch'] == $b['finalMatch']) {
            return 0;
        }
        return ($a['finalMatch'] < $b['finalMatch']) ? 1 : -1;
    }

    public function getBestUsersForAd($id)
    {
        $match = 0;
        $users = User::all();
        $ad = Ad::find($id);
        $companyExp = $ad->experience()->get();
        foreach ($users as $user) {
//region start of exp match
            $userExp = $user->experrience()->get();
            $matchesExp = 0;
            foreach ($companyExp as $cExp) {
                foreach ($userExp as $uExp) {
                    $comArray = explode(" ", strtolower($cExp->position));
                    $userAray = explode(" ", strtolower($uExp->position));
                    $wordsSame = 0;
                    $wordsCount = sizeof($comArray);
                    foreach ($comArray as $comWord) {
                        foreach ($userAray as $userWord) {
                            if(substr(strtolower($comWord), 0, -3) == substr(strtolower($userWord), 0, -3)) {
                                $wordsSame++;
                            }
                        }
                    }
                    if((($wordsSame/$wordsCount)*100) >= 50) {
                        $startDate = new DateTime($uExp->date_from);
                        if($uExp->date_to != null) {
                            $endDate = new DateTime($uExp->date_to);
                        } else {
                            $endDate = new DateTime();
                        }
                        $yearDiff = $endDate->diff($startDate)->format('%y');
                        if($yearDiff < $cExp->years) {
                            $matchesExp = $matchesExp + 0.5;
                        } else {
                            $matchesExp++;
                        }
                    }
                }

                $user->pctmatchExp = ($matchesExp/sizeof($companyExp))*100;
            }
//endregion
//region start of tagNum matches
            $numOfSameTags = 0;
            $userTags = $user->tags()->get();
            $adTags = $ad->tags()->get();
            foreach ($userTags as $userTag) {
                foreach ($adTags as $adTag) {
                    if($userTag->tag_id == $adTag->tag_id) {
                        $numOfSameTags++;
                    }
                }
            }
            $user->pctOfSameTags = ($numOfSameTags/sizeof($adTags))*100;
//endregion
//region start of education matches

            $userEdu = $user->education()->get();
            $adReq = $ad->requirements()->get();
            $numOfEduMatches = 0;
            foreach ($adReq as $req) {
                foreach ($userEdu as $edu) {
                    $comArray = explode(" ", strtolower($req->text));
                    $userAray = explode(" ", strtolower($edu->education_level));
                    $wordsSame = 0;
                    $wordsCount = sizeof($comArray);
                    foreach ($comArray as $comWord) {
                        foreach ($userAray as $userWord) {
                            if(substr(strtolower($comWord), 0, -3) == substr(strtolower($userWord), 0, -3)) {
                                $wordsSame++;
                            }
                        }
                    }
                    if((($wordsSame/$wordsCount)*100) >= 50) {
                        $numOfEduMatches++;
                    }
                }
            }
            $user->pctOfEduMatches = ($numOfEduMatches/sizeof($adReq))*100;
//endregion

//region start of user skill matches

            $skills = $user->skills()->get();
            $adReq = $ad->requirements()->get();
            $numOfSkilsMatched = 0;
            foreach ($adReq as $req) {
                foreach ($skills as $skill) {
                    $comArray = explode(" ", strtolower($req->text));
                    $userAray = explode(" ", strtolower($skill->skill_name));
                    $wordsSame = 0;
                    $wordsCount = sizeof($comArray);
                    foreach ($comArray as $comWord) {
                        foreach ($userAray as $userWord) {
                            if(substr(strtolower($comWord), 0, -3) == substr(strtolower($userWord), 0, -3)) {
                                $wordsSame++;
                            }
                        }
                    }
                    if((($wordsSame/$wordsCount)*100) >= 50) {
                        $numOfSkilsMatched++;
                    }
                }
            }
            $user->pctOfSkilsMatched = ($numOfSkilsMatched/sizeof($adReq))*100;
//endregion
//region start of final calculations

            $finalMatch = ($user->pctOfSameTags * 0.4) + ($user->pctmatchExp * 0.3) + ($user->pctOfSkilsMatched * 0.2) + ($user->pctOfEduMatches * 0.1);
            $user->finalMatch = $finalMatch;
//endregion
        }
        $arr = $users->toArray();
        usort($arr ,array("App\\Http\\Controllers\\OurController", "cmpCompare"));
        return response()->json(['users' => $arr]);

    }


    public function getHomePageBasicInfo($id)
    {
        $ad = Ad::find($id);
        $company = $ad->company()->first();
        $res = array();
        $res['company'] = $company->name . ' (' . $company->description . ')';
        $res['job'] = $ad->title;
        return response()->json(['info' => $res]);

    }

    public function postAd(Request $request)
    {
        $ad = new Ad($request->all());
        $ad->save();
        foreach ($request->experience as $exp) {
            $ex = new ExperienceCompany();
            $ex->years = $exp->years;
            $ex->position = $exp->position;
            $ex->ad_id = $ad->ad_id;
            $ex->save();
        }
        foreach ($request->requirements as $req) {
            $r = new Requirements();
            $r->ad_id = $ad->ad_id;
            $r->text = $req->text;
            $r->save();
        }
        return response()->json(['success' => true]);
    }


}
