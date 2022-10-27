<?php 
namespace App\Service;

class RedirectToService
{
    public function getRedirectURL($request)
    {  
        $host = 'http://'.$request->getHost().':1234';
        $queryURL = $request->query->get('redirect_url');

        if(!$queryURL)
        {
            return $host;
        }

        $url = 'http://'.$request->getHost().':1234'.$queryURL;
        return $url;
    }
}