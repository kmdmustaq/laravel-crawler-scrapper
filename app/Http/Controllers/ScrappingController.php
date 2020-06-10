<?php

namespace App\Http\Controllers;

use App\Crawler;
use App\Http\Library\CompanyInfoLibrary;
use App\Http\Library\ContactLibrary;
use App\Http\Library\CrawlerLibrary;
use App\Http\Library\DirectorLibrary;
use App\Http\Library\IndustryClassLibrary;
use App\Http\Library\ListingsAndComplainsLibrary;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ScrappingController extends Controller
{
    public $crawler = null;
    public $company = null;

    /**
     * Method is to do web scrapping of all the possible linkes from the App\Crawler model
     * 
     * @return json response 
     * 
     */
    public function doWebscrapping()
    {
        // Instantiating Goutte & Guzzle clients
        $goutteClient = new Client();
        $guzzleClient = new GuzzleClient(array(
            'timeout' => 60,
            'verify' => false
        ));
        
        // Setting the Guzzle client objects to goutte client
        $goutteClient->setClient($guzzleClient);

        
        // $url = 'http://www.mycorporateinfo.com/business/kamdhenu-engineering-industries-ltd';
        // $url ='http://www.mycorporateinfo.com/business/asian-flora-limited';
        
        // Fetting the records present in the Crawler model for scrapping
        $crawlerData = (new CrawlerLibrary)->getCrawlabuls();
        $scrapped = 0;

        // Looping of crawler data.
        foreach ($crawlerData as $crawl) {
            
            $url = $crawl->url;
            
            // Getting the DOM object of the requested url (Get url)
            $this->crawler = $goutteClient->request('GET', $url);
            
            // Scrapping the company info.
            $this->scrappingCompany($url);

            // Scrapping the Contact info. the company
            $this->scrappingContact();

            // Scrapping the Industry classification info. the company
            $this->scrappingIndustryClassification();

            // Scrapping the Listing an complains info. the company
            $this->scrappingListingsAndAnnualComplainceDetails();

            // Scrapping the info. of Directors of the company
            $this->scrappingDirectors();

            // Updating the statues of the link.
            (new CrawlerLibrary)->scrapped($crawl->id);
            
            $scrapped++;
        }

        return response()->json([
            'data' => [
                    'Total_urls' => $crawlerData->count(),
                    'Scrapped_urls' => $scrapped,
                    'messgae' => 'Success'
                ]
        ], 200);
    }

    /**
     * Method to scrap the company details and persist it into the table.
     * 
     * @param String $url
     * 
     */
    private function scrappingCompany($url)
    {
        // Check for the specified css id and css class present in the DOM object.
        if ($this->crawler->filter('#companyinformation .greenishcolor')->count()) {
            
            // Get the data from the html table.
            $data = $this->scrapTableInfo('#companyinformation');

            $companyInfo = new CompanyInfoLibrary;
            
            // Parsing the scrapped data $data to a proper format to persist. 
            $parsedCompanyInfo = $companyInfo->parse($data);
            $parsedCompanyInfo['url'] = $url;
            
            // Storing the scrapped and parsed data into table
            $this->company = $companyInfo->store($parsedCompanyInfo);
        }
    }

    /**
     * Method to scrap the contact details and persist it into the table. 
     */
    private function scrappingContact()
    {
        // Check for the specified css id and css class present in the DOM object.
        if ($this->crawler->filter('#contactdetails .greenishcolor')->count()) {
            
            // Get the data from the html table.
            $contactData = $this->scrapTableInfo('#contactdetails');

            $contact = new ContactLibrary;

            // Parsing the scrapped data $data to a proper format to persist. 
            $parsedContact = $contact->parse($contactData);

            // Check for the specified css id and css class present in the DOM object to scrap location info.
            if ($this->crawler->filter('#otherinformation .greenishcolor')->count()) {
                
                // Get the data from the html table.
                $locationData = $this->scrapTableInfo('#otherinformation');
                
                // Parsing the scrapped data $data to a proper format to persist.
                $parsedLocation = $contact->parseLocation($locationData);
                $parsedContact = array_merge($parsedContact, $parsedLocation);
            }

            $parsedContact['company_infos_id'] = $this->company->id;

            // Storing the scrapped and parsed data into table
            $contact->store($parsedContact);
        }
    }

    /**
     * Method to scrap the contact details and persist it into the table. 
     */
    private function scrappingIndustryClassification()
    {
        // Check for the specified css id and css class present in the DOM object.
        if ($this->crawler->filter('#industryclassification .greenishcolor')->count()) {

            // Get the data from the html table.
            $data = $this->scrapTableInfo('#industryclassification');
            $industryInfo = new IndustryClassLibrary;

            // Parsing the scrapped data $data to a proper format to persist. 
            $parsedIndustryInfo = $industryInfo->parse($data);
            $parsedIndustryInfo['company_infos_id'] = $this->company->id;

            // Storing the scrapped and parsed data into table
            $industryInfo->store($parsedIndustryInfo);
        }
    }

    /**
     * Method to scrap the contact details and persist it into the table. 
     */
    private function scrappingListingsAndAnnualComplainceDetails()
    {
        // Check for the specified css id and css class present in the DOM object.
        if ($this->crawler->filter('#listingandannualcomplaincedetails .greenishcolor')->count()) {

            // Get the data from the html table.
            $data = $this->scrapTableInfo('#listingandannualcomplaincedetails');
            $industryInfo = new ListingsAndComplainsLibrary;

            // Parsing the scrapped data $data to a proper format to persist.
            $parsedIndustryInfo = $industryInfo->parse($data);
            $parsedIndustryInfo['company_infos_id'] = $this->company->id;

            // Storing the scrapped and parsed data into table.
            $industryInfo->store($parsedIndustryInfo);
        }
    }

    /**
     * Method to scrap the contact details and persist it into the table. 
     */
    private function scrappingDirectors()
    {
        // Check for the specified css id and css class present in the DOM object.
        if ($this->crawler->filter('#directors .greenishcolor')->count()) {

            // Get the data from the html table.
            $data = $this->scrapTableInfo('#directors');
            array_shift($data);
            
            $headers = Arr::collapse($this->scrapTableHeader('#directors'));
            array_pop($headers);
            
            $directorInfo = new DirectorLibrary;

            // Parsing the scrapped data $data to a proper format to persist.
            $parsedDirectorInfo = $directorInfo->parse($data, $headers, $this->company->id);

            // Storing the scrapped and parsed data into table.
            $directorInfo->store($parsedDirectorInfo);
        }
    }

    /**
     * Method to scrap the info. of orginazation.
     * @param String $cssID css class
     * 
     * @return Array 
     */
    private function scrapTableInfo($cssID)
    {
        // Scrap all the data present in the table>tbody>tr tags and storing into an array
        $data = $this->crawler->filter("$cssID table tbody tr")->each(function($node) {
                return $node->filter('td')->each(function($tr) {
                    return $tr->text();
                });
        });

        return $data;
    }

    /**
     * Method to scrap the info. of orginazation.
     * @param String $cssID css class
     * 
     * @return Array 
     */
    private function scrapTableHeader($cssID)
    {

        // Scrap all the data present in the table>tbody>tr>th tags and storing into an array
        $data = $this->crawler->filter("$cssID table tbody th")->each(function($node) {
                return $node->filter('th')->each(function($th) {
                    return $th->text();
                });
        });

        return $data;
    }
}