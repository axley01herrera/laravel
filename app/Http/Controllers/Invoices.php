<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use App\Models\RestFM;
use Illuminate\Http\Request;

class Invoices extends BaseController
{
    public $fm;

    public function __construct()
    {
        # OBJ MODEL FM
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

    public function invoiceServerSideProcessingDataTable()
    {
        $dataTableRequest = $_REQUEST;

        $params = array();
        $params['draw'] = $dataTableRequest['draw'];
        $params['start'] = $dataTableRequest['start'];
        $params['length'] = $dataTableRequest['length'];
        $params['search'] = $dataTableRequest['search']['value'];
        $params['sortColumn'] = $dataTableRequest['order'][0]['column'];
        $params['sortDir'] = $dataTableRequest['order'][0]['dir'];

        $rows = array();
        $totalRecords = 0;

        $invoices = $this->getInvoices($params);

        if($invoices['error'] == 0)
        {
            $totalRows = sizeof($invoices['data']);

            for($i = 0; $i < $totalRows; $i++)
            {
                $row = array();
                $row['number'] = '<a href="#" class="invoice" data-recordid="'.$invoices['data'][$i]['fieldData']['_zhk_RecordSerialNumber'].'">'.$invoices['data'][$i]['fieldData']['InvoiceNumber'].'</a>';
                $row['invoiceDate'] = $invoices['data'][$i]['fieldData']['InvoiceDateText'];
                $row['dueDate'] = $invoices['data'][$i]['fieldData']['DueDateText'];
                $statusNumber =  $invoices['data'][$i]['fieldData']['Status'];
                $row['status'] = '';
                switch($statusNumber)
                {
                    case 0:
                        $row['status'] = '<span class="badge badge-soft-primary">'.strtolower($invoices['data'][$i]['fieldData']['PHP_ValueList_Invoice_Status::InvoiceWebPortalStatus']).'</span>';
                        break;
                    case 1:
                        $row['status'] = '<span class="badge badge-soft-danger">'.strtolower($invoices['data'][$i]['fieldData']['PHP_ValueList_Invoice_Status::InvoiceWebPortalStatus']).'</span>';
                        break;
                    case 2:
                        $row['status'] = '<span class="badge badge-soft-danger">'.strtolower($invoices['data'][$i]['fieldData']['PHP_ValueList_Invoice_Status::InvoiceWebPortalStatus']).'</span>';
                        break;
                    case 3:
                        $row['status'] = '<span class="badge badge-soft-success">'.strtolower($invoices['data'][$i]['fieldData']['PHP_ValueList_Invoice_Status::InvoiceWebPortalStatus']).'</span>';
                        break;
                }
                $row['balance'] = '$'.number_format($invoices['data'][$i]['fieldData']['BalanceDue'], 2,".",',');
                $row['amount'] = '$'.number_format($invoices['data'][$i]['fieldData']['TotalAmount'], 2,".",',');
                $row['file'] = '';
                $file = $invoices['data'][$i]['fieldData']['PHP_Documents_Invoice::File Container'];
                if(!empty($file)) $row['file'] ='<a href="'.$file.'" target = "_blank" style="cursor: pointer;" class="file"><i class="uil uil-file-alt"></i></a>';

                $rows[$i] =  $row;
            }

            if($totalRows > 0)
                $totalRecords = $invoices['foundCount'];
        }

        $data = array();
        $data['draw'] = $dataTableRequest['draw'];
        $data['recordsTotal'] = intval($totalRecords);
        $data['recordsFiltered'] = intval($totalRecords);
        $data['data'] = $rows;

        return json_encode($data);
    }

    public function invoiceDetail(Request $request)
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        $formData = $request->input('post');
        $invoice = $this->getInvoiceByRecordID($formData['invoiceRecordID']);
        $data = array();

        if($invoice['error'] == 0)
        {
            $data['invoice'] = $invoice['data'][0];
            $data['invoiceLines'] = $invoice['invoiceLines'];
            $data['invoicePayments'] = $invoice['invoicePayments'];
            $data['countInvoiceLines'] = sizeof($data['invoiceLines']);
            $data['countInvoicePayments'] = sizeof($data['invoicePayments']);

            return view('app.billing.invoices.mainDetail', $data);
        }
        else
        {
            $data['error'] = json_encode($invoice);
            return view('app.errorLoadContent', $data);
        }
    }

