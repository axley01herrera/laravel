<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Contact;
use Illuminate\Routing\Controller as BaseController;
use App\Models\RestFM;
use Illuminate\Http\Request;
use App\Mail\SendInvitation;
use Illuminate\Support\Facades\Mail;

class People extends BaseController
{
    public $fm;
    public $contactController;

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

    public function getPeople($id = '', $recordID = '')
    {
        $requestFM = array();

        if(!empty($id))
            $requestFM['__kp_PEOPLE_ID'] = "==". $id;

        if(!empty($recordID))
            $requestFM['RecordID'] = "==". $recordID;

        if(empty($requestFM))
            $requestFM['__kp_PEOPLE_ID'] = "==". (string)session('peopleID');

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_People');
        $return = array();

        if($this->error($result) === 0)
        {
            $record = array();
            $record['recordID'] = (string)$result['response']['data'][0]['fieldData']['RecordID'];
            $record['id'] = (string)$result['response']['data'][0]['fieldData']['__kp_PEOPLE_ID'];
            $record['companyID'] = (string)$result['response']['data'][0]['fieldData']['_kf_COMPANY_ID'];
            $record['contactID'] = (string)$result['response']['data'][0]['fieldData']['_kf_CONTACT_ID'];
            $record['tempID'] = (string)$result['response']['data'][0]['fieldData']['_kf_TEMP_ID'];
            $record['name'] = (string)$result['response']['data'][0]['fieldData']['NameFirst'];
            $record['dob'] = (string)$result['response']['data'][0]['fieldData']['DateOfBirth'];
            $record['lastName'] = (string)$result['response']['data'][0]['fieldData']['NameLast'];
            $record['phoneM'] = (string)preg_replace("/[^A-Za-z0-9 ]/", "", $result['response']['data'][0]['fieldData']['PhoneMobile']);
            $record['phoneW'] = (string)preg_replace("/[^A-Za-z0-9 ]/", "", $result['response']['data'][0]['fieldData']['PhoneWork']);
            $record['email'] = (string)$result['response']['data'][0]['fieldData']['Email'];
            $record['address']['line1'] = (string)$result['response']['data'][0]['fieldData']['AddressLine1'];
            $record['address']['line2'] = (string)$result['response']['data'][0]['fieldData']['AddressLine2'];
            $record['address']['zip'] = (string)$result['response']['data'][0]['fieldData']['AddressZip'];
            $record['address']['city'] = (string)$result['response']['data'][0]['fieldData']['AddressCity'];
            $record['address']['state'] = (string)$result['response']['data'][0]['fieldData']['AddressState'];
            $record['address']['country'] = (string)$result['response']['data'][0]['fieldData']['Country'];
            $record['status'] = (string)$result['response']['data'][0]['fieldData']['Status'];
            $record['type'] = (string)$result['response']['data'][0]['fieldData']['Type'];
            $record['isMainContact'] = (string)$result['response']['data'][0]['fieldData']['IsMainContact'];

            $records = array();
            $records[0] = $record;

            $return['error'] = 0;
            $return['data'] = $records;
        }
        else
        {
            $return['error'] = 1;
            $return['msg'] = 'An error has ocurred';
            $return['method'] = 'getPeopleByID';
            $return['fmError'] = $this->error($result);
        }

        return $return;
    }

    public function createPeople(Request $request)
    {
        $this->contactController = new Contact;
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

        $fieldData = array();
        $fieldData['_kf_COMPANY_ID'] = (string)session('companyID');
        $fieldData['NameFirst'] = $formData['name'];
        $fieldData['NameLast'] = $formData['lastName'];
        $fieldData['Email'] = $formData['email'];
        if(!empty($formData['phoneM'])) $fieldData['PhoneMobile'] = preg_replace("/[^A-Za-z0-9 ]/", "", $formData['phoneM']);
        if(!empty($formData['phoneW'])) $fieldData['PhoneWork'] = preg_replace("/[^A-Za-z0-9 ]/", "", $formData['phoneW']);
        $fieldData['IsMainContact'] = $formData['admin'];

        $data = array();
        $data['fieldData'] = $fieldData;

        $resultCreate = $this->fm->createRecord($data, 'PHP_People'); // CREATE PEOPLE

        if($this->error($resultCreate) === 0)
        {
            $people = $this->getPeople('', $resultCreate['response']['recordId']);

            if($people['error'] == 0)
            {
                $resultCreateCompanyPeople = $this->createCompanyPeople($people['data'][0]['id']); // CREATE COMPANY PEOPLE

                if($resultCreateCompanyPeople['error'] == 0)
                {
                    $response['error'] = 0;
                    $response['userMsg'] = 'Success';

                    if($formData['invitation'] == 1)
                    {
                        $resultSendInvitation = $this->contactController->sendInvitationProcess($people['data'][0]['id']); // SEND INVITATION

                        if($resultSendInvitation['error'] === 0)
                        {
                            $link = route('newUser').'?token='.$resultSendInvitation['data'][0]['token'];

                            Mail::to($formData['email'])->send(new SendInvitation($link));

                            $response['error'] = 0;
                            $response['userMsg'] = 'Success';

                            return json_encode($response);
                        }
                        else // ERROR SEND INVITATION
                        {
                            $response['error'] = 1;
                            $response['userMsg'] = 'An error has ocurred';
                            $response['errorDetail'] = $resultSendInvitation;

                            return json_encode($response);
                        }
                    }
                }
                else // ERROR CREATE COMPANY PEOPLE
                {
                    $response['error'] = 1;
                    $response['userMsg'] = 'An error has ocurred';
                    $response['method'] = 'resultCreateCompanyPeople';
                    $response['errorDetail'] = $resultCreateCompanyPeople;

                    return json_encode($response);
                }
            }
            else // ERROR GET PEOPLE
            {
                $response['error'] = 1;
                $response['userMsg'] = 'An error has ocurred';
                $response['method'] = 'getPeople';
                $response['fmError'] = $people;
            }
        } // ERROR CREATE PEOPLE
        else
        {
            $response['error'] = 1;
            $response['userMsg'] = 'An error has ocurred';
            $response['method'] = 'createPeople';
            $response['fmError'] = $this->error($resultCreate);
        }

        return json_encode($response);
    }

