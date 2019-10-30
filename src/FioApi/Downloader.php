<?php

namespace FioApi;

use Composer\CaBundle\CaBundle;
use DateTimeImmutable;
use DateTimeInterface;
use FioApi\Exceptions\InternalErrorException;
use FioApi\Exceptions\TooGreedyException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use Kdyby\CurlCaBundle\CertificateHelper;
use Psr\Http\Message\ResponseInterface;

class Downloader
{
    /** @var UrlBuilder */
    protected $urlBuilder;

    /** @var Client */
    protected $client;

    /** @var string */
    protected $certificatePath;

    public function __construct(string $token, ClientInterface $client = null)
    {
        $this->urlBuilder = new UrlBuilder($token);
        $this->client = $client;
    }

    public function setCertificatePath(string $path)
    {
        $this->certificatePath = $path;
    }

    public function getCertificatePath(): string
    {
        if ($this->certificatePath) {
            return $this->certificatePath;
        }

        if (class_exists('\Composer\CaBundle\CaBundle')) {
            return CaBundle::getSystemCaRootBundlePath();
        } elseif (class_exists('\Kdyby\CurlCaBundle\CertificateHelper')) {
            return CertificateHelper::getCaInfoFile();
        }

        //Key downloaded from https://www.geotrust.com/resources/root-certificates/
        return __DIR__ . '/keys/Geotrust_PCA_G3_Root.pem';
    }

    public function getClient(): ClientInterface
    {
        if (!$this->client) {
            $this->client = new Client();
        }
        return $this->client;
    }

    public function downloadFromTo(DateTimeInterface $from, DateTimeInterface $to): TransactionList
    {
        $url = $this->urlBuilder->buildPeriodsUrl($from, $to);
        return $this->downloadTransactionsList($url);
    }

    public function downloadSince(DateTimeInterface $since): TransactionList
    {
        return $this->downloadFromTo($since, new DateTimeImmutable());
    }

    public function downloadLast(): TransactionList
    {
        $url = $this->urlBuilder->buildLastUrl();
        return $this->downloadTransactionsList($url);
    }

    public function setLastId(string $id): void
    {
        $client = $this->getClient();
        $url = $this->urlBuilder->buildSetLastIdUrl($id);

        try {
            $client->request('get', $url, ['verify' => $this->getCertificatePath()]);
        } catch (BadResponseException $e) {
            $this->handleException($e);
        }
    }

    private function downloadTransactionsList(string $url): TransactionList
    {
        $client = $this->getClient();

        try {
            /** @var ResponseInterface $response */
            $response = $client->request('get', $url, ['verify' => $this->getCertificatePath()]);
        } catch (BadResponseException $e) {
            $this->handleException($e);
        }

        return TransactionList::create(json_decode($response->getBody()->getContents())->accountStatement);
    }

    private function handleException(BadResponseException $e): void
    {
        if ($e->getCode() == 409) {
            throw new TooGreedyException('You can use one token for API call every 30 seconds', $e->getCode(), $e);
        }
        if ($e->getCode() == 500) {
            throw new InternalErrorException(
                'Server returned 500 Internal Error (probably invalid token?)',
                $e->getCode(),
                $e
            );
        }
        throw $e;
    }
}
