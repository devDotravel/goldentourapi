<?php
namespace DoTravel\GoldenTour;

use GuzzleHttp\Client;
use DoTravel\GoldenTour\Interfaces\APIParent;
use DoTravel\GoldenTour\Model\ResourcesAPI;

class RequestAPI extends APIParent
{
    protected $agentID;
    protected $terminalID;
    public function __construct($apiKey, $agentID, $terminalID = "", $url = "http://www.goldentourscoachtours.co.uk/")
    {
        parent::__construct($url, $apiKey);
        $this->agentID = $agentID;
        $this->terminalID = $terminalID;
    }
    /**
     * Returns all cities.
     *
     * @param String  $language is a Optional params
     * @return object created with simplexml library
     */
    public function getCities(String $language = "English")
    {
        $params = array(
            "languageid" => \DoTravel\GoldenTour\Model\ResourcesAPI::$goldenTourLanguages[$language]
        );
        try {
            $result = self::formatResult($this->client->get(
                $this->url . "xml/cities.aspx",
                array(
                "query" => $params,
                )
            ), "xml");
        } catch (\Exception $e) {
            $result["status"] ="error";
            $result["content"] =  $e->getMessage();
        }

        return $result;
    }

    /**
     * Returns all categories.
     *
     * @param String $cityID The unique identifier of the City you wish to retrieve cityid from,
     * @param String $language The unique identifier of the Language that you find from below table. This is optional.
     * @return object created with simplexml library
     */
    public function getCategoriesInCity(String $cityID, String $language = "English")
    {
        try {
            $params = array(
                "cityid"=>$cityID,
                "key"=> $this->apiKey,
                "languageid" => \DoTravel\GoldenTour\Model\ResourcesAPI::$goldenTourLanguages[$language]
            );
            $result = self::formatResult($this->client->get(
                $this->url . "/xml/categories.aspx",
                array(
                    "query" => $params,
                )
            ), "xml");
        } catch (\Exception $e) {
            $result["status"] ="error";
            $result["content"] =  $e->getMessage();
        }
        return $result;
    }
    /**
     * Returns list of all products in a given category.
     *
     * @param String $categoryID The unique identifier of the category you wish to retrieve products from,
     * @param String $currencyCode Pass currency code.
     * @param String $from from date.
     * @param String $to Pass to date.
     * @param String $language The unique identifier of the Language that you find from below table. This is optional.
     * @return object created with simplexml library
     */
    public function getProductsInCategory(
        String $categoryID,
        String $currencyCode,
        String $from,
        String $to,
        String $language = "English"
    ) {
        try {
            $params = array(
                "category_id"=>$categoryID,
                "key"=> $this->apiKey,
                "currencycode"=>$currencyCode,
                "fromdt"=>$from,
                "todt"=>$to,
                "languageid" => \DoTravel\GoldenTour\Model\ResourcesAPI::$goldenTourLanguages[$language]
            );
            $result = self::formatResult($this->client->get(
                $this->url . "/xml/productlist.aspx",
                array(
                    "query" => $params,
                )
            ), "xml");
        } catch (\Exception $e) {
            $result["status"] ="error";
            $result["content"] =  $e->getMessage();
        }
        return $result;
    }
    /**
     * Returns all information about a given product.
     *
     * @param String $productID The unique identifier of the category you wish to retrieve products from,
     * @param String $currencyCode Pass currency code.
     * @param String $language  The unique identifier of the Language that you find from below table. This is optional.
     * @return object created with simplexml library
     */
    public function getProductsInfoByID(String $productID, String $currencyCode, String $language = "English")
    {
        try {
            $params = array(
                "productid"=>$productID,
                "key"=> $this->apiKey,
                "currencycode"=>$currencyCode,
                "languageid" => \DoTravel\GoldenTour\Model\ResourcesAPI::$goldenTourLanguages[$language]
            );
            $result = self::formatResult($this->client->get(
                $this->url . "/xml/productdetails.aspx",
                array(
                    "query" => $params,
                )
            ), "xml");
        } catch (\Exception $e) {
            $result["status"] ="error";
            $result["content"] =  $e->getMessage();
        }
        return $result;
    }
    /**
     * Returns how many tickets are available for a product on a given date.
     *
     * @param String $productID The unique identifier of the category you wish to retrieve products from
     * @param String $day The day that you wish to check availability for, 1-31.
     * @param String $month The month that you wish to check availability for, 1-12.
     * @param String $year The year that you wish to check availability for.
     * @param mixed $scheduledID  Optional,The unique identifier of schedule for the product you wish to retrieve availability,
     * @param mixed $picktimeid For Shuttle Product only,
     * @return object created with simplexml library
     */
    public function getAvailabilityInProduct(
        String $productID,
        String $day,
        String $month,
        String $year,
        $scheduledID = null,
        $picktimeid = null
    ) {
        try {
            $params = array(
                "productid"=>$productID,
                "key"=> $this->apiKey,
                "day"=>$day,
                "month"=>$month,
                "year"=>$year,
                "scheduleid" => $scheduledID,
                "picktimeid"=> $picktimeid
            );
            $result = self::formatResult($this->client->get(
                $this->url . "/xml/availability.aspx",
                array(
                    "query" => $params,
                )
            ), "xml");
        } catch (\Exception $e) {
            $result["status"] ="error";
            $result["content"] =  $e->getMessage();
        }
        return $result;
    }
    /**
     * Returns all products within a search.
     *
     * @param String $searchText The purpose of searchtext is to search products with any text as you supply.
     * @param String $cityID The unique identifier of the City you wish to retrieve cityid from,
     * @param String $currencyCode  Pass currency code.
     * @param String $language The unique identifier of the Language that you find from below table. This is optional.
     * @return object created with simplexml library
     */
    public function searchProductsByCityID(
        String $searchText,
        String $cityID,
        String $currencyCode,
        String $language = "English"
    ) {
        try {
            $params = array(
                "cityid"=>$cityID,
                "key"=> $this->apiKey,
                "currencycode" => $currencyCode,
                "searchtext" => $searchText,
                "languageid" =>  \DoTravel\GoldenTour\Model\ResourcesAPI::$goldenTourLanguages[$language]
            );
            $result = self::formatResult($this->client->get(
                $this->url . "/xml/search.aspx",
                array(
                    "query" => $params,
                )
            ), "xml");
        } catch (\Exception $e) {
            $result["status"] ="error";
            $result["content"] =  $e->getMessage();
        }
        return $result;
    }
    /**
     * To reserve the pax for any product through xml.
     *
     * @param Int $productID The unique identifier of the product you wish to retrieve paxreservation,
     * @param String $travelDate Format of travel date should be dd/MM/yyyy.
     * @param Int $scheduleID Required,
     * @param Int $lockPAX The number of total pax that you wish to reserve.
     * @return object created with simplexml library
     */
    public function paxReservation(
        Int $productID,
        String $travelDate,
        Int $scheduleID,
        Int $lockPAX
    ) {
        try {
            $body = \DoTravel\GoldenTour\Utils\XMLSerializer::generateValidXmlFromArray(array(
                "productid"=>$productID,
                "key"=> $this->apiKey,
                "agentid" => $this->agentID,
                "traveldate" => $travelDate,
                "scheduleid" =>$scheduleID,
                "lockpax" =>$lockPAX,
            ));

            $result = self::formatResult($this->client->post(
                $this->url . "/xml/paxreservation.aspx",
                array(
                    'headers' => [
                        'Content-Type' => 'text/xml; charset=UTF8',
                    ],
                        "body" => $body,
                )
            ), "xml");
        } catch (\Exception $e) {
            $result["status"] ="error";
            $result["content"] =  $e->getMessage();
        }
        return $result;
    }
    /**
     * Guide for booking through xml.
     *
     * @param array $customerINFO
     * @param array $productINFO
     * @param String $currencyCode Pass any currency code from following table.
     * @param String $paymentMode 'C' or 'A' (C = Credit card and A = On Account).
     * @param array $cardPaymentINFO
     * @param String $securitykeyMETHOD
     * @param String $flagPriceDisplay 'Y' or 'N' (Y = Display price in ticket and N = Hide price in ticket).
     * @param String $flagCreditCardEncrypted 'Y' or 'N' (Y = If credit card details are encrypted and N = If credit card details are not encrypted).
     * @param [type] $data
     * @return object created with simplexml library or json encoded
     */
    public function makeBooking(
        array $customerINFO,
        array $productINFO,
        String $currencyCode,
        String $paymentMode,
        array $cardPaymentINFO,
        String $securitykeyMETHOD,
        String $flagPriceDisplay,
        String $flagCreditCardEncrypted,
        mixed $data = null
    ) {
        try {
            if (!isset($data)) {
                $data = array(
                "Booking"=> array(
                    "agentid" => $this->agentID,
                    "key"=> $this->apiKey,
                    "customer"=>$customerINFO,
                    "productInfo"=> $productINFO,
                    "currencycode"=> $currencyCode,
                    "paymentMode"=> $paymentMode,
                    "cardPayment"=> $cardPaymentINFO,
                    "securitykeymethod"=> $securitykeyMETHOD,
                    "flagPriceDisplay"=> $flagPriceDisplay,
                    "flagCreditCardEncrypted"=> $flagCreditCardEncrypted,
                    ),
                );
            }
            if (is_object($data)) {
                $body = \DoTravel\GoldenTour\Utils\XMLSerializer::generateValidXmlFromObj($data);
            } elseif (is_array($data)) {
                $body = \DoTravel\GoldenTour\Utils\XMLSerializer::generateValidXmlFromArray($data);
            }
            $result = self::formatResult($this->client->get(
                $this->url . "/xml/booking.aspx",
                array(
                    'headers' => [
                        'Content-Type' => 'text/xml; charset=UTF8',
                    ],
                        "body" => $body,
                    )
            ), "xml");
        } catch (\Exception $e) {
            $result["status"] ="error";
            $result["content"] =  $e->getMessage();
        }
        return $result;
    }
    /**
     * Get product open dates.
     *
     * @param String $productID The unique identifier of the product you wish to retrieve,
     * @param String $status string "OPEN" or "CLOSE" use to get open dates or close dates.
     * @param String $from Pass from date.
     * @param String $to Pass from date.
     * @return object created with simplexml library
     */
    public function getOpenedDaysInfo(String $productID, String $status, String $from, String $to)
    {
        try {
            $params = array(
                "productid"=>$productID,
                "key"=> $this->apiKey,
                "status" => $status,
                "fromdt" => $from,
                "todt" => $to
            );
            $result = self::formatResult($this->client->get(
                $this->url . "/xml/getproductdates.aspx",
                array(
                        "query" => $params,
                )
            ), "xml");
        } catch (\Exception $e) {
            $result["status"] ="error";
            $result["content"] =  $e->getMessage();
        }
        return $result;
    }
    /**
     * Get product open dates with schedules and availability information.
     *
     * @param String $productID The unique identifier of the product you wish to retrieve,
     * @param String $status string "OPEN" or "CLOSE" use to get open dates or close dates.
     * @param String $from dd/MM/yyyy Pass from date.
     * @param String $to dd/MM/yyyy Pass to date.
     * @return object created with simplexml library
     */
    public function getBookingDaysInfo(String $productID, String $status, String $from, String $to)
    {
        try {
            $params = array(
                "productid"=>$productID,
                "key"=> $this->apiKey,
                "status" => $status,
                "fromdt" => $from,
                "todt" => $to
            );

            $result = self::formatResult($this->client->get(
                $this->url . "/xml/getbookingdates.aspx",
                array(
                "query" => $params,
                )
            ), "xml");
        } catch (\Exception $e) {
            $result["status"] ="error";
            $result["content"] =  $e->getMessage();
        }
        return $result;
    }
    /**
     * Returns list of all products from a given xml key.
     *
     * @param String $showALL string If value is "Y" then it will return subproducts list also. This is optional.
     * @param String $languageid integer The unique identifier of the Language that you find from below table. This is optional.
     * @return object created with simplexml library
     */
    public function getProductsInAllowedByKey(String $showALL = "Y", String $languageid = "English")
    {
        try {
            $params = array(
                "showallproduct"=>$showALL,
                "key"=> $this->apiKey,
                "languageid" => ResourcesAPI::$goldenTourLanguages[$languageid],
            );
            $result = self::formatResult($this->client->get(
                $this->url . "/xml/productidlist.aspx",
                array(
                        "query" => $params,
                )
            ), "xml");
        } catch (\Exception $e) {
            $result["status"] ="error";
            $result["content"] =  $e->getMessage();
        }
        return $result;
    }
    /**
     * Returns all reviews about a given product.
     *
     * @param String $productID The unique identifier of the product you wish to retrieve, the identifier is found in productlist.aspx.
     * @return object created with simplexml library
     */
    public function getReviewsByProductID(String $productID)
    {
        try {
            $params = array(
                "productid"=>$productID,
                "key"=> $this->apiKey,
            );

            $result = self::formatResult($this->client->get(
                $this->url . "/xml/getproductreviews.aspx",
                array(
                        "query" => $params,
                )
            ), "xml");
        } catch (\Exception $e) {
            $result["status"] ="error";
            $result["content"] =  $e->getMessage();
        }
        return $result;
    }
    /**
     * Returns all available and block pickup points about a given product.
     *
     * @param String $productID The unique identifier of the product you wish to retrieve, the identifier is found in productlist.aspx.
     * @return object created with simplexml library
     */
    public function blockPickUpPoint(String $productID)
    {
        try {
            $params = array(
                "productid"=>$productID,
                "key"=> $this->apiKey,
            );

            $result = self::formatResult($this->client->get(
                $this->url . "/xml/blockpickuppoint.aspx",
                array(
                        "query" => $params,
                )
            ), "xml");
        } catch (\Exception $e) {
            $result["status"] ="error";
            $result["content"] =  $e->getMessage();
        }
        return $result;
    }
    /**
     * Guide to check validity of voucher.
     *
     * @param String $ticketNumber Golden Tours' Voucher Number (Ticket Reference Number).
     * @param String $version APIVersion
     * @param string $command The requested command name. (ValidateTicket)
     * @param mixed $commandParameters Container tag of command parameters
     * @return object created with simplexml library
     */
    public function validateTicketIP(
        String $ticketNumber,
        String $version = "1.0.0",
        String $command = "ValidateTicket",
        mixed $commandParameters = null
    ) {
        try {
            $body = \DoTravel\GoldenTour\Utils\XMLSerializer::generateValidXmlFromArray(
                array(
                    "request"=> array(
                        "version"=>$version,
                        "key"=> $this->apiKey,
                        "account_id" => $this->accountID,
                        "terminal_id"=> $this->terminalID,
                        "timestamp" => date("YYYY-MM-DD HH:ii:ss"),
                        "command" => $command,
                        "ticket_number" => $ticketNumber,
                        "command_parameters" => $commandParameters
                    )
                )
            );
            $result = self::formatResult($this->client->post(
                $this->url . "/process/datatraxvoucher.aspx",
                array(
                    "form_params" => $body,
                )
            ), "xml");
        } catch (\Exception $e) {
            $result["status"] ="error";
            $result["content"] =  $e->getMessage();
        }
        return $result;
    }
    /**
     * Guide to redeem a voucher.
     *
     * @param array $vouchersNumbers An identifier for a voucher to be redeemed.
     * @param String $version API version
     * @param String $command The requested command name. (RedeemVoucher)
     * @param String $comment  User comment from redemption terminal
     * @param Int $selectedBus  The bus id of selected bus.
     * @return object created with simplexml library
     */
    public function redeemVoucherAPI(
        array $vouchersNumbers,
        String $version = "1.0.0",
        String $command = "RedeemVoucher",
        String $comment = null,
        Int $selectedBus = null
    ) {
        try {
            $body = \DoTravel\GoldenTour\Utils\XMLSerializer::generateValidXmlFromArray(
                array(
                    "request"=> array(
                    "version"=>$version,
                    "key"=> $this->apiKey,
                    "account_id" => $this->accountID,
                    "terminal_id"=> $this->terminalID,
                    "timestamp" => date("YYYY-MM-DD HH:ii:ss"),
                    "command" => $command,
                    "comment" => $comment,
                    "selectedbus"=>$selectedBus,
                        "command_parameters" => array(
                            "voucher_numbers"=> $vouchersNumbers
                        )
                    )
                )
            );
           
            $result = self::formatResult($this->client->post(
                $this->url . "/process/datatraxvoucher.aspx",
                array(
                "form_params" => $body,
                )
            ), "xml");
        } catch (\Exception $e) {
            $result["status"] ="error";
            $result["content"] =  $e->getMessage();
        }
        return $result;
    }
    /**
     * Returns all languages.
     *
     * @return object created with simplexml library
     */
    public function getLanguages()
    {
        //not params needed:
        try {
            $result = self::formatResult($this->client->get(
                $this->url . "/xml/languages.aspx"
            ), "xml");
        } catch (\Exception $e) {
            $result["status"] ="error";
            $result["content"] =  $e->getMessage();
        }
        return $result;
    }
}
