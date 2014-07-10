<?php
/**
 * Restful Api请求类
 * 
 * @author Link<dingqing1900@gmail.com>
 */
class RestClient {
    
    private $ch; //cURL会话句柄
    private $http_code; //http响应码

    public $debug = FALSE; //调试开关
    public $timeout = 10; //cURL执行时限
    public $connecttimeout = 10; //尝试连接等待时间
    
    
    
    public function __construct()
    {
        $this->ch = curl_init();
        
        //cURL设置
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->timeout);
    }
    
    public function get_http_code()
    {
        return $this->http_code;
    }

    public function get($url, $params = array(), $headers = array(), $data_type = 'json')
    {
        curl_setopt($this->ch, CURLOPT_HTTPGET,TRUE);
        
        $result = $this->do_request($url, 'GET', $params, $headers, $data_type);
        return $this->get_response($result, $data_type);
    }
    
    public function post($url, $params = array(), $headers = array(), $data_type = 'json')
    {
        
        $result = $this->do_request($url, 'GET', $params, $headers, $data_type);
        return $this->get_response($result, $data_type);
    }
    
    public function put($url, $params = array(), $headers = array(), $data_type = 'json')
    {
        
        $result = $this->do_request($url, 'GET', $params, $headers, $data_type);
        return $this->get_response($result, $data_type);
    }
    
    public function delete($url, $params = array(), $headers = array(), $data_type = 'json')
    {
        
        $result = $this->do_request($url, 'GET', $params, $headers, $data_type);
        return $this->get_response($result, $data_type);
    }
    
    private function do_request($url, $method, $params = array(), $headers = array(), $data_type = 'json')
    {
        
    }
    
    /**
     * 处理request响应结果，支持json, xml, plain text类型
     * 
     * @param mixed   $result     请求返回结果
     * @param string  $data_type  返回数据类型
     * 
     * @return mixed
     */
    public function get_response($result, $data_type = 'json')
    {
        if(empty($result))
        {
            return FALSE;
        }
        
        switch ($data_type)
        {
            case 'json' :
                return json_decode($result, TRUE);
                break;
            case 'xml' :
                return simplexml_load_string($result);
        }
        
        return $result;
    }
    
    public function __destruct()
    {
        curl_close($this->ch);
    }
}

