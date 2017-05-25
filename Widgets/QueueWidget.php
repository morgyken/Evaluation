<?php

namespace Ignite\Evaluation\Widgets;

use Ignite\Core\Library\BaseDashboardWidgets;
use Ignite\Evaluation\Entities\VisitDestinations;

class QueueWidget extends BaseDashboardWidgets {

    /**
     * Get the widget name
     * @return string
     */
    protected function name() {
        return 'QueueWidget';
    }

    /**
     * Get the widget options
     * Possible options:
     *  x, y, width, height
     * @return string
     */
    protected function options() {
        return [
            'width' => '6',
            'height' => '4',
            'x' => '6',
            'y' => '2',
        ];
    }

    /**
     * Get the widget view
     * @return string
     */
    protected function view() {
        return 'evaluation::widgets.queue';
    }

    /**
     * Get the widget data to send to the view
     * @return string
     */
    protected function data() {
        // $limit = $this->setting->get('blog::latest-posts-amount', locale(), 5);
        try {
            $user = \Auth::user()->id;
            $queue = VisitDestinations::whereDestination($user)
                    ->whereCheckout(0)
                    ->oldest()
                    ->get();
            return ['queue' => $queue];
        } catch (\Exception $e) {

        }
    }

}
