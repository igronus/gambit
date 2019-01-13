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


        // TODO: check if '200 Ok' here
        $content = @file_get_contents($this->url);

        if ( ! $content) {
            throw new \Exception(sprintf('Downloader: No content at %s', $this->url));
        }


        return $content;
    }
}
