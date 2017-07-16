<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Company;
use App\ExperienceCompany;
use App\Jobs\Job;
use App\Requirements;
use App\Tag;
use App\TagAd;
use App\TagCompany;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;
use mPDF;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Foundation\Application;
use DateTime;
use PHPMailer;

class OurController extends Controller
{
    public function signUp(Request $request)
    {

        $email = $request->email;
        $pass = $request->password;

        $user = new User();
        $user->email = $email;
        $user->password = $pass;
        if ($user->save() === false) {
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
        if ($user->save() === false) {
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
            $job->experience = $job->experience()->get();
            $job->requirements = $job->requirements()->get();
            $job->company = $job->company()->get();
            $job->tags = $job->tags()->get();
            $arr = array();
            foreach ($job->tags as $tag) {
                $t = Tag::find($tag->tag_id);
                array_push($arr,$t);
            }
            $job->tags = $arr;
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
        $query = DB::table('ad');
        if (($request->has('sex'))) {
            $query->where('sex', '=', $request->sex);
        }
        $res = $query->get();
        return response()->json(['jobs' => $res]);
    }

    public function getTagsByName(Request $request)
    {
        $name = $request->name;
        $tags = Tag::where('name', 'LIKE', '%' . $name . '%')->get();
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
                if (!in_array($ad, $res)) {
                    array_push($res, $ad);
                }
            }
        }

        return response()->json(['jobs' => $res]);
    }

    public function generatePdf($id)
    {
        $ad = Ad::find($id);
        $company = $ad->company()->first();
        $htmlString = file_get_contents(storage_path("adHtml.html"), 'r');
        $htmlString = str_replace("%OPIS%", $company->description, $htmlString);
        $htmlString = str_replace("%ADRESA%", $company->address, $htmlString);
        $htmlString = str_replace("%NASLOV%", $ad->title, $htmlString);
        $htmlString = str_replace("%TELEFON%", $company->contact, $htmlString);
        $htmlString = str_replace("%KOMPANIJA%", $company->name, $htmlString);
        $reqs = $ad->requirements()->get();
        $zahtevi = "";
        foreach ($reqs as $req) {
            $zahtevi = $zahtevi . ' <ul> <li>' . $req->text . '</li> </ul>';
        }
        $htmlString = str_replace("%ZAHTEVI%", $zahtevi, $htmlString);
        $phoneNums = "";
        for ($i = 0; $i < 12; $i++) {
            $phoneNums = $phoneNums . ' <tr> <td>' . $company->contact . '</td> <hr> </tr>';
        }
        $htmlString = str_replace("%TELEFONI%", $phoneNums, $htmlString);

        // CHart Type
        $cht = "qr";
// CHart Size
        $chs = "100x100";
// CHart Link
// the url-encoded string you want to change into a QR code
        $chl = urlencode("https://www.linkedin.com/in/otasevicm");
// CHart Output Encoding (optional)
// default: UTF-8
        $choe = "UTF-8";
        $qrcode = 'https://chart.googleapis.com/chart?cht=' . $cht . '&chs=' . $chs . '&chl=' . $chl . '&choe=' . $choe;
        $htmlString = str_replace("%QRCODE%", $qrcode, $htmlString);

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($htmlString);
        $mpdf->Output('bandera.pdf', 'F');

        return response()->json(['jobs' => "jea"]);
    }

    public function getCompanyById($id)
    {
        ;
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
                            if (substr(strtolower($comWord), 0, -3) == substr(strtolower($userWord), 0, -3)) {
                                $wordsSame++;
                            }
                        }
                    }
                    if ((($wordsSame / $wordsCount) * 100) >= 50) {
                        $startDate = new DateTime($uExp->date_from);
                        if ($uExp->date_to != null) {
                            $endDate = new DateTime($uExp->date_to);
                        } else {
                            $endDate = new DateTime();
                        }
                        $yearDiff = $endDate->diff($startDate)->format('%y');
                        if ($yearDiff < $cExp->years) {
                            $matchesExp = $matchesExp + 0.5;
                        } else {
                            $matchesExp++;
                        }
                    }
                }
                if(sizeof($companyExp) != 0) {
                    $user->pctmatchExp = ($matchesExp / sizeof($companyExp)) * 100;
                } else {
                    $user->pctmatchExp = 0;
                }
            }
