<?php
namespace trueWallet;

class Voucher{
    private $mobile;
    private $voucher;
    private $USER_AGENT = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36'; // Custom as you want

    public function __construct($mobile, $voucher){
        $this->mobile = $mobile;
        $this->voucher = explode("?v=", $voucher)[1];
        $this->USER_AGENT = $this->uidv4();
        // $this->USER_AGENT = $this->userAgent();
        
    }

    public function verify(){
        $url = "https://gift.truemoney.com/campaign/vouchers/{$this->voucher}/verify?mobile={$this->mobile}";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Content-Type: application/json",
            "User-Agent: $this->USER_AGENT"
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSLVERSION, 7); // Thanks to Permisz

        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }

    public function redeem(){
        $url = "https://gift.truemoney.com/campaign/vouchers/{$this->voucher}/redeem";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Content-Type: application/json",
            "User-Agent: $this->USER_AGENT"
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_SSLVERSION, 7); // Thanks to Permisz

        $data = json_encode(array(
            'mobile' => $this->mobile,
            'voucher_hash' => $this->voucher
        ));

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $resp = curl_exec($curl);
        curl_close($curl);

        return $resp;
    }

    private function uidv4($data = null){
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public function userAgent(){
        $headers = array();
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        return $headers['User-Agent'];
    }

}