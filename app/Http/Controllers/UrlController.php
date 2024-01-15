<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use GuzzleHttp\Client;


class UrlController extends Controller
{
    
    /**
    * Renders the main page. This will return a JSON response with the result of the action
    * @param $request
    * @return The response to the request as a JSON object or an error message if something went wrong during the execution
    */
    public function index(Request $request)
    {
        return Inertia::render('Main/Index', [
            'result' => $request->input('result')
        ]);
    }

    /**
    * @brief Insert Url to database. This will be used for url insert and insert_threat_entry.
    * @param $request
    * @return Response object with url
    */
    public function insertUrl(Request $request)
    {
        $request->validate([  
            'url'=>'required',  
        ]);
        $client = new Client();
        $url = $request->input('url');

        // Convert New Url to Hash
        $hashUrl = UrlController::generateHash($url);

        // Lookup API. Test if URL is safe.
        $res = $client->request('POST', 'https://developers.google.com/safe-browsing/v4/lookup-api', [
            'client' => [
                'clientId' => 'yourcompanyname',
                'clientVersion' => '1.5.2'
            ],
            'threatInfo' => [
                'threatTypes' => ['MALWARE', 'SOCIAL_ENGINEERING'],
                'platformTypes' => ['WINDOWS'],
                'threatEntryTypes' => ['URL'],
                'threatEntries' => [
                    'url' => $url
                ]
            ]
        ]);
        $check = Url::where('realUrl', $url)->get();
        // Redirect with error if status code! = 200 otherwise with hashUrl
        if ($res->getStatusCode() != 200) {
            return redirect('/home/?result=error');
        }
        else if ($check->count() > 0) {
            return redirect('/home/?result='.$check[0] -> hashUrl);
        } else {
            Url::create([
                'realUrl' => $url,
                'hashUrl' => $hashUrl,
            ]);
            return redirect('/home/?result='.$hashUrl);
        }
    }

    
    /**
    * @brief Generates a hash of $input based on md5. This is used to convert input Url to hash Url.
    * @param $input
    * @return The hash of $
    */
    function generateHash($input) {
        $string = explode('/', $input);
        if (count($string) == 1) {
            return $input;
        }
        $hash = md5($input);
        $hash = base_convert($hash, 16, 36);
        $hash = substr($hash, 0, 6);
        $string[count($string) - 1] = $hash;
        return implode('/', $string);
    }

    
    /**
    * @brief Redirects to the URL that was used to generate the hash. This is done by checking the result of the request to see if it matches an existing URL in the database
    * @param $request
    * @return A redirect object that contains the url to redirect to and the result of the hash in the query string
    */
    public function redirectUrl(Request $request) {
        $hashurl = $request->input('result');
        $urlData = Url::where('hashUrl', $hashurl)->get();
        return Redirect::to('https://'.$urlData[0]->realUrl);
    }
}
