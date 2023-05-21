<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use App\Models\RestFM;
use Illuminate\Http\Request;
use App\Mail\TicketMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Contact;
use Illuminate\Support\Arr;

class Ticket extends BaseController
{
    public $fm;
    public $contactController;

    public function __construct()
    {
        # OBJ MODELS
        $this->fm = new RestFM;

        # OBJ CONTROLLERS
        $this->contactController = new Contact;
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

    public function ticketServerSideProcessingDataTableOpen()
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

        $tickets = $this->getTickets($params);

        if($tickets['error'] == 0)
        {
            $totalRows = sizeof($tickets['data']);

            for($i = 0; $i < $totalRows; $i++)
            {
                if (intval($tickets['data'][$i]['fieldData']['Ticket_Status_n']) < 6)
                {
                    $row = array();
                    $row['number'] = '<a href="#" class="ticket" data-recordid="'.$tickets['data'][$i]['fieldData']['RecordID'].'">'.$tickets['data'][$i]['fieldData']['__kp_SUPPORTTICKET_ID'].'</a>';
                    $row['title'] = $tickets['data'][$i]['fieldData']['Description_Title'];
                    $row['createdDate'] = $tickets['data'][$i]['fieldData']['_zhk_CreatedDateText'].' '.$tickets['data'][$i]['fieldData']['_zhk_CreatedTime'];
                    $row['createdDateTmstp'] = strtotime($row['createdDate']);
                    $row['severity'] = $tickets['data'][$i]['fieldData']['Ticket_Severity_name'];
                    $row['priority'] = $tickets['data'][$i]['fieldData']['Ticket_Priority_name'];
                    $row['type'] = $tickets['data'][$i]['fieldData']['Ticket_Type_name'];

                    $status = $tickets['data'][$i]['fieldData']['Ticket_Status_n'];
                    $row['status'] = strtolower($tickets['data'][$i]['fieldData']['Ticket_Status_name']).$status;

                    switch($status)
                    {
                        case 1:
                            $row['status'] = '<span class="badge badge-soft-primary">'.strtolower($tickets['data'][$i]['fieldData']['Ticket_Status_name']).'</span>';
                            break;
                        case 2:
                            $row['status'] = '<span class="badge badge-soft-warning">'.strtolower($tickets['data'][$i]['fieldData']['Ticket_Status_name']).'</span>';
                            break;
                        case 3:
                            $row['status'] = '<span class="badge badge-soft-success">'.strtolower($tickets['data'][$i]['fieldData']['Ticket_Status_name']).'</span>';
                            break;
                        case 4:
                            $row['status'] = '<span class="badge badge-soft-success">'.strtolower($tickets['data'][$i]['fieldData']['Ticket_Status_name']).'</span>';
                            break;
                        case 5:
                            $row['status'] = '<span class="badge badge-soft-secondary">'.strtolower($tickets['data'][$i]['fieldData']['Ticket_Status_name']).'</span>';
                            break;
                    }

                    $rows[$i] =  $row;
                }

            }

            if($totalRows > 0)
                $totalRecords = $tickets['foundCount'];
        }

        $data = array();
        $data['draw'] = $dataTableRequest['draw'];
        $data['recordsTotal'] = intval($totalRecords);
        $data['recordsFiltered'] = intval($totalRecords);
        $columns = array_column($rows, 'createdDateTmstp');
        array_multisort($columns, SORT_DESC, $rows);
        $data['data'] = $rows;

        return json_encode($data);
    }

    public function ticketServerSideProcessingDataTableHistory()
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

        $tickets = $this->getTickets($params);

