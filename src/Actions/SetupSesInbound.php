<?php

namespace Kiekbjul\SesFeedbackInbound\Actions;

use Aws\S3\Exception\S3Exception;
use Aws\Ses\Exception\SesException;
use Kiekbjul\SesFeedbackInbound\Traits\AwsClients;
use Kiekbjul\SesFeedbackInbound\Traits\GenerateResourceName;
use Kiekbjul\SesFeedbackInbound\Traits\SnsSubscribe;

class SetupSesInbound
{
    use AwsClients, GenerateResourceName, SnsSubscribe;

    public function run($accountId, $domain, $recipients)
    {
        $this->createBucket($domain);
        $this->allowSesToPutEmailsIntoTheBucket($domain, $accountId);
        $topicArn = $this->createInboundTopic($domain);
        $this->subscribeInboundEndpointToTopic($topicArn);
        $this->createReceiptRuleSet($domain);
        $this->setReceiptRule($domain, $topicArn, $recipients);
        $this->setActiveReceiptRuleSet($domain);
    }

    /*
    *  AWS API
    */

    protected function createBucket($domain)
    {
        try {
            $this->s3->createBucket([
                'ACL' => 'private',
                'Bucket' => $this->inboundResourceName($domain),
                'CreateBucketConfiguration' => [
                    'LocationConstraint' => config('services.ses.region'),
                ],
            ]);
        } catch (S3Exception $ex) {
        }
    }

    protected function allowSesToPutEmailsIntoTheBucket($domain, $accountId)
    {
        $this->s3->putBucketPolicy([
            'Bucket' => $this->inboundResourceName($domain),
            'Policy' => $this->generateBucketPolicy($domain, $accountId),
        ]);
    }

    protected function createReceiptRuleSet($domain)
    {
        try {
            $this->ses->createReceiptRuleSet([
                'RuleSetName' => $this->inboundResourceName($domain),
            ]);
        } catch (SesException $ex) {
            if ($ex->getAwsErrorCode() != 'AlreadyExists') {
                throw $ex;
            }
        }
    }

    protected function setReceiptRule($domain, $topicArn, $recipients)
    {
        try {
            $this->ses->createReceiptRule(
                $this->generateReceiptRule($domain, $topicArn, $recipients)
            );
        } catch (SesException $ex) {
            if ($ex->getAwsErrorCode() != 'AlreadyExists') {
                throw $ex;
            }

            $this->ses->updateReceiptRule(
                $this->generateReceiptRule($domain, $topicArn, $recipients)
            );
        }
    }

    /*
    * HELPERS
    */

    protected function generateBucketPolicy($domain, $accountId)
    {
        return json_encode([
            'Version' => '2012-10-17',
            'Statement' => [
                [
                    'Sid' => 'AllowSESPuts',
                    'Effect' => 'Allow',
                    'Principal' => [
                        'Service' => 'ses.amazonaws.com',
                    ],
                    'Action' => 's3:PutObject',
                    'Resource' => 'arn:aws:s3:::'.$this->inboundResourceName($domain).'/*',
                    'Condition' => [
                        'StringEquals' => [
                            'aws:Referer' => $accountId,
                        ],
                    ],
                ],
            ],
        ]);
    }

    protected function generateReceiptRule($domain, $topicArn, $recipients)
    {
        return [
            'Rule' => [
                'Actions' => [
                    $this->generateInboundAction($domain, $topicArn),
                ],
                'Enabled' => true,
                'Name' => $this->inboundResourceName($domain),
                'Recipients' => $recipients,
                'ScanEnabled' => true,
            ],
            'RuleSetName' => $this->inboundResourceName($domain),
        ];
    }

    protected function generateInboundAction($domain, $topicArn, $mode = 's3')
    {
        if ($mode == 's3') {
            return [
                'S3Action' => [
                    'BucketName' => $this->inboundResourceName($domain),
                    'TopicArn' => $topicArn,
                ],
            ];
        }

        return [
            'SNSAction' => [
                'Encoding' => 'UTF-8',
                'TopicArn' => $topicArn,
            ],
        ];
    }

    protected function setActiveReceiptRuleSet($domain)
    {
        $this->ses->setActiveReceiptRuleSet([
            'RuleSetName' => $this->inboundResourceName($domain),
        ]);
    }
}
