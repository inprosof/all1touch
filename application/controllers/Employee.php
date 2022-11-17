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

class Employee extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('employee_model', 'employee');
        $this->load->model('settings_model', 'system');
        $this->load->model('salaryprocess_model', 'salary_process');
        $this->load->model('events_model', 'events');
        $this->load->model('locations_model', 'locations');

        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if (!$this->aauth->premission(98) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $this->load->library("Custom");
        $this->li_a = 'emp';

    }

    public function index()
    {
        if (!$this->aauth->premission(98) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employees List';
        $data['employee'] = $this->employee->list_employee();
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/list', $data);
        $this->load->view('fixed/footer');
    }

    public function salary_slip()
    {
        if (!$this->aauth->premission(102) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employees List';
        $data['employee'] = $this->employee->list_employee();
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/salary_slip', $data);
        $this->load->view('fixed/footer');
    }


    public function salary_generate()
    {
        if (!$this->aauth->premission(102) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Salary Generate';
        $id = $this->input->get('id');
        $employee = $this->employee->employee_details($id);
        $system = $this->system->company_details(1);
        $data['employee'] = $employee;
        $data['system'] = $system;
        /**
         * Base
         */
        $number_hours_work_0 = $system['number_hours_work'];
        $month = $this->input->get('month');
        $year = $this->input->get('year');

        $data['month'] = $month;
        $data['year'] = $year;

        $basic_salary_3 = $employee['basic_salary'];
        $data['basic_salary'] = $basic_salary_3;
        $number_day_work_month_4 = $system['number_day_work_month'];
        $data['number_day_work_month'] = $number_day_work_month_4;
        $single_day_val_5 = $basic_salary_3 / $number_day_work_month_4;

        $data['single_day_val'] = round($single_day_val_5, 3);
        $single_hour_val_6 = $single_day_val_5 / $number_hours_work_0;
        $data['single_hour_val'] = round($single_hour_val_6, 3);
        $meal_sub_7 = $employee['subsidy_meal'];
        $data['meal_sub'] = $meal_sub_7;
        $sales_base_8 = $employee['c_rate'];

        /**
         * Faults
         */
        $faults_month_18 = 0;
        $faults_month = $this->events->select_event_of_month_row($month, $year, $employee['id'], -1);
        if ($faults_month > 0) {
            $faults_month_18 = $faults_month;
        }

        $faults_month_just_19 = 0;
        $faults_month_just = $this->events->select_event_of_month_row($month, $year, $employee['id'], 1);
        if ($faults_month_just > 0) {
            $faults_month_just_19 = $faults_month_just;
        }

        $faults_month_not_just_20 = 0;
        $faults_month_not_just = $this->events->select_event_of_month_row($month, $year, $employee['id'], 0);
        if ($faults_month_not_just > 0) {
            $faults_month_not_just_20 = $faults_month_not_just;
        }

        $data['fault_month'] = $faults_month_18;
        $data['fault_just_month'] = $faults_month_just_19;
        $data['fault_not_just_month'] = $faults_month_not_just_20;
        /**
         * Vacations
         */
        $vacationDaysYear = 0;
        $vacationDaysYear_1 = $this->getVacationOfYear($year, $employee['id']);
        if ($vacationDaysYear_1 > 0) {
            $vacationDaysYear = $vacationDaysYear_1;
        }
        $vacationDaysMonth_23 = 0;
        $vacationDaysMonth = $this->getVacationOfMonth($month, $year, $employee['id']);
        if ($vacationDaysMonth > 0) {
            $vacationDaysMonth_23 = $vacationDaysMonth;
        }


        $vacationDaysYearstill_37 = $system['annual_vacation'] - $vacationDaysYear;
        $data['vacationDaysYear'] = $vacationDaysYear;
        $data['vacation_month_days'] = $vacationDaysMonth_23;
        $data['vacation_total_still'] = $vacationDaysYearstill_37;
        /**
         * holidays
         */
        $holidaysDaysMonth_28 = 0;
        $holidaysDaysMonth = $this->getHolidaysOfMonth($month, $year);
        if ($holidaysDaysMonth > 0) {
            $holidaysDaysMonth_28 = $holidaysDaysMonth;
        }
        $data['holidays_month'] = $holidaysDaysMonth_28;
        /**
         * Period
         */
        $days_work_in_month_29 = $number_day_work_month_4 - $faults_month_not_just_20 - $vacationDaysMonth_23 - $holidaysDaysMonth_28;
        $data['days_work_in_month'] = $days_work_in_month_29;
        /**
         * Remunerations
         */
        $matury_monthly_salary_30 = $days_work_in_month_29 * $single_day_val_5;
        $data['matury_monthly_salary'] = round($matury_monthly_salary_30, 3);
        /**
         * Complementary
         */
        $vacation_month_value_24 = $vacationDaysMonth_23 * $single_day_val_5;
        $data['vacation_month_value'] = round($vacation_month_value_24, 3);

        $meal_month_value_31 = $meal_sub_7 * $days_work_in_month_29;
        $data['meal_month_value'] = round($meal_month_value_31, 3);

        $produtivity_month_value_34 = $employee['productivity'];
        $data['produtivity_month_value'] = $produtivity_month_value_34;

        $attendance_hour_mont_35 = 0;
        $attendance_hour_mont = $this->getAttendanceOfMonth($month, $year, $employee['id']);
        if ($attendance_hour_mont > 0) {
            $attendance_hour_mont_35 = $attendance_hour_mont;
        }
        $data['attendance_hour_month'] = $attendance_hour_mont_35;

        $attendance_hour_month_value_36 = $attendance_hour_mont_35 * $single_hour_val_6;
        $data['attendance_hour_month_value'] = round($attendance_hour_month_value_36, 3);

        /**
         * Sales Comission this part not finish
         */

        /**
         * Sales Comission
         */
        $saleData = 0;
        $saleCommissionRate = 0;
        $saleDataCommissionsValue = 0;
        $saleDa = $this->employee->sales_num_month($month, $year, $employee['id']);
        if ($saleDa > 0) {
            $saleData = $saleDa;
            $saleCommissionRate = $sales_base_8;
            $details = $this->employee->sales_details_month($month, $year, $employee['id']);
            $saleDataCommiValue = $details['total'];
            $saleDataCommissionsValue = ($sales_base_8 / 100) * $saleDataCommiValue;
        }

        $data['saleData'] = $saleData;
        $data['saleCommissionRate'] = $saleCommissionRate;
        $data['saleDataCommissionsValue'] = $saleDataCommissionsValue;

        /**
         * Net Dedutions
         */

        $credit_value_33 = $this->input->get('credit_value');
        $data['credit_value'] = $credit_value_33;
        $debit_value_34 = $this->input->get('debit_value');
        $data['debit_value'] = $debit_value_34;

        /**
         * Legal Dedutions
         */

        $total_use_irs_ss_38 = $matury_monthly_salary_30 + $meal_month_value_31 + $vacation_month_value_24 + $debit_value_34 + $attendance_hour_month_value_36;
        $social_secur_month_40 = $total_use_irs_ss_38 * ($system['social_security'] / 100);
        $data['social_secur_month'] = round($total_use_irs_ss_38, 3);

        $getValueIrsMax = $this->salary_process->getValueIrsMax($employee['id'], $total_use_irs_ss_38);
        $valueIrsMax = $getValueIrsMax ? $getValueIrsMax['up_to'] : 0;
        $getValueIrsMin = $this->salary_process->getValueIrsMin($employee['id'], $total_use_irs_ss_38);
        $valueIrsMin = $getValueIrsMin ? $getValueIrsMin['up_to'] : 0;
        $valueIrs = (float)($valueIrsMax - $total_use_irs_ss_38) < (float)((float)$total_use_irs_ss_38 - $valueIrsMin) ? $getValueIrsMax : $getValueIrsMin;

        $irs_percen_use_41 = $valueIrs['value_x'] ?? 0;
        $irs_month_42 = $total_use_irs_ss_38 * ($irs_percen_use_41 / 100);
        $data['irs_month'] = round($irs_month_42, 3);


        $total_gross_month_39 = $matury_monthly_salary_30 + $meal_month_value_31 + $vacation_month_value_24 + $debit_value_34 + $attendance_hour_month_value_36;
        $data['total_gross_month'] = round($total_gross_month_39, 3);

        $total_dedutions_month_43 = $social_secur_month_40 + $irs_month_42;
        $data['total_dedutions_month'] = round($total_dedutions_month_43, 3);

        $total_minus_discont_month_44 = ($total_gross_month_39 - $total_dedutions_month_43);
        $data['total_minus_discont_month'] = round($total_minus_discont_month_44, 3);

        $total_net_month_45 = $credit_value_33 + $total_minus_discont_month_44;
        $data['total_net_month'] = round($total_net_month_45, 3);

        $this->load->view('fixed/header', $head);
        $this->load->view('employee/salary_generate', $data);
        $this->load->view('fixed/footer');
    }

    public function view_salary_process()
    {
        if (!$this->aauth->premission(102) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $id = $this->input->get('id');
        $data['process'] = $this->salary_process->get_process_item($id);
        $employee_id = $data['process']['employee_id'];
        $data['system'] = $this->system->company_details(1);
        $data['employee'] = $this->employee->employee_details($employee_id);

        $head['title'] = 'Salary Process View';

        $this->load->view('fixed/header', $head);
        $this->load->view('employee/view_salary', $data);
        $this->load->view('fixed/footer');
    }

    public function save_salary_process()
    {
        if (!$this->aauth->premission(102) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        if ($this->input->post()) {
            $employee_id = $this->input->post('employee_id', true);
            $month = $this->input->post('salary_month', true);
            $year = $this->input->post('salary_year', true);
            $message = $this->input->post('message');
            $credit_value_33 = $this->input->post('credit_value');
            $debit_value_34 = $this->input->post('debit_value');
        }

        $employee = $this->employee->employee_details($employee_id);
        $system = $this->system->company_details(1);

        $number_hours_work_0 = $system['number_hours_work'];
        $basic_salary_3 = $employee['basic_salary'];
        $number_day_work_month_4 = $system['number_day_work_month'];
        $single_day_val_5 = round($basic_salary_3 / $number_day_work_month_4, 3);
        $single_hour_val_6 = round($single_day_val_5 / $number_hours_work_0, 3);
        $meal_sub_7 = $employee['subsidy_meal'];
        $sales_base_8 = $employee['c_rate'];
        /**
         * Faults
         */

        $faults_month_18 = 0;
        $faults_month = $this->events->select_event_of_month_row($month, $year, $employee['id'], -1);
        if ($faults_month > 0) {
            $faults_month_18 = $faults_month;
        }

        $faults_month_just_19 = 0;
        $faults_month_just = $this->events->select_event_of_month_row($month, $year, $employee['id'], 1);
        if ($faults_month_just > 0) {
            $faults_month_just_19 = $faults_month_just;
        }

        $faults_month_not_just_20 = 0;
        $faults_month_not_just = $this->events->select_event_of_month_row($month, $year, $employee['id'], 0);
        if ($faults_month_not_just > 0) {
            $faults_month_not_just_20 = $faults_month_not_just;
        }
        /**
         * Vacations
         */
        $vacationDaysYear = 0;
        $vacationDaysYear_1 = $this->getVacationOfYear($year, $employee['id']);
        if ($vacationDaysYear_1 > 0) {
            $vacationDaysYear = $vacationDaysYear_1;
        }
        $vacationDaysMonth_23 = 0;
        $vacationDaysMonth = $this->getVacationOfMonth($month, $year, $employee['id']);
        if ($vacationDaysMonth > 0) {
            $vacationDaysMonth_23 = $vacationDaysMonth;
        }

        $vacationDaysYearstill_37 = $system['annual_vacation'] - $vacationDaysYear;
        /**
         * holidays
         */
        $holidaysDaysMonth_28 = 0;
        $holidaysDaysMonth = $this->getHolidaysOfMonth($month, $year);
        if ($holidaysDaysMonth > 0) {
            $holidaysDaysMonth_28 = $holidaysDaysMonth;
        }
        /**
         * Period
         */
        $days_work_in_month_29 = $number_day_work_month_4 - $faults_month_not_just_20 - $vacationDaysMonth_23 - $holidaysDaysMonth_28;
        /**
         * Remunerations
         */
        $matury_monthly_salary_30 = $days_work_in_month_29 * $single_day_val_5;
        /**
         * Complementary
         */
        $vacation_month_value_24 = $vacationDaysMonth_23 * $single_day_val_5;
        $meal_month_value_31 = $meal_sub_7 * $days_work_in_month_29;
        $produtivity_month_value_34 = $employee['productivity'];
        $attendance_hour_mont_35 = 0;
        $attendance_hour_mont = $this->getAttendanceOfMonth($month, $year, $employee['id']);
        if ($attendance_hour_mont > 0) {
            $attendance_hour_mont_35 = $attendance_hour_mont;
        }
        $attendance_hour_month_value_36 = $attendance_hour_mont_35 * $single_hour_val_6;
        /**
         * Sales Comission
         */
        $saleData = 0;
        $saleCommissionRate = 0;
        $saleDataCommissionsValue = 0;
        $saleDa = $this->employee->sales_num_month($month, $year, $employee['id']);
        if ($saleDa > 0) {
            $saleData = $saleDa;
            $saleCommissionRate = $sales_base_8;
            $details = $this->employee->sales_details_month($month, $year, $employee['id']);
            $saleDataCommiValue = $details['total'];
            $saleDataCommissionsValue = ($sales_base_8 / 100) * $saleDataCommiValue;
        }

        /**
         * Legal Dedutions
         */

        $total_use_irs_ss_38 = $matury_monthly_salary_30 + $meal_month_value_31 + $vacation_month_value_24 + $debit_value_34 + $attendance_hour_month_value_36;
        $social_secur_month_40 = $total_use_irs_ss_38 * ($system['social_security'] / 100);
        $getValueIrsMax = $this->salary_process->getValueIrsMax($employee['id'], $total_use_irs_ss_38);
        $valueIrsMax = $getValueIrsMax ? $getValueIrsMax['up_to'] : 0;
        $getValueIrsMin = $this->salary_process->getValueIrsMin($employee['id'], $total_use_irs_ss_38);
        $valueIrsMin = $getValueIrsMin ? $getValueIrsMin['up_to'] : 0;

        if ($getValueIrsMax == null || $getValueIrsMax == '') {
            $getValueIrsMax = 0;
        }

        if ($getValueIrsMin == null || $getValueIrsMin == '') {
            $getValueIrsMin = 0;
        }

        $valueIrs = (float)($valueIrsMax - $total_use_irs_ss_38) < (float)((float)$total_use_irs_ss_38 - $valueIrsMin) ? $getValueIrsMax : $getValueIrsMin;

        $irs_percen_use_41 = $valueIrs['value_x'];
        if ($irs_percen_use_41 == "" || $irs_percen_use_41 == null) {
            $irs_percen_use_41 = 0;
        }
        $irs_month_42 = $total_use_irs_ss_38 * ($irs_percen_use_41 / 100);
        $total_gross_month_39 = $matury_monthly_salary_30 + $meal_month_value_31 + $vacation_month_value_24 + $debit_value_34 + $attendance_hour_month_value_36;
        $total_dedutions_month_43 = $social_secur_month_40 + $irs_month_42;
        $total_minus_discont_month_44 = ($total_gross_month_39 - $total_dedutions_month_43);
        $total_net_month_45 = $credit_value_33 + $total_minus_discont_month_44;

        $data = array(
            'month' => $month,
            'year' => $year,
            'employee_id' => $employee_id,
            'monthly_message' => $message,
            'monthly_basic_salary' => $basic_salary_3,
            'matury_monthly_salary' => $matury_monthly_salary_30,
            'monthly_meal' => $meal_sub_7,
            'monthly_meal_subsidy' => $meal_month_value_31,
            'monthly_social_security' => $social_secur_month_40,
            'monthly_irs' => $irs_month_42,
            'total_credit' => $credit_value_33,
            'total_debit' => $debit_value_34,
            'total_income' => $total_dedutions_month_43,
            'total_transfer' => $total_net_month_45,
            'gross_income' => $total_gross_month_39,
            'total_net' => $total_minus_discont_month_44,
            'monthly_vacations' => $vacationDaysMonth_23,
            'vacations_value' => $vacation_month_value_24,
            'number_hours_work' => $number_hours_work_0,
            'number_day_work_month' => $number_day_work_month_4,
            'single_day_val' => $single_day_val_5,
            'single_hour_val' => $single_hour_val_6,
            'faults_month' => $faults_month_18,
            'faults_month_just' => $faults_month_just_19,
            'faults_month_not_just' => $faults_month_not_just_20,
            'vacationDaysYear' => $vacationDaysYear,
            'vacationDaysYearstill' => $vacationDaysYearstill_37,
            'holidaysDaysMonth' => $holidaysDaysMonth_28,
            'days_work_in_month' => $days_work_in_month_29,
            'total_use_irs_ss' => $total_use_irs_ss_38,
            'irs_percen_use' => $irs_percen_use_41,
            'produtivity_month_value' => $produtivity_month_value_34,
            'attendance_hour_mont' => $attendance_hour_mont_35,
            'attendance_hour_month_value' => $attendance_hour_month_value_36,
            'saleData' => $saleData,
            'saleCommissionRate' => $saleCommissionRate,
            'saleDataCommissionsValue' => $saleDataCommissionsValue
        );

        if ($this->salary_process->save_salary($data)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "<a href='salaries' class='btn btn-grey btn-lg'><span class='bi bi-eye' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
        //$process = $this->salary_process->get_last_process();
        //$this->session->set_flashdata('message', 'Successfully save salary');
        //redirect('/employee/history?id='.$employee_id);
    }

    public function getAttendanceOfMonth($month, $year, $employee_id)
    {
        $event = $this->events->select_attendance_of_month($month, $year, $employee_id);
        $attendancehours = 0;
        foreach ($event as $item) {
            $houratten = round((strtotime($item->tto) - strtotime($item->tfrom)) / 3600, 2);
            $attendancehours = $attendancehours + $houratten;
        }

        return $attendancehours;
    }

    public function getHolidaysOfMonth($month, $year)
    {
        $holidaysDays = $this->events->select_holidays_of_month_row($month, $year);
        return $holidaysDays;
    }

    public function getVacationOfMonth($month, $year, $employee_id)
    {
        $vacationDays = $this->events->select_event_of_month_row($month, $year, $employee_id, 1);
        return $vacationDays;
    }

    public function getVacationOfYear($year, $employee_id)
    {
        $vacationDays = $this->events->select_vacation_of_year_row($year, $employee_id);
        return $vacationDays;
    }


    public function salaries()
    {
        if (!$this->aauth->premission(102) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employees List';
        $data['employee'] = $this->employee->list_employee();
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/salaries', $data);
        $this->load->view('fixed/footer');
    }


    public function view()
    {
        if (!$this->aauth->premission(98) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Details';

        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/view', $data);
        $this->load->view('fixed/footer');

    }

    public function history()
    {
        if (!$this->aauth->premission(102) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Details';
        $data['employee'] = $this->employee->employee_details($id);
        $data['salary_process'] = $this->salary_process->get_list($data['employee']['id']);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/history', $data);
        $this->load->view('fixed/footer');
    }

    public function add()
    {
        if (!$this->aauth->premission(99) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Employee';
        $data['locations'] = $this->locations->locations_list2();
        $this->load->library("Common");
        $data['countrys'] = $this->common->countrys();
        $data['dept'] = $this->employee->department_list($this->aauth->get_user()->loc, $this->aauth->get_user()->loc);
        $data['typeIRS'] = $this->employee->list_type_irs();
        $data['custom_fields'] = $this->custom->add_fields(6);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/add', $data);
        $this->load->view('fixed/footer');
    }

    public function submit_user()
    {
        if (!$this->aauth->premission(99) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }

        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        $roleid = 3;
        if ($this->input->post('roleid')) {
            $roleid = $this->input->post('roleid');
        }

        $location = $this->input->post('location', true);
        $name = $this->input->post('name', true);
        $phone = $this->input->post('phone');
        $email = $this->input->post('email', true);
        $address = $this->input->post('address', true);
        $city = $this->input->post('city');
        $region = $this->input->post('region');
        $country = $this->input->post('country');
        $postbox = $this->input->post('postbox');
        $basic_salary = numberClean($this->input->post('basic_salary', true));
        $subsidy_meal = numberClean($this->input->post('subsidy_meal', true));
        $medical_allowance = $this->input->post('medical');
        $commission = $this->input->post('commission');
        $department = $this->input->post('department', true);
        $irs = $this->input->post('irs_number', true);
        $niss = $this->input->post('social_security_number', true);
        $type_employee = $this->input->post('type_employee', true);
        $type_irs = $this->input->post('type_irs', true);
        $married = $this->input->post('married', true);
        $account_bank = $this->input->post('account_bank');
        $number_children = $this->input->post('number_children');
        $productivity = $this->input->post('productivity');
        $mess_ativos = 0;
        if (filter_has_var(INPUT_POST, 'mess_ativos')) {
            $mess_ativos = 1;
        } else {
            $mess_ativos = 0;
        }
        $a = $this->aauth->create_user($email, $password, $username);
        if ((string)$this->aauth->get_user($a)->id != $this->aauth->get_user()->id) {
            $nuid = (string)$this->aauth->get_user($a)->id;
            if ($nuid > 0) {
                $this->employee->add_employee($nuid, (string)$this->aauth->get_user($a)->username, $name, $roleid, $phone, $address, $city, $region, $country, $postbox, $location, $basic_salary, $subsidy_meal, $medical_allowance, $commission, $department, $irs, $niss, $type_employee, $type_irs, $married, $account_bank, $number_children, $productivity, $mess_ativos);
            }
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'There has been an error, please try again.'));
        }
    }

    public function invoices()
    {
        if (!$this->aauth->premission(98) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Invoices';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/invoices', $data);
        $this->load->view('fixed/footer');
    }

    public function invoices_list()
    {
        if (!$this->aauth->premission(98) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $eid = $this->input->post('eid');
        $list = $this->employee->invoice_datatables($eid);
        $data = array();

        $no = $this->input->post('start');


        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = $invoices->invoicedate;
            $row[] = amountExchange($invoices->total, 0, $this->aauth->get_user()->loc);
            switch ($invoices->status) {
                case "paid" :
                    $out = '<span class="label label-success">Paid</span> ';
                    break;
                case "due" :
                    $out = '<span class="label label-danger">Due</span> ';
                    break;
                case "canceled" :
                    $out = '<span class="label label-warning">Canceled</span> ';
                    break;
                case "partial" :
                    $out = '<span class="label label-primary">Partial</span> ';
                    break;
                default :
                    $out = '<span class="label label-info">Pending</span> ';
                    break;
            }
            $row[] = $out;
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="bi bi-eye"></i> View</a> &nbsp; <a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->invoicecount_all($eid),
            "recordsFiltered" => $this->employee->invoicecount_filtered($eid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function transactions()
    {
        if (!$this->aauth->premission(98) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Transactions';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/transactions', $data);
        $this->load->view('fixed/footer');
    }

    public function translist()
    {
        if (!$this->aauth->premission(98) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $eid = $this->input->post('eid');
        $list = $this->employee->get_datatables($eid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->date;
            $row[] = $prd->account;
            $row[] = amountExchange($prd->debit, 0, $this->aauth->get_user()->loc);
            $row[] = amountExchange($prd->credit, 0, $this->aauth->get_user()->loc);

            $row[] = $prd->payer;
            $row[] = $prd->method;
            $row[] = '<div class="action-btn"><a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-outline-success btn-sm" title="' . $this->lang->line('View') . '"><span class="bi bi-eye"></span> View</a> <a data-object-id="' . $pid . '" class="btn btn-outline-danger btn-sm delete-object" title="' . $this->lang->line('Delete') . '"><span class="bi bi-trash"></span>Delete</a></div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->count_all(),
            "recordsFiltered" => $this->employee->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    function disable_user()
    {
        if (!$this->aauth->premission(121) && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $uid = intval($this->input->post('deleteid'));
        $nuid = intval($this->aauth->get_user()->id);
        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' => 'You can not disable yourself!'));
        } else {

            $this->db->select('banned');
            $this->db->from('geopos_users');
            $this->db->where('id', $uid);
            $query = $this->db->get();
            $result = $query->row_array();
            if ($result['banned'] == 0) {
                $this->aauth->ban_user($uid);
            } else {
                $this->aauth->unban_user($uid);
            }
            echo json_encode(array('status' => 'Success', 'message' => 'User Profile updated successfully!'));
        }
    }

    function enable_user()
    {
        if (!$this->aauth->premission(121) && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $uid = intval($this->input->post('deleteid'));
        $nuid = intval($this->aauth->get_user()->id);
        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' => 'You can not disable yourself!'));
        } else {
            $a = $this->aauth->unban_user($uid);
            echo json_encode(array('status' => 'Success', 'message' => 'User Profile disabled successfully!'));
        }
    }

    function delete_history()
    {
        if (!$this->aauth->premission(121) && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $uid = intval($this->input->post('deleteid'));
        if ($uid) {
            $this->db->delete('geopos_salary_process', array('id' => $uid));
            echo json_encode(array('status' => 'Success', 'message' => 'Processamento de Salário Removido. Por favor faça refresh na Página!'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


    function delete_user()
    {
        if (!$this->aauth->premission(121) && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $uid = intval($this->input->post('empid'));
        $nuid = intval($this->aauth->get_user()->id);

        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' => 'You can not delete yourself!'));
        } else {
            $this->db->delete('geopos_employees', array('id' => $uid));
            $this->db->delete('geopos_users', array('id' => $uid));
            echo json_encode(array('status' => 'Success', 'message' => 'User Profile deleted successfully! Please refresh the page!'));


        }
    }


    public function calc_income()
    {
        $eid = $this->input->post('eid');
        if ($this->employee->money_details($eid)) {
            $details = $this->employee->money_details($eid);
            echo json_encode(array('status' => 'Success', 'message' =>
                '<br> Total Income: ' . amountExchange($details['credit'], 0, $this->aauth->get_user()->loc) . '<br> Total Expenses: ' . amountExchange($details['debit'], 0, $this->aauth->get_user()->loc)));
        }
    }

    public function calc_sales()
    {
        $eid = $this->input->post('eid');
        if ($this->employee->sales_details($eid)) {
            $details = $this->employee->sales_details($eid);
            echo json_encode(array('status' => 'Success', 'message' =>
                'Total de Vendas (Total Pago):  ' . amountExchange($details['total'], 0, $this->aauth->get_user()->loc)));
        }
    }

    public function update()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(100) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $data['typeIRS'] = $this->employee->list_type_irs();

        $id = $this->input->get('id');
        $this->load->model('employee_model', 'employee');
        if ($this->input->post()) {
            $eid = $this->input->post('eid', true);
            $roleid = $this->input->post('roleid', true);
            $location = $this->input->post('location', true);
            $name = $this->input->post('name', true);
            $phone = $this->input->post('phone');
            $phonealt = $this->input->post('phonealt');
            $email = $this->input->post('email', true);
            $address = $this->input->post('address', true);
            $city = $this->input->post('city');
            $region = $this->input->post('region');
            $country = $this->input->post('country');
            $postbox = $this->input->post('postbox');
            $basic_salary = numberClean($this->input->post('basic_salary', true));
            $subsidy_meal = numberClean($this->input->post('subsidy_meal', true));
            $medical_allowance = $this->input->post('medical');
            $commission = $this->input->post('commission');
            $department = $this->input->post('department', true);
            $irs = $this->input->post('irs_number', true);
            $niss = $this->input->post('social_security_number', true);
            $type_employee = $this->input->post('type_employee', true);
            $type_irs = $this->input->post('type_irs', true);
            $married = $this->input->post('married', true);
            $account_bank = $this->input->post('account_bank');
            $number_children = $this->input->post('number_children');
            $productivity = $this->input->post('productivity');

            $mess_ativos = 0;
            if (filter_has_var(INPUT_POST, 'mess_ativos')) {
                $mess_ativos = 1;
            } else {
                $mess_ativos = 0;
            }
            $this->employee->update_employee($eid, $name, $phone, $phonealt, $address, $city, $region, $country, $postbox, $location, $basic_salary, $subsidy_meal, $medical_allowance, $department, $commission, $roleid, $irs, $niss, $type_employee, $type_irs, $married, $account_bank, $number_children, $productivity, $mess_ativos);

        } else {
            $head['usernm'] = $this->aauth->get_user($id)->username;
            $head['title'] = $head['usernm'] . ' Profile';
            $data['locations'] = $this->locations->locations_list2();
            $data['user'] = $this->employee->employee_details($id);
            $this->load->library("Common");
            $data['countrys'] = $this->common->countrys();
            $data['custom_fields'] = $this->custom->view_edit_fields($id, 6);
            $data['dept'] = $this->employee->department_list($this->aauth->get_user()->loc, $this->aauth->get_user()->loc);
            $data['eid'] = intval($id);
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/edit', $data);
            $this->load->view('fixed/footer');
        }


    }


    public function displaypic()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if (!$this->aauth->premission(100) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $this->load->model('employee_model', 'employee');
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/employee/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->employee->editpicture($id, $img);
        }


    }


    public function user_sign()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if (!$this->aauth->premission(100) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $this->load->model('employee_model', 'employee');
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/employee_sign/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->employee->editsign($id, $img);
        }
    }


    public function updatepassword()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if (!$this->aauth->premission(100) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        if ($this->input->post()) {
            $this->load->library("form_validation");
            $eid = $this->input->post('eid');
            $this->form_validation->set_rules('newpassword', 'Password', 'required');
            $this->form_validation->set_rules('renewpassword', 'Confirm Password', 'required|matches[newpassword]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => 'Error', 'message' => '<br>Rules<br> Password length should  be at least 6 [a-z-0-9] allowed!<br>New Password & Re New Password should be same!'));
            } else {
                $newpassword = $this->input->post('newpassword');
                echo json_encode(array('status' => 'Success', 'message' => 'Password Updated Successfully!'));
                $this->aauth->update_user($eid, false, $newpassword, false);
            }
        } else {
            $this->load->model('employee_model', 'employee');
            $id = $this->input->get('id');
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $head['usernm'] . ' Profile';
            $data['user'] = $this->employee->employee_details($id);
            $data['eid'] = intval($id);
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/password', $data);
            $this->load->view('fixed/footer');
        }


    }

    public function permissions()
    {
        if (!$this->aauth->premission(101) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Permissions';
        $data['permission'] = $this->employee->employee_permissions();
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/permissions', $data);
        $this->load->view('fixed/footer');
    }

    public function permissions_update()
    {
        if (!$this->aauth->premission(101) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Permissions';
        $permission = $this->employee->employee_permissions();

        foreach ($permission as $row) {
            $i = $row['id'];
            $name1 = 'r_' . $i . '_1';
            $name2 = 'r_' . $i . '_2';
            $name3 = 'r_' . $i . '_3';
            $name4 = 'r_' . $i . '_4';
            $name5 = 'r_' . $i . '_5';
            $name6 = 'r_' . $i . '_6';
            $name8 = 'r_' . $i . '_8';
            $val1 = 0;
            $val2 = 0;
            $val3 = 0;
            $val4 = 0;
            $val5 = 0;
            $val6 = 0;
            $val7 = 0;
            $val8 = 0;
            if ($this->input->post($name1)) $val1 = 1;
            if ($this->input->post($name2)) $val2 = 1;
            if ($this->input->post($name3)) $val3 = 1;
            if ($this->input->post($name4)) $val4 = 1;
            if ($this->input->post($name5)) $val5 = 1;
            if ($this->input->post($name6)) $val6 = 1;
            if ($this->input->post($name8)) $val8 = 1;
            if ($this->aauth->get_user()->roleid == 5 && $i == 9) $val5 = 1;
            $data = array('r_1' => $val1, 'r_2' => $val2, 'r_3' => $val3, 'r_4' => $val4, 'r_5' => $val5, 'r_6' => $val6, 'r_8' => $val8);
            $this->db->set($data);
            $this->db->where('id', $i);
            $this->db->update('geopos_premissions');
        }

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED')));
    }


    public function vacations()
    {
        if (!$this->aauth->premission(108) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $this->lang->line('Vacations');
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/vacation_list');
        $this->load->view('fixed/footer');
    }


    public function vacon_list()
    {
        if (!$this->aauth->premission(108) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $list = $this->employee->vacations_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $obj) {
            $datetime1 = date_create($obj->start);
            $datetime2 = date_create($obj->end);
            $interval = date_diff($datetime1, $datetime2);
            $day = $interval->format('%a days');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->name_emp;
            $row[] = $obj->start;
            $row[] = $obj->end;
            $row[] = $day;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->holidays_count_all(),
            "recordsFiltered" => $this->employee->holidays_count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function departments()
    {
        if (!$this->aauth->premission(109) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['department_list'] = $this->employee->department_list($this->aauth->get_user()->loc);
        $head['title'] = 'Departments';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/departments', $data);
        $this->load->view('fixed/footer');

    }

    public function department()
    {
        if (!$this->aauth->premission(109) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $data['id'] = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['department'] = $this->employee->department_view($data['id'], $this->aauth->get_user()->loc);
        $data['department_list'] = $this->employee->department_elist($data['id']);
        $head['title'] = 'Departments';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/department', $data);
        $this->load->view('fixed/footer');

    }

    public function delete_dep()
    {
        if (!$this->aauth->premission(121) && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $id = $this->input->post('deleteid');


        if ($this->employee->deletedepartment($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function adddep()
    {
        if (!$this->aauth->premission(110) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        if ($this->input->post()) {

            $name = $this->input->post('name', true);


            if ($this->employee->adddepartment($this->aauth->get_user()->loc, $name)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='adddep' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='departments' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Add Department';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/adddep');
            $this->load->view('fixed/footer');
        }

    }

    public function editdep()
    {
        if (!$this->aauth->premission(111) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        if ($this->input->post()) {

            $name = $this->input->post('name', true);
            $id = $this->input->post('did');

            if ($this->employee->editdepartment($id, $this->aauth->get_user()->loc, $name)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='adddep' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='departments' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $data['department'] = $this->employee->department_view($data['id'], $this->aauth->get_user()->loc);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Department';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/editdep', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function payroll_create()
    {
        if (!$this->aauth->premission(111) && !$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7) {
            exit($this->lang->line('translate19'));
        }
        $this->load->library("Common");
        $this->load->library("Custom");
        $this->load->model('settings_model', 'settings');
        $discship = [];
        if ($this->aauth->get_user()->loc == 0) {
            $discship = $this->settings->online_pay_settings_main();
        } else {
            $discship = $this->settings->online_pay_settings($this->aauth->get_user()->loc);
        }

        $data['permissions'] = $discship;
        $this->load->model('transactions_model', 'transactions');
        $data['cat'] = $this->transactions->categories();
        $data['accounts'] = $this->transactions->acc_list();
        $data['metodos_pagamentos'] = $this->common->smetopagamento();
        $head['title'] = "Add Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/payroll_create', $data);
        $this->load->view('fixed/footer');

    }

    public function emp_search()
    {
        $name = $this->input->get('keyword', true);
        $whr = "geopos_employees.system = 0 AND ";
        if ($this->aauth->get_user()->loc) {
            $whr .= ' (geopos_users.loc=' . $this->aauth->get_user()->loc . ') AND ';
        }
        if ($name) {
            $queryvem = "SELECT geopos_employees.* ,geopos_users.email FROM geopos_employees  LEFT JOIN geopos_users ON geopos_users.id=geopos_employees.id  WHERE $whr (UPPER(geopos_employees.name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(geopos_employees.phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6";
            $query = $this->db->query($queryvem);
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {

                echo "<li onClick=\"selectPay('" . $row['id'] . "','" . $row['name'] . " ','" . amountFormat_general($row['basic_salary']) . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }

    public function payroll()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Payroll Transactions';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/payroll');
        $this->load->view('fixed/footer');
    }

    public function payroll_emp()
    {

        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Payroll Transactions';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/payroll_employee', $data);
        $this->load->view('fixed/footer');
    }


    public function payrolllist()
    {

        $eid = $this->input->post('eid');
        $list = $this->employee->pay_get_datatables($eid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->date;

            $row[] = amountExchange($prd->debit, 0, $this->aauth->get_user()->loc);
            $row[] = amountExchange($prd->credit, 0, $this->aauth->get_user()->loc);
            $row[] = $prd->account;
            $row[] = $prd->payer;
            $row[] = $prd->methodname;
            $row[] = '<div class="action-btn"><a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-outline-success btn-sm" title=' . $this->lang->line('View') . '><span class="bi bi-eye"></span></a> <a  href="#" data-object-id="' . $pid . '" class="btn btn-outline-danger btn-sm delete-object" title=' . $this->lang->line('Delete') . '><span class="bi bi-trash"></span></a></div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->pay_count_all($eid),
            "recordsFiltered" => $this->employee->pay_count_filtered($eid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function faults()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $this->lang->line('Faults');
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/fault_list');
        $this->load->view('fixed/footer');
    }

    public function fault()
    {
        if ($this->input->post()) {
            $emp = $this->input->post('employee');
            $adate = datefordatabase($this->input->post('adate'));
            $edate = datefordatabase($this->input->post('edate'));
            $justified = $this->input->post('justified');
            $note = $this->input->post('note');

            if ($this->employee->addfault($emp, $adate, $edate, $justified, $note)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='fault' class='btn btn-primary btn-md'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='faults' class='btn btn-grey btn-md'><span class='bi bi-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['emp'] = $this->employee->list_employee();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('New Fault');
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/fault', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function flt_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->employee->fault_datatables($cid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $obj) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->name;
            $row[] = dateformat($obj->adate);
            $row[] = dateformat($obj->edate);
            if ($obj->justified == 1) {
                $row[] = $this->lang->line('Yes');
            } else {
                $row[] = $this->lang->line('No');
            }
            $row[] = $obj->note;
            $row[] = "<div class='action-btn'><a href='" . base_url("employee/edfault?id=$obj->id") . "' class='btn btn-outline-primary btn-sm' title='" . $this->lang->line('Edit') . "'><i class='bi bi-pencil'></i> " . "</a> " . '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-outline-danger btn-sm delete-object" title=' . $this->lang->line('Delete') . '><span class="bi bi-trash"></span></a></div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->fault_count_all($cid),
            "recordsFiltered" => $this->employee->fault_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete_fault()
    {
        if (!$this->aauth->premission(11)) {
            exit($this->lang->line('translate19'));
        }

        $id = $this->input->post('deleteid');

        if ($this->employee->deletefault($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }

    }


    public function edfault()
    {
        if ($this->input->post()) {
            $id = $this->input->post('did');
            $adate = datefordatabase($this->input->post('adate'));
            $edate = datefordatabase($this->input->post('edate'));
            $justified = $this->input->post('justified');
            $note = $this->input->post('note');
            $emp = $this->input->post('employee');

            if ($this->employee->edithfault($id, $emp, $adate, $edate, $justified, $note)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='fault' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='faults' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $data['emp'] = $this->employee->list_employee();
            $data['fault'] = $this->employee->fault_view($data['id'], $this->aauth->get_user()->loc);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Fault';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/editfault', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function attendances()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $this->lang->line('Attendance');
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/attendance_list');
        $this->load->view('fixed/footer');

    }

    public function attendance()
    {
        if ($this->input->post()) {
            $emp = $this->input->post('employee');
            $adate = datefordatabase($this->input->post('adate'));
            $from = timefordatabase($this->input->post('from'));
            $todate = timefordatabase($this->input->post('to'));
            $note = $this->input->post('note');

            if ($this->employee->addattendance($emp, $adate, $from, $todate, $note)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='attendance' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='attendances' class='btn btn-grey btn-lg'><span class='bi bi-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['emp'] = $this->employee->list_employee();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'New Attendance';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/attendance', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function auto_attendance()
    {
        if ($this->input->post()) {
            $auto_attand = $this->input->post('attend');

            if ($this->employee->autoattend($auto_attand)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $this->load->model('plugins_model', 'plugins');

            $data['auto'] = $this->plugins->universal_api(62);


            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Auto Attendance';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/autoattend', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function att_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->employee->attendance_datatables($cid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $obj) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->name;
            $row[] = dateformat($obj->adate) . ' &nbsp; ' . $obj->tfrom . ' - ' . $obj->tto;
            $row[] = round((strtotime($obj->tto) - strtotime($obj->tfrom)) / 3600, 2);
            $row[] = round($obj->actual_hours / 3600, 2);
            $row[] = $obj->note;

            $row[] = '<div class="action-btn"><a href="#" data-object-id="' . $obj->id . '" class="btn btn-outline-danger btn-sm delete-object" title=' . $this->lang->line('Delete') . '><span class="bi bi-trash"></span></a></div>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->attendance_count_all($cid),
            "recordsFiltered" => $this->employee->attendance_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete_attendance()
    {
        if (!$this->aauth->premission(11)) {
            exit($this->lang->line('translate19'));
        }

        $id = $this->input->post('deleteid');

        if ($this->employee->deleteattendance($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


}