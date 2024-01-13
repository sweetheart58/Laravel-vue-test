<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redirect;

class MainController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Main/Index', [
            'result' => $request->input("result")
        ]);
    }

    public function insertUrl(Request $request)
    {
        $request->validate([  
            'url'=>'required',  
        ]);
        $client = new Client();
        $url = $request->input("url");
        $hashUrl = MainController::generateHash($url);
        $res = $client->request('POST', 'https://developers.google.com/safe-browsing/v4/lookup-api', [
            "client" => [
                "clientId" => "yourcompanyname",
                "clientVersion" => "1.5.2"
            ],
            "threatInfo" => [
                "threatTypes" => ["MALWARE", "SOCIAL_ENGINEERING"],
                "platformTypes" => ["WINDOWS"],
                "threatEntryTypes" => ["URL"],
                "threatEntries" => [
                    'url' => $hashUrl
                ]
            ]
        ]);
        $check = DB::table("urldata")->where('realUrl', $url)->get();
        if ($res->getStatusCode() != 200) {
            return redirect("/home/error");
        }
        else if ($check->count() > 0) {
            return redirect("/home/?result=".$check[0] -> hashUrl);
        } else {
            DB::table("urldata")->insert([
                'realUrl' => $url,
                'hashUrl' => $hashUrl,
            ]);
            return redirect("/home/?result=".$hashUrl);
        }
    }
    function generateHash($input) {
        $string = explode("/", $input);
        if (count($string) == 1) {
            return $input;
        }
        $hash = md5($input);
        $hash = base_convert($hash, 16, 36);
        $hash = substr($hash, 0, 6);
        $string[count($string) - 1] = $hash;
        return implode("/", $string);
    }
    public function redirectUrl(Request $request) {
        $hashurl = $request->input("result");
        $urlData = DB::table("urldata")->where('hashUrl', $hashurl)->get();
        return Redirect::to('https://'.$urlData[0]->realUrl);
    }
}
