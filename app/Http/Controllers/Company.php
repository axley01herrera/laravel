<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use App\Models\RestFM;
use Illuminate\Http\Request;

class Company extends BaseController
{
    public $fm;

    public function __construct()
    {
        # OBJ MODELS
        $this->fm = new RestFM;
    }

    public function error($result)
    {
        if(isset($result["messages"][0]["code"]))
        {

            if ($result["messages"][0]["code"] == 0)
                return 0;
            elseif($result["messages"][0]["code"] == '401')
                return 401;
            else
                return '('.$result["messages"][0]["code"].') '.$result["messages"][0]["message"];
        }
        else
            return $result;
    }

    public function returnModalEditCompanyInfo()
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        $company = $this->getCompany();

        if($company['error'] == 0)
        {
            $data = array();
            $data['company'] = $company['data'][0];

            return view('app.account.profile.modals.company', $data);
        }
    }

    public function returnModalEditCompanyContactPerson()
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        $company = $this->getCompany();

        if($company['error'] == 0)
        {
            $data = array();
            $data['company'] = $company['data'][0];

            return view('app.account.profile.modals.mainContact', $data);
        }
    }

    public function returnModalEditCompanyBilling()
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        $company = $this->getCompany();

        if($company['error'] == 0)
        {
            $data = array();
            $data['company'] = $company['data'][0];

            return view('app.account.profile.modals.billing', $data);
        }
    }

    public function returnModalEditCompanyShipping()
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        $company = $this->getCompany();

        if($company['error'] == 0)
        {
            $data = array();
            $data['company'] = $company['data'][0];

            return view('app.account.profile.modals.shipping', $data);
        }
    }

    public function updateCompany(Request $request)
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
        {
            $response = array();
            $response['error'] = 1;
            $response['userMsg'] = 'Session Expired';
            
            return json_encode($response);
        }

        $formData = $request->input('post');
        
        $fieldData = array();
        if(isset($formData['name']))$fieldData[$formData['name']['field']] = $formData['name']['value'];
        if(isset($formData['phone']))$fieldData[$formData['phone']['field']] = $formData['phone']['value'];
        if(isset($formData['phoneType']))$fieldData[$formData['phoneType']['field']] = $formData['phoneType']['value'];
        if(isset($formData['email']))$fieldData[$formData['email']['field']] = $formData['email']['value'];
        if(isset($formData['addressLine1']))$fieldData[$formData['addressLine1']['field']] = $formData['addressLine1']['value'];

        if(isset($formData['addressLine2']))
        {
            if(!empty($formData['addressLine2']['value']))
                $fieldData[$formData['addressLine2']['field']] = $formData['addressLine2']['value'];
            else
                $fieldData[$formData['addressLine2']['field']] = '';
        }

        if(isset($formData['zip']))$fieldData[$formData['zip']['field']] = $formData['zip']['value'];
        if(isset($formData['city']))$fieldData[$formData['city']['field']] = $formData['city']['value'];
        if(isset($formData['state']))$fieldData[$formData['state']['field']] = $formData['state']['value'];
        if(isset($formData['country']))$fieldData[$formData['country']['field']] = $formData['country']['value'];

        if(isset($formData['web']))
        {
            if(!empty($formData['web']['value']))
                $fieldData[$formData['web']['field']] = $formData['web']['value']; 
            else $fieldData[$formData['web']['field']] = '';
        }
            
        if(isset($formData['personName']))$fieldData[$formData['personName']['field']] = $formData['personName']['value'];
        if(isset($formData['personEmail']))$fieldData[$formData['personEmail']['field']] = $formData['personEmail']['value'];
        if(isset($formData['personC']))$fieldData[$formData['personC']['field']] = $formData['personC']['value'];
        if(isset($formData['personW']))$fieldData[$formData['personW']['field']] = $formData['personW']['value'];
        if(isset($formData['personExt']))
        {
            if(!empty($formData['personExt']['value']))
                $fieldData[$formData['personExt']['field']] = $formData['personExt']['value'];
            else
                $fieldData[$formData['personExt']['field']] = '';
        }

        if(isset($formData['billingLine1']))$fieldData[$formData['billingLine1']['field']] = $formData['billingLine1']['value'];

        if(isset($formData['billingLine2']))
        {
            if(!empty($formData['billingLine2']['value']))
                $fieldData[$formData['billingLine2']['field']] = $formData['billingLine2']['value'];
            else
                $fieldData[$formData['billingLine2']['field']] = '';
        }
        
        if(isset($formData['billingZip']))$fieldData[$formData['billingZip']['field']] = $formData['billingZip']['value'];
        if(isset($formData['billingCity']))$fieldData[$formData['billingCity']['field']] = $formData['billingCity']['value'];
        if(isset($formData['billingState']))$fieldData[$formData['billingState']['field']] = $formData['billingState']['value'];
        if(isset($formData['billingCountry']))$fieldData[$formData['billingCountry']['field']] = $formData['billingCountry']['value'];

        if(isset($formData['shippingLine1']))$fieldData[$formData['shippingLine1']['field']] = $formData['shippingLine1']['value'];

        if(isset($formData['shippingLine2']))
        {
            if(!empty($formData['shippingLine2']['value']))
                $fieldData[$formData['shippingLine2']['field']] = $formData['shippingLine2']['value'];
            else
                $fieldData[$formData['shippingLine2']['field']] = '';
        }

        if(isset($formData['shippingZip']))$fieldData[$formData['shippingZip']['field']] = $formData['shippingZip']['value'];
        if(isset($formData['shippingCity']))$fieldData[$formData['shippingCity']['field']] = $formData['shippingCity']['value'];
        if(isset($formData['shippingState']))$fieldData[$formData['shippingState']['field']] = $formData['shippingState']['value'];
        if(isset($formData['shippingCountry']))$fieldData[$formData['shippingCountry']['field']] = $formData['shippingCountry']['value'];
        
        $data = array();
        $data['fieldData'] = $fieldData;

        $result = $this->fm->editRecord($formData['companyRecordID'], $data, 'PHP_Company');

        $response = array();

        if($this->error($result) === 0)
        {
            $response['error'] = 0;
            $response['userMsg'] = 'Success';
        }
        else
        {
            $response = array();
            $response['error'] = 1;
            $response['userMsg'] = 'An error has ocurred';
            $response['method'] = 'updateCompany';
            $response['fmError'] = $this->error($result);
        }

        return json_encode($response);
    }

    public function getCompany()
    {
        $requestFM = array();
        $requestFM['__kp_COMPANY_ID'] = "==". (string)session('companyID');

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Company');

        if($this->error($result) === 0)
        {
            $record = array();
            $record['recordID'] = (string)$result['response']['data'][0]['fieldData']['RecordID'];
            $record['name'] = (string)$result['response']['data'][0]['fieldData']['d_Name_Company'];
            $record['phone'] = (string)$result['response']['data'][0]['fieldData']['d_Prime_PhoneNumber1'];
            $record['phoneType'] = (string)$result['response']['data'][0]['fieldData']['d_Prime_PhoneNumber1_Type'];
            $record['email'] = (string)$result['response']['data'][0]['fieldData']['d_Prime_Email'];
            $record['url'] = (string)$result['response']['data'][0]['fieldData']['d_Prime_URL'];

            $record['address'] = array();
            $record['address']['line1'] = (string)$result['response']['data'][0]['fieldData']['d_Prime_Address1'];
            $record['address']['line2'] = (string)$result['response']['data'][0]['fieldData']['d_Prime_Address2'];
            $record['address']['zip'] = (string)$result['response']['data'][0]['fieldData']['d_Prime_Address_Zip'];
            $record['address']['city'] = (string)$result['response']['data'][0]['fieldData']['d_Prime_Address_City'];
            $record['address']['state'] = (string)$result['response']['data'][0]['fieldData']['d_Prime_Address_State'];
            $record['address']['country'] = (string)$result['response']['data'][0]['fieldData']['d_Prime_Country'];

            $record['contact'] = array();
            $record['contact']['person']['name'] = (string)$result['response']['data'][0]['fieldData']['d_Main_ContactPerson'];
            $record['contact']['person']['phoneC'] = (string)$result['response']['data'][0]['fieldData']['d_Main_ContactPerson_Phone_Cell'];
            $record['contact']['person']['phoneW'] = (string)$result['response']['data'][0]['fieldData']['d_Main_ContactPerson_Phone'];
            $record['contact']['person']['phoneExt'] = (string)$result['response']['data'][0]['fieldData']['d_Main_ContactPerson_Phone_Ext'];
            $record['contact']['person']['email'] = (string)$result['response']['data'][0]['fieldData']['d_Main_ContactPerson_Email'];

            $record['billing'] = array();
            $record['billing']['address']['line1'] = (string)$result['response']['data'][0]['fieldData']['d_Billing_Address1'];
            $record['billing']['address']['line2'] = (string)$result['response']['data'][0]['fieldData']['d_Billing_Address2'];
            $record['billing']['address']['zip'] = (string)$result['response']['data'][0]['fieldData']['d_Billing_Address_Zip'];
            $record['billing']['address']['city'] = (string)$result['response']['data'][0]['fieldData']['d_Billing_Address_City'];
            $record['billing']['address']['state'] = (string)$result['response']['data'][0]['fieldData']['d_Billing_Address_State'];
            $record['billing']['address']['country'] = (string)$result['response']['data'][0]['fieldData']['d_Billing_Country'];

            $record['shipping'] = array();
            $record['shipping']['address']['line1'] = (string)$result['response']['data'][0]['fieldData']['d_Shipping_Address1'];
            $record['shipping']['address']['line2'] = (string)$result['response']['data'][0]['fieldData']['d_Shipping_Address2'];
            $record['shipping']['address']['zip'] = (string)$result['response']['data'][0]['fieldData']['d_Shipping_Address_Zip'];
            $record['shipping']['address']['city'] = (string)$result['response']['data'][0]['fieldData']['d_Shipping_Address_City'];
            $record['shipping']['address']['state'] = (string)$result['response']['data'][0]['fieldData']['d_Shipping_Address_State'];
            $record['shipping']['address']['country'] = (string)$result['response']['data'][0]['fieldData']['d_Shipping_Country'];
            
            $records = array();
            $records[0] = $record;

            $return = array();
            $return['error'] = 0;
            $return['data'] = $records;

            return $return;
        }
        else
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'An error has ocurred';
            $return['method'] = 'getCompany';
            $return['fmError'] = $this->error($result);

            return $return;
        }
    }
}