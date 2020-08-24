<?php
namespace Kiekbjul\SesFeedbackInbound\Traits;

use Illuminate\Support\Str;

trait GenerateResourceName
{
    protected function feedbackResourceName($domain)
    {
        return 'laravel-ses-feedback-' . $this->kebabDomain($domain);
    }

    protected function inboundResourceName($domain)
    {
        return 'laravel-ses-inbound-' . $this->kebabDomain($domain);
    }

    protected function kebabDomain($domain)
    {
        return Str::of($domain)->replace('.', '-')->kebab();
    }
}
