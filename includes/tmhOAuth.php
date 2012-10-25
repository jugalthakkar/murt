<?php
/**
 * tmhOAuth
 *
 * An OAuth 1.0A library written in PHP.
 * The library supports file uploading using multipart/form as well as general
 * REST requests. OAuth authentication is sent using the an Authorization Header.
 *
 * @author themattharris
 * @version 0.7.0
 *
 * 04 September 2012
 */
class tmhOAuth {
  const VERSION = '0.7.0';

  var $response = array();

  /**
   * Creates a new tmhOAuth object
   *
   * @param string $config, the configuration to use for this request
   */
  public function __construct($config) {
    $this->params = array();
    $this->headers = array();
    $this->auto_fixed_time = false;
    $this->buffer = null;

    // default configuration options
    $this->config = array_merge(
      array(
        // leave 'user_agent' blank for default, otherwise set this to
        // something that clearly identifies your app
        'user_agent'                 => '',
        // default timezone for requests
        'timezone'                   => 'UTC',

        'use_ssl'                    => true,
        'host'                       => 'api.twitter.com',

        'consumer_key'               => '',
        'consumer_secret'            => '',
        'user_token'                 => '',
        'user_secret'                => '',
        'force_nonce'                => false,
        'nonce'                      => false, // used for checking signatures. leave as false for auto
        'force_timestamp'            => false,
        'timestamp'                  => false, // used for checking signatures. leave as false for auto

        // oauth signing variables that are not dynamic
        'oauth_version'              => '1.0',
        'oauth_signature_method'     => 'HMAC-SHA1',

        // you probably don't want to change any of these curl values
        'curl_connecttimeout'        => 30,
        'curl_timeout'               => 10,

        // for security this should always be set to 2.
        'curl_ssl_verifyhost'        => 2,
        // for security this should always be set to true.
        'curl_ssl_verifypeer'        => true,

        // you can get the latest cacert.pem from here http://curl.haxx.se/ca/cacert.pem
        'curl_cainfo'                => dirname(__FILE__) . '/cacert.pem',
        'curl_capath'                => dirname(__FILE__),

        'curl_followlocation'        => false, // whether to follow redirects or not

        // support for proxy servers
        'curl_proxy'                 => false, // really you don't want to use this if you are using streaming
        'curl_proxyuserpwd'          => false, // format username:password for proxy, if required
        'curl_encoding'              => '',    // leave blank for all supported formats, else use gzip, deflate, identity

        // streaming API
        'is_streaming'               => false,
        'streaming_eol'              => "\r\n",
        'streaming_metrics_interval' => 60,

        // header or querystring. You should always use header!
        // this is just to help me debug other developers implementations
        'as_header'                  => true,
        'debug'                      => false,
      ),
      $config
    );
    $this->set_user_agent();
    date_default_timezone_set($this->config['timezone']);

  }

  private function set_user_agent() {
    if (!empty($this->config['user_agent']))
      return;

    if ($this->config['curl_ssl_verifyhost'] && $this->config['curl_ssl_verifypeer']) {
      $ssl = '+SSL';
    } else {
      $ssl = '-SSL';
    }

    $ua = 'tmhOAuth ' . self::VERSION . $ssl . ' - //github.com/themattharris/tmhOAuth';
    $this->config['user_agent'] = $ua;
  }

  /**
   * Generates a random OAuth nonce.
   * If 'force_nonce' is true a nonce is not generated and the value in the configuration will be retained.
   *
   * @param string $length how many characters the nonce should be before MD5 hashing. default 12
   * @param string $include_time whether to include time at the beginning of the nonce. default true
   * @return void
   */
  private function create_nonce($length=12, $include_time=true) {
    if ($this->config['force_nonce'] == false) {
      $sequence = array_merge(range(0,9), range('A','Z'), range('a','z'));
      $length = $length > count($sequence) ? count($sequence) : $length;
      shuffle($sequence);

      $prefix = $include_time ? microtime() : '';
      $this->config['nonce'] = md5(substr($prefix . implode('', $sequence), 0, $length));
    }
  }

  /**
   * Generates a timestamp.
   * If 'force_timestamp' is true a nonce is not generated and the value in the configuration will be retained.
   *
   * @return void
   */
  private function create_timestamp() {
    $this->config['timestamp'] = ($this->config['force_timestamp'] == false ? time() : $this->config['timestamp']);
  }

  /**
   * Encodes the string or array passed in a way compatible with OAuth.
   * If an array is passed each array value will will be encoded.
   *
   * @param mixed $data the scalar or array to encode
   * @return $data encoded in a way compatible with OAuth
   */
  private function safe_encode($data) {
    if (is_array($data)) {
      return array_map(array($this, 'safe_encode'), $data);
    } else if (is_scalar($data)) {
      return str_ireplace(
        array('+', '%7E'),
        array(' ', '~'),
        rawurlencode($data)
      );
    } else {
      return '';
    }
  }

  /**
   * Decodes the string or array from it's URL encoded form
   * If an array is passed each array value will will be decoded.
   *
   * @param mixed $data the scalar or array to decode
   * @return $data decoded from the URL encoded form
   */
  private function safe_decode($data) {
    if (is_array($data)) {
      return array_map(array($this, 'safe_decode'), $data);
    } else if (is_scalar($data)) {
      return rawurldecode($data);
    } else {
      return '';
    }
  }

  /**
   * Returns an array of the standard OAuth parameters.
   *
   * @return array all required OAuth parameters, safely encoded
   */
  private function get_defaults() {
    $defaults = array(
      'oauth_version'          => $this->config['oauth_version'],
      'oauth_nonce'            => $this->config['nonce'],
      'oauth_timestamp'        => $this->config['timestamp'],
      'oauth_consumer_key'     => $this->config['consumer_key'],
      'oauth_signature_method' => $this->config['oauth_signature_method'],
    );

    // include the user token if it exists
    if ( $this->config['user_token'] )
      $defaults['oauth_token'] = $this->config['user_token'];

    // safely encode
    foreach ($defaults as $k => $v) {
      $_defaults[$this->safe_encode($k)] = $this->safe_encode($v);
    }

    return $_defaults;
  }

  /**
   * Extracts and decodes OAuth parameters from the passed string
   *
   * @param string $body the response body from an OAuth flow method
   * @return array the response body safely decoded to an array of key => values
   */
  public function extract_params($body) {
    $kvs = explode('&', $body);
    $decoded = array();
    foreach ($kvs as $kv) {
      $kv = explode('=', $kv, 2);
      $kv[0] = $this->safe_decode($kv[0]);
      $kv[1] = $this->safe_decode($kv[1]);
      $decoded[$kv[0]] = $kv[1];
    }
    return $decoded;
  }

  /**
   * Prepares the HTTP method for use in the base string by converting it to
   * uppercase.
   *
   * @param string $method an HTTP method such as GET or POST
   * @return void value is stored to a class variable
   * @author themattharris
   */
  private function prepare_method($method) {
    $this->method = strtoupper($method);
  }

  /**
   * Prepares the URL for use in the base string by ripping it apart and
   * reconstructing it.
   *
   * Ref: 3.4.1.2
   *
   * @param string $url the request URL
   * @return void value is stored to a class variable
   * @author themattharris
   */
  private function prepare_url($url) {
    $parts = parse_url($url);

    $port   = isset($parts['port']) ? $parts['port'] : false;
    $scheme = $parts['scheme'];
    $host   = $parts['host'];
    $path   = isset($parts['path']) ? $parts['path'] : false;

    $port or $port = ($scheme == 'https') ? '443' : '80';

    if (($s