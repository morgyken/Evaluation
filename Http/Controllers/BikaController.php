<?php

namespace Ignite\Evaluation\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Evaluation\Repositories\BikaRepository;

class BikaController extends AdminBaseController {

    /**
     * @var BikaRepository
     */
    protected $bika;

    /**
     * BikaController constructor.
     * @param BikaRepository $repo
     */
    public function __construct(BikaRepository $repo) {
        parent::__construct();
        $this->bika = $repo;
    }

    public function view() {
        $url = mconfig('evaluation.bika.url');
        $url .= ':' . mconfig('evaluation.bika.port');
        $url .= '/' . mconfig('evaluation.bika.top_level_url');
        // $url .= '/@@API/read?portal_type=Client';
        $url .= '/@@API/read?portal_type=Client';
        $resutls = $this->bika->execute($url);
        dd(json_decode($resutls));
    }

    public function create() {
        $url = mconfig('evaluation.bika.url');
        $url .= ':' . mconfig('evaluation.bika.port');
        $url .= '/' . mconfig('evaluation.bika.top_level_url');
        // $url .= '/@@API/read?portal_type=Client';
        $url .= '/@@API/read?portal_type=Client';
        $resutls = $this->bika->execute($url);
        dd(json_decode($resutls));
    }

}
