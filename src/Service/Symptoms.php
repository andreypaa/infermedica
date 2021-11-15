<?php

namespace App\Service;

// https://developer.infermedica.com/docs/v3/api#/

class Symptoms
{
    protected $req;

    public function __construct(Req $req)
    {
        $this->req = $req;
    }

    // список симптомов по определенному возрасту возрасту
    public function getByYear(int $year):array
    {
        $ret = [];

        $raw = $this->req->get('symptoms?age.unit=year&age.value='.$year);
        if ($raw) {
            $data = json_decode($raw, true);
            if ($data) {
                foreach ($data as $symptom) {
                    if (!empty($symptom['name'])) {
                        $ret[] = $symptom['name'];
                    }
                }
            }
        }

        return $ret;
    }

    // список симптомов по диапазону возрастов
    public function getByRangeYear(int $start = 18, int $end = 30):array
    {
        $ret = [];
        foreach (range($start, $end) as $year) {
            $ret[] = $this->getByYear($year);
        }

        return array_unique(array_merge(...$ret));
    }
}