    public function updatePeople(Request $request)
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

        $fieldData = array();
        $fieldData['_kf_COMPANY_ID'] = (string)session('companyID');
        $fieldData['NameFirst'] = $formData['name'];
        $fieldData['NameLast'] = $formData['lastName'];
        $fieldData['Email'] = $formData['email'];
        if(!empty($formData['phoneM'])) $fieldData['PhoneMobile'] = preg_replace("/[^A-Za-z0-9 ]/", "", $formData['phoneM']);
        if(!empty($formData['phoneW'])) $fieldData['PhoneWork'] = preg_replace("/[^A-Za-z0-9 ]/", "", $formData['phoneW']);

        $data = array();
        $data['fieldData'] = $fieldData;

        $result = $this->objUpdatePeoples($formData['peopleRecordID'], $data);

        return $result;
    }

    public function createCompanyPeople($peopleID)
    {
        $fieldData = array();
        $fieldData['_kf_COMPANY_ID'] = (string)session('companyID');
        $fieldData['_kf_PEOPLE_ID'] = $peopleID;

        $data = array();
        $data['fieldData'] = $fieldData;

        $result = $this->fm->createRecord($data, 'PHP_Company_People');
        $return = array();

        if($this->error($result) === 0)
        {
            $return['error'] = 0;
            $return['userMsg'] = 'success';
        }
        else
        {
            $return['error'] = 1;
            $return['userMsg'] = 'An error has ocurred';
            $return['method'] = 'createCompanyPeople';
            $return['fmError'] = $this->error($result);
        }

        return $return;
    }

    public function objUpdatePeoples($recordID, $data)
    {
        $result = $this->fm->editRecord($recordID, $data, 'PHP_People');
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

    public function returnModalEditPeople()
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        $people = $this->getPeople();

        if($people['error'] == 0)
        {
            $data = array();
            $data['people'] = $people['data'][0];

            return view('app.account.profile.modals.people', $data);
        }
    }

    public function updatePersonalInformation(Request $request)
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
        if(isset($formData['name'])) $fieldData['NameFirst'] = $formData['name'];
        if(isset($formData['lastName'])) $fieldData['NameLast'] = $formData['lastName'];
        if(isset($formData['dob'])) $fieldData['DateOfBirth'] = $formData['dob'];
        if(isset($formData['phoneM'])) $fieldData['PhoneMobile'] = $formData['phoneM'];
        if(isset($formData['phoneW'])) $fieldData['PhoneWork'] = $formData['phoneW'];
        if(isset($formData['addressLine1'])) $fieldData['AddressLine1'] = $formData['addressLine1'];
        if(isset($formData['addresLine2'])) $fieldData['AddressLine2'] = $formData['addresLine2']; else $fieldData['AddressLine2'] = '';
        if(isset($formData['city'])) $fieldData['AddressCity'] = $formData['city'];
        if(isset($formData['state'])) $fieldData['AddressState'] = $formData['state'];
        if(isset($formData['zip'])) $fieldData['AddressZip'] = $formData['zip'];
        if(isset($formData['country'])) $fieldData['Country'] = $formData['country'];
        if(isset($formData['email'])) $fieldData['Email'] = $formData['email'];

        $data = array();
        $data['fieldData'] = $fieldData;

        $result = $this->fm->editRecord($formData['peopleRecordID'], $data, 'PHP_People');

        if($this->error($result) === 0)
        {
            $response = array();
            $response['error'] = 0;
            $response['userMsg'] = 'Personal Information updated';

            return json_encode($response);
        }
        else
        {
            $response = array();
            $response['error'] = 1;
            $response['userMsg'] = 'An error has ocurred';
            $response['method'] = 'updatePersonalInformation';
            $response['fmError'] = $this->error($result);

            return json_encode($response);
        }
    }

    public function peopleDetail(Request $request)
    {
         # VERIFY SESSION
         $resultVerifySession = session('status');

         if($resultVerifySession == NULL || $resultVerifySession == 0)
             return view('app.logout');

        $formData = $request->input('post');

        $people = $this->getPeople($formData['peopleID']);

        if($people['error'] <> 0)
        {
            $data = array();
            $data['error'] = json_encode( $people);

            return view('app.errorLoadContent', $data);
        }

        $data = array();
        $data['people'] = $people['data']['0'];

        return view('app.account.contacts.mainDetail', $data);
    }

    public function modalCreatePeople(Request $request)
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        $formData = $request->input('post');
        $data = array();

        if($formData['action'] == 'add')
        {
            $data['modalTitle'] = 'Create Contact';
            $data['action'] = $formData['action'];
        }
        elseif($formData['action'] == 'edit')
        {
            $people = $this->getPeople($formData['peopleID'], '');
            $data['modalTitle'] = 'Edit Contact';
            $data['action'] = $formData['action'];
            $data['people'] = $people['data'][0];
        }

        return view('app.account.contacts.modalCreatePeople', $data);
    }
}
