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
     * @param String  $language
     * @return object created with simplexml library
     */
    public function getCities(String $language = "English")
    {
        $params = array(
            "languageid" => \DoTravel\GoldenTour\Model\ResourcesAPI::$goldenTourLanguages[$language]
        );
        //params can be:
        // languageid is a Optional params
        try {
            $result = self::formatResult($this->client->get(
                $this->url . "xml/cities.aspx",
                array(
                "query" => $params,
                )
            ), "xml");
        } catch (\Exception $e) {
            $result = -1;
        }
        return $result;
    }

    /**
     * Returns all categories.
     *
     * @param String $cityID
     * @param String $language
     * @return object created with simplexml library
     */
    public function getCategoriesInCity(String $cityID, String $language = "English")
    {
        $params = array(
                "cityid"=>$cityID,
                "key"=> $this->apiKey,
                "languageid" => \DoTravel\GoldenTour\Model\ResourcesAPI::$goldenTourLanguages[$language]
        );
        //params can be:
        // cityid The unique identifier of the City you wish to retrieve cityid from, the identifier is found in cities.aspx.
        //key Pass agent's key.
        //languageid The unique identifier of the Language that you find from below table. This is optional.
        $result = self::formatResult($this->client->get(
            $this->url . "/xml/categories.aspx",
            array(
            "query" => $params,
            )
        ), "xml");
        return $result;
    }
    /**
     * Returns list of all products in a given category.
     *
     * @param String $categoryID
     * @param String $currencyCode
     * @param String $from
     * @param String $to
     * @param String $language
     * @return object created with simplexml library
     */
    public function getProductsInCategory(
        String $categoryID,
        String $currencyCode,
        String $from,
        String $to,
        String $language = "English"
    ) {
        $params = array(
                "category_id"=>$categoryID,
                "key"=> $this->apiKey,
                "currencycode"=>$currencyCode,
                "fromdt"=>$from,
                "todt"=>$to,
                "languageid" => \DoTravel\GoldenTour\Model\ResourcesAPI::$goldenTourLanguages[$language]
        );
        
        //params can be:
        // category_id The unique identifier of the category you wish to retrieve products from, the identifier is found in categories.aspx.
        //key Pass agent's key.
        //currencycode Pass currency code.
        //fromdt Pass from date.
        //todt Pass to date.
        //languageid The unique identifier of the Language that you find from below table. This is optional.
        $result = self::formatResult($this->client->get(
            $this->url . "/xml/productlist.aspx",
            array(
            "query" => $params,
            )
        ), "xml");
        return $result;
    }
    /**
     * Returns all information about a given product.
     *
     * @param String $productID
     * @param String $currencyCode
     * @param String $language
     * @return object created with simplexml library
     */
    public function getProductsInfoByID(String $productID, String $currencyCode, String $language = "English")
    {
        $params = array(
                "productid"=>$productID,
                "key"=> $this->apiKey,
                "currencycode"=>$currencyCode,
                "languageid" => \DoTravel\GoldenTour\Model\ResourcesAPI::$goldenTourLanguages[$language]
        );
        
        //params can be:
        // productid The unique identifier of the category you wish to retrieve products from,
        // the identifier is found in categories.aspx.
        //key Pass agent's key.
        //currencycode Pass currency code.
        //contentformat Web description in XML tags can be plain or HTML.
        //If the value is HTML then html tags will be returns with product description.
        //If value is blank or plain then HTML tags will not be returned.
        //languageid The unique identifier of the Language that you find from below table. This is optional.
        $result = self::formatResult($this->client->get(
            $this->url . "/xml/productdetails.aspx",
            array(
            "query" => $params,
            )
        ), "xml");
        return $result;
    }
    /**
     * Returns how many tickets are available for a product on a given date.
     *
     * @param String $productID
     * @param String $day
     * @param String $month
     * @param String $year
     * @param mixed $scheduledID
     * @param mixed $picktimeid
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
        $params = array(
                "productid"=>$productID,
                "key"=> $this->apiKey,
                "day"=>$day,
                "month"=>$month,
                "year"=>$year,
                "scheduleid" => $scheduledID,
                "picktimeid"=> $picktimeid
        );
        //params can be:
        // productid The unique identifier of the category you wish to retrieve products from,
        // the identifier is found in categories.aspx.
        //key Pass agent's key.
        //day The day that you wish to check availability for, 1-31.

        //month The month that you wish to check availability for, 1-12.

        //year The year that you wish to check availability for.
        //scheduleid Optional,The unique identifier of schedule for the product you wish to retrieve availability,
        //the identifier is found in Product Detail.
        //picktimeid For Shuttle Product only,
        //The unique identifier of pickup time for the Shuttle transfer product you wish to retrieve availability,
        //the identifier is found in Product Detail.
        $result = self::formatResult($this->client->get(
            $this->url . "/xml/availability.aspx",
            array(
            "query" => $params,
            )
        ), "xml");
        return $result;
    }
    /**
     * Returns all products within a search.
     *
     * @param String $searchText
     * @param String $cityID
     * @param String $currencyCode
     * @param String $language
     * @return object created with simplexml library
     */
    public function searchProductsByCityID(
        String $searchText,
        String $cityID,
        String $currencyCode,
        String $language = "English"
    ) {
        $params = array(
                "cityid"=>$cityID,
                "key"=> $this->apiKey,
                "currencycode" => $currencyCode,
                "searchtext" => $searchText,
                "languageid" =>  \DoTravel\GoldenTour\Model\ResourcesAPI::$goldenTourLanguages[$language]
            );
        
        //params can be:
        //cityid The unique identifier of the City you wish to retrieve cityid from,
        //the identifier is found in cities.aspx.
        //key Pass agent's key.
        //searchtext The purpose of searchtext is to search products with any text as you supply.
        //currencycode Pass currency code.
        //languageid The unique identifier of the Language that you find from below table. This is optional.
        $result = self::formatResult($this->client->get(
            $this->url . "/xml/search.aspx",
            array(
            "query" => $params,
            )
        ), "xml");
        return $result;
    }
    /**
     * To reserve the pax for any product through xml.
     *
     * @param String $productID
     * @param String $agentID
     * @param String $travelDate
     * @param String $scheduleID
     * @param String $lockPAX
     * @return object created with simplexml library
     */
    public function paxReservation(
        String $productID,
        String $agentID,
        String $travelDate,
        String $scheduleID,
        String $lockPAX
    ) {
        $body = array(
                "productid"=>$productID,
                "key"=> $this->apiKey,
                "agentid" => $agentID,
                "traveldate" => $travelDate,
                "scheduleid" =>$scheduleID,
                "lockpax" =>$lockPAX,
            );
        
        //params can be:
        //productid The unique identifier of the product you wish to retrieve paxreservation, the identifier is found in productlist.aspx.
        // agentid Pass agent's id.
        //key Pass agent's key.
        //traveldate Format of travel date should be dd/MM/yyyy.(When product type is add on and flag allowed date is 'N' then it is not required. Also in attraction Open Dated ticket it is not required.)
        //scheduleid Required,The unique identifier of schedule for the product you wish to retrieve paxreservation, the identifier is found in Product Detail.
        //lockpax The number of total pax that you wish to reserve.
        
        $result = self::formatResult($this->client->post(
            $this->url . "/xml/paxreservation.aspx",
            array(
            "form_params" => $body,
            )
        ), "xml");
        return $result;
    }
    /**
     * Guide for booking through xml.
     *
     * @param String $agentID
     * @param array $customerINFO
     * @param array $productINFO
     * @param String $currencyCode
     * @param String $paymentMode
     * @param array $cardPaymentINFO
     * @param String $securitykeyMETHOD
     * @param String $flagPriceDisplay
     * @param String $flagCreditCardEncrypted
     * @param [type] $data
     * @return object created with simplexml library or json encoded
     */
    public function makeBooking(
        String $agentID,
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
        //body to post is:
        //Booking Top level container element.
        // agentid Unique ID of agent which is assigned. It is required field (Only integer value is accepted).
        //key XML key of agent which is assigned. It is required field.
        //customer Container of all the details of Customer. It is required field.
        //START CONTENTS INSIDE CUSTOMER
        //title The title of Customer like Mr., Miss., Dr. etc. It is required field.
        //firstName The first name of customer. It is required field.
        //lastName The last name of customer. It is required field.
        //email The Email address of customer. It is required field.
        //address1 The address 1 of customer. It is required field.
        //address2 The address 2 of customer.
        //city The city of customer. It is required field.
        //county The county of customer.
        //postCode The post Code where customer lives. It is required field.
        //countryCode The code of country where customer lives.
        //mobile The mobile number of customer.
        //<flagnewsLetter> If customer wants to receive newsletter send 'Y' for yes else 'N' for no.
        //<sendEmail> If customer wants an Email of Booking then send 'Y' or 'Yes' else 'N' or 'No'.
        //END CONTENTS INSIDE CUSTOMER
        //<productInfo> The main container where products will be there inside this container.
        //START CONTENTS INSIDE PRODUCT INFO
        //<product> The container where all the details of product will be passed.
        //START CONTENTS INSIDE PRODUCT
        //<ticketRefNumber> If ticketRefNumber will be inserted then this ticket number will be used otherwise it will be generated automatically.
        //<travelDate> Format of travel date should be dd/MM/yyyy.(When product type is add on and flag allowed date is 'N' then it is not required. Also in attraction Open Dated ticket it is not required.)
        //<productId> Unique Id assigned to product. Please see (productdetails.aspx).
        //<scheduleId> Unique Id of schedule. Please see (productdetails.aspx).
        //<pickuptimeId> The unique Id of Pick up and Time which is selected. Please see (productdetails.aspx).
        //<droppointId> The unique Id of Drop Point which is selected. It required to pass for Shuttle Transfer Type Product.
        //<paxtoken> The pax token which will received by paxreservation API product wise.
        //<referenceNumber> Pass reference number.It is not required field.
        //<otherRequirement> The special requirement of customer for the product selected.
        //<nights> In case of only 'Hotel' product type it is required field.
        //<promotionalCode> The promotional code of the customer.
        //<paxInfo> The main container of all the pax(s).
        //<unit> The container which will contain the unitId and paxCount.
        //<unitId> unitId is the unique Id of each price unit (Adult, Child, etc.). Please see (productdetails.aspx). It is required field.
        //<paxCount> The quantity of each unit. It is required field (Only integer value is accepted).
        //<transferInfo> When product type is transfer then this container is required and all the tags inside the tag are required.
        //<airlineName> Name of airline.
        //<flightNumber> Number of flight.
        //<transferTime> Time of transfer. Format of time should be HH:MM AM/PM (For Shuttle type transfer product)
        //<hotelName> Name of hotel.
        //<hotelAddress> Address of hotel.
        //<postCode> Postcode of hotel.
        //<mobile> Mobile number of Customer.
        //<origin> Origin.
        //<destination> Destination.
        //<greetingName> The name of person which is to be transferred.
        //END CONTENTS INSIDE PRODUCT
        //END CONTENTS INSIDE PRODUCT INFO
        //<currencyCode> Pass any currency code from following table.
        //<paymentMode> 'C' or 'A' (C = Credit card and A = On Account).
        //<cardPayment> The container tag which will contain all the credit card information. Required field in case of credit card.
        //START CONTENTS INSIDE CardPayment
        //<nameOnCard> Name which is on credit card.
        //<cardNumber> Credit Card Number.
        //<cardType> Enter any type from following table.
        //<expiryDate> Expiry date of credit card in mm/yyyy format.
        //<issueNumber> Issue number of credit card.
        //<cardVerificationNumber> Card Verification number of credit card.
        //<enabled3DSecure> 'Y' or 'N' (Y = 3DEnroll for transaction and N = No 3DEnroll for transaction ).
        //<response3DURL> Website address where should be redirection performed from bank's website after 3DEnroll. This address must be XML agent's website URL.
        //END CONTENTS INSIDE CardPayment
        //<flagPriceDisplay> 'Y' or 'N' (Y = Display price in ticket and N = Hide price in ticket).
        //<flagCreditCardEncrypted> 'Y' or 'N' (Y = If credit card details are encrypted and N = If credit card details are not encrypted).
        
        if (!isset($data)) {
            $data = array(
                "Booking"=> array(
                    "agentid" => $agentID,
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
        $result = self::formatResult($this->client->post(
            $this->url . "/xml/booking.aspx",
            array(
            "form_params" => $body,
            )
        ), "xml");
        return $result;
    }
    /**
     * Get product open dates.
     *
     * @param String $productID
     * @param String $status
     * @param String $from
     * @param String $to
     * @return object created with simplexml library
     */
    public function getOpenedDaysInfo(String $productID, String $status, String $from, String $to)
    {
        $params = array(
                "productid"=>$productID,
                "key"=> $this->apiKey,
                "status" => $status,
                "fromdt" => $from,
                "todt" => $to
            );
        
        //params can be:
        //productid The unique identifier of the product you wish to retrieve,
        //the identifier is found in productlist.aspx.
        //key string Pass agent's key.
        //status string "OPEN" or "CLOSE" use to get open dates or close dates.
        //fromdt dd/MM/yyyy Pass from date.
        //todt dd/MM/yyyy Pass to date.

        $result = self::formatResult($this->client->get(
            $this->url . "/xml/getproductdates.aspx",
            array(
            "query" => $params,
            )
        ), "xml");
        return $result;
    }
    /**
     * Get product open dates with schedules and availability information.
     *
     * @param String $productID
     * @param String $status
     * @param String $from
     * @param String $to
     * @return object created with simplexml library
     */
    public function getBookingDaysInfo(String $productID, String $status, String $from, String $to)
    {
        $params = array(
                "productid"=>$productID,
                "key"=> $this->apiKey,
                "status" => $status,
                "fromdt" => $from,
                "todt" => $to
            );
        
        //params can be:
        //productid The unique identifier of the product you wish to retrieve,
        //the identifier is found in productlist.aspx.
        //key string Pass agent's key.
        //status string "OPEN" or "CLOSE" use to get open dates or close dates.
        //fromdt dd/MM/yyyy Pass from date.
        //todt dd/MM/yyyy Pass to date.

        $result = self::formatResult($this->client->get(
            $this->url . "/xml/getbookingdates.aspx",
            array(
            "query" => $params,
            )
        ), "xml");
        return $result;
    }
    /**
     * Returns list of all products from a given xml key.
     *
     * @param String $showALL
     * @param String $languageid
     * @return object created with simplexml library
     */
    public function getProductsInAllowedByKey(String $showALL = "Y", String $languageid = "English")
    {
        $params = array(
                "showallproduct"=>$showALL,
                "key"=> $this->apiKey,
                "languageid" => ResourcesAPI::$goldenTourLanguages[$languageid],
            );
        //params can be:
        //key string Pass agent's key.
        //showallproduct string If value is "Y" then it will return subproducts list also. This is optional.
        //languageid integer The unique identifier of the Language that you find from below table. This is optional.

        $result = self::formatResult($this->client->get(
            $this->url . "/xml/productidlist.aspx",
            array(
            "query" => $params,
            )
        ), "xml");
        return $result;
    }
    /**
     * Returns all reviews about a given product.
     *
     * @param String $productID
     * @return object created with simplexml library
     */
    public function getReviewsByProductID(String $productID)
    {
        $params = array(
                "productid"=>$productID,
                "key"=> $this->apiKey,
        );
        //params can be:
        //key string Pass agent's key.
        //productid The unique identifier of the product you wish to retrieve, the identifier is found in productlist.aspx.

        $result = self::formatResult($this->client->get(
            $this->url . "/xml/getproductreviews.aspx",
            array(
            "query" => $params,
            )
        ), "xml");
        return $result;
    }
    /**
     * Returns all available and block pickup points about a given product.
     *
     * @param String $productID
     * @return object created with simplexml library
     */
    public function blockPickUpPoint(String $productID)
    {
        $params = array(
                "productid"=>$productID,
                "key"=> $this->apiKey,
        );
        //params can be:
        //key string Pass agent's key.
        //productid The unique identifier of the product you wish to retrieve, the identifier is found in productlist.aspx.

        $result = self::formatResult($this->client->get(
            $this->url . "/xml/blockpickuppoint.aspx",
            array(
            "query" => $params,
            )
        ), "xml");
        return $result;
    }
    /**
     * Guide to check validity of voucher.
     *
     * @param String $ticketNumber
     * @param String $version
     * @param string $command
     * @param mixed $commandParameters
     * @return object created with simplexml library
     */
    public function validateTicketIP(
        String $ticketNumber,
        String $version = "1.0.0",
        String $command = "ValidateTicket",
        mixed $commandParameters = null
    ) {
        $body = \DoTravel\GoldenTour\Utils\XMLSerializer::generateValidXmlFromArray(
            array(
            "request"=> array(
                "version"=>$version,
                "key"=> $this->apiKey,
                "account_id" => $this->accountID,
                "terminal_id"=> $this->terminalID,
                "timestamp" => date("YYYY-MM-DD HH:ii:ss"),
                "command" => $command,
                "ticket_number" => $ticketNumber
                )
            )
        );
        //params can be:
        //key string Pass agent's key.
        //version string Pass agent's account id in GoldenTours system.

        //account_id string Pass agent's account id in GoldenTours system.
        //terminal_id string Pass agent's id of terminal making request on GoldenTours system.
        //timestamp Date Time Request's unique timestamp in YYYY-MM-DD HH:mm:ss format
        //command string The requested command name. (ValidateTicket)
        //command_parameters (N/A) Container tag of command parameters
        //ticket_number String Golden Tours' Voucher Number (Ticket Reference Number).

        $result = self::formatResult($this->client->post(
            $this->url . "/process/datatraxvoucher.aspx",
            array(
                "form_params" => $body,
            )
        ), "xml");
        return $result;
    }
    /**
     * Guide to redeem a voucher.
     *
     * @param array $vouchersNumbers
     * @param String $version
     * @param String $command
     * @param String $comment
     * @param Int $selectedBus
     * @return object created with simplexml library
     */
    public function redeemVoucherAPI(
        array $vouchersNumbers,
        String $version = "1.0.0",
        String $command = "RedeemVoucher",
        String $comment = null,
        Int $selectedBus = null
    ) {
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
        //params can be:
        //key string Pass agent's key.
        //version string API Version of request. (Current API version is 1.00.00)
        //account_id string Pass agent's account id in GoldenTours system.
        //terminal_id string Pass agent's id of terminal making request on GoldenTours system.
        //timestamp datetime Request's unique timestamp in YYYY-MM-DD HH:mm:ss format
        //command string The requested command name. (RedeemVoucher)
        //comment string (Optional) User comment from redemption terminal
        //selectedbus integer (Optional) The bus id of selected bus.
        //command_parameters (N/A) Container tag of command parameters
        //voucher_numbers (N/A) Contains a list of of one or more voucher_number nodes.
        // Each node represents the number of a voucher entered in the redeem transaction.
        //See voucher_number node table for details.
        //voucher_number String An identifier for a voucher to be redeemed.

        $result = self::formatResult($this->client->post(
            $this->url . "/process/datatraxvoucher.aspx",
            array(
                "form_params" => $body,
            )
        ), "xml");
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
        
        $result = self::formatResult($this->client->get(
            $this->url . "/xml/languages.aspx"
        ), "xml");
        return $result;
    }
}
