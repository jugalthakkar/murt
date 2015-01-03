<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class murtUtilities {

    public function isBot($agent)
    {
        $bots = [
            'googlebot',
            'yahoo',
            'bingbot',
            'baiduspider',
            'facebookexternalhit',
            'twitterbot',
            'rogerbot',
            'linkedinbot',
            'embedly',
            'quora link preview',
            'showyoubot',
            'outbrain',
            'pinterest',
            'developers.google.com/+/web/snippet',
            'bot',
            'spider',
            'crawl',
            'curl'
        ];
        foreach ($bots as $bot)
        {
            if (strpos($agent, $bot) != false)
            {
                return true;
            }
        }
        return false;
    }
}
$murtUtilities=new murtUtilities();