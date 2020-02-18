<?php

namespace App\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;

/**
 * Class GithubUserSearcher
 * @package App\Utils
 */
class GithubUserSearcher
{
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';

    /**
     * @param string $login
     * @return array
     */
    public function run(string $login): array
    {
        $client = new Client(['base_uri' => 'https://api.github.com/']);

        try {
            $response = $client->request('GET', 'users/' . $login);

            return [
                'status' => self::STATUS_SUCCESS,
                'data' => json_decode($response->getBody()->getContents(), true),
            ];
        } catch (RequestException $exception) {
            if ($exception->getCode() === 404) {
                return [
                    'status' => self::STATUS_ERROR,
                    'data' => 'User by current login not found.',
                ];
            }
        }


    }
}
