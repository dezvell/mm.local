<?php
/**
 * Bluz Framework Component
 *
 * @copyright Bluz PHP Team
 * @link https://github.com/bluzphp/framework
 */

/**
 * @namespace
 */
namespace Bluz\Request;

use Bluz\Common\Options;

/**
 * Request
 *
 * @package  Bluz\Request
 * @author   Anton Shevchuk
 * @link     https://github.com/bluzphp/framework/wiki/Request
 */
class AbstractRequest
{
    use Options;

    /**
     * @const string HTTP METHOD constant names
     */
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_GET = 'GET';
    const METHOD_HEAD = 'HEAD';
    const METHOD_PATCH = 'PATCH';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    const METHOD_TRACE = 'TRACE';
    const METHOD_CONNECT = 'CONNECT';

    /**
     * Command line request
     */
    const METHOD_CLI = 'CLI';

    /**
     * HTTP Request
     */
    const METHOD_HTTP = 'HTTP';

    /**
     * @const string HTTP ACCEPT MIME types
     */
    const ACCEPT_CLI = 'CLI';
    const ACCEPT_HTML = 'HTML';
    const ACCEPT_JSON = 'JSON';
    const ACCEPT_JSONP = 'JSONP';
    const ACCEPT_XML = 'XML';

    /**
     * @var string REQUEST_URI
     */
    protected $requestUri;

    /**
     *
     * @var string base URL
     */
    protected $baseUrl;

    /**
     * @var string base path
     */
    protected $basePath;

    /**
     * @var string HTTP Accept Mime Type or CLI
     */
    protected $accept;

    /**
     * @var string HTTP Method or CLI
     */
    protected $method;

    /**
     * @var string module name
     */
    protected $module = 'index';

    /**
     * @var string controller name
     */
    protected $controller = 'index';

    /**
     * @var array instance parameters
     */
    protected $params = array();

    /**
     * @var array instance raw parameters
     */
    protected $rawParams = array();


    /**
     * Return HTTP method or CLI
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Overwrite request method
     *
     * @param  string $method
     * @return void
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Check CLI
     *
     * @return bool
     */
    public function isCli()
    {
        return $this->method == self::METHOD_CLI;
    }

    /**
     * Check HTTP
     *
     * @return bool
     */
    public function isHttp()
    {
        return $this->method != self::METHOD_CLI;
    }

    /**
     * Is this a GET method request?
     *
     * @return bool
     */
    public function isGet()
    {
        return ($this->getMethod() === self::METHOD_GET);
    }

    /**
     * Is this a POST method request?
     *
     * @return bool
     */
    public function isPost()
    {
        return ($this->getMethod() === self::METHOD_POST);
    }

    /**
     * Is this a PUT method request?
     *
     * @return bool
     */
    public function isPut()
    {
        return ($this->getMethod() === self::METHOD_PUT);
    }

    /**
     * Is this a DELETE method request?
     *
     * @return bool
     */
    public function isDelete()
    {
        return ($this->getMethod() === self::METHOD_DELETE);
    }

    /**
     * Get the request URI.
     *
     * @return string
     */
    public function getRequestUri()
    {
        return $this->requestUri;
    }

    /**
     * Set the request URI.
     *
     * @param  string $requestUri
     * @return void
     */
    public function setRequestUri($requestUri)
    {
        $this->requestUri = $requestUri;
    }

    /**
     * Get an action parameter
     *
     * @param  string $key
     * @param  mixed  $default Default value to use if key not found
     * @return mixed
     */
    public function getParam($key, $default = null)
    {
        return isset($this->params[$key]) ? $this->params[$key] : $default;
    }

    /**
     * Set an action parameter
     *
     * A $value of null will unset the $key if it exists
     *
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function setParam($key, $value)
    {
        $key = (string)$key;

        if ((null === $value) && isset($this->params[$key])) {
            unset($this->params[$key]);
        } elseif (null !== $value) {
            $this->params[$key] = $value;
        }
    }

    /**
     * Get parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Get all request parameters
     *
     * @return array
     */
    public function getAllParams()
    {
        return $this->getParams();
    }

    /**
     * Overwrite all parameters
     *
     * @param  array $params
     * @return void
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * Get raw params, w/out module and controller
     *
     * @return array
     */
    public function getRawParams()
    {
        return $this->rawParams;
    }

    /**
     * Set raw params, w/out module and controller
     *
     * @param  array $params
     * @return void
     */
    public function setRawParams(array $params)
    {
        $this->rawParams = $params;
    }

    /**
     * Retrieve a member of the $_ENV super global
     *
     * If no $key is passed, returns the entire $_ENV array.
     *
     * @param  string $key
     * @param  mixed  $default Default value to use if key not found
     * @return mixed  Returns null if key does not exist
     */
    public function getEnv($key = null, $default = null)
    {
        if (null === $key) {
            return $_ENV;
        }
        return (isset($_ENV[$key])) ? $_ENV[$key] : $default;
    }

    /**
     * Retrieve a member of the $_SERVER super global
     *
     * If no $key is passed, returns the entire $_SERVER array.
     *
     * @param  string $key
     * @param  string $default Default value to use if key not found
     * @return string Returns null if key does not exist
     */
    public function getServer($key = null, $default = null)
    {
        if (null === $key) {
            return $_SERVER;
        }
        return (isset($_SERVER[$key])) ? $_SERVER[$key] : $default;
    }

    /**
     * Retrieve the module name
     *
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Retrieve the module name
     *
     * @param  string $name
     * @return void
     */
    public function setModule($name)
    {
        $this->module = $name;
    }

    /**
     * Retrieve the controller name
     *
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Retrieve the controller name
     *
     * @param  string $name
     * @return void
     */
    public function setController($name)
    {
        $this->controller = $name;
    }
}
