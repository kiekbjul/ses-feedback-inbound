<?php

namespace Kiekbjul\SesFeedbackInbound\Traits;

trait SnsSubscribe
{
    use GenerateResourceName, AwsClients;

    /*
    *  SNS TOPIC
    */

    protected function createTopic($name)
    {
        return $this->sns->createTopic([
            'Name' => $name,
        ])['TopicArn'];
    }

    protected function createFeedbackTopic($domain)
    {
        return $this->createTopic(
            $this->feedbackResourceName($domain)
        );
    }

    protected function createInboundTopic($domain)
    {
        return $this->createTopic(
            $this->inboundResourceName($domain)
        );
    }

    /*
    *  SUBSCRIBE TO TOPIC
    */

    protected function subscribeEndpointToTopic($endPoint, $topicArn)
    {
        $this->sns->subscribe([
            'Endpoint' => url($endPoint),
            'Protocol' => 'https',
            'TopicArn' => $topicArn,
        ]);
    }

    protected function subscribeFeedbackEndpointToTopic($topicArn)
    {
        $this->subscribeEndpointToTopic(
            route('ses-feedback'),
            $topicArn
        );
    }

    protected function subscribeInboundEndpointToTopic($topicArn)
    {
        $this->subscribeEndpointToTopic(
            route('ses-inbound'),
            $topicArn
        );
    }
}
