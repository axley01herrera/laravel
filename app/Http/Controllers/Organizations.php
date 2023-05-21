<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use App\Models\RestFM;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class Organizations extends BaseController
{
    public $fm;
    public $fm2;

    public function __construct()
    {
        # OBJ MODELS
        $this->fm = new RestFM;

        $host = 'data.sicompound.cloud';
        $db = 'SiData.fmp12';
        $user = 'icadmin';
        $pass = 'AaF6bac21d!';
        $layout = 'Organizations';
        $tokenName = 'fmtoken2';

        $this->fm2 = new RestFM($host, $db, $user, $pass, $layout, $tokenName);
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

    public function generateOrganizationsKeys(Request $request)
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
        $fieldData['clientID'] = md5(md5(md5(date('m/d/Y h:i:s a', time()))));
        $fieldData['clientSecret'] = md5(md5(md5(date('m/d/y h:i:s a', time()))));

        $data = array();
        $data['fieldData'] = $fieldData;

        $result = $this->fm2->editRecord(session('organizationsRecordID'), $data, 'Organizations');

        if($this->error($result) === 0)
        {
            $organizationLogParams = array();
            $organizationLogParams['organizationID'] = session('organizationsID');
            $organizationLogParams['jsonRequest'] = json_encode($fieldData);
            $organizationLogParams['jsonResponse'] = '';
            $organizationLogParams['action'] = 'update';
            $organizationLogParams['table'] = 'Organizations';
            $organizationLogParams['token'] = '';
            $organizationLogParams['sqlPK'] = '';
            $organizationLogParams['modifiedRecordID'] = session('organizationsRecordID');
            $description = array();
            $description['Source'] = 'portal';
            $description['Description'] = 'Updating ClientID and ClientSecret';
            $organizationLogParams['description'] = json_encode($description);
            $organizationLogParams['jsonOldData'] = json_encode($formData);

            $resultCreateLog = $this->createOrganizationLog($organizationLogParams);

            $response = array();
            $response['error'] = 0;
            $response['clientID'] = $fieldData['clientID'];
            $response['clientSecret'] = $fieldData['clientSecret'];
            $response['resultLog'] = $resultCreateLog;

            return json_encode($response);
        }
        else
        {
            $response = array();
            $response['error'] = 1;
            $response['userMsg'] = 'An error has ocurred';
            $response['method'] = 'generateOrganizationsKeys';
            $response['fmError'] = $this->error($result);

            return json_encode($response);
        }
    }

    public function updateCredentials(Request $request) // NOT IN USE
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
        $fieldData['ICHostname'] = $formData['host'];
        $fieldData['ICFileName'] = $formData['file'];
        $fieldData['ICUsername'] = $formData['user'];
        $fieldData['ICPassword'] = $formData['password'];

        $data = array();
        $data['fieldData'] = $fieldData;

        $result = $this->fm2->editRecord(session('organizationsRecordID'), $data, 'Organizations');

        if($this->error($result) === 0)
        {
            $jsonFielData = array();
            $jsonFielData['host'] = $formData['currentHost'];
            $jsonFielData['file'] = $formData['currentFile'];
            $jsonFielData['user'] = $formData['currentUser'];
            $jsonFielData['password'] = $formData['currentPassword'];

            $description = array();
            $description['Source'] = 'portal';
            $description['Description'] = 'Updating credentials';

            $organizationLogParams = array();
            $organizationLogParams['organizationID'] = session('organizationsID');
            $organizationLogParams['action'] = 'update';
            $organizationLogParams['table'] = 'Organizations';
            $organizationLogParams['token'] = '';
            $organizationLogParams['modifiedRecordID'] = session('organizationsRecordID');
            $organizationLogParams['jsonFieldData'] = json_encode($jsonFielData);
            $organizationLogParams['jsonRequest'] = json_encode($fieldData);
            $organizationLogParams['description'] = json_encode($description);

            $resultCreateLog = $this->createOrganizationLog($organizationLogParams);

            $response = array();
            $response['error'] = 0;
            $response['userMsg'] = 'Updated credentials';

            $response['resultLog'] = $resultCreateLog;

            return json_encode($response);
        }
        else
        {
            $response = array();
            $response['error'] = 1;
            $response['userMsg'] = 'An error has ocurred';
            $response['method'] = 'generateOrganizationsKeys';
            $response['fmError'] = $this->error($result);

            return json_encode($response);
        }
    }

    public function getToken(Request $request)
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

        $requestFM = array();
        $requestFM['clientID'] = "==". $formData['clientID'];
        $requestFM['clientSecret'] = "==". $formData['clientSecret'];

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm2->findRecords($criteria, 'Organizations');

        if($this->error($result) === 0)
        {
            $token = md5(md5(md5(date_timestamp_get(date_create()))));

            $fieldData = array();
            $fieldData['token'] = $token;
            $fieldData['_fk_Organization'] = $result["response"]["data"][0]["fieldData"]["OrganizationID"];

            $data['fieldData'] = $fieldData;

            $resultCreateToken = $this->fm2->createRecord($data, 'OrganizationsTokens'); // CREATE TOKEN

            if($this->error($resultCreateToken) === 0) // SUCCESS
            {
                $organizationLogParams = array();
                $organizationLogParams['organizationID'] = $result["response"]["data"][0]["fieldData"]["OrganizationID"];
                $organizationLogParams['jsonRequest'] = json_encode($formData);
                $organizationLogParams['action'] = 'insert';
                $organizationLogParams['table'] = 'OrganizationsTokens';
                $organizationLogParams['token'] = $token;
                $organizationLogParams['modifiedRecordID'] = $resultCreateToken['response']['recordId'];
                
                $description = array();
                $description['Source'] = 'portal';
                $description['Description'] = 'get token';
                $organizationLogParams['description'] = json_encode($description);

                $resultCreateLog = $this->createOrganizationLog($organizationLogParams);

                $response = array();
                $response['error'] = 0;
                $response['token'] = $token;
                $response['resultLog'] = $resultCreateLog;

                return json_encode($response);
            }
            else // ERROR
            {
                $response = array();
                $response['error'] = 1;
                $response['userMsg'] = 'An error has ocurred';
                $response['method'] = 'Create token';
                $response['fmError'] = $this->error($resultCreateToken);

                return json_encode($response);
            }
        }
        elseif($this->error($result) === 401) // RECORD NOT FOUND
        {
            $response = array();
            $response['error'] = 1;
            $response['userMsg'] = 'Organizations not found';

            return json_encode($response);
        }
        else // ERROR FM REQUEST
        {
            $response = array();
            $response['error'] = 1;
            $response['userMsg'] = 'An error has ocurred';
            $response['method'] = 'getToken';
            $response['fmError'] = $this->error($result);

            return json_encode($response);
        }
    }

    public function tokensServerSideProcessingDataTable()
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

        $tokens = $this->getTokens($params);

        if($tokens['error'] == 0)
        {
            $totalRows = sizeof($tokens['data']);

            for($i = 0; $i < $totalRows; $i++)
            {
                $row = array();
                $row['token'] = '<i style="cursor: pointer;" class="text-primary bx bx-copy-alt clipboardtable" title="copy" data-clipboard-target="#txt-r'.$tokens['data'][$i]['fieldData']['RecordID'].'"></i> <span id="txt-r'.$tokens['data'][$i]['fieldData']['RecordID'].'">'.$tokens['data'][$i]['fieldData']['token'].'</span>' ;
                $row['ExpirationDate'] = $tokens['data'][$i]['fieldData']['CreationTimestamText'];
                if($tokens['data'][$i]['fieldData']['tokenIsExpired'] == 0)
                {
                    $row['status'] = '<span class="badge badge-soft-success">active</span>';
                    $row['btnRevoke'] = '<button type="button" class="btn-soft-light  revoke" data-expiration="'.$tokens['data'][$i]['fieldData']['tokenExpirationTimestamp'].'" data-recordid="'.$tokens['data'][$i]['fieldData']['RecordID'].'"><i style="font-size: 24px;" class="mdi mdi-close-box-outline" title="revoke"></i></button>';
                }
                if($tokens['data'][$i]['fieldData']['tokenIsExpired'] == 1)
                {
                    $row['status'] = '<span class="badge badge-soft-danger">expired</span>';
                    $row['btnRevoke'] = '';
                }

                $rows[$i] =  $row;
            }

            if($totalRows > 0)
                $totalRecords = $tokens['foundCount'];
        }

        $data = array();
        $data['draw'] = $dataTableRequest['draw'];
        $data['recordsTotal'] = intval($totalRecords);
        $data['recordsFiltered'] = intval($totalRecords);
        $data['data'] = $rows;

        return json_encode($data);
    }

    public function getTokens($params)
    {
        if(!empty($params['search']))
        {
            $requestFM0['token'] = $params['search'];
            $requestFM0['_fk_Organization'] = session('organizationsID');

            $requestFM1['CreationTimestamText'] = $params['search'];
            $requestFM1['_fk_Organization'] = session('organizationsID');

            $query = array($requestFM0, $requestFM1);
        }
        else
        {
            $requestFM = array();
            $requestFM['_fk_Organization'] = session('organizationsID');

            $query = array($requestFM);
        }

        $criteria = array();
        $criteria['query'] = $query;
        $criteria['offset'] = $params['start'] + 1;
        $criteria['limit'] = $params['length'];
        $criteria['sort'] = $this->getSort($params['sortColumn'], $params['sortDir']);

        $result = $this->fm2->findRecords($criteria, 'OrganizationsTokens');

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
            $return['method'] = 'getTokens';
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
                $sort1['fieldName'] = 'token';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'token';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        elseif($column == 1)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'tokenExpirationTimestamp';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'tokenExpirationTimestamp';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        /*elseif($column == 2)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'tokenIsExpired';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'tokenIsExpired';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }*/

        return $sort;
    }

    public function revokeToken(Request $request)
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
        $fieldData['tokenExpirationTimestamp'] = date('m/d/Y h:i:s A', strtotime($formData['tokenDate'].'-1 days'));

        $data = array();
        $data['fieldData'] = $fieldData;

        $result = $this->fm2->editRecord($formData['tokenRecordID'], $data, 'OrganizationsTokens');

        if($this->error($result) === 0)
        {
            $response = array();
            $response['error'] = 0;
            $response['userMsg'] = 'Revoked token';

            return json_encode($response);
        }
        else
        {
            $response = array();
            $response['error'] = 1;
            $response['userMsg'] = 'An error has ocurred';
            $response['method'] = 'revokeToken';
            $response['fmError'] = $this->error($result);

            return json_encode($response);
        }
    }

    # ORGANIZATION LOG

    public function createOrganizationLog($organizationLogParams)
    {
        $fieldData = array();
        if(!empty($organizationLogParams['organizationID'])) $fieldData['_fk_Organization'] = $organizationLogParams['organizationID'];
        if(!empty($organizationLogParams['jsonRequest'])) $fieldData['jsonRequest'] = $organizationLogParams['jsonRequest'];
        if(!empty($organizationLogParams['jsonResponse'])) $fieldData['jsonResponse'] = $organizationLogParams['jsonResponse'];
        if(!empty($organizationLogParams['action'])) $fieldData['sqlCommand'] = $organizationLogParams['action'];
        if(!empty($organizationLogParams['table'])) $fieldData['sqlTable'] = $organizationLogParams['table'];
        if(!empty($organizationLogParams['token'])) $fieldData['tokenRequest'] = $organizationLogParams['token'];
        if(!empty($organizationLogParams['sqlPK'])) $fieldData['sqlPK'] = $organizationLogParams['sqlPK'];
        if(!empty($organizationLogParams['modifiedRecordID'])) $fieldData['modifiedRecordID'] = $organizationLogParams['modifiedRecordID'];
        if(!empty($organizationLogParams['description'])) $fieldData['description'] = $organizationLogParams['description'];
        if(!empty($organizationLogParams['jsonOldData'])) $fieldData['jsonOldData'] = $organizationLogParams['jsonOldData'];

        $data = array();
        $data['fieldData'] = $fieldData;

        $result = $this->fm2->createRecord($data, 'OrganizationsLogs'); // CREATE RECORD

        if($this->error($result) === 0) // SUCCESS
        {
            $return = array();
            $return['error'] = 0;
            $return['msg'] = 'success';

            return $return;
        }
        else // ERROR
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'An error has ocurred';
            $return['method'] = 'createOrganizationLog';
            $return['fmError'] = $this->error($result);

            return $return;
        }
    }
}
