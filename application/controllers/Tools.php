<?php
/**

 * 
 * ***********************************************************************
 *
 
 
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * 
 *  * 
 * ***********************************************************************
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Tools extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        $this->load->model('tools_model', 'tools');
        $this->li_a = 'misc';

    }

    //todo section

    public function todo()
    {
        $this->li_a = 'project';
        if (!$this->aauth->premission(61) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Lista de Tarefas';
        $data['totalt'] = $this->tools->task_count_all();

        $this->load->view('fixed/header', $head);
        $this->load->view('todo/index', $data);
        $this->load->view('fixed/footer');

    }

    public function addtask()
    {
        $this->li_a = 'project';
        if (!$this->aauth->premission(65) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $this->load->model('employee_model', 'employee');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['emp'] = $this->employee->list_employee();
        $head['title'] = 'Adicionar Tarefa';

        $this->load->view('fixed/header', $head);
        $this->load->view('todo/addtask', $data);
        $this->load->view('fixed/footer');

    }

    public function edittask()
    {
        $this->li_a = 'project';
        if (!$this->aauth->premission(67) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $name = $this->input->post('name', true);
            $status = $this->input->post('status');
            $priority = $this->input->post('priority');
            $stdate = $this->input->post('staskdate', true);
            $tdate = $this->input->post('taskdate', true);
            $employee = $this->input->post('employee');
            $content = $this->input->post('content');
            $stdate = datefordatabase($stdate);
            $tdate = datefordatabase($tdate);

            if ($this->tools->edittask($id, $name, $status, $priority, $stdate, $tdate, $employee, $content)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . "  <a href='todo' class='btn btn-blue btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {

            $this->load->model('employee_model', 'employee');

            $head['usernm'] = $this->aauth->get_user()->username;
            $data['emp'] = $this->employee->list_employee();
            $head['title'] = 'Alterar Tarefa';

            $id = $this->input->get('id');
            $data['task'] = $this->tools->viewtask($id);

            $this->load->view('fixed/header', $head);
            $this->load->view('todo/edittask', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function save_addtask()
    {
		if (!$this->aauth->premission(66) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
        }
        $name = $this->input->post('name', true);
        $status = $this->input->post('status');
        $priority = $this->input->post('priority');
        $stdate = $this->input->post('staskdate');
        $tdate = $this->input->post('taskdate');
        $employee = $this->input->post('employee');
        $content = $this->input->post('content');
        $assign = $this->aauth->get_user()->id;
        $stdate = datefordatabase($stdate);
        $tdate = datefordatabase($tdate);

        if ($this->tools->addtask($name, $status, $priority, $stdate, $tdate, $employee, $assign, $content)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('New Task Added') . "  <a href='addtask' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a>   <a href='todo' class='btn btn-blue btn-lg'><span class='icon-list-ul' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }

    }

    public function set_task()
    {
		$id = $this->input->post('tid');
		$stat = $this->input->post('stat');
        $this->tools->settask($id, $stat);
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED'), 'pstatus' => 'Success'));
    }

	public function view_note()
    {
        $id = $this->input->post('tid');
        $note = $this->tools->note_v($id);
        echo json_encode(array('title' => $note['title'], 'content' => $note['content'], 'date_ini' => $note['cdate'], 'date_last' => $note['last_edit'], 'employee' => $note['employee']));
    }
	
	
    public function view_task()
    {
        $id = $this->input->post('tid');
        $task = $this->tools->viewtask($id);
        echo json_encode(array('name' => $task['name'], 'description' => $task['description'], 'employee' => $task['emp'], 'assign' => $task['assign'], 'priority' => $task['priority']));
    }

    public function task_stats()
    {
        $this->tools->task_stats();
    }

    public function delete_i()
    {
		if (!$this->aauth->premission(121) && !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $id = $this->input->post('deleteid');

        if ($this->tools->deletetask($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


    public function todo_load_list()
    {
        if (!$this->aauth->premission(4)) {
			exit($this->lang->line('translate19'));
        }
        $cday = $this->input->get('cday');
        $list = $this->tools->task_datatables($cday);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $task) {
            $no++;
			if ($task->status == 'Done') {
                $name = '<a class="check text-success" data-id="' . $task->id . '" data-stat="'. $task->status .'"> <i class="fa fa-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';
            }else if($task->status == 'Due'){
				$name = '<a class="check text-warning" data-id="' . $task->id . '" data-stat="'. $task->status .'"> <i class="fa fa-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';
			}else{
				$name = '<a class="check text-default" data-id="' . $task->id . '" data-stat="'. $task->status .'"> <i class="fa fa-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';
			}
			
            $row = array();
            $row[] = $no;
			
			$row[] = '<a href="#" class="btn btn-primary btn-sm rounded set-task" data-id="' . $task->id . '" data-stat="0"> SET </a>' . $name;
            $row[] = dateformat($task->duedate);
            $row[] = dateformat($task->start);
			$row[] = '<span class="task_' . $task->status . '">' . $this->lang->line($task->status) . '</span>';
			$option = '';
			if ($this->aauth->premission(67) || $this->aauth->get_user()->roleid == 7){
				$option .= '<a href="edittask?id=' . $task->id . '" data-object-id="' . $task->id . '" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span>  ' . $this->lang->line('Edit') . '</a>&nbsp;';
			}
			
			if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7){
				$option .= '<a href="#" data-object-id="' . $task->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';
			}
			$row[] = $option;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tools->task_count_all($cday),
            "recordsFiltered" => $this->tools->task_count_filtered($cday),
            "data" => $data,
        );
        echo json_encode($output);
    }


    //set goals

    public function setgoals()
    {
        if (!$this->aauth->get_user()->roleid == 5 || !$this->aauth->get_user()->roleid == 7) {

            exit($this->lang->line('translate19'));

        }
        $this->li_a = 'company';
        if ($this->input->post('income')) {

            $income = (float)$this->input->post('income');
            $expense = (float)$this->input->post('expense');
            $sales = (float)$this->input->post('sales');
            $netincome = (float)$this->input->post('netincome');


            if ($this->tools->setgoals($income, $expense, $sales, $netincome)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Set Goals';
            $data['goals'] = $this->tools->goals(1);

            $this->load->view('fixed/header', $head);
            $this->load->view('goals/index', $data);
            $this->load->view('fixed/footer');
        }

    }

    //notes

    public function notes()
    {
        if (!$this->aauth->premission(80) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {

            exit($this->lang->line('translate19'));

        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Notes';
        $this->load->view('fixed/header', $head);
        $this->load->view('notes/index');
        $this->load->view('fixed/footer');
    }


    public function notes_load_list()
    {
        if (!$this->aauth->premission(80) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {

            exit($this->lang->line('translate19'));

        }
        $list = $this->tools->notes_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $note) {
            $row = array();
            $no++;
            $row[] = $no;
			$row[] = dateformat($note->cdate);
			$row[] = dateformat($note->last_edit);
            $row[] = $note->title;
            $row[] = $note->name_add;
			$row[] = $note->cli_add;
			$option = '';
			if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7 || $this->aauth->premission(80))
			{
				 $option .= '<a href="#" data-id="' . $note->id . '" class="view_note"><span class="fa fa-eye"></span>  ' . $this->lang->line('View') . '</a>&nbsp;';
			}
			if ($this->aauth->get_user()->roleid == 5 || $this->aauth->get_user()->roleid == 7 || $this->aauth->premission(82))
			{
				$option .= ' <a href="editnote?id=' . $note->id . '&cid=' . $note->fid . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span> ' . $this->lang->line('Edit') . '</a>&nbsp;';
			}
			if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7){
				$option .= ' <a class="btn btn-danger btn-sm delete-object" href="#" data-object-id="' . $note->id . '"> <i class="fa fa-trash"></i> </a>';
			}
			$row[] = $option;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tools->notes_count_all(),
            "recordsFiltered" => $this->tools->notes_count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function addnote()
    {
        if (!$this->aauth->premission(81) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {

            exit($this->lang->line('translate19'));

        }
        if ($this->input->post('title')) {

            $title = $this->input->post('title', true);
            $content = $this->input->post('content');

            if ($this->tools->addnote($title, $content)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='addnote' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Adicionar Nota';
            $this->load->view('fixed/header', $head);
            $this->load->view('notes/addnote');
            $this->load->view('fixed/footer');
        }

    }

    public function editnote()
    {
        if (!$this->aauth->premission(82) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {

            exit($this->lang->line('translate19'));

        }
        if ($this->input->post('title')) {
            $id = $this->input->post('id');
            $title = $this->input->post('title', true);
            $content = $this->input->post('content');

            if ($this->tools->editnote($id, $title, $content)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . "  <a href='editnote?id=$id' class='btn btn-blue btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $id = $this->input->get('id');
            $data['note'] = $this->tools->note_v($id);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Alterar Nota';
            $this->load->view('fixed/header', $head);
            $this->load->view('notes/editnote', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function delete_note()
    {
        if (!$this->aauth->premission(121) && !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $id = $this->input->post('deleteid');

        if ($this->tools->deletenote($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


    //documents


    public function documents()
    {
        if (!$this->aauth->premission(89) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {

            exit($this->lang->line('translate19'));

        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Documentos';
        $this->load->view('fixed/header', $head);
        $this->load->view('notes/documents');
        $this->load->view('fixed/footer');


    }

    public function document_load_list()
    {
        if (!$this->aauth->premission(89) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {

            exit($this->lang->line('translate19'));

        }
        $list = $this->tools->document_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $document) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = dateformat($document->cdate);
			$row[] = $document->title;
			$row[] = $document->name_add;
			$row[] = $document->cli_add;
            $option = '<a href="' . base_url('userfiles/documents/' . $document->filename) . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a>&nbsp;';
			if ($this->aauth->premission(121) || $this->aauth->get_user()->roleid == 7){
				$option .= '<a class="btn btn-danger btn-xs delete-object" href="#" data-object-id="' . $document->id . '"> <i class="fa fa-trash"></i> </a>';
			}
            $row[] = $option;				 
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tools->document_count_all(),
            "recordsFiltered" => $this->tools->document_count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function adddocument()
    {
        if (!$this->aauth->premission(90) || (!$this->aauth->get_user()->roleid == 5 && !$this->aauth->get_user()->roleid == 7)) {
            exit($this->lang->line('translate19'));
												  

        }
        $this->load->helper(array('form'));
        $data['response'] = 3;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Adicionar Documento';

        $this->load->view('fixed/header', $head);

        if ($this->input->post('title')) {
            $title = $this->input->post('title', true);
            $config['upload_path'] = './userfiles/documents';
            $config['allowed_types'] = 'docx|docs|txt|pdf|xls';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = 3000;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('userfile')) {
                $data['response'] = 0;
                $data['responsetext'] = 'File Upload Error';

            } else {
                $data['response'] = 1;
                $data['responsetext'] = 'Document Uploaded Successfully. <a href="documents"
                                       class="btn btn-blue btn-md"><i
                                                class="fa fa-folder"></i>
                                    </a>';
                $filename = $this->upload->data()['file_name'];
                $this->tools->adddocument($title, $filename);
            }

            $this->load->view('notes/adddocument', $data);
        } else {


            $this->load->view('notes/adddocument', $data);


        }
        $this->load->view('fixed/footer');


    }


    public function delete_document()
    {
        if (!$this->aauth->premission(121) && !$this->aauth->get_user()->roleid == 7){
			exit($this->lang->line('translate19'));
		}
        $id = $this->input->post('deleteid');

        if ($this->tools->deletedocument($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


    public function pendingtasks()
    {
        $tasks = $this->tools->pending_tasks();

        $tlist = '';
        $tc = 0;
        foreach ($tasks as $row) {


            $tlist .= '<a href="javascript:void(0)" class="list-group-item">
                      <div class="media">
                        <div class="media-left valign-middle"><i class="icon-bullhorn2 icon-bg-circle bg-cyan"></i></div>
                        <div class="media-body">
                          <h6 class="media-heading">' . $row['name'] . '</h6>
                          <p class="notification-text font-small-2 text-muted">Vencida em ' . dateformat($row['duedate']) . '.</p><small>
                            Start <time  class="media-meta text-muted">' . dateformat($row['start']) . '</time></small>
                        </div>
                      </div></a>';
            $tc++;
        }

        echo json_encode(array('tasks' => $tlist, 'tcount' => $tc));


    }


}