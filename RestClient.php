<?php
/**
 * Restful Api请求类
 * 
 * @author Mckee<dingqing1900@gmail.com>
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

    public function get($url, $params = array(), $headers = array())
    {
        curl_setopt($this->ch, CURLOPT_HTTPGET,TRUE);
        
        if(!empty($params)) $url .= '?' . http_build_query ($params);
        
        $result = $this->do_request($url, $headers);
        return $this->get_response($result);
    }
    
    public function post($url, $params = array(), $headers = array())
    {
        curl_setopt($this->ch, CURLOPT_POST, TRUE);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, !empty($params) ? json_encode($params) : '');
        
        $headers = array_merge($headers, array(
            'Content-type: application/json'
        )); 
                
        $result = $this->do_request($url, $headers);
        return $this->get_response($result);
    }
    
    public function put($url, $params = array(), $headers = array())
    {
        curl_setopt($this->ch, CURLOPT_PUT, TRUE);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, !empty($params) ? json_encode($params) : '');
        
        $headers = array_merge($headers, array(
			'X-HTTP-Method-Override: PUT', 
			'Content-type: application/json'
		));
        
        $result = $this->do_request($url, $headers);
        return $this->get_response($result);
    }
    
    public function delete($url, $params = array(), $headers = array())
    {
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        
        $result = $this->do_request($url, $headers);
        return $this->get_response($result);
    }
    
    public function patch($url, $params = array(), $headers = array())
    {
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, !empty($params) ? json_encode($params) : '');
        
        $headers = array_merge($headers, array(
			'X-HTTP-Method-Override: PATCH', 
			'Content-type: application/json'
		));
        
        $result = $this->do_request($url, $headers);
        return $this->get_response($result);
    }


    private function do_request($url, $params = array(), $headers = array())
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($this->ch);
        
        $this->http_code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
        $curl_info = curl_getinfo($this->ch);
        
        if($this->debug)
        {
            echo "==========params==========\r\n";
            print_r($params);
            
            echo "==========headers==========\r\n";
            print_r($headers);
            
            echo "==========curl_info==========\r\n";
            print_r(curl_getinfo($this->ch));
            
            echo "==========response==========\r\n";
            print_r($response);
            
            echo "==========curl_error==========\r\n";
            print_r(curl_error($this->ch));
        }
        
        return $response;
    }
    
    /**
     * 处理request响应结果
     * 
     * @param mixed   $result     请求返回结果
     * 
     * @return mixed
     */
    private function get_response($result)
    {
        if(empty($result))
        {
            return FALSE;
        }
        

        return json_decode($result, TRUE);

    }
    
    public function __destruct()
    {
        curl_close($this->ch);
    }
}

