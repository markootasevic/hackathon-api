<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$app->middleware([
    App\Http\Middleware\CORSMiddleware::class
]);

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->post('/signupUser', 'OurController@signUp');
$app->post('/signupCompany', 'OurController@signUpCom');
$app->post('/loginUser','OurController@logIn');
$app->post('/loginCompany','OurController@logInCom');
$app->get('/jobs/all','OurController@getAllJobs');
$app->post('/jobs/filter','OurController@getJobsFilter');
$app->post('/tag/filter','OurController@getTagsByName');
$app->post('/jobs/tag','OurController@getJobsForTag');
$app->get('/company/{id}','OurController@getCompanyById');
$app->get('/job/bestUsers/{id}','OurController@getBestUsersForAd');
$app->get('/job/basicInfo/{id}','OurController@getHomePageBasicInfo');
$app->post('/job/new','OurController@postAd');
$app->get('/pdf/{id}','OurController@generatePdf');
$app->post('/sendJobOffer','OurController@sendMail');
$app->get('/user/getBestOffer/{id}','OurController@getBestAdsForUser');
$app->get('/company/images/{id}','OurController@getImagesForCompany');
$app->get('/job/{id}','OurController@getJobById');
$app->post('/job','OurController@postCompany');
$app->get('/job/company/{id}','OurController@getJobForCompany');















