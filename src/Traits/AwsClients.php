<?php

namespace Kiekbjul\SesFeedbackInbound\Traits;

use Aws\S3\S3Client;
use Aws\Ses\SesClient;
use Aws\Sns\SnsClient;

trait AwsClients
{
    protected $ses;
    protected $sns;
    protected $s3;

    public function __construct()
    {
        $credentials = [
            'credentials' => [
                'key' => config('services.ses.key'),
                'secret' => config('services.ses.secret'),
            ],
            'region' => config('services.ses.region'),
            'version' => 'latest',
        ];

        $this->ses = new SesClient($credentials);
        $this->sns = new SnsClient($credentials);
        $this->s3 = new S3Client($credentials);
    }
}
