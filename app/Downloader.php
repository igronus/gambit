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
        $content = @file_get_contents($this->url);

        if ( ! $content) {
            throw new \Exception(sprintf('Downloader: No content at %s', $this->url));
        }


        if ($this->cacher) {
            $this->cacher->put($key, $content);
        }


        return $content;
    }
}