        if($tickets['error'] == 0)
        {
            $totalRows = sizeof($tickets['data']);

            for($i = 0; $i < $totalRows; $i++)
            {
                $row = array();
                $row['number'] = '<a href="#" class="ticket" data-recordid="'.$tickets['data'][$i]['fieldData']['RecordID'].'">'.$tickets['data'][$i]['fieldData']['__kp_SUPPORTTICKET_ID'].'</a>';
                $row['title'] = $tickets['data'][$i]['fieldData']['Description_Title'];
                $row['createdDate'] = $tickets['data'][$i]['fieldData']['_zhk_CreatedDateText'].' '.$tickets['data'][$i]['fieldData']['_zhk_CreatedTime'];
                $row['createdDateTmstp'] = strtotime($row['createdDate']);
                $row['severity'] = $tickets['data'][$i]['fieldData']['Ticket_Severity_name'];
                $row['priority'] = $tickets['data'][$i]['fieldData']['Ticket_Priority_name'];
                $row['type'] = $tickets['data'][$i]['fieldData']['Ticket_Type_name'];

                $status = $tickets['data'][$i]['fieldData']['Ticket_Status_n'];
                $row['status'] = strtolower($tickets['data'][$i]['fieldData']['Ticket_Status_name']).$status;

                $row['status'] = '<span class="badge badge-soft-danger">'.strtolower($tickets['data'][$i]['fieldData']['Ticket_Status_name']).'</span>';

                if (intval($tickets['data'][$i]['fieldData']['Ticket_Status_n']) == 6 )
                    $rows[] =  $row;

            }

            if($totalRows > 0)
                $totalRecords = sizeof($rows);
        }

        $data = array();
        $data['draw'] = $dataTableRequest['draw'];
        $data['recordsTotal'] = intval($totalRecords);
        $data['recordsFiltered'] = intval($totalRecords);
        $columns = array_column($rows, 'createdDateTmstp');
        array_multisort($columns, SORT_DESC, $rows);
        $data['data'] = $rows;

