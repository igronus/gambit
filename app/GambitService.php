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
    private $parser;

    public function setDownloader(DownloaderInterface $downloader) {
        $this->downloader = $downloader;
    }

    public function setParser(ParserInterface $parser) {
        $this->parser = $parser;
    }


    public function getData($devices)
    {
        if ( ! $this->downloader) {
            throw new \Exception('GambitService: No downloader specified');
        }

        if ( ! $this->parser) {
            throw new \Exception('GambitService: No parser specified');
        }


        $data = [];

        foreach ($devices as $name => $url) {
            $d = new TUF2000M($name);

            $this->downloader->setUrl($url);
            $d->rawData = $this->downloader->download();

            $parsedData = $this->parser->parse($d->rawData);
            $d->datetime = $parsedData['datetime'];
            $d->registers = $parsedData['registers'];

            $data[] = $d;
        }

        return $data;
    }
}
