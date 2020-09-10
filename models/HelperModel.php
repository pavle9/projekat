<?php
/**
 * Created by Pavle Poljcic.
 * User: pavle
 * Date: 8/30/18
 * Time: 10:30 PM
 */

/**
 * Class HelperModel - class for
 */
class HelperModel
{
    /**
     * Function for checking is it ajax request
     */
    public static function isAjax()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest')
        {
            return true;
        }
        else
            return false;
    }

    /**
     * Function for setting pagnation parameters
     */
    public static function paginationParameters($pg,$pageNumber, $pageSize, $totalRecords, $default_url, $pagination_url)
    {
        $pg->pagenumber = $pageNumber;
        $pg->pagesize = $pageSize;
        $pg->totalrecords = $totalRecords;
        $pg->showfirst = true;
        $pg->showlast = true;
        $pg->paginationcss = "pagination";
        $pg->paginationstyle = 1; // 1: advance, 0: normal
        $pg->defaultUrl = $default_url;
        $pg->paginationUrl = $pagination_url;
        return $pg;
    }
}