        return json_encode($data);
    }

    public function modalCreateTicket(Request $request)
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        $formData = $request->input('post');
        $contact = $this->contactController->getContact();
        $supportSeverityValueList = $this->getSupportSeverityValueList();
        $supportPriorityValueList = $this->getSupportPriorityValueList();
        $supportTicketType = $this->getSupportTicketTypeValueList();

        if($contact['error'] <> 0) // VALIDATE ERROR REQUEST FM USER INFORMATION
        {
            $data = array();
            $data['error'] = json_encode($contact);

            return view('app.errorLoadContent', $data);
        }

        if($supportSeverityValueList['error'] <> 0) // VALIDATE ERROR REQUEST FM SUPPORT SEVERITY VALUE LIST
        {
            $data = array();
            $data['error'] = json_encode($supportSeverityValueList);

            return view('app.errorLoadContent', $data);
        }

        if($supportTicketType['error'] <> 0) // VALIDATE ERROR REQUEST FM SUPPORT TICKET TYPE VALUE LIST
        {
            $data = array();
            $data['error'] = json_encode($supportTicketType);

            return view('app.errorLoadContent', $data);
        }

        if($formData['action'] == 'add') // ADD
        {
            $data = array();
            $data['pageTitle'] = 'New Ticket';

            $data['contact'] = $contact['data'][0];
            $data['supportSeverityDropdown'] = $supportSeverityValueList['data'];
            $data['totalSupportSeverityDropdown'] = sizeof($data['supportSeverityDropdown']);
            $data['supportPriorityDropdown'] = $supportPriorityValueList['data'];
            $data['totalSupportPriorityDropdown'] = sizeof($data['supportPriorityDropdown']);
            $data['supportTicketTypeDropdown'] = $supportTicketType['data'];
            $data['totalSupportTicketTypeDropdown'] = sizeof($data['supportTicketTypeDropdown']);

            $data['action'] = $formData['action'];

            return view('app.ticket.modalCreateTicket', $data);
        }
    }

    public function ticketDetail(Request $request)
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        $formData = $request->input('post');

        $ticket = $this->getTicketByRecordID($formData['ticketRecordID']);

        $data = array();

        if($ticket['error'] == 0)
        {
            $documents = $this->getDocumentsByTicket($ticket['data'][0]['ticketID']);

            if($documents['error'] == 0)
            {
                $data['ticketDetail'] = $ticket['data'][0];
                $data['portalTimeLogs'] = $ticket['portalTimeLogs'];
                $data['countTimeLogs'] = sizeof($data['portalTimeLogs']);
                $data['ticketDocuments'] = $documents['data'];
                $data['totalDocuments'] = sizeof($data['ticketDocuments']);

                return view('app.ticket.ticketDetail', $data);
            }
            else
            {
                $data['error'] = json_encode($documents);

                return view('app.errorLoadContent', $data);
            }
        }
        else
        {
            $data = array();
            $data['error'] = json_encode($ticket);

            return view('app.errorLoadContent', $data);
        }
    }

    public function getTickets($params)
    {
        if(!empty($params['search']))
        {
            $requestFM0['__kp_SUPPORTTICKET_ID'] = $params['search'];
            $requestFM0['_kf_Contact_ID'] = "==".session('contactID');

            $requestFM1['Description_Title'] = $params['search'];
            $requestFM1['_kf_Contact_ID'] = "==".session('contactID');

            $requestFM2['_zhk_CreatedDateText'] = $params['search'];
            $requestFM2['_kf_Contact_ID'] = "==". session('contactID');

            $requestFM3['Ticket_Severity_name'] = $params['search'];
            $requestFM3['_kf_Contact_ID'] = "==".session('contactID');

            $requestFM4['Ticket_Type_name'] = $params['search'];
            $requestFM4['_kf_Contact_ID'] = "==".session('contactID');

            $requestFM5['Ticket_Status_name'] = $params['search'];
            $requestFM5['_kf_Contact_ID'] = "==".session('contactID');


            $query = array($requestFM0,  $requestFM1, $requestFM2, $requestFM3, $requestFM4, $requestFM5);
        }
        else
        {
            $requestFM = array();
            $requestFM['_kf_Contact_ID'] = "==".session('contactID');

            $query = array($requestFM);
        }

        $criteria = array();
        $criteria['query'] = $query;
        $criteria['offset'] = $params['start'] + 1;
        $criteria['limit'] = $params['length'];
        $criteria['sort'] = $this->getSort($params['sortColumn'], $params['sortDir']);

        $result = $this->fm->findRecords($criteria, 'PHP_Tickets');

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
                $sort1['fieldName'] = '__kp_SUPPORTTICKET_ID';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = '__kp_SUPPORTTICKET_ID';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        if($column == 1)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'Description_Title';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'Description_Title';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        elseif($column == 2)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = '_zhk_CreatedDate';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = '_zhk_CreatedDate';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        elseif($column == 3)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'Ticket_Severity_name';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'Ticket_Severity_name';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        elseif($column == 4)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'Ticket_Type_name';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'Ticket_Type_name';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }
        elseif($column == 5)
        {
            if($dir == 'asc')
            {
                $sort1['fieldName'] = 'Ticket_Status_name';
                $sort1['sortOrder'] = 'ascend';
                $sort = array ($sort1);
            }
            elseif($dir == 'desc')
            {
                $sort1['fieldName'] = 'Ticket_Status_name';
                $sort1['sortOrder'] = 'descend';
                $sort = array ($sort1);
            }
        }

        return $sort;
    }

    public function ticketSubmit(Request $request)
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

        if($formData['action'] == 'add') // ADD
        {
            $fieldData = array();
            $fieldData['_kf_Contact_ID'] = session('contactID');
            $fieldData['_kf_People_ID'] = session('peopleID');
            $fieldData['Description_Title'] = $formData['title'];
            $fieldData['Ticket_Severity_n'] = $formData['supportSeverity'];
            $fieldData['Ticket_Priority_n'] = $formData['supportPriority'];
            $fieldData['Ticket_Type_n'] = $formData['supportType'];
            $fieldData['Description_Issue'] = $formData['description'];

            $data = array();
            $data['fieldData'] = $fieldData;

            $result = $this->fm->createRecord($data, 'PHP_Tickets'); // CREATE

            if($this->error($result) === 0) // SUCCESS
            {
                $response['error'] = 0;
                $response['userMsg'] = 'Success';
                $response['recordID'] = $result['response']['recordId'];
                $response['data'] = $data;

                return json_encode($response);
            }
            else // ERROR
            {
                $response['error'] = 1;
                $response['userMsg'] = 'An error has ocurred';
                $response['method'] = 'ticketSubmit';
                $response['fmError'] = $this->error($result);
                $response['data'] = $data;

                return json_encode($response);
            }
        }
    }

    public function getSupportSeverityValueList()
    {
        $requestFM = array();
        $requestFM['SupportTicketSeverity'] = "*";

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_ValueList'); // FIND

        if($this->error($result) === 0) // SUCCESS
        {
            $records = array();
            $countResult = sizeof($result['response']['data']);

            for($i = 0; $i < $countResult; $i++)
            {
                $record = array();
                $record['id'] = (string)$result['response']['data'][$i]['fieldData']['_zhk_RecordSerialNumber'];
                $record['text'] = $result['response']['data'][$i]['fieldData']['SupportTicketSeverity'];

                $records[$i] = $record;
            }

            $return = array();
            $return['error'] = 0;
            $return['data'] = $records;

            return $return;
        }
        else // ERROR
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'An error has ocurred';
            $return['metod'] = 'getSupportSeverityValueList';
            $return['fmError'] = $this->error($result);

            return $return;
        }
    }

    public function getSupportPriorityValueList()
    {
        $requestFM = array();
        $requestFM['SupportTicketPriority'] = "*";

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_ValueList'); // FIND

        if($this->error($result) === 0) // SUCCESS
        {
            $records = array();
            $countResult = sizeof($result['response']['data']);

            for($i = 0; $i < $countResult; $i++)
            {
                $record = array();
                $record['id'] = (string)$result['response']['data'][$i]['fieldData']['_zhk_RecordSerialNumber'];
                $record['text'] = $result['response']['data'][$i]['fieldData']['SupportTicketPriority'];

                $records[$i] = $record;
            }

            $return = array();
            $return['error'] = 0;
            $return['data'] = $records;

            return $return;
        }
        else // ERROR
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'An error has ocurred';
            $return['metod'] = 'getSupportSeverityValueList';
            $return['fmError'] = $this->error($result);

            return $return;
        }
    }

    public function getSupportTicketTypeValueList()
    {
        $requestFM = array();
        $requestFM['SupportTicketType'] = "*";

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_ValueList'); // FIND

        if($this->error($result) === 0) // SUCCESS
        {
            $records = array();
            $countResult = sizeof($result['response']['data']);

            for($i = 0; $i < $countResult; $i++)
            {
                $record = array();
                $record['id'] = (string)$result['response']['data'][$i]['fieldData']['_zhk_RecordSerialNumber'];
                $record['text'] = $result['response']['data'][$i]['fieldData']['SupportTicketType'];

                $records[$i] = $record;
            }

            $return = array();
            $return['error'] = 0;
            $return['data'] = $records;

            return $return;
        }
        else // ERROR
        {
            $return = array();
            $return['error'] = 1;
            $return['msg'] = 'An error has ocurred';
            $return['metod'] = 'getSupportSeverityValueList';
            $return['fmError'] = $this->error($result);

            return $return;
        }
    }

    public function ticketUploadScreemshot()
    {
        if(!empty($_FILES['fileImage']))
        {
            $resultGetTicketID = $this->getTicketByRecordID($_POST['recordID']);

            if($resultGetTicketID['error'] == 0)
            {
                $files = $_FILES['fileImage'];
                $totalFiles = sizeof($files['name']);

                for($i = 0; $i < $totalFiles; $i++)
                {
                    $fieldData = array();
                    $fieldData['_kf_SUPPORTTICKET_ID'] = $resultGetTicketID['data'][0]['ticketID'];
                    $fieldData['SupportTicket_ImageType'] = 1;

                    $data = array();
                    $data['fieldData'] = $fieldData;

                    $resultCreateRecord = $this->fm->createRecord($data, 'PHP_Documents');

                    if($this->error($resultCreateRecord) === 0)
                    {
                        $documentRecordID = $resultCreateRecord['response']['recordId'];
                        $fieldName = 'File Container';

                        $file = array();
                        $file['name'] = $files['name'][$i];
                        $file['type'] = $files['type'][$i];
                        $file['tmp_name'] = $files['tmp_name'][$i];
                        $file['size'] = $files['size'][$i];

                        $resultUploadContainer = $this->fm->uploadContainer($documentRecordID, $fieldName, $file, $repetition = 1, 'PHP_Documents');

                        if($this->error($resultUploadContainer))

                        $response = array();
                        $response['error'] = 0;
                        $response['userMsg'] = 'Files uploaded successfully';
                    }
                    else
                    {
                        $response = array();
                        $response['error'] = 1;
                        $response['userMsg'] = 'An error has ocurred';
                        $response['method'] = 'resultCreateRecord';
                        $response['fmError'] = $this->error($resultCreateRecord);

                        return json_encode($response);
                    }
                }

                return json_encode($response);
            }
            else
            {
                $response = array();
                $response['error'] = 1;
                $response['userMsg'] = 'An error has ocurred';
                $response['method'] = 'resultGetTicketID';
                $response['fmError'] = $resultGetTicketID;

                return json_encode($response);
            }
        }
    }

    public function getTicketByRecordID($recordID)
    {
        $requestFM = array();
        $requestFM['RecordID'] = "==". $recordID;

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Tickets');
        $return = array();

        if($this->error($result) === 0)
        {
            $record = array();
            $record['ticketID'] = (string)$result['response']['data'][0]['fieldData']['__kp_SUPPORTTICKET_ID'];
            $record['title'] = (string)$result['response']['data'][0]['fieldData']['Description_Title'];
            $record['peopleID'] = (string)$result['response']['data'][0]['fieldData']['_kf_People_ID'];
            $record['companyID'] = (string)$result['response']['data'][0]['fieldData']['_kf_Company_ID'];
            $record['contactID'] = (string)$result['response']['data'][0]['fieldData']['_kf_Contact_ID'];
            $record['developerID'] = (string)$result['response']['data'][0]['fieldData']['_kf_Developer_ID'];
            $record['companyName'] = (string)$result['response']['data'][0]['fieldData']['Company_Name'];
            $record['ticketSeverityName'] = (string)$result['response']['data'][0]['fieldData']['Ticket_Severity_name'];
            $record['ticketPriorityName'] = (string)$result['response']['data'][0]['fieldData']['Ticket_Priority_name'];
            $record['ticketStatusName'] = strtolower((string)$result['response']['data'][0]['fieldData']['Ticket_Status_name']);
            $record['ticketStatusN'] = (string)$result['response']['data'][0]['fieldData']['Ticket_Status_n'];
            $record['ticketTypeName'] = (string)$result['response']['data'][0]['fieldData']['Ticket_Type_name'];
            $record['descriptionIssue'] = (string)$result['response']['data'][0]['fieldData']['Description_Issue'];
            $record['descriptionIssueDisplay'] = (string)$result['response']['data'][0]['fieldData']['Description_Issue_display'];
            $record['descriptionResolutionDisplay'] = (string)$result['response']['data'][0]['fieldData']['Description_Resolution_display'];
            $record['descriptionResolutionFinal'] = (string)$result['response']['data'][0]['fieldData']['Description_Resolution_Final'];
            $record['peopleEmail'] = (string)$result['response']['data'][0]['fieldData']['People_Email'];
            $record['peopleNameFirst'] = (string)$result['response']['data'][0]['fieldData']['People_NameFirst'];
            $record['peopleNameFullTitle'] = (string)$result['response']['data'][0]['fieldData']['People_NameFullTitle'];
            $record['peopleNameLast'] = (string)$result['response']['data'][0]['fieldData']['People_NameLast'];
            $record['peoplePhone'] = (string)$result['response']['data'][0]['fieldData']['People_Phone'];
            $record['recordID'] = (string)$result['response']['data'][0]['fieldData']['RecordID'];
            $record['dateResolved'] = (string)$result['response']['data'][0]['fieldData']['Date_Resolved'];
            $record['creationDate'] = (string)$result['response']['data'][0]['fieldData']['_zhk_CreatedDate'];
            $record['creationTime'] = (string)$result['response']['data'][0]['fieldData']['_zhk_CreatedTime'];

            $portalTimeLogs = $result['response']['data'][0]['portalData']['portalTimeLogs'];
            $countPortalTimeLogs = sizeof($portalTimeLogs);
            $recordsTimeLogs = array();

            for($i = 0; $i < $countPortalTimeLogs; $i++)
            {
                $recordTimeLogs = array();
                $recordTimeLogs['recordID'] = $portalTimeLogs[$i]['recordId'];
                $recordTimeLogs['by'] = $portalTimeLogs[$i]['PHP_Ticket_People::NameFull'];
                $recordTimeLogs['date'] = $portalTimeLogs[$i]['PHP_Time::_zhk_CreatedDate'];
                $recordTimeLogs['time'] = $portalTimeLogs[$i]['PHP_Time::_zhk_CreatedTime'];
                $recordTimeLogs['description'] = $portalTimeLogs[$i]['PHP_Time::Description'];

                $recordsTimeLogs[$i] = $recordTimeLogs;
            }

            $records = array();
            $records[0] = $record;

            $return['error'] = 0;
            $return['data'] = $records;
            $return['portalTimeLogs'] = $recordsTimeLogs;
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

    public function ticketSendEmailAfterCreate(Request $request)
    {
        $formData = $request->input('post');

        $ticketDetail = $this->getTicketByRecordID($formData['ticketRecordID']);

        if($ticketDetail['error'] == 0)
        {
            $emailData = array();
            $emailData['title'] = 'New Ticket';
            $emailData['number'] = $ticketDetail['data'][0]['ticketID'];
            $emailData['creationDate'] = $ticketDetail['data'][0]['creationDate'].' '.$ticketDetail['data'][0]['creationTime'];
            $emailData['description'] = $ticketDetail['data'][0]['descriptionIssue'];
            $emailData['contact']['companyName'] = $ticketDetail['data'][0]['companyName'];
            $emailData['contact']['peopleNameFullTitle'] = $ticketDetail['data'][0]['peopleNameFullTitle'];
            $emailData['contact']['peopleEmail'] = $ticketDetail['data'][0]['peopleEmail'];
            $emailData['contact']['peoplePhone'] = $ticketDetail['data'][0]['peoplePhone'];
            $emailData['contact']['recordID'] = $ticketDetail['data'][0]['recordID'];
            $emailData['companyID'] = $ticketDetail['data'][0]['companyID'];
            $emailData['peopleID'] = $ticketDetail['data'][0]['peopleID'];


            // icsupport@isakcomputing.com TODO

            Mail::to('do.not.reply.the.msg@gmail.com')->send(new TicketMail($emailData)); // SEND EMAIL

            $response = array();
            $response['error'] = 0;
            $response['userMsg'] = 'Success send email';

            return json_encode($response);
        }
        else
        {
            $response = array();
            $response['error'] = 1;
            $response['method'] = 'ticketSendEmailAfterCreate';
            $response['fmError'] = $ticketDetail;

            return json_encode($response);
        }
    }

    public function getDocumentsByTicket($ticketID)
    {
        $requestFM = array();
        $requestFM['_kf_SUPPORTTICKET_ID'] = "==".$ticketID;

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Documents');

        if($this->error($result) === 0)
        {
            $records = array();
            $totalRecords = sizeof($result['response']['data']);

            for($i = 0; $i < $totalRecords; $i++)
            {
                $record = array();
                $record['document'] = $result['response']['data'][$i]['fieldData']['File Container'];

                $records[$i] = $record;
            }

            $return = array();
            $return['error'] = 0;
            $return['data'] = $records;

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
            $return['method'] = 'getDocumentsByTicket';
            $return['fmError'] = $this->error($result);

            return $return;
        }
    }

    public function requestApiAccess()
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

        $fieldData = array();
        $fieldData['_kf_Contact_ID'] = session('contactID');
        $fieldData['_kf_People_ID'] = session('peopleID');
        $fieldData['Description_Title'] = 'Request API Access';
        $fieldData['Description_Issue'] = 'We are requesting access to the API';
        $fieldData['Ticket_Severity_n'] = 4;
        $fieldData['Ticket_Type_n'] = 3;

        $data = array();
        $data['fieldData'] = $fieldData;

        $result = $this->fm->createRecord($data, 'PHP_Tickets');

        if($this->error($result) === 0)
        {
            $response = array();
            $response['error'] = 0;
            $response['userMsg'] = 'Ticket created';
            $response['recordID'] = $result['response']['recordId'];
            $response['data'] = $data;

            return json_encode($response);
        }
        else
        {
            $response = array();
            $response['error'] = 1;
            $response['userMsg'] = 'An error has ocurred';
            $response['method'] = 'ticketSubmit';
            $response['fmError'] = $this->error($result);
            $response['data'] = $data;

            return json_encode($response);
        }
    }

    public function getNewTicketDT()
    {
        $newTickets = $this->getNewTickets();

        if($newTickets['error'] <> 0)
        {
            $data['error'] = json_encode($newTickets);
            return view('app.errorLoadContent', $data);
        }

        $data = array();
        $data['newTickets'] = $newTickets['data'];
        $data['countNewTickets'] = sizeof($newTickets['data']);

        return view('app.dashboard.layouts.tbodyNewTickets', $data);
    }

    public function getNewTickets()
    {
        $requestFM = array();
        $requestFM['Ticket_Status_n'] = "<=2";
        $requestFM['_kf_Contact_ID'] = "==".session('contactID');

        $query = array($requestFM);

        $criteria = array();
        $criteria['query'] = $query;

        $result = $this->fm->findRecords($criteria, 'PHP_Tickets');

        $return = array();
        $records = array();

        if($this->error($result) === 0)
        {
            $count = sizeof($result["response"]["data"]);

            for($i = 0; $i < $count; $i++)
            {
                $record = array();
                $record['recordID'] = (string)$result['response']['data'][$i]['fieldData']['RecordID'];
                $record['number'] = (string)$result['response']['data'][$i]['fieldData']['__kp_SUPPORTTICKET_ID'];
                $record['subject'] = (string)$result['response']['data'][$i]['fieldData']['Description_Title'];
                $record['createdDate'] = (string)$result['response']['data'][$i]['fieldData']['_zhk_CreatedDateText'];
                $record['createdDateTmstp'] = strtotime($result['response']['data'][$i]['fieldData']['_zhk_CreatedDateText'].' '.$result['response']['data'][$i]['fieldData']['_zhk_CreatedTime']);
                $record['severiry'] = (string)$result['response']['data'][$i]['fieldData']['Ticket_Severity_name'];
                $record['type'] = (string)$result['response']['data'][$i]['fieldData']['Ticket_Type_name'];

                $records[$i] = $record;
            }

            $return['error'] = 0;
            $columns = array_column($records, 'createdDateTmstp');
            array_multisort($columns, SORT_DESC, $records);
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
            $return['method'] = 'getNewTickets';
            $return['fmError'] = $this->error($result);
        }

        return $return;
    }

    public function modalNote(Request $request)
    {
        # VERIFY SESSION
        $resultVerifySession = session('status');

        if($resultVerifySession == NULL || $resultVerifySession == 0)
            return view('app.logout');

        $formData = $request->input('post');

        $data = array();
        $data['callFrom'] = $formData['callFrom'];
        $data['action'] = $formData['action'];

        if($formData['action'] == 'add')
        {
            $data['pageTitle'] = 'New Note';
            $data['ticketRecordID'] = $formData['ticketRecordID'];
            $data['ticketID'] = $formData['ticketID'];
        }

        return view('app.ticket.modalNote', $data);
    }

    public function saveNote(Request $request)
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
        $fieldData['_kf_SupportTicket_ID'] = $formData['ticketID'];
        $fieldData['Description'] = $formData['description'];
        $fieldData['_zhk_CreatedName'] = session('peopleID');
        $fieldData['isShowInCustomerPortal'] = 1;

        $data = array();
        $data['fieldData'] = $fieldData;

        if($formData['action'] == 'add')
            $result = $this->fm->createRecord($data, 'PHP_Time'); // CREATE

        if($this->error($result) === 0) // SUCCESS
        {
            $response['error'] = 0;
            $response['userMsg'] = 'Success';
            $response['recordID'] = $result['response']['recordId'];
            $response['data'] = $data;
        }
        else // ERROR
        {
            $response['error'] = 1;
            $response['userMsg'] = 'An error has ocurred';
            $response['method'] = 'ticketSubmit';
            $response['fmError'] = $this->error($result);
            $response['data'] = $data;
        }

        return json_encode($response);
    }
}
