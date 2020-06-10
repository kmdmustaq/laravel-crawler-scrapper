<?php

namespace Tests\Browser;

use App\Crawler;
use Exception;
use Facebook\WebDriver\WebDriverBy;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class duskSpiderTest extends DuskTestCase
{
    protected static $domain = 'mycorporateinfo.com';
    protected static $startUrl = 'http://www.mycorporateinfo.com/';


    public function setUp(): void{
        parent::setUp();
        $this->artisan('migrate:fresh'); 
    }

    /** @test */
    public function urlSpider()
    {
        $startingLink = Crawler::create([
            'url' => self::$startUrl,
            'is_crawled' => false,
        ]);

        $this->browse(function (Browser $browser) use ($startingLink) {
            $this->getLinks($browser, $startingLink);
        });
        
        return $this->assertTrue(true);
    }

    protected function getLinks(Browser $browser, $currentUrl){

        $this->processCurrentUrl($browser, $currentUrl);


        try{

            foreach(Crawler::where('is_crawled', false)->get() as $link) {
                $this->getLinks($browser, $link);
            }


        }catch(Exception $e){

        }
    }

    protected function processCurrentUrl(Browser $browser, $currentUrl){

        //Check if already crawled
        if(Crawler::where('url', $currentUrl->url)->first()->is_crawled == true)
            return;

        //Visit URL
        $browser->visit($currentUrl->url);

        //Get Links and Save to DB if Valid
        $linkElements = $browser->driver->findElements(WebDriverBy::tagName('a'));
        foreach($linkElements as $element){
            $href = $element->getAttribute('href');
            $href = $this->trimUrl($href);
            if($this->isValidUrl($href)){
                //var_dump($href);
                Crawler::create([
                    'url' => $href,
                    'is_crawled' => false,
                ]);
            }
        }

        //Update current url status to crawled
        $currentUrl->is_crawled = true;
        $currentUrl->status  = $this->getHttpStatus($currentUrl->url);
        $currentUrl->title = $browser->driver->getTitle();
        $currentUrl->save();
    }


    protected function isValidUrl($url){
        $parsed_url = parse_url($url);

        if(isset($parsed_url['host'])){
            if(strpos($parsed_url['host'], self::$domain) !== false && !Crawler::where('url', $url)->exists()){
                return true;
            }
        }
        return false;
    }

    protected function trimUrl($url){
        $url = strtok($url, '#');
        $url = rtrim($url,"/");
        return $url;
    }

    protected function getHttpStatus($url){
        $headers = get_headers($url, 1);
        return intval(substr($headers[0], 9, 3));
    }
}
