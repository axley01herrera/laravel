<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use App\Models\RestFM;
use Illuminate\Http\Request;

class Contracts extends BaseController
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

    public function contractsServerSideProcessingDataTable()
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

        $contracts = $this->getContracts($params);

        if($contracts['error'] == 0)
        {
            $totalRows = sizeof($contracts['data']);

            for($i = 0; $i < $totalRows; $i++)
            {
                $row = array();
                $row['number'] = '<a href="#" class="contract" data-recordid="'.$contracts['data'][$i]['fieldData']['_zhk_RecordSerialNumber'].'">'.$contracts['data'][$i]['fieldData']['__kp_CUSTCONTRACT_ID'].'</a>';
                $row['dateStart'] = $contracts['data'][$i]['fieldData']['Date_Start'];
                $row['dateExpire'] = $contracts['data'][$i]['fieldData']['Date_Expire'];
                $row['file'] = '';
                $file = $contracts['data'][$i]['fieldData']['ContractPDF'];
                if(!empty($file)) $row['file'] ='<a href="'.$file.'" target = "_blank" style="cursor: pointer;" class="file"><i class="uil uil-file-alt"></i></a>';

                $rows[$i] =  $row;
            }

            if($totalRows > 0)
                $totalRecords = $contracts['foundCount'];
        }

        $data = array();
        $data['draw'] = $dataTableRequest['draw'];
        $data['recordsTotal'] = intval($totalRecords);
        $data['recordsFiltered'] = intval($totalRecords);
        $data['data'] = $rows;

        return json_encode($data);
    }

    public function getContracts($params)
    {
        if(!empty($params['search']))
        {
            $requestFM0['__kp_CUSTCONTRACT_ID'] = $params['search'];
            //$requestFM0['_kf_COMPANY_ID'] = "==". session('companyID');

            $requestFM1['Date_Start'] = $params['search'];
            //$requestFM1['_kf_COMPANY_ID'] = "==". session('companyID');

            $requestFM2['Date_Expire'] = $params['search'];
            //$requestFM2['_kf_COMPANY_ID'] = "==". session('companyID');

            $query = array($requestFM0,  $requestFM1, $requestFM2);
        }
        else
        {
            $requestFM = array();
            //$requestFM['_kf_COMPANY_ID'] = "==".session('companyID');
            $requestFM['_kf_COMPANY_ID'] = "*";

            $query = array($requestFM);
        }

        $criteria = array();
        $criteria['query'] = $query;
        $criteria['offset'] = $params['start'] + 1;
        $criteria['limit'] = $params['length'];
        $criteria['sort'] = $this->getSort($params['sortColumn'], $params['sortDir']);

        $result = $this->fm->findRecords($criteria, 'PHP_Contracts');

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
                $sort1['fieldName'] = '__kp_CUSTCONTRACT_ID';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = '__kp_CUSTCONTRACT_ID';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        if($column == 1)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'Date_Start';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'Date_Start';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        elseif($column == 2)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'Date_Expire';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'Date_Expire';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }

        return $sort;
    }

    public function contractDetail(Request $request)
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        $formData = $request->input('post');

        $contract = $this->getContractByRecordID($formData['contractRecordID']);

        $data = array();

        if($contract['error'] == 0)
        {
            $data['contract'] = $contract['data'][0];
            $data['countProducts'] = $contract['countProducts'];
            $data['products'] = $contract['contractProducts'];
            return view('app.billing.contracts.mainDetail', $data);

        }
        else
        {
            $data['error'] = json_encode($contract);
            return view('app.errorLoadContent', $data);
        }
    }

    public function getContractByRecordID($recordID)
    {
        $requestFM = array();
        $requestFM['_zhk_RecordSerialNumber'] = "==". $recordID;

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Contracts');

        $return = array();

        if($this->error($result) === 0)
        {
            $record = array();
            $record['id'] = (string)$result['response']['data'][0]['fieldData']['__kp_CUSTCONTRACT_ID'];
            $record['fkCompany'] = (string)$result['response']['data'][0]['fieldData']['_kf_COMPANY_ID'];
            $record['fkContact'] = (string)$result['response']['data'][0]['fieldData']['_kf_CONTACT_ID'];
            $record['fkPeople'] = (string)$result['response']['data'][0]['fieldData']['_kf_PEOPLE_ID_PRIMARY'];
            $record['companyDisplayName'] = (string)$result['response']['data'][0]['fieldData']['_zct_CompanyDisplayName'];
            $record['recordID'] = (string)$result['response']['data'][0]['fieldData']['_zhk_RecordSerialNumber'];
            $record['contractPDF'] = (string)$result['response']['data'][0]['fieldData']['ContractPDF'];
            $record['dateExpire'] = (string)$result['response']['data'][0]['fieldData']['Date_Expire'];
            $record['dateStart'] = (string)$result['response']['data'][0]['fieldData']['Date_Start'];
            $record['dateStartRenewal'] = (string)$result['response']['data'][0]['fieldData']['Date_StartRenewal90'];
            $record['selected'] = (string)$result['response']['data'][0]['fieldData']['Selected'];

            $records = array();
            $records[0] = $record;

            $portalContractItems = $result['response']['data'][0]['portalData']['portalContractItems'];

            $countContractItems = sizeof($portalContractItems);

            $contractItems = array();

            for($i = 0 ; $i < $countContractItems; $i++)
            {
                $portalRecord = array();
                $portalRecord['recordID'] = $portalContractItems[$i]['recordId'];
                $portalRecord['productNumber'] = $portalContractItems[$i]['PHP_CustContracts_Items::_kf_PRODUCT_ID'];
                $portalRecord['productName'] = $portalContractItems[$i]['PHP_Products_CNItemRelated::ProductName'];
                $portalRecord['price'] = number_format($portalContractItems[$i]['PHP_CustContracts_Items::PriceEach'], 2,".",',');;
                $portalRecord['description'] = $portalContractItems[$i]['PHP_Products_CNItemRelated::ProductDescription'];

                $contractItems[$i] = $portalRecord;
            }

            $return['error'] = 0;
            $return['data'] = $records;
            $return['countProducts'] = $countContractItems;
            $return['contractProducts'] = $contractItems;
        }
        else
        {
            $return['error'] = 1;
            $return['msg'] = 'An error has ocurred';
            $return['metod'] = 'getTicketByRecordID';
            $return['fmError'] = $this->error($result);
        }

        return $return;
    }

}
