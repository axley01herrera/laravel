<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use App\Models\RestFM;
use Illuminate\Http\Request;

class Payment extends BaseController
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

    public function modalCreatePayment(Request $request)
    {
        /*
            Parameters:
                callFrom = ('dashboard', 'mainPayment')
        */

        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        $formData = $request->input('post');

        $selCard = array();
        $selCard[0]['id'] = 1;
        $selCard[0]['text'] = 'American Express';
        $selCard[1]['id'] = 2;
        $selCard[1]['text'] = 'Discovery Card';
        $selCard[2]['id'] = 3;
        $selCard[2]['text'] = 'Diners';
        $selCard[3]['id'] = 4;
        $selCard[3]['text'] = 'Master Card';
        $selCard[4]['id'] = 5;
        $selCard[4]['text'] = 'Visa';

        $data = array();
        $data['selCard'] = json_encode($selCard);
        $data['callFrom'] = $formData['callFrom'];

        return view('app.billing.payment.modalCreatePayment', $data);
    }

    public function saveCard(Request $request)
    {
        $response = array();

        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
        {
            $response['error'] = 1;
            $response['userMsg'] = 'Session Expired';

            return json_encode($response);
        }

        $formData = $request->input('post');
        $removeCardDefault = $this->removeCardDefault();

        if($removeCardDefault['error'] == 0)
        {
            $fieldData = array();
            $fieldData['_kf_Client_ID'] = session('companyID');
            $fieldData['cardHolderName'] = $formData['holderName'];
            $fieldData['cardNumber'] = str_replace(' ', '', $formData['number']);
            $fieldData['cardExpirationM'] = $formData['expMont'];
            $fieldData['cardExpirationY'] = $formData['expYear'];
            $fieldData['cardCVV'] = $formData['cvv'];
            $fieldData['billingAddress1'] = $formData['line1'];
            if(!empty($formData['line2'])) $fieldData['billingAddress2'] = $formData['line2'];
            $fieldData['billingZIP'] = $formData['zip'];
            $fieldData['billingCity'] = $formData['city'];
            $fieldData['billingState'] = $formData['state'];
            $fieldData['billingCountry'] = $formData['country'];
            $fieldData['default'] = 1;
            $fieldData['cardType'] = $formData['cardType'];

            $data = array();
            $data['fieldData'] = $fieldData;

            $result = $this->fm->createRecord($data, 'PHP_Payment_Methods');

            if($this->error($result) === 0)
            {
                $response['error'] = 0;
                $response['userMsg'] = 'Success';
            }
            else
            {
                $response['error'] = 1;
                $response['userMsg'] = 'An error has ocurred';
                $response['method'] = 'saveCard';
                $response['fmError'] = $this->error($result);
            }
        }
        else
        {
            $response['error'] = 1;
            $response['userMsg'] = 'An error has ocurred';
            $response['errorDetail'] = $removeCardDefault;
        }

        return json_encode($response);
    }

    public function removeCardDefault()
    {
        $requestFM = array();
        $requestFM['_kf_Client_ID'] = "==". (string)session('companyID');
        $requestFM['default'] = "==1";

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Payment_Methods');
        $return = array();

        if($this->error($result) === 0)
        {
            $count = sizeof($result['response']['data']);

            for($i = 0 ; $i < $count; $i++)
            {
                $fieldData = array();
                $fieldData['default'] = 0;

                $data = array();
                $data['fieldData'] = $fieldData;

                $resultEditRecord = $this->fm->editRecord($result['response']['data'][$i]['fieldData']['RecordID'], $data, 'PHP_Payment_Methods');

                if($this->error($resultEditRecord) <> 0)
                {
                    $return['error'] = 1;
                    $return['method'] = 'removeCardDefault - resultEditRecord';
                    $return['fmError'] = $this->error($resultEditRecord);

                    return $return;
                }
            }

            $return['error'] = 0;
        }
        elseif($this->error($result) === 401)
            $return['error'] = 0;
        else
        {
            $return['error'] = 1;
            $return['method'] = 'removeCardDefault';
            $return['fmError'] = $this->error($result);
        }

        return $return;
    }

    public function getPayments()
    {
        $requestFM = array();
        $requestFM['_kf_Client_ID'] = "==". (string)session('companyID');

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Payment_Methods');

        $return = array();
        $records = array();

        if($this->error($result) === 0)
        {
            $count = sizeof($result['response']['data']);

            for($i = 0 ; $i < $count; $i++)
            {
                $record = array();
                $record['recordID'] = (string)$result['response']['data'][$i]['fieldData']['RecordID'];
                $record['cardNumber'] = $result['response']['data'][$i]['fieldData']['cardNumber'];
                $record['lastFour'] = substr($record['cardNumber'], -4);
                $record['cardType'] = $result['response']['data'][$i]['fieldData']['cardType'];
                $record['default'] = $result['response']['data'][$i]['fieldData']['default'];
                $record['isExpired'] = $result['response']['data'][$i]['fieldData']['isExpired'];
                $record['cardExpirationM'] = $result['response']['data'][$i]['fieldData']['cardExpirationM'];
                $record['cardExpirationY'] = $result['response']['data'][$i]['fieldData']['cardExpirationY'];
                $records[$i] = $record;
            }

            $return['error'] = 0;
            $return['data'] = $records;
        }
        elseif($this->error($result) === 401)
        {
            $return['error'] = 0;
            $return['data'] = array();
        }
        else
        {
            $return['error'] = 1;
            $return['method'] = 'getPayments';
            $return['fmError'] = $this->error($result);
        }

        return $return;
    }

    public function setDefaultPayment(Request $request)
    {
        $response = array();

        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
        {
            $response['error'] = 1;
            $response['userMsg'] = 'Session Expired';

            return json_encode($response);
        }

        $formData = $request->input('post');
        $removeCardDefault = $this->removeCardDefault();

        if($removeCardDefault['error'] == 0)
        {
            $fieldData = array();
            $fieldData['default'] = 1;

            $data = array();
            $data['fieldData'] = $fieldData;

            $result = $this->fm->editRecord($formData['paymentRecordID'], $data, 'PHP_Payment_Methods');

            if($this->error($result) === 0)
            {
                $response['error'] = 0;
                $response['userMsg'] = 'Success';
            }
            else
            {
                $response['error'] = 1;
                $response['userMsg'] = 'An error has ocurred';
                $response['method'] = 'setDefaultPayment';
                $response['fmError'] = $this->error($result);
            }
        }
        else
        {
            $response['error'] = 1;
            $response['userMsg'] = 'An error has ocurred';
            $response['errorDetail'] = $removeCardDefault;
        }

        return json_encode($response);
    }

    public function defaultPaymentMethod()
    {
        $data = array();
        $defaultPayment = $this->getDefaultPaymentMethod();

        if($defaultPayment['error'] == 0)
        {
            $data['defaultPayment'] = $defaultPayment['data'];
            return view('app.dashboard.layouts.defaultPaymenMethod', $data);
        }
        else
        {
            $data['error'] = json_encode($defaultPayment);
            return view('app.errorLoadContent', $data);
        }
    }

    public function getDefaultPaymentMethod()
    {
        $requestFM = array();
        $requestFM['_kf_Client_ID'] = "==". (string)session('companyID');
        $requestFM['default'] = "==1";

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Payment_Methods');

        $return = array();
        $records = array();

        if($this->error($result) === 0)
        {
            $record = array();
            $record['recordID'] = (string)$result['response']['data'][0]['fieldData']['RecordID'];
            $record['cardNumber'] = $result['response']['data'][0]['fieldData']['cardNumber'];
            $record['lastFour'] = substr($record['cardNumber'], -4);
            $record['cardType'] = $result['response']['data'][0]['fieldData']['cardType'];
            $record['default'] = $result['response']['data'][0]['fieldData']['default'];
            $record['isExpired'] = $result['response']['data'][0]['fieldData']['isExpired'];
            $record['cardExpirationM'] = $result['response']['data'][0]['fieldData']['cardExpirationM'];
            $record['cardExpirationY'] = $result['response']['data'][0]['fieldData']['cardExpirationY'];

            $records[0] = $record;

            $return['error'] = 0;
            $return['data'] = $records;
        }
        elseif($this->error($result) === 401)
        {
            $return['error'] = 0;
            $return['data'] = array();
        }
        else
        {
            $return['error'] = 1;
            $return['method'] = 'getDefaultPaymentMethod';
            $return['fmError'] = $this->error($result);
        }

        return $return;
    }
}
