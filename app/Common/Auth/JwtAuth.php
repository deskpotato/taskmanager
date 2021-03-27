<?php
namespace  App\Common\Auth;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;

class JwtAuth
{

    /**
     * jwt token
     * @var
     */
    private  $token;

    private  $decodeToken;


    private $iss = "taskmanager.local";

    private $aud = 'imooc_server_app';

    private $uid; //用户数据库id

    private $secrect = 'xadada11113wxxxQQQ';

    private  static $instance;

    public  static  function  getInstance()
    {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }

        return self::$instance;
    }


    private  function  __construct()
    {

    }

    private  function __clone()
    {
        // TODO: Implement __clone() method.
    }


    /**
     * uid
     * @param $uid
     * @return $this
     */
    public  function  setUid($uid){
        $this->uid = $uid;
        return $this;
    }

    /**
     * 获取 token
     * @return string
     */
    public  function  getToken(){

        return (string)$this->token;
    }

    public  function setToken($token){
        $this->token = $token;
        return $this;
    }

    /**
     * 编码jwt
     * @return $this
     */
    public  function  encode()
    {
        $time  =time();
        $this->token = (new Builder())->setHeader('alg','HS256')
            ->setIssuer($this->iss)
            ->setAudience($this->aud)
            ->setIssuedAt($time)
            ->setExpiration($time+3600)
            ->set('uid',$this->uid)
            ->sign(new Sha256(),$this->secrect)
            ->getToken();

        return $this;
    }

    /**
     * parse token
     * @return $this
     */
    public  function  decode(){
        if(!$this->decodeToken){
            $this->decodeToken = (new Parser())->parse((string)$this->token);
            $this->uid = $this->decodeToken->getClaim('uid');
        }
        return $this;
    }

    public  function  verify(){
        $result = $this->decode()->verify(new Sha256(),$this->secrect);
        return $result;
    }

    public  function  validate(){
        $data = new ValidationData();
        $data->setIssuer($this->iss);
        $data->setAudience($this->aud);
        return $this->decode()->validate($data);

    }
}
