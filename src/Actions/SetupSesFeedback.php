<?php

namespace Kiekbjul\SesFeedbackInbound\Actions;

use Aws\Ses\Exception\SesException;
use Kiekbjul\SesFeedbackInbound\Traits\AwsClients;
use Kiekbjul\SesFeedbackInbound\Traits\GenerateResourceName;
use Kiekbjul\SesFeedbackInbound\Traits\SnsSubscribe;

class SetupSesFeedback
{
    use AwsClients, GenerateResourceName, SnsSubscribe;

    public static $events = ['send', 'reject', 'delivery', 'bounce', 'complaint', 'click', 'open', 'delivery_delay'];

    public function run($domain, $events)
    {
        $topicArn = $this->createFeedbackTopic($domain);

        $this->subscribeFeedbackEndpointToTopic($topicArn);
        $this->createConfigurationSet($domain);
        $this->setEventDestination($domain, $events, $topicArn);
    }

    /*
    * AWS API
    */

    protected function createConfigurationSet($domain)
    {
        try {
            $this->ses->createConfigurationSet([
                'ConfigurationSet' => [
                    'Name' => $this->feedbackResourceName($domain),
                ],
            ]);
        } catch (SesException $ex) {
            if ($ex->getAwsErrorCode() != 'ConfigurationSetAlreadyExists') {
                throw $ex;
            }
        }
    }

    protected function setEventDestination($domain, $events, $topicArn)
    {
        try {
            $this->ses->createConfigurationSetEventDestination(
                $this->generateEventDestination($domain, $events, $topicArn)
            );
        } catch (SesException $ex) {
            if ($ex->getAwsErrorCode() != 'EventDestinationAlreadyExists') {
                throw $ex;
            }

            $this->ses->updateConfigurationSetEventDestination(
                $this->generateEventDestination($domain, $events, $topicArn)
            );
        }
    }

    /*
    * HELPERS
    */

    protected function generateEventDestination($domain, $events, $topicArn)
    {
        return [
            'ConfigurationSetName' => $this->feedbackResourceName($domain),
            'EventDestination' => [
                'Enabled' => true,
                'MatchingEventTypes' => $events,
                'Name' => $this->feedbackResourceName($domain),
                'SNSDestination' => [
                    'TopicARN' => $topicArn,
                ],
            ],
        ];
    }
}
