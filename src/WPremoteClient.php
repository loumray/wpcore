<?php
namespace WPCore;

use WPCore\admin\WPpostSaveable;

class WPremoteClient
{
    protected $wphttp;

    protected $baseurl;
    protected $bodyformat = 'json';

    public function __construct($baseurl, $format = 'json')
    {
        $this->baseurl = $baseurl;
        $this->bodyformat = $format;
    }

    protected function wphttp()
    {
        if (is_null($this->wphttp)) {
            $this->wphttp = _wp_http_get_object();
        }

        return $this->wphttp;
    }

    public function setFormat($format)
    {
        $this->bodyformat = $format;
    }

    public function filterJson($json)
    {
        return json_decode($json, true);
    }

    protected function filter($response)
    {
        $body = wp_remote_retrieve_body($response);

        //Apply content filter depending of format
        switch ($this->bodyformat) {
            case 'json':
                $body = $this->filterJson($body);
                break;
            default:
            case 'raw':
        }

        return $body;
    }

    public function get($endpoint, $args = [], $httpOptions = [])
    {
        //TODO add args to endpoint
        $endpoint = trailingslashit($this->baseurl).$endpoint;
        $endpoint = add_query_arg($args, $endpoint);
        $response = $this->wphttp()->get($endpoint, $httpOptions);

        if (is_wp_error($response)) {
            throw new Exceptions\WPHttpException($response);
        }

        return $this->filter($response);
    }

    public function post($endpoint, $args = [], $httpOptions = [])
    {
        //Args gg int body
        $response = $this->wphttp()->post(trailingslashit($this->baseurl).$endpoint, $httpOptions);
        if (is_wp_error($response)) {
            throw new Exceptions\WPHttpException($response);
        }

        return $this->filter($response);
    }

}
