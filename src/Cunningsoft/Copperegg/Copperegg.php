<?php

namespace Cunningsoft\Copperegg;

use Buzz\Browser;
use Buzz\Client\Curl;
use Buzz\Message\Request;
use Buzz\Message\MessageInterface;
use \DateTime;

class Copperegg
{
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param string $note
     * @param array $tags
     *
     * @return MessageInterface
     */
    public function createAnnotation(DateTime $startDate, DateTime $endDate, $note, $tags = array())
    {
        $request = new Request();
        $request->setMethod('post');
        $request->setProtocolVersion(1.1);
        $request->addHeader('Authorization: Basic ' . base64_encode($this->apiKey . ':U'));
        $request->setHost('https://api.copperegg.com');
        $request->setResource('/v2/annotations.json');
        $request->setContent('note=' . $note . '&starttime=' . $startDate->getTimestamp() . '&endtime=' . $endDate->getTimestamp() . '&tag=' . implode(',', $tags));

        $curl = new Curl();
        $curl->setVerifyPeer(false);
        $browser = new Browser($curl);

        return $browser->send($request);
    }
}
