<?php
/**
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above PCTECKSERV notice.
 *  *
 *  *
 * ***********************************************************************
 */

defined('BASEPATH') or exit('No direct script access allowed');



class Events extends CI_Controller

{

    public function __construct()

    {

        parent:: __construct();



        $this->load->model('settings_model', 'system');



        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }



        if (!$this->aauth->premission(6)) {



            exit($this->lang->line('translate19'));



        }

        $this->load->model('events_model');

        $this->li_a = 'misc';



    }


    public function index() {

        $this->load->model('employee_model', 'employee');

        $data['employees'] = $this->employee->list_employee();

        $data['eventTypes'] = $this->db->select("*")->from("geopos_events_type")->get()->result();

        $this->load->view('fixed/header');

        $this->load->view('events/cal', $data);

        $this->load->view('fixed/footer');
    }


    function getEventArray($event,$start,$end){
        return array(
            'id' => $event->id,
            'title' => $event->title,
            'start' => $start,
            'end' => $event->end,
            // 'url' => $event->url,
            'allDay'=>$event->allDay,
            'color'=>$event->color,
            'description'=>$event->description,
            'event_repeat' => $event->event_repeat,
            'event_type' => $event->event_type,
            'event_associated' => $event->event_associated,
            'employee_id' => $event->id,
        );
    }

    /*Get all Events */

    public function getEvents()
    {
        $start = $this->input->get('start');
        $end = $this->input->get('end');
        $result = $this->events_model->getEvents($start, $end);
        // print_r($result);die;
        $i=0;

        $items = array();
        foreach ($result as $key => $event) {

                if ($event->event_repeat == 1) {
                    foreach ($this->getDailyTasks($event) as $s) {
                        array_push($items, $s);
                    }
                }else

                if ($event->event_repeat == 2) {
                    foreach ($this->getWeeklyTasks($event) as $s) {
                        array_push($items, $s);
                    }
                }else

                if ($event->event_repeat == 3) {
                    foreach ($this->getMonthlyTasks($event) as $s) {
                        array_push($items, $s);
                    }
                }else
                if ($event->event_repeat == 4) {
                    foreach ($this->getYearlyTasks($event) as $s) {
                        array_push($items, $s);
                    }
                } else {
                    foreach ($this->getDayTask($event) as $s) {
                        array_push($items, $s);
                    }
                }

            // $data[$i]['id'] = $value->id;
            // $data[$i]['title'] = $value->title;
            // $data[$i]['start'] = $value->start;
            // $data[$i]['end'] = $value->end;
            // $data[$i]['allDay'] = $value->allDay;
            // $data[$i]['color'] = $value->color;
            // $data[$i]['description'] = $value->description;
            // $i++;
            // if($value->event_repeat == 2){
            //     $start_date = $value->start;  
            //     $date = strtotime($start_date);
            //     $date = strtotime("+7 day", $date);
            //     // echo date('Y/m/d', $date);
            //     $data[$i]['id'] = $value->id;
            //     $data[$i]['title'] = $value->title;
            //     $data[$i]['start'] = date('Y-m-d h:i:s', $date);
            //     // $data[$i]['end'] = $value->end;
            //     $data[$i]['allDay'] = $value->allDay;
            //     $data[$i]['color'] = $value->color;
            //     $data[$i]['description'] = $value->description;
            //     $i++;
            // }

        }

        echo json_encode($items);
    }

      /**
     * single day task
     * @param $event
     * @return array
     */
    function getDayTask($event)
    {
        $end = $event->end;
        $start = $event->start;

        $events[] =$this->getEventArray($event,$start,$end);
        return $events;

    }

    /**
     * repeating tasks even (n) days. Note if you can even put 7 days to make them weekly.
     *
     * @param $event
     * @return array
     */
    function getDailyTasks($event)
    {
        $end = $event->end;
        $start = $event->start;

        $FromDate = new DateTime($event->start);
        $ToDate   = new DateTime($event->end);
        $Interval = $FromDate->diff($ToDate);
      
        $hours = $Interval->h;
        $weeks = floor($Interval->d/7);
        $days = $Interval->d % 7;
        $months = $Interval->m;

        $events = array();
        $date = $start;
        for ($i = 1; $i <= $days + 1; $i++) {
            // if ($event->status == 'completed')
            //     continue;

            $events[] = $this->getEventArray($event,$date,$date);
            $date = DateTime::createFromFormat('Y-m-d h:i:s',$date)
                       ->add(DateInterval::createFromDateString('1 day'))
                       ->format('Y-m-d h:i:s');
            // $date = Carbon::parse($date)->addDays($event->freq);

        }
        return $events;
    }

    /**
     * Weekly events repeating every (n) weeks
     * @param $event
     * @return array
     */
    function getWeeklyTasks($event)
    {
        $end = $event->end;
        $start = $event->start;
     
        $FromDate = new DateTime($event->start);
        $ToDate   = new DateTime($event->end);
        $Interval = $FromDate->diff($ToDate);
  
        $hours = $Interval->h;
        $weeks = floor($Interval->d/7);
        $days = $Interval->d % 7;
        $months = $Interval->m;

        $events = array();
        $date = $start;
    
        for ($i = 1; $i <= 20; $i++) {
            $events[] = $this->getEventArray($event,$date,$date);
            $date = DateTime::createFromFormat('Y-m-d h:i:s',$date)
                       ->add(DateInterval::createFromDateString('1 week'))
                       ->format('Y-m-d h:i:s');
            // $date = Carbon::parse($date)->addWeeks($event->freq);

        }
        return $events;

    }

    /**
     * Monthly events repeating every (n) months
     * @param $event
     * @return array
     */
    function getMonthlyTasks($event)
    {
        $end = $event->end;
        $start = $event->start;

        $FromDate = new DateTime($event->start);
        $ToDate   = new DateTime($event->end);
        $Interval = $FromDate->diff($ToDate);
      
        $hours = $Interval->h;
        $weeks = floor($Interval->d/7);
        $days = $Interval->d % 7;
        $months = $Interval->m;

        $events = array();
        $date = $start;
        //daily tasks
        for ($i = 1; $i <= $months + 1; $i++) {
            //skip completed.
            // if ($event->status == 'completed')
            //     continue;

            $events[] = $this->getEventArray($event,$date,$date);
            $date = DateTime::createFromFormat('Y-m-d h:i:s',$date)
            ->add(DateInterval::createFromDateString('1 month'))
            ->format('Y-m-d h:i:s');
            // $date = Carbon::parse($date)->addMonths($event->freq);

        }
        return $events;

    }

    /**
     * yearly repeating events repeats every (n) years
     *
     * @param $event
     * @return array
     */
    function getYearlyTasks($event)
    {
        $end = $event->end;
        $start = $event->start;

        $FromDate = new DateTime($event->start);
        $ToDate   = new DateTime($event->end);
        $Interval = $FromDate->diff($ToDate);
      
        $years = $Interval->y;

        $events = array();
        $date = $start;
        //daily tasks
        for ($i = 1; $i <= $years + 1; $i++) {
            //skip completed.
            // if ($event->status == 'completed')
            //     continue;

            $events[] =$this->getEventArray($event,$date,$date);
            $date = DateTime::createFromFormat('Y-m-d h:i:s',$date)
            ->add(DateInterval::createFromDateString('1 year'))
            ->format('Y-m-d h:i:s');
            // $date = Carbon::parse($date)->addYears($event->freq);

        }
        return $events;
    }


    /*Add new event */

    public function addEvent()

    {

        $title = $this->input->post('title', true);

        $start = $this->input->post('start', true);

        $end = $this->input->post('end', true);

        $description = $this->input->post('description', true);

        $color = $this->input->post('color');

        $event_type = $this->input->post('event_type', true);

		$event_repeat = $this->input->post('event_repeat');

		$event_associated = $this->input->post('event_associated');

		$event_all_day = "true";





		if($event_repeat == "0")

		{

			$event_repeat = 0;

		}else if($event_repeat == 1)

		{

			$event_repeat = 1;

		}else if($event_repeat == 2)

		{

			$event_repeat = 2;

		}else if($event_repeat == 3)

		{

			$event_repeat = 3;

		}else if($event_repeat == 4)

		{

			$event_repeat = 4;

		}



		if($event_associated == 0 || $event_associated == "0")

		{

            if($event_type == 1 || $event_associated == "1")

            {

                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('EventADDVacation')));

            }else{

                $employee_id = 0;

                $result = $this->events_model->addEvent($title, $start, $end, $description, $color, $event_type, $event_repeat, $event_associated, $event_all_day, $employee_id);

                if ($result) {

                    echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('EventADD')));

                }else{

                    echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

                }

            }

		}else{

			$employee_id = $this->input->post('employee_id', true);

            if($event_type == 1 || $event_associated == "1")

            {

                $year = date('Y', strtotime($start));

                $vacations = $this->events_model->select_vacation_of_year($year, $employee_id);

                $vacationOfYear = 0;

                $system = $this->system->company_details(1);

        

                foreach ($vacations as $vacation) {

                    $v_start = new DateTime($vacation['start']);

                    $v_end = new DateTime($vacation['end']);

                    $diff = $v_start->diff($v_end);

                    $vacationOfYear = $vacationOfYear + ($diff->d);

                }

        

                $currentStart = new DateTime($start);

                $currentEnd = new DateTime($end);

                $currentDiff = $currentStart->diff($currentEnd);

        

                if ($vacationOfYear + $currentDiff->d > $system['annual_vacation']) {

                    echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('EventADDVacationNotMORE')));

                } else {

                    $result = $this->events_model->addEvent($title, $start, $end, $description, $color, $event_type, $event_repeat, $event_associated, $event_all_day, $employee_id);

                    if ($result) {

                        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('EventADD')));

                    }else{

                        echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

                    }

                }

            }else{

                $result = $this->events_model->addEvent($title, $start, $end, $description, $color, $event_type, $event_repeat, $event_associated, $event_all_day, $employee_id);

                if ($result) {

                    echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('EventADDVacation')));

                }else{

                    echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

                }

            }

		}

    }



    /*Update Event */

    public function updateEvent()

    {

        $title = $this->input->post('title', true);

        $id = $this->input->post('id');

        $description = $this->input->post('description', true);

        $event_type = $this->input->post('event_type', true);

		$event_repeat = $this->input->post('event_repeat');

        $color = $this->input->post('color');

		$event_associated = $this->input->post('event_associated');

		

		if($event_repeat == 0)

		{

			

		}else if($event_repeat == 1)

		{

			

		}else if($event_repeat == 2)

		{

			

		}else if($event_repeat == 3)

		{

			

		}else if($event_repeat == 4)

		{

			

		}

		

		if($event_associated == 0)

		{

			$employee_id = $this->input->post('employee_id', true);

		}else{

			$employee_id = 0;

		}



        $result = $this->events_model->updateEvent($id, $title, $description, $color, $event_type, $event_repeat, $event_associated, $employee_id);

        echo $result;

    }



    /*Delete Event*/

    public function deleteEvent()

    {

		if (!$this->aauth->premission(11)) {

            exit($this->lang->line('translate19'));

        }

		

        $result = $this->events_model->deleteEvent();

        echo $result;

    }



    public function dragUpdateEvent()

    {



        $result = $this->events_model->dragUpdateEvent();

        echo $result;

    }

	

	/*Events Type */

	

	

	public function events_type()

    {

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = $this->lang->line('Events Type');

        $this->load->view('fixed/header', $head);

        $this->load->view('events/eve_type_list');

        $this->load->view('fixed/footer');

    }

	

	public function addeventstype()
    {
        if ($this->input->post()) {
            $name = $this->input->post('name', true);
			$paid = $this->input->post('paid');
            if ($this->events_model->addEventType($name, $paid)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='addeventstype' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='events_type' class='btn btn-grey btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
            } else {

                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

            }

        } else {

            $data['emp'] = $this->events_model->list_employee();

            $head['usernm'] = $this->aauth->get_user()->username;

            $head['title'] = $this->lang->line('New Event Type');

            $this->load->view('fixed/header', $head);

            $this->load->view('events/event_type', $data);

            $this->load->view('fixed/footer');

        }



    }

	

	 /*Get events Type */

	public function getEventsType()

    {

        $result = $this->events_model->getEventsType();

        echo json_encode($result);

    }



    /*Add new event Type */

    /*public function addEventTypes()

    {

        $name = $this->input->post('name', true);

        $paid = $this->input->post('paid', true);

		

		if ($this->events_model->addEventType($name, $paid)) {

			echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "   <a href='event' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='events' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));

		}else{

			echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR') . '- Invalid'));

		}

    }*/



    /*Update Event */

    public function updateEventType()

    {

        $name = $this->input->post('name', true);

        $id = $this->input->post('id');

        $paid = $this->input->post('paid');

        $result = $this->events_model->updateEventType($id, $name, $paid);

        echo $result;

    }



    /*Delete Event*/

    public function delEventType()

    {

        if (!$this->aauth->premission(11)) {

            exit($this->lang->line('translate19'));

        }

        $id = $this->input->post('deleteid');



        if ($this->events_model->deleteEventType($id)) {

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

        }

    }





    public function evt_load_list()
    {
        if (!$this->aauth->premission(6)) {
            exit($this->lang->line('translate19'));
        }
        $list = $this->events_model->ecttyppp_datatables();
        $data = array();
        $no = 0;
        foreach ($list as $obj) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $obj->name;
            if($obj->paid == 1){
				$row[] = $this->lang->line('Proc. Salary');
			}else{
				$row[] = $this->lang->line('Not Proc. Salary');
			}
			
			if($obj->delete == 1)
			{
				$row[] = '<a href="editeventtype?id=' . $obj->id . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span> ' . $this->lang->line('Edit') . '</a> <a class="btn btn-danger btn-sm delete-object" href="#" data-object-id="' . $obj->id . '"> <i class="fa fa-trash"></i> </a>'; 
			}else{
				$row[] = '<a href="editeventtype?id=' . $obj->id . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span> ' . $this->lang->line('Edit') . '</a>'; 
			}
            //$row[] = '<a class="btn-info btn-sm" href="events/editeventtype?id=' . $obj->id . '" data-object-id="' . $obj->id . '"> <i class="fa fa-pencil"></i> </a>&nbsp;<a class="btn-danger btn-sm delete-object" href="#" data-object-id="' . $obj->id . '"> <i class="fa fa-trash"></i> </a>';
            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->events_model->ecttyppp_count_all(),

            "recordsFiltered" => $this->events_model->ecttyppp_count_filtered(),

            "data" => $data,

        );

        echo json_encode($output);

    }

	

	

	public function editeventtype()

    {

        if ($this->input->post()) {

			$name = $this->input->post('name', true);

			$id = $this->input->post('did');

			$paid = $this->input->post('paid');



            if ($this->events_model->updateEventType($id, $name, $paid)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='event_type' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='events_type' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));

            } else {

                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

            }

        } else {

            $data['id'] = $this->input->get('id');

            $data['evtype'] = $this->events_model->eventtype_view($data['id']);

			

            $head['title'] = 'Edit Event Type';

            $this->load->view('fixed/header', $head);

            $this->load->view('events/event_type_edit', $data);

            $this->load->view('fixed/footer');

        }



    }



}