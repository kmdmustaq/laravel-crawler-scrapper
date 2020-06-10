<?php

namespace App\Http\Library;

use App\Crawler;

class CrawlerLibrary {

    /**
     * Method to update the satus if it is scrapped or not.accordion
     * 
     * @param $id
     */
    public function scrapped($id)
    {
        $crawl = Crawler::find($id);

        $crawl->is_scrapped = true;
        $crawl->save();
    }

    /**
     * Method to fetch all the records from App\Crawler Model.
     * 
     * @return EloquentCollection object.
     */
    public function getCrawlabuls()
    {
        return Crawler::where('is_scrapped', 0)->get();
    }
}