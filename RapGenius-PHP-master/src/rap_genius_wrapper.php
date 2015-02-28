<?php


if (!function_exists('curl_init')) {
  throw new Exception('RapGenius needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
  throw new Exception('RapGenius needs the JSON PHP extension.');
}





/**
 * Handles API requests. Parametrization methods are chainable.
 * For further informatio, go to
 *  https://developer.musixmatch.com/documentation/
 *
 * @author Anderson Marques <http://twitter.com/cacovsky>
 */
class RapGenius
{
    
    
    /**
     * Version.
     */
    const VERSION = '0.0.1';

    /**
     * Default options for curl.
     */
    public static $CURL_OPTS = array(
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 60,
        CURLOPT_USERAGENT      => 'rapgenius-php-0.0.1',
    );
    
    
    public static $STATUS_CODES = array(
        200=>'The request was successful',
        400=>'The request had bad syntax or was inherently impossible to be satisfied',
        401=>'authentication failed, probably because of a bad API key',
        402=>'a limit was reached, either you exceeded per hour requests limits or your balance is insufficient.',
        403=>'You are not authorized to perform this operation / the api version you’re trying to use has been shut down.',
        404=>'requested resource was not found',
        405=>'requested method was not found',  
    );
    

    protected $_base_url = 'api.rapgenius.com/search/';
    protected $_result   = '';
    protected $_use_ssl  = '';
    protected $_method   = '';
    
    protected $_query_parameters = array();


    public function __construct()
    {

    }

    
    
    /**
     * @return MusicXMatch
     */
    public function param_q($query)
    {

        foreach ($query as $key=>$value)
        {
            $this->_query_parameters[$key] = str_replace(' ', '+', $value);
        }
        return $this;
    }
    
    /**
     * @param string $query_string a utf-8 artist query string
     * @return MusicXMatch
     */
    public function param_q_artist($query_string)
    {
        $this->_query_parameters['q_artist'] = $query_string;
        return $this;
    }
    
    
    /**
     * Resets parameters, except for the apikey
     * @chainable
     * 
     */
    public function reset_params()
    {

        $this->_query_parameters = array();
        return $this;
    }
    

    /**
     * Executes the request and returns the result
     * @param resource $ch a custom curl resource
     */
    public function execute_request($ch = null)
    {
        $url = $this->build_query_url();
        
        if (!$ch)
        {
            $ch = curl_init($url);
            curl_setopt_array($ch, self::$CURL_OPTS);
        }
        
        
        $query_result = curl_exec($ch);
        
        curl_close($ch);
        
        
        $full_result = json_decode($query_result, true);

        
        return $this->_result = $full_result['response']['hits'];
        
    }
    
    
    public function result()
    {
        return $this->result;
    }
    
    
    /**
     * Uses the parameters and other stuff to build the query string
     * @return string the url to be fetched
     */
    public function build_query_url()
    {

        //protocol
       // $url =  $this->_use_ssl ? 'https://'  : 'http://';
        
        //base url
        $url = $this->_base_url;

        
        $url .= '?';
        
        foreach ($this->_query_parameters as $key=>$value)
        {
            $url.=$key.'='.$value.'&';
        }
        
        
        $url.= 'format=json';
        
        return $url;
        
    }
    
}


?>
