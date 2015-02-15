<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

if(isset($_GET["street_address"]) && isset($_GET["city"]) && isset($_GET["state"])) 
{
    date_default_timezone_set('America/Los_Angeles');

    $getstreet = $_GET["street_address"];
    $getcity = $_GET["city"];
    $getstate = $_GET["state"];

    $url = "http://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id=X1-ZWz1dxgc822nez_4lr3d&address=".urlencode($getstreet)."&citystatezip=".urlencode($getcity)."%2C+".urlencode($getstate)."&rentzestimate=true";

    $xml = simplexml_load_file($url);

    $convertArray = array();

    $convertArray['code']=(string)$xml->message->code;

    if($xml->message->code != 0)
    {

        $convertArray['text']=(string)$xml->message->text;
        echo json_encode($convertArray);
        exit(0);
    }

    $link=$xml->response->results->result->links->homedetails;

    $convertArray['homedetails']=(string)$link;

    $convertArray['street']=(string)$xml->response->results->result->address->street;
    $convertArray['city']= (string)$xml->response->results->result->address->city;
    $convertArray['state']=(string)$xml->response->results->result->address->state;

    if($xml->response->results->result->address->zipcode=="")
        $convertArray['zipcode']="N/A";
    else
        $convertArray['zipcode']= (string)$xml->response->results->result->address->zipcode;

    if($xml->response->results->result->links->address->latitude=="")
        $convertArray['latitude']="N/A";
    else
        $convertArray['latitude']= (string)$xml->response->results->result->links->address->latitude;


    if($xml->response->results->result->links->address->longitude=="")
        $convertArray['longitude']="N/A";
    else
        $convertArray['longitude']= (string)$xml->response->results->result->links->address->longitude;


    if($xml->response->results->result->useCode=="")
        $convertArray['useCode']="N/A";
    else
        $convertArray['useCode']=(string)$xml->response->results->result->useCode;


    if($xml->response->results->result->lastSoldPrice=="")
        $convertArray['lastSoldPrice']="N/A";
    else
        $convertArray['lastSoldPrice']=(string)'$'.number_format(floatval($xml->response->results->result->lastSoldPrice),2,'.',',');


    if($xml->response->results->result->yearBuilt=="")
        $convertArray['yearBuilt']="N/A";
    else
        $convertArray['yearBuilt']=(string)$xml->response->results->result->yearBuilt;


    if($xml->response->results->result->lastSoldDate=="")
        $convertArray['lastSoldDate']="N/A";
    else
        $convertArray['lastSoldDate']=(string)date('d-M-Y',strtotime($xml->response->results->result->lastSoldDate));


    if($xml->response->results->result->lotSizeSqFt=="")
        $convertArray['lotSizeSqFt']="N/A";
    else
        $convertArray['lotSizeSqFt']= (string)number_format(floatval($xml->response->results->result->lotSizeSqFt))." sq. ft.";


    if($xml->response->results->result->zestimate->{'last-updated'}=="")
        $convertArray['estimateLastUpdate']="N/A";
    else
        $convertArray['estimateLastUpdate']=(string)date('d-M-Y',strtotime($xml->response->results->result->zestimate->{'last-updated'}));


    if($xml->response->results->result->zestimate->amount=="")
        $convertArray['estimateAmount']="N/A";
    else
        $convertArray['estimateAmount']= (string)'$'.number_format(floatval($xml->response->results->result->zestimate->amount),2,'.',',');


    if($xml->response->results->result->finishedSqFt=="")
        $convertArray['finishedSqFt']="N/A";
    else
        $convertArray['finishedSqFt']=(string)number_format(floatval($xml->response->results->result->finishedSqFt))." sq. ft.";


    if($xml->response->results->result->zestimate->valueChange=="")
        $convertArray['estimateValueChange']="N/A";
    else
    {
        if($xml->response->results->result->zestimate->valueChange>0)
        {
            $convertArray['estimateValueChangeSign']="+";    
            $convertArray['imgp']="http://cs-server.usc.edu:20843/up_g.gif";
            $convertArray['estimateValueChange']=(string)'$'.number_format(floatval($xml->response->results->result->zestimate->valueChange),2,'.',',');   
        }
        else
        {
            $convertArray['estimateValueChangeSign']="-";    
            $convertArray['imgp']="http://cs-server.usc.edu:20843/down_r.gif";
            $convertArray['estimateValueChange']=(string)'$'.number_format(floatval(-$xml->response->results->result->zestimate->valueChange),2,'.',',');
        }
    }


    if($xml->response->results->result->bathrooms=="")
        $convertArray['bathrooms']="N/A";
    else
        $convertArray['bathrooms']=(string)$xml->response->results->result->bathrooms;

    if($xml->response->results->result->zestimate->valuationRange->low=="") 
        $convertArray['estimateValuationRangeLow']="N/A";
    else
        $convertArray['estimateValuationRangeLow']=(string)'$'.number_format(floatval($xml->response->results->result->zestimate->valuationRange->             low),2,'.',',').' - $';


    if($xml->response->results->result->zestimate->valuationRange->high=="") 
        $convertArray['estimateValuationRangeHigh']="";
    else
        $convertArray['estimateValuationRangeHigh']=(string) number_format(floatval($xml->response->results->result->zestimate->valuationRange->           high),2,'.',',');

    if($xml->response->results->result->bedrooms=="")
        $convertArray['bedrooms']="N/A";
    else
        $convertArray['bedrooms']=(string)$xml->response->results->result->bedrooms;


    if($xml->response->results->result->rentzestimate->{'last-updated'}=="")
        $convertArray['restimateLastUpdate']="N/A";
    else
        $convertArray['restimateLastUpdate'] = (string)date('d-M-Y',strtotime($xml->response->results->result->rentzestimate->{'last-updated'}));    


    if($xml->response->results->result->rentzestimate->amount=="")
        $convertArray['restimateAmount'] = "N/A";
    else
        $convertArray['restimateAmount']= (string) '$'.(number_format(floatval($xml->response->results->result->rentzestimate->amount),2,'.',','));


    if($xml->response->results->result->taxAssessmentYear=="")
        $convertArray['taxAssessmentYear']="N/A";
    else
        $convertArray['taxAssessmentYear']=(string)$xml->response->results->result->taxAssessmentYear;


    if($xml->response->results->result->rentzestimate->valueChange=="")
        $convertArray['restimateValueChange']="N/A";
    else
    {
        if($xml->response->results->result->rentzestimate->valueChange>0)
        {
            $convertArray['restimateValueChangeSign']="+";
            $convertArray['imgn']="http://cs-server.usc.edu:20843/up_g.gif";
            $convertArray['restimateValueChange']= (string)'$'.number_format(floatval($xml->response->results->result->rentzestimate->valueChange),2,'.',',');         
        }
        else
        {
            $convertArray['restimateValueChangeSign']="-";
            $convertArray['imgn']="http://cs-server.usc.edu:20843/down_r.gif";
            $convertArray['restimateValueChange']= (string)'$'.number_format(floatval(-$xml->response->results->result->rentzestimate->valueChange),2,'.',',');
        }
    }


    if($xml->response->results->result->taxAssessment=="")
        $convertArray['taxAssessment']="N/A";
    else
        $convertArray['taxAssessment']=(string)'$'.number_format(floatval($xml->response->results->result->taxAssessment),2,'.',',');


    if($xml->response->results->result->rentzestimate->valuationRange->low=="") 
        $convertArray['restimateValuationRangeLow']="N/A";
    else
        $convertArray['restimateValuationRangeLow']= (string) '$'.number_format(floatval($xml->response->results->result->rentzestimate->valuationRange->low),2,'.',',').' - $';

    if($xml->response->results->result->rentzestimate->valuationRange->high=="")
        $convertArray['restimateValuationRangeHigh']="N/A";
    else
        $convertArray['restimateValuationRangeHigh']= (string) number_format(floatval($xml->response->results->result->rentzestimate->valuationRange->high),2,'.',',');


    $append=$xml->response->results->result->zpid;
    $convertArray['graph1']="http://www.zillow.com/app?chartDuration=1year&chartType=partner&height=300&page=webservice%2FGetChart&service=chart&showPercent=true&width=600&zpid=".$append;
    $convertArray['graph2']="http://www.zillow.com/app?chartDuration=5years&chartType=partner&height=300&page=webservice%2FGetChart&service=chart&showPercent=true&width=600&zpid=".$append;
    $convertArray['graph3']="http://www.zillow.com/app?chartDuration=10years&chartType=partner&height=300&page=webservice%2FGetChart&service=chart&showPercent=true&width=600&zpid=".$append;

    echo json_encode($convertArray);
}

?>