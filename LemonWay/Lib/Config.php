<?php
namespace LemonWay\Lib;
/**
 * API Config settings
 */
class Config
{
    /**
     * DirectKit URL
     * @var string
     */
    public $dkUrl;

    /**
     * WebKit URL
     * @var string
     */
    public $wkUrl;

    /**
     * is Sandbox
     * @var boolean
     */
    public $sandbox = true;

    /**
     * Login
     * @var string
     */
    public $wlLogin;

    /**
     * Password
     * @var string
     */
    public $wlPass;

    /**
     * Lang
     * @var string
     */
    public $lang;

    /**
     * isDebugEnabled
     * @var boolean
     */
    public $isDebugEnabled = false;
    
    /**
     * user_agent
     * @var string
     */
	public $user_agent;
	
	/**
     * remote_addr
     * @var string
     */
	public $remote_addr;
}
