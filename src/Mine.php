<?php
namespace Goldminer\Guts;

use Exception;
use GuzzleHttp\Client;

class Mine
{

    const USER_ID = '250bd709-0abb-4d60-a677-936c27289cfb';
    const USER_NAME = 'JasonJames';

    private $client;
    private $user;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function mine()
    {
        $bucketId = $this->excavate();
        if (!empty($bucketId)) {
            $this->store(self::USER_ID, $bucketId);
        }
    }

    public function excavate()
    {
        $res = $this->callExcavate();

        if (!empty($res)) {
            $array = json_decode($res->getBody(), true);
        }

        if (isset($array['gold']['units'])) {
            return $array['bucketId'];
        } else {
            $this->excavate();
        }
    }

    public function store(string $userId, string $bucketId)
    {
        $res = $this->callStore($userId, $bucketId);
        return $res;
    }

    /**
     * @param string $userId
     * @param string $bucketId
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function callStore(string $userId, string $bucketId)
    {
        try {
            return $this->client->request('POST', 'http://10.14.1.182:8883/v1/store', [
                'query' => [
                    'userId' => $userId,
                    'bucketId' => $bucketId,
                ]
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
            $this->callStore($userId, $bucketId);
        }
    }

    /**
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function callExcavate()
    {
        try {
            return $this->client->request('POST', 'http://10.14.1.182:8883/v1/excavate', [
                'timeout' => 2,
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
            $this->callExcavate();
        }
    }

}