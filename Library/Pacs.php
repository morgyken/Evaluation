<?php
/**
 * Project: platform
 * Company: Dervis Group <https://dervisgroup.com>
 * Author: Samuel Dervis <dervis@dervisgroup.com>
 */

namespace Ignite\Evaluation\Library;


use Curl;

class Pacs
{
    /**
     * @var int
     */
    public $patient;
    /**
     * @var int
     */
    public $test;
    /**
     * @var string
     */
    public $_id;
    /**
     * @var string
     */
    public $base_path;

    public function __construct($patient, $test)
    {
        $this->patient = $patient;
        $this->test = $test;
        $this->_id = $patient . '/' . $test;
        $this->base_path = mconfig('evaluation.orthanc.host');
    }

    public function processPacsServer()
    {
        $patient = $this->getPatientIdentifier();
        if (empty($patient)) {
            return null;
        }
        $study = $this->getStudyDetails($patient);
        if (empty($study)) {
            return null;
        }
        $series = $this->getSeriesDetails($study);
        if (empty($series)) {
            return null;
        }
        return $this->base_path . '/app/explorer.html#series?uuid=' . $series;
    }

    private function getSeriesDetails($series)
    {
        $url = $this->base_path . '/studies/' . $series;
        $series = Curl::to($url)
            ->returnResponseObject()
            ->asJsonResponse()->get();
        return $series->content->Series[0];
    }

    private function getStudyDetails($patient)
    {
        $url = $this->base_path . $patient->Path;
        $study = Curl::to($url)
            ->returnResponseObject()
            ->asJsonResponse()->get();
        return $study->content->Studies[0];
    }

    /**
     * @return bool
     */
    private function getPatientIdentifier()
    {
        $url = $this->base_path . '/tools/lookup';
        $content = Curl::to($url)
            ->returnResponseObject()
            ->asJsonResponse()
            ->withData($this->_id)->post();
        if (empty($content)) {
            return false;
        }
        return $content->content[0];
    }

}