    public function getInvoices($params)
    {
        if(!empty($params['search']))
        {
            $requestFM0['InvoiceNumber'] = '*'.$params['search'].'*'; // FIND IN FM IS FIELD IS TYPE NUMBER
            $requestFM0['_kf_Client_ID'] = "==".session('companyID');
            $requestFM0['Status'] = "> 0";

            $requestFM1['InvoiceDateText'] = $params['search'];
            $requestFM1['_kf_Client_ID'] = "==".session('companyID');
            $requestFM1['Status'] = "> 0";

            $requestFM2['DueDateText'] = $params['search'];
            $requestFM2['_kf_Client_ID'] = "==".session('companyID');
            $requestFM2['Status'] = "> 0";

            $requestFM3['PHP_ValueList_Invoice_Status::InvoiceWebPortalStatus'] = $params['search'];
            $requestFM3['_kf_Client_ID'] = "==". session('companyID');
            $requestFM3['Status'] = "> 0";

            $requestFM4['BalanceDue'] = '*'.$params['search'].'*';
            $requestFM4['_kf_Client_ID'] = "==". session('companyID');
            $requestFM4['Status'] = "> 0";

            $requestFM5['TotalAmount'] = '*'.$params['search'].'*';
            $requestFM5['_kf_Client_ID'] = "==". session('companyID');
            $requestFM5['Status'] = "> 0";

            $requestFM6['InvoiceNumber'] = '*'.$params['search'].'*';
            $requestFM6['_kf_Client_ID'] = "==".session('peopleID');
            $requestFM6['Status'] = "> 0";

            $requestFM7['InvoiceDateText'] = $params['search'];
            $requestFM7['_kf_Client_ID'] = "==".session('peopleID');
            $requestFM7['Status'] = "> 0";

            $requestFM8['DueDateText'] = $params['search'];
            $requestFM8['_kf_Client_ID'] = "==".session('peopleID');
            $requestFM8['Status'] = "> 0";

            $requestFM9['PHP_ValueList_Invoice_Status::InvoiceWebPortalStatus'] = $params['search'];
            $requestFM9['_kf_Client_ID'] = "==". session('peopleID');
            $requestFM9['Status'] = "> 0";

            $requestFM10['BalanceDue'] = '*'.$params['search'].'*';
            $requestFM10['_kf_Client_ID'] = "==". session('peopleID');
            $requestFM10['Status'] = "> 0";

            $requestFM11['TotalAmount'] = '*'.$params['search'].'*';
            $requestFM11['_kf_Client_ID'] = "==". session('peopleID');
            $requestFM11['Status'] = "> 0";

            $query = array($requestFM0, $requestFM1, $requestFM2, $requestFM3, $requestFM4, $requestFM5, $requestFM6, $requestFM7, $requestFM8, $requestFM9, $requestFM10, $requestFM11);
        }
        else
        {
            $requestFM0 = array();
            $requestFM0['_kf_Client_ID'] = "==".session('companyID');
            $requestFM0['Status'] = "> 0";

            $requestFM1 = array();
            $requestFM1['_kf_Client_ID'] = "==".session('peopleID');
            $requestFM1['Status'] = "> 0";

            $query = array($requestFM0, $requestFM1);
        }

        $criteria = array();
        $criteria['query'] = $query;
        $criteria['offset'] = $params['start'] + 1;
        $criteria['limit'] = $params['length'];
        $criteria['sort'] = $this->getSort($params['sortColumn'], $params['sortDir']);

        $result = $this->fm->findRecords($criteria, 'PHP_Invoice');

        if($this->error($result) === 0)
        {
            $return = array();
            $return['error'] = 0;
            $return['data'] = $result['response']['data'];
            $return['foundCount'] = $result['response']['dataInfo']['foundCount'];

            return $return;
        }
        elseif($this->error($result) === 401)
        {
            $return = array();
            $return['error'] = 0;
            $return['data'] = array();

            return $return;
        }
        else
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'An error has ocurred';
            $return['method'] = 'getTickets';
            $return['fmError'] = $this->error($result);

            return $return;
        }
    }

    public function getSort($column, $dir)
    {
        $sort = '';

        if($column == 0)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'InvoiceNumber';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'InvoiceNumber';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        if($column == 1)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'InvoiceDate';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'InvoiceDate';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        if($column == 2)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'DueDate';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'DueDate';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        if($column == 3)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'PHP_ValueList_Invoice_Status::InvoiceWebPortalStatus';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'PHP_ValueList_Invoice_Status::InvoiceWebPortalStatus';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        if($column == 4)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'BalanceDue';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'BalanceDue';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        if($column == 5)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'TotalAmount';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'TotalAmount';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }

        return $sort;
    }

    public function getInvoiceByRecordID($recordID)
    {
        $requestFM = array();
        $requestFM['RecordID'] = "==". $recordID;

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Invoice');

        if($this->error($result) === 0)
        {
            $record = array();
            $record['recordID'] = (string)$result['response']['data'][0]['fieldData']['_zhk_RecordSerialNumber'];
            $record['invoiceID'] = (string)$result['response']['data'][0]['fieldData']['__kp_INVOICE_ID'];
            $record['clientID'] = (string)$result['response']['data'][0]['fieldData']['_kf_Client_ID'];
            $record['number'] = (string)$result['response']['data'][0]['fieldData']['InvoiceNumber'];
            $record['status'] = $result['response']['data'][0]['fieldData']['Status'];
            $record['labelStatus'] = (string)strtoupper($result['response']['data'][0]['fieldData']['PHP_ValueList_Invoice_Status::InvoiceWebPortalStatus']);
            $record['BilledTo']['companyName'] = (string)$result['response']['data'][0]['fieldData']['PHP_Company::d_Name_Company'];
            $record['BilledTo']['address']['line1'] = (string)$result['response']['data'][0]['fieldData']['PHP_Company::d_Prime_Address1'];
            $record['BilledTo']['address']['line2'] = (string)$result['response']['data'][0]['fieldData']['PHP_Company::d_Prime_Address2'];
            $record['BilledTo']['address']['city'] = (string)$result['response']['data'][0]['fieldData']['PHP_Company::d_Prime_Address_City'];
            $record['BilledTo']['address']['state'] = (string)$result['response']['data'][0]['fieldData']['PHP_Company::d_Prime_Address_State'];
            $record['BilledTo']['address']['zip'] = (string)$result['response']['data'][0]['fieldData']['PHP_Company::d_Prime_Address_Zip'];
            $record['BilledTo']['address']['country'] = (string)$result['response']['data'][0]['fieldData']['PHP_Company::d_Prime_Country'];
            $record['BilledTo']['companyEmail'] = (string)$result['response']['data'][0]['fieldData']['PHP_Company::d_Prime_Email'];
            $record['BilledTo']['companyPhone'] = (string)$result['response']['data'][0]['fieldData']['PHP_Company::d_Prime_PhoneNumber1'];
            $record['invoiceDate'] = (string)$result['response']['data'][0]['fieldData']['InvoiceDate'];
            $record['poNumber'] = (string)$result['response']['data'][0]['fieldData']['PONumber'];
            $record['subTotalAmount'] = number_format($result['response']['data'][0]['fieldData']['SubTotalAmount'], 2,".",',');
            $record['discountAmount'] = number_format($result['response']['data'][0]['fieldData']['DiscountAmount'], 2,".",',');
            $record['totalAmount'] = number_format($result['response']['data'][0]['fieldData']['TotalAmount'], 2,".",',');
            $record['dueDate'] = (string)$result['response']['data'][0]['fieldData']['DueDate'];
            $record['terms'] = (string)$result['response']['data'][0]['fieldData']['Terms'];
            $record['file'] = '';
            $file = (string)$result['response']['data'][0]['fieldData']['PHP_Documents_Invoice::File Container'];
            if(!empty($file)) $record['file'] = $file;


            $records = array();
            $records[0] = $record;

            $portalInvoiceLines = $result['response']['data'][0]['portalData']['portalInvoiceLines'];
            $countInvoiceLines = sizeof($portalInvoiceLines);

            $invoiceLines = array();

            for($i = 0 ; $i < $countInvoiceLines; $i++)
            {
                $portalRecord = array();
                $portalRecord['recordID'] = (string)$result['response']['data'][0]['portalData']['portalInvoiceLines'][$i]['recordId'];
                $portalRecord['productName'] = (string)$result['response']['data'][0]['portalData']['portalInvoiceLines'][$i]['PHP_Products_LineRelated::ProductName'];
                $portalRecord['qty'] = (string)$result['response']['data'][0]['portalData']['portalInvoiceLines'][$i]['PHP_Invoice_Lines::Qty'];
                $portalRecord['price'] = number_format($result['response']['data'][0]['portalData']['portalInvoiceLines'][$i]['PHP_Invoice_Lines::Price'], 2,".",',');;
                $portalRecord['amount'] = number_format($result['response']['data'][0]['portalData']['portalInvoiceLines'][$i]['PHP_Invoice_Lines::Amount'], 2,".",',');
                $portalRecord['productCode'] = (string)$result['response']['data'][0]['portalData']['portalInvoiceLines'][$i]['PHP_Products_LineRelated::ProductCode'];
                $portalRecord['description'] = (string)$result['response']['data'][0]['portalData']['portalInvoiceLines'][$i]['PHP_Invoice_Lines::Description'];

                $invoiceLines[$i] = $portalRecord;
            }

            $portalInvoicePayments = $result['response']['data'][0]['portalData']['portalInvoicePayments'];
            $countInvoicePayments = sizeof($portalInvoicePayments);

            $invoicePayments = array();

            for($i = 0 ; $i < $countInvoicePayments; $i++)
            {
                $portalRecord = array();
                $portalRecord['recordID'] = (string)$result['response']['data'][0]['portalData']['portalInvoicePayments'][$i]['recordId'];
                $portalRecord['contactID'] = (string)$result['response']['data'][0]['portalData']['portalInvoicePayments'][$i]['PHP_Invoice_Payments::_kf_Contact_ID'];
                $portalRecord['dateExpected'] = (string)$result['response']['data'][0]['portalData']['portalInvoicePayments'][$i]['PHP_Invoice_Payments::PaymentDateExpected'];
                $portalRecord['date'] = (string)$result['response']['data'][0]['portalData']['portalInvoicePayments'][$i]['PHP_Invoice_Payments::PaymentDate'];
                $portalRecord['status'] = (string)$result['response']['data'][0]['portalData']['portalInvoicePayments'][$i]['PHP_Invoice_Payments::Status'];
                $portalRecord['statusLabel'] = '';

                switch($portalRecord['status'])
                {
                    case 0:
                        $portalRecord['statusLabel'] = '<span class="badge badge-soft-warning">'.strtolower($result['response']['data'][0]['portalData']['portalInvoicePayments'][$i]['PHP_ValueList_Invoice_Payment_Status::PaymentStatus']) .'</span>';
                        break;
                    case 1:
                        $portalRecord['statusLabel'] = '<span class="badge badge-soft-success">'.strtolower($result['response']['data'][0]['portalData']['portalInvoicePayments'][$i]['PHP_ValueList_Invoice_Payment_Status::PaymentStatus']) .'</span>';
                        break;
                }

                $portalRecord['amount'] = number_format($result['response']['data'][0]['portalData']['portalInvoicePayments'][$i]['PHP_Invoice_Payments::PaymentAmount'], 2,".",',');

                $invoicePayments[$i] = $portalRecord;
            }

            $return = array();
            $return['error'] = 0;
            $return['data'] = $records;
            $return['invoiceLines'] = $invoiceLines;
            $return['invoicePayments'] = $invoicePayments;

            return $return;
        }
        else
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'An error has ocurred';
            $return['metod'] = 'getInvoiceByRecordID';
            $return['fmError'] = $this->error($result);

            return $return;
        }
    }

    public function getUnpaidInvoices()
    {
        $requestFM0 = array();
        $requestFM0['_kf_Client_ID'] = "==".session('companyID');
        $requestFM0['Status'] = "== 1";

        $requestFM1 = array();
        $requestFM1['_kf_Client_ID'] = "==".session('companyID');
        $requestFM1['Status'] = "== 2";

        $requestFM2 = array();
        $requestFM2['_kf_Client_ID'] = "==".session('peopleID');
        $requestFM2['Status'] = "== 1";

        $requestFM3 = array();
        $requestFM3['_kf_Client_ID'] = "==".session('peopleID');
        $requestFM3['Status'] = "== 2";

        $query = array($requestFM0, $requestFM1, $requestFM2, $requestFM3);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Invoice');

        $return = array();
        $records = array();

        if($this->error($result) === 0)
        {
            $count = sizeof($result["response"]["data"]);

            for($i = 0; $i < $count; $i++)
            {
                $record = array();
                $record['recordID'] = (string)$result['response']['data'][$i]['fieldData']['_zhk_RecordSerialNumber'];
                $record['invoiceID'] = (string)$result['response']['data'][$i]['fieldData']['__kp_INVOICE_ID'];
                $record['clientID'] = (string)$result['response']['data'][$i]['fieldData']['_kf_Client_ID'];
                $record['number'] = (string)$result['response']['data'][$i]['fieldData']['InvoiceNumber'];
                $record['status'] = $result['response']['data'][$i]['fieldData']['Status'];
                $record['labelStatus'] = strtolower($result['response']['data'][$i]['fieldData']['PHP_ValueList_Invoice_Status::InvoiceWebPortalStatus']);
                $record['BilledTo']['companyName'] = (string)$result['response']['data'][$i]['fieldData']['PHP_Company::d_Name_Company'];
                $record['BilledTo']['address']['line1'] = (string)$result['response']['data'][$i]['fieldData']['PHP_Company::d_Prime_Address1'];
                $record['BilledTo']['address']['line2'] = (string)$result['response']['data'][$i]['fieldData']['PHP_Company::d_Prime_Address2'];
                $record['BilledTo']['address']['city'] = (string)$result['response']['data'][$i]['fieldData']['PHP_Company::d_Prime_Address_City'];
                $record['BilledTo']['address']['state'] = (string)$result['response']['data'][$i]['fieldData']['PHP_Company::d_Prime_Address_State'];
                $record['BilledTo']['address']['zip'] = (string)$result['response']['data'][$i]['fieldData']['PHP_Company::d_Prime_Address_Zip'];
                $record['BilledTo']['address']['country'] = (string)$result['response']['data'][$i]['fieldData']['PHP_Company::d_Prime_Country'];
                $record['BilledTo']['companyEmail'] = (string)$result['response']['data'][$i]['fieldData']['PHP_Company::d_Prime_Email'];
                $record['BilledTo']['companyPhone'] = (string)$result['response']['data'][$i]['fieldData']['PHP_Company::d_Prime_PhoneNumber1'];
                $record['invoiceDate'] = (string)$result['response']['data'][$i]['fieldData']['InvoiceDate'];
                $record['poNumber'] = (string)$result['response']['data'][$i]['fieldData']['PONumber'];
                $record['subTotalAmount'] = number_format($result['response']['data'][$i]['fieldData']['SubTotalAmount'], 2,".",',');
                $record['discountAmount'] = number_format($result['response']['data'][$i]['fieldData']['DiscountAmount'], 2,".",',');
                $record['totalAmount'] = number_format($result['response']['data'][$i]['fieldData']['TotalAmount'], 2,".",',');
                $record['dueDate'] = (string)$result['response']['data'][$i]['fieldData']['DueDate'];
                $record['terms'] = (string)$result['response']['data'][$i]['fieldData']['Terms'];

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
            $return['msg'] = 'An error has ocurred';
            $return['method'] = 'getUnpaidInvoices';
            $return['fmError'] = $this->error($result);
        }

        return $return;
    }

    public function getUnpaidInvoicesDT()
    {
        $unpaidInvoices = $this->getUnpaidInvoices();

        if($unpaidInvoices['error'] <> 0)
        {
            $data['error'] = json_encode($unpaidInvoices);
            return view('app.errorLoadContent', $data);
        }

        $data = array();
        $data['unpaidInvoices'] = $unpaidInvoices['data'];
        $data['countUnpaidInvoices'] = sizeof($unpaidInvoices['data']);

        return view('app.dashboard.layouts.tbodyUnpaidInvoces', $data);
    }

    public function getChartBillData()
    {
        $requestFM0 = array();
        $requestFM0['_kf_Client_ID'] = "==".session('companyID');
        $requestFM0['InvoiceDate'] = "2/2022...2/2023";
        $requestFM0['Status'] = "==3";

        $requestFM1 = array();
        $requestFM1['_kf_Client_ID'] = "==".session('peopleID');
        $requestFM1['InvoiceDate'] = "2/2022...2/2023";
        $requestFM1['Status'] = "==3";

        $query = array($requestFM0, $requestFM1);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Invoice');

        $return = array();

        if($this->error($result) === 0)
        {
            $count = sizeof($result["response"]["data"]);

            $jan = 0;
            $feb = 0;
            $mar = 0;
            $apr = 0;
            $may = 0;
            $jun = 0;
            $jul = 0;
            $aug = 0;
            $sep = 0;
            $oct = 0;
            $nov = 0;
            $dec = 0;
            $totalAmount = 0;

            for($i = 0; $i < $count; $i++)
            {
                $amount = $result['response']['data'][$i]['fieldData']['TotalAmount'];
                $totalAmount = $totalAmount + $amount;
                $mont = date('n', strtotime($result['response']['data'][$i]['fieldData']['InvoiceDate']));
                switch ($mont)
                {
                    case 1:
                        $jan = $jan + $amount;
                    break;
                    case 2:
                        $feb = $feb + $amount;
                    break;
                    case 3:
                        $mar = $mar + $amount;
                    break;
                    case 4:
                        $apr = $apr + $amount;
                    break;
                    case 5:
                        $may = $may + $amount;
                    break;
                    case 6:
                        $jun = $jun + $amount;
                    break;
                    case 7:
                        $jul = $jul + $amount;
                    break;
                    case 8:
                        $aug = $aug + $amount;
                    break;
                    case 9:
                        $sep = $sep + $amount;
                    break;
                    case 10:
                        $oct = $oct + $amount;
                    case 11:
                        $nov = $nov + $amount;
                    break;
                    case 12:
                        $dec = $dec + $amount;
                    break;
                }
            }

            $return['error'] = 0;
            $return['totalAmount'] = '$ '.number_format( $totalAmount, 2,".",',');
            $return['jan'] = number_format( $jan, 2,".",',');
            $return['feb'] = number_format( $feb, 2,".",',');
            $return['mar'] = number_format( $mar, 2,".",',');
            $return['apr'] = number_format( $apr, 2,".",',');
            $return['may'] = number_format( $may, 2,".",',');
            $return['jun'] = number_format( $jun, 2,".",',');
            $return['jul'] = number_format( $jul, 2,".",',');
            $return['aug'] = number_format( $aug, 2,".",',');
            $return['sep'] = number_format( $sep, 2,".",',');
            $return['oct'] = number_format( $oct, 2,".",',');
            $return['nov'] = number_format( $nov, 2,".",',');
            $return['dec'] = number_format( $dec, 2,".",',');
        }
        elseif($this->error($result) === 401)
        {
            $return['error'] = 0;
            $return['data'] = array();
        }
        else
        {
            $return['error'] = 1;
            $return['msg'] = 'An error has ocurred';
            $return['method'] = 'getUnpaidInvoices';
            $return['fmError'] = $this->error($result);
        }

        return json_encode($return);

    }
}
