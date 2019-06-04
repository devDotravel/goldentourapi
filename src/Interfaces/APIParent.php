<?php

namespace DoTravel\GoldenTour\Interfaces;

use GuzzleHttp\Client;

class APIParent
{
    protected $url = "";
    protected $apiKey = "";
    protected $client;

    protected function __construct($url = "", $apiKey = "")
    {
        if (!empty($url)) {
            $this->url = $url;
        }

        if (!empty($apiKey)) {
            $this->apiKey = $apiKey;
        }
        $this->client = new Client();
    }

    protected static function formatResult($response, $format = "json")
    {
        try {
            if ($response != -1) {
                $result = self::formatData($response->getBody(), $format);
            } else {
                $result = -1;
            }
        } catch (\Exception $e) {
            $result = -1;
        }

        return $result;
    }

    protected static function formatData($data, $formatTo = "json")
    {
        $result = array("status" => "ok", "content" => null);

        try {
            switch ($formatTo) {
                case "json":
                    $result["content"] = json_decode($data);
                    break;
                case "xml":
                    $dataFormatted = simplexml_load_string($data);
                    if (isset($dataFormatted->error)) {
                        $result["status"] = "error";
                        $result["content"] = $dataFormatted->error;
                    } elseif (isset($dataFormatted->errors)) {
                        $result["status"] = "error";
                        if (isset($dataFormatted->errors)) {
                            foreach ($dataFormatted->errors as $row) {
                                if (isset($row)) {
                                    $result["content"][] = $row->error->description;
                                }
                            }
                        }
                    } else {
                        $result["content"] = $dataFormatted;
                    }
                    break;
            }
        } catch (\Exception $e) {
            $result = -1;
        }
        return $result;
    }

    protected static function formatResultToArray($response)
    {
        if (!is_int($response)) {
            $request = json_decode($response->getBody()->getContents(), true);
            if ($request->requestStatus->success == true) {
                $result = $request;
            } else {
                $result = $request;
            }
        }
        return $result;
    }
}
