<?php 
    Class apiconfig
    {
        protected $grant_type = 'client_credentials';
        protected $apiUrl = 'https://api.aligncommerce.com/';
        protected $scope  = array('products','buyer','invoice');

        function getAuthorizationCode($username , $password , $clientId , $secretKey)
        {

            $result = array();
            $oauth_param = array(
                'grant_type'    => $this->grant_type, 
                'client_id'     => $clientId,
                'client_secret' => $secretKey,
                'scope'         => implode(',', $this->scope));

            $url = $this->apiUrl . 'oauth/access_token';
            $this->request = curl_init();
            $this->http_login($username , $password);
            $this->set_request_options($url, $oauth_param);

            $response = curl_exec($this->request);
            curl_close ($this->request);

            if($response)
            {
                $res = json_decode($response);
                if( isset($res->access_token) )
                {
                    $result['access_token'] = $res->access_token;
                }
                elseif(isset($res->error))
                {
                    $result['error'] = $res->error;
                    $result['error_message'] = $res->error_message;
                }
                return $result;
            }
        }

        function createInvoice($username , $password , $access_token , $post_data)
        {

            $result = array();
            $url  = $this->apiUrl . 'invoice';

            $this->request = curl_init();
            $this->http_login($username , $password);
            $this->set_request_options($url, $post_data);

            $response = curl_exec ($this->request);
            curl_close ($this->request);

            if($response)
            {
                $res = json_decode($response,true);

                if($res->error)
                {
                    $result['error'] = $res->error;
                    $result['error_message'] = $res->error_message;
                }else{
                    $result['invoice'] = $res;
                }
                return $result;
            }
        }  

        protected function set_request_options($url, $vars) {
            curl_setopt($this->request, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($this->request, CURLOPT_URL, $url);
            curl_setopt($this->request, CURLOPT_POSTFIELDS, http_build_query($vars));
            curl_setopt($this->request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->request, CURLOPT_TIMEOUT, 30);
            curl_setopt($this->request, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($this->request, CURLOPT_SSL_VERIFYHOST, 0);
        }

        protected function http_login($username = '', $password = '')
        {
            curl_setopt($this->request, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($this->request, CURLOPT_USERPWD,  $username .":" . $password);
            curl_setopt($this->request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        }

        public function getCurrency($username , $password )
        {
            $url = 'https://api.aligncommerce.com/currency';
            $curl_c   = curl_init($url);         
            curl_setopt($curl_c, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl_c, CURLOPT_USERPWD,  $username .":" . $password);
            curl_setopt($curl_c, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

            curl_setopt($curl_c, CURLOPT_TIMEOUT, 10);
            curl_setopt($curl_c, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_c, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl_c, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl_c, CURLOPT_CUSTOMREQUEST, 'GET');
            $response = curl_exec ($curl_c);
            curl_close ($curl_c);

            if($response)
            {
                $res = json_decode($response);
                if($res->error)
                {
                    $result['error'] = $res->error;
                    $result['error_message'] = $res->error_message;
                }else{
                    $result['currency'] = json_decode($response,true);
                }
                return $result;
            }

        }

}