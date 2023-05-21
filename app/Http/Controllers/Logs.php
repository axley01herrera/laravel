<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use App\Models\RestFM;
use Illuminate\Http\Request;

class Logs extends BaseController
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

    public function logsServerSideProcessingDataTable()
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

        $logs = $this->getLogs($params);

        if($logs['error'] == 0)
        {
            $totalRows = sizeof($logs['data']);

            for($i = 0; $i < $totalRows; $i++)
            {
                $row = array();
                $row['createdBy'] = $logs['data'][$i]['fieldData']['CreatedBy'];
                $row['createdDate'] = $logs['data'][$i]['fieldData']['CreationTimestampText'];
                $row['table'] = $logs['data'][$i]['fieldData']['sqlTable'];
                $row['modifiedRecordID'] = $logs['data'][$i]['fieldData']['modifiedRecordID'];
                $row['sqlCommand'] = '';
                if($logs['data'][$i]['fieldData']['sqlCommand'] == 'insert') $row['sqlCommand'] = '<span class="badge badge-soft-success">'.$logs['data'][$i]['fieldData']['sqlCommand'].'</span>';
                if($logs['data'][$i]['fieldData']['sqlCommand'] == 'update') $row['sqlCommand'] = '<span class="badge badge-soft-warning">'.$logs['data'][$i]['fieldData']['sqlCommand'].'</span>';
                $logRecordID = $logs['data'][$i]['fieldData']['RecordID'];
                $url = "logDetailNewTab/".$logRecordID;
                $row['btnDetail'] = '<button type="button" class="btn-soft-light log" data-recordid="'.$logs['data'][$i]['fieldData']['RecordID'].'"><i class="mdi mdi-information-outline" title="detail" style="font-size: 24px;"></i></button>
                                     <a class="btn-soft-light" href="'.$url.'" target="_blank"><i class="uil-link-alt" title="detail" style="font-size: 24px;"></i></a>';
                $row['request'] = json_encode($logs['data'][$i]['fieldData']['jsonRequest']);
                $row['response'] = json_encode($logs['data'][$i]['fieldData']['jsonResponse']);
                $row['jsonOldData'] = json_encode($logs['data'][$i]['fieldData']['jsonOldData']);
                $description = json_decode($logs['data'][$i]['fieldData']['description'], true);
                if(empty($description))
                    $row['description'] = "";
                else {
                    if (!empty($description['Description']))
                        $row['description'] = $description['Description'];
                    else
                        $row['description'] = "";
                }
                $rows[$i] = $row;
            }

            if($totalRows > 0)
                $totalRecords = $logs['foundCount'];
        }
        else
            return json_encode($logs);

        $data = array();
        $data['draw'] = $dataTableRequest['draw'];
        $data['recordsTotal'] = intval($totalRecords);
        $data['recordsFiltered'] = intval($totalRecords);
        $data['data'] = $rows;

        return json_encode($data);
    }

    public function getLogs($params)
    {
        if(!empty($params['search']))
        {
            $requestFM0['CreatedBy'] = $params['search'];
            $requestFM0['NCPDP'] = session('NCPDP');

            $requestFM1['CreationTimestampText'] = $params['search'];
            $requestFM1['NCPDP'] = session('NCPDP');

            $requestFM2['sqlTable'] = $params['search'];
            $requestFM2['NCPDP'] = session('NCPDP');

            $requestFM3['modifiedRecordID'] = $params['search'];
            $requestFM3['NCPDP'] = session('NCPDP');

            $requestFM4['sqlCommand'] = $params['search'];
            $requestFM4['NCPDP'] = session('NCPDP');

            $requestFM5['jsonRequest'] = "=*" . $params['search'] . "*";
            $requestFM5['NCPDP'] = session('NCPDP');

            $requestFM6['jsonResponse'] = "=*" . $params['search'] . "*";
            $requestFM6['NCPDP'] = session('NCPDP');

            $requestFM7['jsonOldData'] = "=*" . $params['search'] . "*";
            $requestFM7['NCPDP'] = session('NCPDP');

            $query = array($requestFM0, $requestFM1,  $requestFM2, $requestFM3, $requestFM4, $requestFM5, $requestFM6, $requestFM7);
        }
        else
        {
            $requestFM = array();
            $requestFM['NCPDP'] = session('NCPDP');

            $query = array($requestFM);
        }

        $criteria = array();
        $criteria['query'] = $query;
        $criteria['offset'] = $params['start'] + 1;
        $criteria['limit'] = $params['length'];
        $criteria['sort'] = $this->getSort($params['sortColumn'], $params['sortDir']);

        $result = $this->fm->findRecords($criteria, 'PHP_OrganizationLogs');

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
                $sort1['fieldName'] = 'CreationTimestamp';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'CreationTimestamp';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        elseif($column == 1)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'sqlTable';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'sqlTable';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        elseif($column == 2)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'modifiedRecordID';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'modifiedRecordID';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        elseif($column == 3)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'sqlCommand';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'sqlCommand';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }

        return $sort;
    }

    public function logDetail(Request $request)
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        $formData = $request->input('post');

        $log = $this->getLogByRecordID($formData['logRecordID']);

        if($log['error'] == 0)
        {
            $data = array();
            $data['logDetail'] = $log['data'][0];

            return view('app.api.logs.logDetail', $data);
        }
        else
        {
            $data = array();
            $data['error'] = json_encode($log);

            return view('app.errorLoadContent', $data);
        }
    }

    public function logDetailNewTab( $logRecordId )
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return redirect(route('login'));

        $dataView = array();
        $dataView['logRecordId'] = $logRecordId;
        return view('app.api.logs.logDetailNewTab', $dataView);
    }

    public function getLogByRecordID($recordID)
    {
        $requestFM = array();
        $requestFM['RecordID'] = "==". $recordID;

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_OrganizationLogs');

        if($this->error($result) === 0)
        {
            $record = array();
            $record['id'] = (string)$result['response']['data'][0]['fieldData']['__pk_ID'];
            $record['fkOrganization'] = (string)$result['response']['data'][0]['fieldData']['_fk_Organization'];
            $record['createdBy'] = (string)$result['response']['data'][0]['fieldData']['CreatedBy'];
            $record['createdDate'] = (string)$result['response']['data'][0]['fieldData']['CreationTimestampText'];
            $record['modificationDate'] = (string)$result['response']['data'][0]['fieldData']['ModificationTimestamText'];
            $record['modifiedBy'] = (string)$result['response']['data'][0]['fieldData']['ModifiedBy'];
            $record['modifiedRecordID'] = (string)$result['response']['data'][0]['fieldData']['modifiedRecordID'];
            $record['NCPDP'] = (string)$result['response']['data'][0]['fieldData']['NCPDP'];
            $record['recordID'] = (string)$result['response']['data'][0]['fieldData']['RecordID'];
            $record['sqlCommand'] = (string)$result['response']['data'][0]['fieldData']['sqlCommand'];
            $record['table'] = (string)$result['response']['data'][0]['fieldData']['sqlTable'];
            $record['sqlPK'] = (string)$result['response']['data'][0]['fieldData']['sqlPK'];
            $record['token'] = (string)$result['response']['data'][0]['fieldData']['tokenRequest'];
            $record['oldData'] = json_decode($result['response']['data'][0]['fieldData']['jsonOldData']);
            $record['oldData'] = json_encode($record['oldData'], JSON_PRETTY_PRINT );
            $record['request'] = json_decode($result['response']['data'][0]['fieldData']['jsonRequest']);
            $record['request'] = json_encode($record['request'], JSON_PRETTY_PRINT );
            $record['response'] = json_decode($result['response']['data'][0]['fieldData']['jsonResponse']);
            $record['response'] = json_encode($record['response'], JSON_PRETTY_PRINT );
            $record['description'] = json_decode($result['response']['data'][0]['fieldData']['description']);
            $record['description'] = json_encode($record['description'], JSON_PRETTY_PRINT );
            $record['flagOldData'] = json_decode($result['response']['data'][0]['fieldData']['jsonOldData'], true);
            $record['flagResponse'] = json_decode($result['response']['data'][0]['fieldData']['jsonResponse'], true);
            $record['flagComparison'] = "";

            $arrayOldData = json_decode($record['oldData'], true);
            if(!empty($record['flagResponse']['data'][0]))
                $arrayResponse = $record['flagResponse']['data'][0];
            else
                $arrayResponse = "";

            function array_diff_assoc_recursive($array1, $array2)
            {
                foreach($array1 as $key => $value)
                {
                    if(is_array($value))
                    {
                        if(!isset($array2[$key]))
                        {
                            $difference[$key] = $value;
                        }
                        elseif(!is_array($array2[$key]))
                        {
                            $difference[$key] = $value;
                        }
                        else
                        {
                            $new_diff = array_diff_assoc_recursive($value, $array2[$key]);
                            if($new_diff != FALSE)
                            {
                                $difference[$key] = $new_diff;
                            }
                        }
                    }
                    elseif(!isset($array2[$key]) || $array2[$key] != $value)
                    {
                        $difference[$key] = $value;
                    }
                }
                return !isset($difference) ? 0 : $difference;
            }

            if(!empty($arrayOldData) && !empty($arrayResponse)){
                $logComparison = array_diff_assoc_recursive($arrayResponse, $arrayOldData);
                if(!empty($logComparison)){
                    $record['flagComparison'] = 1;
                    $record['logComparison'] = json_encode($logComparison, JSON_PRETTY_PRINT);
                }else
                    $record['flagComparison'] = 2;
            }

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
            $return['metod'] = 'getLogByRecordID';
            $return['fmError'] = $this->error($result);

            return $return;
        }
    }
}
