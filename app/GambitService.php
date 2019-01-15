<?php

namespace App;

/**
 * The main service.
 *
 * @author igronus
 */
class GambitService implements ServiceInterface
{
    private $downloader;

    public function setDownloader(DownloaderInterface $downloader) {
        $this->downloader = $downloader;
    }


    public function getData($devices)
    {
        if ( ! $this->downloader) {
            throw new \Exception('GambitService: No downloader specified');
        }


        $data = [];

        foreach ($devices as $name => $url) {
            $d = new TUF2000M($name);
            $this->downloader->setUrl($url);
            $d->rawData = $this->downloader->download();

            $data[] = $d;
        }

        return $data;
    }
}
