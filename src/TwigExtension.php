
Editing:  
/home/pokesman/public_html/hms/App/vendor/slim/twig-view/src/TwigExtension.php
 Encoding:    Re-open Use Code Editor     Close  Save Changes

<?php
/**
 * Slim Framework (http://slimframework.com)
 *
 * @link      https://github.com/slimphp/Twig-View
 * @copyright Copyright (c) 2011-2015 Josh Lockhart
 * @license   https://github.com/slimphp/Twig-View/blob/master/LICENSE.md (MIT License)
 */
namespace Slim\Views;

class TwigExtension extends \Twig_Extension
{
    /**
     * @var \Slim\Interfaces\RouterInterface
     */
    private $router;

    /**
     * @var string|\Slim\Http\Uri
     */
    private $uri;

    public function __construct($router, $uri)
    {
        $this->router = $router;
        $this->uri = $uri;
    }

    public function getName()
    {
        return 'slim';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('path_for', array($this, 'pathFor')),
            new \Twig_SimpleFunction('get_base_url', array($this, 'baseUrl')),
            new \Twig_SimpleFunction('getParam_get', array($this, 'getParamGet')),
            new \Twig_SimpleFunction('getParam_post', array($this, 'getParamPost')),
            new \Twig_SimpleFunction('getParam_request', array($this, 'getParamRequest')),
            new \Twig_SimpleFunction('get_base_path', array($this, 'getBasePath')),
            new \Twig_SimpleFunction('get_path', array($this, 'getPath')),
            new \Twig_SimpleFunction('get_fragment', array($this, 'getFragment')),
            new \Twig_SimpleFunction('get_root_url', array($this, 'getRootUrl'))
        ];
    }

// Own
    public function getParamGet($key)
    {
        return ($_GET[$key]) ? $_GET[$key] : '';
    }
    public function getParamPost($key)
    {
        return ($_POST[$key]) ? $_POST[$key] : '';
    }
    public function getParamRequest($key)
    {
        return ($_REQUEST[$key]) ? $_REQUEST[$key] : '';
    }
    public function getBasePath()
    {
        if (method_exists($this->uri, 'getBasePath')) {
            return $this->uri->getBasePath();
        }
    }
    public function getPath()
    {
        if (method_exists($this->uri, 'getPath')) {
            return $this->uri->getPath();
        }
    }
    public function getFragment()
    {
        if (method_exists($this->uri, 'getFragment')) {
            return $this->uri->getFragment();
        }
    }
    public function getRootUrl()
    {
        if (method_exists($this->uri, 'getBasePath') && method_exists($this->uri, 'getPath')) {
            return $this->uri->getBasePath() . DIRECTORY_SEPARATOR . trim($this->uri->getPath(), '/');
        }
    }
// End Own

    public function pathFor($name, $data = [], $queryParams = [], $appName = 'default')
    {
        return $this->router->pathFor($name, $data, $queryParams);
    }
    public function baseUrl()
    {
        if (is_string($this->uri)) {
            return $this->uri;
        }
        if (method_exists($this->uri, 'getBaseUrl')) {
            return $this->uri->getBaseUrl();
        }
    }
    /**
     * Set the base url
     *
     * @param string|Slim\Http\Uri $baseUrl
     * @return void
     */
    public function setBaseUrl($baseUrl)
    {
        $this->uri = $baseUrl;
    }
}

