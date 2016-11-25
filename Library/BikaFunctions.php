<?php

namespace Ignite\Evaluation\Library;

use Ignite\Evaluation\Repositories\BikaRepository;

class BikaFunctions implements BikaRepository {

    /**
     * @var
     */
    protected $curl;

    /**
     * BikaFunctions constructor.
     */
    public function __construct() {
        $this->__login();
    }

    public function execute($url) {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        $result = curl_exec($this->curl);
        curl_close($this->curl);
        return $result;
    }

    public function __login() {
        $url = mconfig('evaluation.bika.url');
        $url .= ':' . mconfig('evaluation.bika.port');
        $url .= '/' . mconfig('evaluation.bika.top_level_url');
        $username = mconfig('evaluation.bika.username');
        $password = mconfig('evaluation.bika.password');
        $post_data = "form.submitted=1&pwd_empty=0&__ac_name=$username&__ac_password=$password&submit=Log in";
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_URL, $url . '/login_form');
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->curl, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_exec($this->curl);
    }

}