//endregion
//region start of tagNum matches
            $numOfSameTags = 0;
            $userTags = $user->tags()->get();
            $adTags = $ad->tags()->get();
            foreach ($userTags as $userTag) {
                foreach ($adTags as $adTag) {
                    if ($userTag->tag_id == $adTag->tag_id) {
                        $numOfSameTags++;
                    }
                }
            }
            if( sizeof($adTags) != 0) {
                $user->pctOfSameTags = ($numOfSameTags / sizeof($adTags)) * 100;
            } else {
                $user->pctOfSameTags = 0;
            }
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
                            if (substr(strtolower($comWord), 0, -3) == substr(strtolower($userWord), 0, -3)) {
                                $wordsSame++;
                            }
                        }
                    }
                    if ((($wordsSame / $wordsCount) * 100) >= 50) {
                        $numOfEduMatches++;
                    }
                }
            }
            if( sizeof($adReq) != 0) {
                $user->pctOfEduMatches = ($numOfEduMatches / sizeof($adReq)) * 100;
            } else {
                $user->pctOfEduMatches = 0;
            }
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
                            if (substr(strtolower($comWord), 0, -3) == substr(strtolower($userWord), 0, -3)) {
                                $wordsSame++;
                            }
                        }
                    }
                    if ((($wordsSame / $wordsCount) * 100) >= 50) {
                        $numOfSkilsMatched++;
                    }
                }
            }
            if( sizeof($adReq) != 0) {
                $user->pctOfSkilsMatched = ($numOfSkilsMatched / sizeof($adReq)) * 100;
            } else {
                $user->pctOfSkilsMatched = 0;
            }
//endregion
//region start of final calculations

            $finalMatch = ($user->pctOfSameTags * 0.4) + ($user->pctmatchExp * 0.3) + ($user->pctOfSkilsMatched * 0.2) + ($user->pctOfEduMatches * 0.1);
            $user->finalMatch = $finalMatch;
