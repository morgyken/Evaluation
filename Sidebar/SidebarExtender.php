<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Evaluation\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Ignite\Core\Contracts\Authentication;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\SidebarExtender as Panda;

/**
 * Description of SidebarExtender
 *
 * @author Samuel Dervis <samueldervis@gmail.com>
 */
class SidebarExtender implements Panda {

    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     */
    public function __construct(Authentication $auth) {
        $this->auth = $auth;
    }

    public function extendWith(Menu $menu) {
        $menu->group('Dashboard', function (Group $group) {
            $group->item('Evaluation', function (Item $item) {
                $item->weight(2);
                $item->authorize($this->auth->hasAccess('evaluation.*'));
                $item->icon('fa fa-heartbeat');

                $item->item('Preliminary Examinations', function (Item $item) {
                    $item->icon('fa fa-wheelchair');
                    $item->route('evaluation.queues', 'nurse');
                    $item->authorize($this->auth->hasAccess('evaluation.examination.preliminary'));
                });
                $item->item('Doctor\'s queue', function (Item $item) {
                    $item->icon('fa fa-wheelchair-alt');
                    $item->route('evaluation.queues', 'doctor');
                    $item->authorize($this->auth->hasAccess('evaluation.examination.doctor'));
                });
                $item->item('Radiology Queue', function (Item $item) {
                    $item->icon('fa fa-braille');
                    $item->route('evaluation.queues', 'radiology');
                    $item->authorize($this->auth->hasAccess('evaluation.examination.radiology'));
                });
                $item->item('Diagnostics Queue', function (Item $item) {
                    $item->icon('fa fa-hotel');
                    $item->route('evaluation.queues', 'diagnostics');
                    $item->authorize($this->auth->hasAccess('evaluation.examination.diagnostics'));
                });
                $item->item('Laboratory Queue', function (Item $item) {
                    $item->icon('fa fa-diamond');
                    $item->route('evaluation.queues', 'laboratory');
                    $item->authorize($this->auth->hasAccess('evaluation.examination.laboratory'));
                });
                $item->item('Theatre Queue', function (Item $item) {
                    $item->icon('fa fa-heartbeat');
                    $item->route('evaluation.queues', 'theatre');
                    $item->authorize($this->auth->hasAccess('evaluation.examination.theatre'));
                });
                $item->item('Pharmacy Queue', function (Item $item) {
                    $item->icon('fa fa-tablet');
                    $item->route('evaluation.queues', 'pharmacy');
                    $item->authorize($this->auth->hasAccess('evaluation.examination.pharmacy'));
                });
                $item->item('Physiotherapy Queue', function (Item $item) {
                    $item->icon('fa fa-openid');
                    $item->route('evaluation.queues', 'physio');
                    $item->authorize($this->auth->hasAccess('evaluation.examination.physio'));
                });
                $item->item('Review Visits', function (Item $item) {
                    $item->icon('fa fa-deaf');
                    $item->route('evaluation.review');
                    $item->authorize($this->auth->hasAccess('evaluation.examination.review'));
                });
            });

            $group->item('Setup', function (Item $item) {
                $item->item('Procedure Categories', function(Item $item) {
                    $item->icon('fa fa-wpforms');
                    $item->route('evaluation.setup.procedure_cat', 'procedure_categories');
                    $item->authorize($this->auth->hasAccess('evaluation.settings.procedure_categories'));
                    $item->weight(4);
                });
                $item->item('Procedures', function(Item $item) {
                    $item->icon('fa fa-hourglass-1');
                    $item->route('evaluation.setup.procedures', 'procedures');
                    $item->authorize($this->auth->hasAccess('evaluation.settings.procedures'));
                    $item->weight(4);
                });
                /*
                  $item->item('Sub-Procedures', function(Item $item) {
                  $item->icon('fa fa-tree');
                  $item->route('evaluation.setup.subprocedures', 'procedures');
                  $item->authorize($this->auth->hasAccess('evaluation.settings.procedures'));
                  $item->weight(4);
                  });
                 */
            });
        });
        return $menu;
    }

}
