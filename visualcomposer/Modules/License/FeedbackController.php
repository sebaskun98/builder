<?php

namespace VisualComposer\Modules\License;

if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

use VisualComposer\Framework\Container;
use VisualComposer\Framework\Illuminate\Support\Module;
use VisualComposer\Helpers\License;
use VisualComposer\Helpers\Options;
use VisualComposer\Helpers\Request;
use VisualComposer\Helpers\Traits\EventsFilters;
use VisualComposer\Helpers\Url;
use WP_Query;

/**
 * Class FeedbackController
 * @package VisualComposer\Modules\License
 */
class FeedbackController extends Container implements Module
{
    use EventsFilters;

    /**
     * FeedbackController constructor.
     */
    public function __construct()
    {
        $this->addFilter('vcv:ajax:license:feedback:submit:adminNonce', 'submitForm');
        $this->addFilter('vcv:editor:variables', 'addVariables');
    }

    /**
     * Send good or bad feedback to HUB
     *
     * @param $response
     * @param \VisualComposer\Helpers\Request $requestHelper
     * @param \VisualComposer\Helpers\Url $urlHelper
     * @param \VisualComposer\Helpers\Options $optionsHelper
     *
     * @return array
     */
    protected function submitForm($response, Request $requestHelper, Url $urlHelper, Options $optionsHelper)
    {
        $optionsHelper->set('feedback-sent', time());

        $goodOrBad = (int)$requestHelper->input('vcv-feedback');
        $url = $urlHelper->query(
            vcvenv('VCV_HUB_URL'),
            [
                'vcv-send-feedback' => 'sendFeedback',
                'vcv-value' => $goodOrBad,
            ]
        );

        wp_remote_get(
            $url,
            [
                'timeout' => 30,
            ]
        );

        return ['status' => true];
    }

    /**
     * @param $variables
     * @param $payload
     * @param \VisualComposer\Helpers\License $licenseHelper
     * @param \VisualComposer\Helpers\Options $optionsHelper
     *
     * @return array
     */
    protected function addVariables($variables, $payload, License $licenseHelper, Options $optionsHelper)
    {
        $value = false;
        // do only if feedback not sent previously
        if (!$optionsHelper->get('feedback-sent')) {
            // Actively used for more then 1 month
            $isActivelyUsed = $licenseHelper->isPremiumActivated() && $licenseHelper->isActivelyUsed();
            // System check is OK
            $systemStatusFailing = $optionsHelper->get('systemCheckFailing', false);
            // Have at least 3 posts with VCWB
            $vcvPosts = new WP_Query(
                [
                    'post_type' => 'any',
                    'post_status' => ['publish', 'pending', 'draft', 'auto-draft', 'future', 'private'],
                    'posts_per_page' => 3,
                    'meta_key' => VCV_PREFIX . 'pageContent',
                    'suppress_filters' => true,
                ]
            );
            // @codingStandardsIgnoreLine
            $foundPostsOk = (int)$vcvPosts->found_posts >= 3;
            $value = $isActivelyUsed && !$systemStatusFailing && $foundPostsOk;
        }
        $variables[] = [
            'key' => 'VCV_SHOW_FEEDBACK_FORM',
            'value' => $value,
            'type' => 'constant',
        ];

        return $variables;
    }
}