//endregion
        }
        $arr = $users->toArray();
        if(sizeof($arr) > 3) {
            $shortArr = array();
            for ($i = 0; $i < 3;$i++) {
                array_push($shortArr, $arr[$i]);
            }
            $arr = $shortArr;
        }
        usort($arr, array("App\\Http\\Controllers\\OurController", "cmpCompare"));
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
        $ad = new Ad();
        $ad->company_id = $request->companyID;
        $ad->sex = $request->sex;
        $ad->age = $request->age;
        $ad->pay = $request->pay;
        $ad->what_we_offer = $request->what_we_offer;

        $ad->save();
        $exps = explode(';',$request->requirements);
        foreach ($exps as $req) {
            $r = new Requirements();
            $r->ad_id = $ad->ad_id;
            $r->text = $req;
            $r->save();
        }
        $tagStr = $request->tag;
        $tag = Tag::where('name','=',$tagStr)->first();
        if($tag){
            $tagCom = new TagCompany();
            $tagCom->tag_id = $tag->tag_id;
            $tagCom->company_id = $ad->company_id;
            $tagCom->save();
        }
        return response()->json(['success' => true]);
    }

    public function sendMail(Request $request)
    {
        $userId = $request->user_id;
        $adId = $request->ad_id;
        $user = User::find($userId);
        $email = $user->email;
        $mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'marko.otasevic@mmklab.org';                 // SMTP username
        $mail->Password = 'Marko1994';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom('office@poslic.com', 'Poslic');
        $mail->addAddress($email, 'Marko Otasevic');     // Add a recipient          // Name is optional
        $mail->addReplyTo('office@poslic.com', 'Poslic');
        // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        $ad = Ad::find($adId);
        $company = $ad->company()->first();
        $htmlBody = '<h4>Korisnik: ' . $company->name . ' zeli da vas kontaktira za posao: ' . $ad->title . '</h4>' . '.' . '<br> U koliko zelite da kontaktirate ovog korisnika to mozete uciniti na: ' . $company->contact;

        $mail->Subject = 'Imate novi zahtev za posao';
        $mail->Body = $htmlBody;
        $mail->AltBody = 'Dobili ste novu ponudu za posao';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }

    public function getBestAdsForUser($id)
    {
        $match = 0;
        $user = User::find($id);
        $ads = Ad::all();
        foreach ($ads as $ad) {
//region start of exp match
            $companyExp = $ad->experience()->get();
            $userExp = $user->experrience()->get();
            $matchesExp = 0;
            foreach ($userExp as $uExp) {
                foreach ($companyExp as $cExp) {
                    $comArray = explode(" ", strtolower($cExp->position));
                    $userAray = explode(" ", strtolower($uExp->position));
                    $wordsSame = 0;
                    $wordsCount = sizeof($comArray);
                    foreach ($userAray as $userWord) {
                        foreach ($comArray as $comWord) {
                            if (substr(strtolower($comWord), 0, -3) == substr(strtolower($userWord), 0, -3)) {
                                $wordsSame++;
                            }
                        }
                    }
                    if ((($wordsSame / $wordsCount) * 100) >= 50) {
                        $startDate = new DateTime($uExp->date_from);
                        if ($uExp->date_to != null) {
                            $endDate = new DateTime($uExp->date_to);
                        } else {
                            $endDate = new DateTime();
                        }
                        $yearDiff = $endDate->diff($startDate)->format('%y');
                        if ($yearDiff < $cExp->years) {
                            $matchesExp = $matchesExp + 0.5;
                        } else {
                            $matchesExp++;
                        }
                    }
                }

                $ad->pctmatchExp = ($matchesExp / sizeof($companyExp)) * 100;
            }
//endregion
//region start of tagNum matches
            $numOfSameTags = 0;
            $userTags = $user->tags()->get();
            $adTags = $ad->tags()->get();
            foreach ($userTags as $userTag) {
                foreach ($adTags as $adTag) {
                    if ($userTag->tag_id == $adTag->tag_id) {
                        $numOfSameTags++;
                    }
                }
            }
            $ad->pctOfSameTags = ($numOfSameTags / sizeof($adTags)) * 100;
//endregion
//region start of education matches

            $userEdu = $user->education()->get();
            $adReq = $ad->requirements()->get();
            $numOfEduMatches = 0;
            foreach ($userEdu as $edu) {
                foreach ($adReq as $req) {
                    $comArray = explode(" ", strtolower($req->text));
                    $userAray = explode(" ", strtolower($edu->education_level));
                    $wordsSame = 0;
                    $wordsCount = sizeof($comArray);
                    foreach ($userAray as $userWord) {
                        foreach ($comArray as $comWord) {
                            if (substr(strtolower($comWord), 0, -3) == substr(strtolower($userWord), 0, -3)) {
                                $wordsSame++;
                            }
                        }
                    }
                    if ((($wordsSame / $wordsCount) * 100) >= 50) {
                        $numOfEduMatches++;
                    }
                }
            }
            if(sizeof($adReq) == 0) {
                $ad->pctOfEduMatches = 1;
            } else {
                $ad->pctOfEduMatches = ($numOfEduMatches / sizeof($adReq)) * 100;
            }
//endregion

//region start of user skill matches

            $skills = $user->skills()->get();
            $adReq = $ad->requirements()->get();
            $numOfSkilsMatched = 0;
            foreach ($skills as $skill) {
                foreach ($adReq as $req) {
                    $comArray = explode(" ", strtolower($req->text));
                    $userAray = explode(" ", strtolower($skill->skill_name));
                    $wordsSame = 0;
                    $wordsCount = sizeof($comArray);
                    foreach ($userAray as $userWord) {
                        foreach ($comArray as $comWord) {
                            if (substr(strtolower($comWord), 0, -3) == substr(strtolower($userWord), 0, -3)) {
                                $wordsSame++;
                            }
                        }
                    }
                    if ((($wordsSame / $wordsCount) * 100) >= 50) {
                        $numOfSkilsMatched++;
                    }
                }
            }
            if(sizeof($adReq) == 0) {
                $ad->pctOfSkilsMatched = 1;
            } else {
                $ad->pctOfSkilsMatched = ($numOfSkilsMatched / sizeof($adReq)) * 100;
            }
//endregion
//region start of final calculations

            $finalMatch = ($user->pctOfSameTags * 0.4) + ($user->pctmatchExp * 0.3) + ($user->pctOfSkilsMatched * 0.2) + ($user->pctOfEduMatches * 0.1);
            $ad->finalMatch = $finalMatch;
//endregion
        }
        $arr = $ads->toArray();
        usort($arr, array("App\\Http\\Controllers\\OurController", "cmpCompare"));
        return response()->json(['jobs' => $arr]);
    }

    public function getImagesForCompany($id)
    {
        $com = Company::find($id);
        $images = $com->pictures()->get();
        return response()->json(['images' => $images->toArray()]);
    }

    public function getJobById($id)
    {
        $job = Ad::find($id);
        $job->company = $job->company()->get();
        $job->tags = $job->tags()->get();
        $job->experience = $job->experience()->get();
        $job->requirements = $job->requirements()->get();
        return response()->json(['job' => $job->toArray()]);
    }

    public function postCompany(Request $request)
    {
        $com = new Company();
        $com->name = $request->name;
        $com->address = $request->address;
        $com->description = $request->description;
        $com->contact = $request->contact;
        $com->save();
        $tags = $request->tags;
        foreach ($tags as $tag) {
            $t = new Tag();
            $t->tag_id = $tag->tag_id;
            $t->company_id = $com->company_id;
            $t->save();
        }
        return response()->json(['success' => true]);
    }

    public function getJobForCompany($id)
    {
        $com = Company::find($id);
        $jobs = $com->ads()->get();
        return response()->json(['jobs' => $jobs]);
    }
}
