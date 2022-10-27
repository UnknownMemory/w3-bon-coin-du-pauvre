<?php 
namespace App\Service;

class RedirectToService
{
    public function getRedirectURL($request)
    {  
        $host = 'http://'.$request->getHost().':1234';
        $queryURL = $request->query->get('redirect_to');

        if(!$queryURL)
        {
            return $host;
        }
        
        return $host.$queryURL;
    }
}