<?php

namespace App\Http\Controllers;
use App\Http\Controllers\People;
use Illuminate\Routing\Controller as BaseController;
use App\Models\RestFM;
use Illuminate\Http\Request;
use App\Mail\SendInvitation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class Contact extends BaseController
{
    public $fm;
    public $peopleController;

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

    public function getContact($peopleID = '')
    {
        if(empty($peopleID))
        {
            $requestFM = array();
            $requestFM['__kp_CONTACT_ID'] = "==". (string)session('contactID');
        }
        else
        {
            $requestFM = array();
            $requestFM['_kf_PEOPLE_ID'] = "==". $peopleID;
        }

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Contacts');

        if($this->error($result) === 0)
        {
            $record = array();
            $record['recordID'] = (string)$result['response']['data'][0]['fieldData']['RecordID'];
            $record['user'] = (string)$result['response']['data'][0]['fieldData']['WebPortal_Username'];
            $record['peopleName'] = (string)$result['response']['data'][0]['fieldData']['PHP_People::NameFull'];
            $record['peoplePhone'] = (string)preg_replace("/[^A-Za-z0-9 ]/", "", $result['response']['data'][0]['fieldData']['PHP_People::PhoneMobile']);
            $record['peopleEmail'] = (string)$result['response']['data'][0]['fieldData']['PHP_People::Email'];
            $record['orgClientID'] = (string)$result['response']['data'][0]['fieldData']['Organizations::clientID'];
            $record['orgClientSecret'] = (string)$result['response']['data'][0]['fieldData']['Organizations::clientSecret'];
            $record['orgICHostname'] = (string)$result['response']['data'][0]['fieldData']['Organizations::ICHostname'];
            $record['orgICFileName'] = (string)$result['response']['data'][0]['fieldData']['Organizations::ICFileName'];
            $record['orgICUsername'] = (string)$result['response']['data'][0]['fieldData']['Organizations::ICUsername'];
            $record['orgICPassword'] = (string)$result['response']['data'][0]['fieldData']['Organizations::ICPassword'];
            $record['orgICAPIToken'] = (string)$result['response']['data'][0]['fieldData']['Organizations::ICAPIToken'];

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
            $return['method'] = 'getContact';
            $return['fmError'] = $this->error($result);

            return $return;
        }
    }

    public function updateContact($recordID, $data)
    {
        $result = $this->fm->editRecord($recordID, $data, 'PHP_Contacts');
        $return = array();

        if($this->error($result) === 0)
        {
            $return['error'] = 0;
            $return['userMsg'] = 'Success';
        }
        else
        {
            $return = array();
            $return['error'] = 1;
            $return['userMsg'] = 'An error has ocurred';
            $return['method'] = 'updatePersonalInformation';
            $return['fmError'] = $this->error($result);
        }

        return json_encode($return);
    }

    public function returnModalResetPassword()
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        $contact = $this->getContact();

        if($contact['error'] == 0)
        {
            $data = array();
            $data['contact'] = $contact['data'][0];

            return view('app.account.profile.modals.resetPassword', $data);
        }
    }

    public function updatePassword(Request $request)
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

        $checkCurrentPassword = $this->checkCurrentPassword($formData['contactRecordID'], $formData['currentPassword']);

        if($checkCurrentPassword['error'] == 0)
        {
            $fieldData = array();
            $fieldData['WebPortal_Password'] = password_hash($formData['newPassword'], PASSWORD_DEFAULT);

            $data = array();
            $data['fieldData'] = $fieldData;

            $result = $this->fm->editRecord($formData['contactRecordID'], $data, 'PHP_Contacts');

            if($this->error($result) === 0)
            {
                $response = array();
                $response['error'] = 0;
                $response['userMsg'] = 'Success';

                return json_encode($response);
            }
            else
            {
                $response = array();
                $response['error'] = 1;
                $response['userMsg'] = 'An error has ocurred';
                $response['method'] = 'updateCredentials';
                $response['fmError'] = $this->error($result);

                return json_encode($response);
            }
        }
        else
        {
            $response = array();
            $response['error'] = 1;
            $response['userMsg'] = $checkCurrentPassword['msg'];
            $response['errorDetail'] = $checkCurrentPassword;

            return json_encode($response);
        }

    }

    public function checkCurrentPassword($recordID, $currentPassword)
    {
        $requestFM = array();
        $requestFM['RecordID'] = "==". $recordID;

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Contacts');

        if($this->error($result) === 0)
        {
            if(password_verify($currentPassword , $result ['response']['data'][0]['fieldData']['WebPortal_Password']))
            {
                $return = array();
                $return['error'] = 0;

                return $return;
            }
            else
            {
                $return = array();
                $return['error'] = 1;
                $return['msg'] = 'Invalid current password';

                return $return;
            }
        }
        else
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'An error has ocurred';
            $return['method'] = 'checkCurrentPassword';
            $return['fmError'] = $this->error($result);

            return $return;
        }
    }

    public function contactList()
    {
        return view('app.account.contacts.layouts.mainList');
    }

    public function contactsServerSideProcessingDataTable()
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

        $contacts = $this->getPeopleContacts($params);

        if($contacts['error'] == 0)
        {
            $totalRows = sizeof($contacts['data']);

            for($i = 0; $i < $totalRows; $i++)
            {
                $row = array();
                $row['name'] = '<a href="#" class="contact" data-recordid="'.$contacts['data'][$i]['fieldData']['_kf_PEOPLE_ID'].'">'.$contacts['data'][$i]['fieldData']['PHP_People::NameFull'].'</a>';
                $row['email'] = $contacts['data'][$i]['fieldData']['PHP_People::Email'];
                $row['phone'] = '<span class="phoneMask">'.preg_replace("/[^A-Za-z0-9 ]/", "", $contacts['data'][$i]['fieldData']['PHP_People::PhoneMobile']).'</span>';

                $main = $contacts['data'][$i]['fieldData']['PHP_People::IsMainContact'];
                $row['isMainContact'] = $main;
                switch($main)
                {
                    case '':
                        $row['isMainContact'] = '';
                    break;
                    case '0':
                        $row['isMainContact'] = '<div class="form-check form-switch mb-2" dir="ltr"><input id="switchMain'.$i.'" type="checkbox" class="form-check-input switchMain" data-recordid="'.$contacts['data'][$i]['fieldData']['_kf_PEOPLE_ID'].'" data-value="'.$main.'"></div>';
                    break;
                    case '1':
                        $row['isMainContact'] = '<div class="form-check form-switch mb-2" dir="ltr"><input id="switchMain'.$i.'" type="checkbox" class="form-check-input switchMain" checked data-recordid="'.$contacts['data'][$i]['fieldData']['_kf_PEOPLE_ID'].'" data-value="'.$main.'"></div>';
                    break;
                }

                $webPortalStatus = $contacts['data'][$i]['fieldData']['PHP_Contacts::WebPortal_isActive'];
                $row['switch'] = $webPortalStatus;

                switch($webPortalStatus)
                {
                    case '0':
                        $row['switch'] = '<div class="form-check form-switch mb-2" dir="ltr"><input id="switch'.$i.'" type="checkbox" class="form-check-input switch" data-recordid="'.$contacts['data'][$i]['fieldData']['_kf_PEOPLE_ID'].'" data-value="'.$webPortalStatus.'"></div>';
                    break;
                    case '1':
                        $row['switch'] = '<div class="form-check form-switch mb-2" dir="ltr"><input id="switch'.$i.'" type="checkbox" class="form-check-input switch" checked data-recordid="'.$contacts['data'][$i]['fieldData']['_kf_PEOPLE_ID'].'" data-value="'.$webPortalStatus.'"></div>';
                    break;
                }

                $row['buttons'] = '<button class="send btn-soft-light" data-email="'.$contacts['data'][$i]['fieldData']['PHP_People::Email'].'" data-recordid="'.$contacts['data'][$i]['fieldData']['_kf_PEOPLE_ID'].'"><i title="send invitation" class="uil uil-envelope-alt" style="font-size: 24px;"></i></button>';
                $row['buttons'] = $row['buttons'].'<button class="edit btn-soft-light ms-1" data-email="'.$contacts['data'][$i]['fieldData']['PHP_People::Email'].'" data-recordid="'.$contacts['data'][$i]['fieldData']['_kf_PEOPLE_ID'].'"><i title="edit" class="uil uil-edit" style="font-size: 24px;"></i></button>';

                $rows[$i] =  $row;
            }

            if($totalRows > 0)
                $totalRecords = $contacts['foundCount'];
        }
        else
            return json_encode($contacts);

        $data = array();
        $data['draw'] = $dataTableRequest['draw'];
        $data['recordsTotal'] = intval($totalRecords);
        $data['recordsFiltered'] = intval($totalRecords);
        $data['data'] = $rows;

        return json_encode($data);
    }

    public function getPeopleContacts($params)
    {
        if(!empty($params['search']))
        {
            $requestFM0['PHP_People::NameFull'] = $params['search'];
            $requestFM0['_kf_COMPANY_ID'] = "==".session('companyID');

            $requestFM1['PHP_People::Email'] = $params['search'];
            $requestFM1['_kf_COMPANY_ID'] = "==".session('companyID');

            $requestFM2['PHP_People::PhoneMobile'] = $params['search'];
            $requestFM2['_kf_COMPANY_ID'] = "==".session('companyID');

            $requestFM3['PHP_People::IsMainContact'] = $params['search'];
            $requestFM3['_kf_COMPANY_ID'] = "==".session('companyID');

            $requestFM4['PHP_People::Status'] = $params['search'];
            $requestFM4['_kf_COMPANY_ID'] = "==".session('companyID');

            $query = array($requestFM0, $requestFM1,  $requestFM2, $requestFM3, $requestFM4);
        }
        else
        {
            $requestFM = array();
            $requestFM['_kf_COMPANY_ID'] = "==". (string)session('companyID');

            $query = array($requestFM);
        }

        $criteria = array();
        $criteria['query'] = $query;
        $criteria['offset'] = $params['start'] + 1;
        $criteria['limit'] = $params['length'];
        $criteria['sort'] = $this->getSort($params['sortColumn'], $params['sortDir']);

        $result = $this->fm->findRecords($criteria, 'PHP_Company_People');

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
            $return['method'] = 'getPeopleContacts';
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
                $sort1['fieldName'] = 'PHP_People::NameFull';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'PHP_People::NameFull';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        elseif($column == 1)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'PHP_People::Email';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'PHP_People::Email';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        elseif($column == 2)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'PHP_People::PhoneMobile';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'PHP_People::PhoneMobile';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }

        return $sort;
    }

    public function sendInvitation(Request $request)
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

        $contact = $this->sendInvitationProcess($formData['peopleID']);

        if($contact['error'] === 0)
        {
            $link = route('newUser').'?token='.$contact['data'][0]['token'];

            Mail::to($formData['email'])->send(new SendInvitation($link));

            $response['error'] = 0;
            $response['userMsg'] = 'Success';

            return json_encode($response);
        }
        else
        {
            $response = array();
            $response['error'] = 1;
            $response['userMsg'] = 'An error has ocurred';
            $response['errorDetail'] = $contact;

            return json_encode($response);
        }
    }

    public function sendInvitationProcess($peopleID, $status = 1)
    {
        $requestFM = array();
        $requestFM['_kf_PEOPLE_ID'] = "==". $peopleID;

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Contacts'); // FIND

        if($this->error($result) === 0) // SUCCESS IS RESEND INVITATION UPDATE TOKEN
        {
            $fieldData = array();
            $fieldData['WebPortal_PasswordTemp'] = md5($peopleID.uniqid());
            $fieldData['WebPortal_isActive'] = $status;

            $data = array();
            $data['fieldData'] = $fieldData;

            $updateContact = $this->fm->editRecord($result['response']['data'][0]['fieldData']['RecordID'], $data, 'PHP_Contacts');

            if($this->error($updateContact) === 0)
            {
                $record = array();
                $record['token'] = $fieldData['WebPortal_PasswordTemp'];

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
                $return['metod'] = 'updateContact in sendInvitationProcess';
                $return['fmError'] = $this->error($updateContact);

                return $return;
            }
        }
        elseif($this->error($result) === 401) // RECORD NOT FOUND IS FIRST INVITATION CREATE CONTACT AND INSERT TOKEN
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'Contact not found';

            $fieldData = array();
            $fieldData['_kf_PEOPLE_ID'] = $peopleID;
            $fieldData['WebPortal_PasswordTemp'] = md5($peopleID.uniqid());
            $fieldData['WebPortal_isActive'] = 1;

            $data = array();
            $data['fieldData'] = $fieldData;

            $createContact = $this->fm->createRecord($data, 'PHP_Contacts');

            if($this->error($createContact) === 0)
            {
                $record = array();
                $record['token'] = $fieldData['WebPortal_PasswordTemp'];

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
                $return['metod'] = 'createContact in sendInvitationProcess';
                $return['fmError'] = $this->error($createContact);

                return $return;
            }
        }
        else // ERROR FM REQUEST
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'An error has ocurred';
            $return['metod'] = 'sendInvitationProcess';
            $return['fmError'] = $this->error($result);

            return $return;
        }
    }

    public function activeInactiveUser(Request $request)
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

        $contact = $this->getContact($formData['peopleID']);

        if($contact['error'] === 0)
        {
            $fieldData = array();
            $fieldData['WebPortal_isActive'] = $formData['value'];

            $data = array();
            $data['fieldData'] = $fieldData;

            $result = $this->updateContact($contact['data'][0]['recordID'], $data);

            return $result;
        }
        else
        {
            $response = array();
            $response['error'] = 1;
            $response['userMsg'] = 'An error has ocurred';
            $response['errorDetail'] = $contact;

            return json_encode($response);
        }
    }

    public function actionAdminSwitch(Request $request)
    {
        $this->peopleController = new People;
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

        $people = $this->peopleController->getPeople($formData['peopleID']);

        if($people['error'] == 0)
        {
            $fieldData = array();
            $fieldData['IsMainContact'] = $formData['value'];

            $data = array();
            $data['fieldData'] = $fieldData;

            $result = $this->peopleController->objUpdatePeoples($people['data'][0]['recordID'], $data);

            return $result;
        }
        else
        {
            $response['error'] = 1;
            $response['userMsg'] = 'An error has ocurred';
            $response['errorDetail'] = json_encode($people);
        }
    }

    public function getOrderChartData()
    {
        $requestFM = array();
        $requestFM['NCPDP'] = "==". session('NCPDP');
        $requestFM['sqlTable'] = "==order";
        $requestFM['sqlCommand'] = "==insert";

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;
        $criteria['limit'] = 999999;

        $result = $this->fm->findRecords($criteria, 'PHP_OrganizationLogsDashboard');
        $return = array();

        if($this->error($result) === 0)
        {
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

            $countOrders = sizeof($result['response']['data']);

            for($i = 0 ; $i < $countOrders; $i++)
            {
                $creationTimestamp = $result['response']['data'][$i]['fieldData']['CreationTimestamp'];
                $mont = date('n', strtotime($creationTimestamp));

                switch ($mont)
                {
                    case 1:
                        $jan ++;
                    break;
                    case 2:
                        $feb ++;
                    break;
                    case 3:
                        $mar ++;
                    break;
                    case 4:
                        $apr ++;
                    break;
                    case 5:
                        $may ++;
                    break;
                    case 6:
                        $jun ++;
                    break;
                    case 7:
                        $jul ++;
                    break;
                    case 8:
                        $aug ++;
                    break;
                    case 9:
                        $sep ++;
                    break;
                    case 10:
                        $oct ++;
                    break;
                    case 11:
                        $nov ++;
                    break;
                    case 12:
                        $dec ++;
                    break;
                }
            }

            $return['error'] = 0;
            $return['totalOrders'] = $countOrders;
            $return['jan'] = $jan;
            $return['feb'] = $feb;
            $return['mar'] = $mar;
            $return['apr'] = $apr;
            $return['may'] = $may;
            $return['jun'] = $jun;
            $return['jul'] = $jul;
            $return['aug'] = $aug;
            $return['sep'] = $sep;
            $return['oct'] = $oct;
            $return['nov'] = $nov;
            $return['dec'] = $dec;
        }
        else
        {
            $return['error'] = 1;
            $return['userMsg'] = 'An error has ocurred';
            $return['method'] = 'getOrderChartData';
            $return['fmError'] = $this->error($result);
        }

        return json_encode($return);
    }
}
