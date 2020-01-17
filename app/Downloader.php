<?php

namespace App;

/**
 * The implementation is responsible for getting raw data from specified URL/path.
 *
 * @author igronus
 */
class Downloader implements DownloaderInterface
{
    private $url;

    public function setUrl($url) {
        $this->url = $url;
    }


    private $cacher;

    public function setCacher(CacherInterface $c) {
        $this->cacher = $c;
    }

    /**
     * Fetching data.
     *
     * @return string
     * @throws \Exception
     */
    private function fetch(string $method, string $url, string $body="", array $headers = []) 
    {
        $context = stream_context_create([
            "http" => [
                // http://docs.php.net/manual/en/context.http.php
                "method"        => $method,
                "header"        => implode("\r\n", $headers),
                "content"       => $body,
                "ignore_errors" => true,
            ],
        ]);
    
        $response = file_get_contents($url, false, $context);
        $status_line = $http_response_header[0];
    
        preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
    
        $status = $match[1];
    
        if ($status !== "200") {
            throw new \Exception("unexpected response status: {$status_line}\n" . $response);
        }
    
        return $response;
    }


    /**
     * Downloading data.
     *
     * @return string
     * @throws \Exception
     */
    function download() {
        if ( ! $this->url) {
            throw new \Exception('Downloader: No url specified');
        }


        if ($this->cacher) {
            $key = sprintf('url_%s', $this->url);

            if ($this->cacher->get($key) !== null) {
                return $this->cacher->get($key);
            }
        }


        // TODO: check if '200 Ok' here
        $content = $this->fetch("GET", $this->url);

        if ( ! $content) {
            throw new \Exception(sprintf('Downloader: No content at %s', $this->url));
        }


        if ($this->cacher) {
            $this->cacher->put($key, $content);
        }


        return $content;
    }
}
