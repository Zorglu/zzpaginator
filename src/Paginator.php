<?php
declare (strict_types=1);
/**
 *
 * Inspired by https://github.com/jasongrimes/php-paginator
 *
 */

namespace zozor;

/**
 * Main class
 */
class Paginator{

    /**
     * total number of records
     */
    protected int $total;

    /**
     * per_page number of records per page
     */
    protected int $per_page;

    /**
     * current current page number
     */
    protected int $current;

    /**
     * max_to_show number of showed buttons
     */
    protected int $max_to_show;

    /**
     * number of calculated pages
     */
    protected int $nb_page;

    /**
     * class's constructor
     *
     * @param int $total number of records
     * @param int $per_page number of records per page (default 10)
     * @param int $max_to_show number of showed buttons
     * @param int $current current page number
     *
     */
    public function __construct (int $total, int $per_page = 10, int $max_to_show, int $current = 0) {
        $this->total = $total;
        $this->per_page = $per_page;
        $this->current = $current;
        $this->max_to_show = $max_to_show;
        $this->nb_page = $this->per_page !== 0 ? (int)ceil($this->total / $this->per_page) : 0;
    }

    /**
     * create data for un new page
     *
     * @param int $num Number of the page
     * @param bool $active is it an active page ? (default false)
     * @param bool $ellipsis is it an ellipsis ? (default false)
     * @param string $text button text for next and previous button ( default "")
     * @return array array with (text, num, active) elements
     */
    protected function newPage(int $num, bool $active = false, bool $ellipsis = false, string $text = ""):array {
        if(! $ellipsis){
            return [
                'text' => $text != "" ? $text : $num,
                'num' => $num,
                'active' => $active,
            ];
        }else{
            return [
                'text' => $text = "…",
                'num' => "…",
                'active' => false
            ];
        }
    }

    /**
     * print json of pagination'array by default
     * @return string pagination'array in json format
     */
    public function __toString():string {
        return $this->getJson();
    }

    /**
     * get the pagination'array
     * @return array pagination'array
     */
    public function get():array {
        $result = [];
        if($this->nb_page > 1){
            if ($this->nb_page <= $this->max_to_show) {
                for ($i = 1; $i <= $this->nb_page; $i++) {
                    $result[] = $this->newPage($i, $i == $this->current);
                }
            }else{
                $offset = (int) floor(($this->max_to_show - 3) / 2);
                if ($this->current + $offset > $this->nb_page) {
                    $start = $this->nb_page - $this->max_to_show + 2;
                } else {
                    $start = $this->current - $offset;
                }
                if ($start < 2){
                    $start = 2;
                }
                $end = $start + $this->max_to_show - 3;
                if ($end >= $this->nb_page){
                    $end = $this->nb_page - 1;
                }
                if($this->current > 1){
                    $result[] = $this->newPage($this->current -1, $this->current == 1, false, "&laquo;");
                }
                $result[] = $this->newPage(1, $this->current == 1);
                if ($start > 2) {
                    $result[] = $this->newPage(0, false, true);
                }
                for ($i = $start; $i <= $end; $i++) {
                    $result[] = $this->newPage($i, $i == $this->current);
                }
                if ($end < $this->nb_page - 1) {
                    $result[] = $this->newPage(0, false, true);
                }
                $result[] = $this->newPage($this->nb_page, $this->current == $this->nb_page);
                if($this->current < $end){
                    $result[] = $this->newPage($this->current +1, $this->current == 1, false, "&raquo;");
                }
            }
        }
        return $result;
    }

    /**
     * get the array of pagination in json format
     * @return string pagination'array in json format
     */
    public function getJson():string {
        return json_encode($this->get());
    }

}
