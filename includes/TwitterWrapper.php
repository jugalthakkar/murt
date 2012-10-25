<?php
require_once('tmhOAuth.php');
require_once('constants.php');

/**
 * Description of TwitterWrapper
 *
 * @author Jugal
 */
class TwitterWrapper {



    public static function tweet($status) {
    //    echo 'tweeting';
        $connection = new tmhOAuth(array(
                        'consumer_key' => CONSUMER_KEY,
                        'consumer_secret' => CONSUMER_SECRET,
                        'user_token' => USER_TOKEN,
                        'user_secret' => USER_SECRET,
        ));       
        $connection->request('POST',
                $connection->url('1.1/statuses/update','json'),
                array('status' => $status));
     //   echo '<pre>';
//        print_r($connection->response);
  //      echo '</pre>';
        return $connection->response['code'];
    }
}
?>