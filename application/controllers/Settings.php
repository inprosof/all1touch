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

class Settings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('invoices_model', 'invocies');
        $this->load->model('products_model', 'products');
        $this->li_a = 'settings';

        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if ($this->aauth->get_user()->roleid < 5) {

            exit($this->lang->line('translate19'));

        }

        $this->load->model('settings_model', 'settings');
    }

    public function company()
    {
        $this->li_a = 'company';
        if ($this->input->post()) {
            $name = $this->input->post('name', true);
            $phone = $this->input->post('phone', true);
            $email = $this->input->post('email', true);
            $address = $this->input->post('address', true);
            $city = $this->input->post('city', true);
            $region = $this->input->post('region', true);
            $country = $this->input->post('country', true);
            $postbox = $this->input->post('postbox', true);
            $taxid = $this->input->post('taxid', true);
            $social_security = $this->input->post('social_security', true);
            $annual_vacation = $this->input->post('annual_vacation', true);
            $number_day_work_month = $this->input->post('number_day_work_month', true);
            $number_hours_work = $this->input->post('number_hours_work', true);
            $share_capital = $this->input->post('share_capital', true);
            $registration = $this->input->post('registration', true);
            $conservator = $this->input->post('conservator', true);
            $passive_res = 0;
            if (filter_has_var(INPUT_POST, 'passive_res')) {
                $passive_res = 1;
            } else {
                $passive_res = 0;
            }
            $rent_ab = 0;
            if (filter_has_var(INPUT_POST, 'rent_ab')) {
                $rent_ab = 1;
            } else {
                $rent_ab = 0;
            }
            $zon_fis = $this->input->post('zon_fis');

            $foundation = datefordatabase($this->input->post('foundation', true));
            $data_share = $this->input->post('data_share');

            $this->db->delete('geopos_documents_copys', array('loc' => 0));
            $typs_id = $this->input->post('pid');
            $pcopyid = $this->input->post('pcopyid');
            $typslist = array();
            $prodindex = 0;
            foreach ($typs_id as $key => $value) {
                $data = array(
                    'loc' => 0,
                    'typ_doc' => $typs_id[$key],
                    'copy' => $pcopyid[$key]);
                $typslist[$prodindex] = $data;
                $prodindex++;
            }
            $this->db->insert_batch('geopos_documents_copys', $typslist);
            $this->settings->update_company(1, $name, $phone, $email, $address, $city, $region, $country, $postbox, $taxid, $social_security, $annual_vacation, $number_day_work_month, $number_hours_work, $share_capital, $registration, $conservator, $passive_res, $foundation, $data_share, $rent_ab, $zon_fis);
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . ' Por favor Faça SHIFT+F5 para verificar as Alterações.'));
        } else {
            $id = $this->input->get('id');
            if ($id != null) {
                $data['param' . $id] = $id;
            } else {
                $id = 0;
                $data['param1'] = 1;
            }

            if ($id == 1 || $id == 0) {
                $data['param2'] = 0;
                $data['param3'] = 0;
                $data['param4'] = 0;
                $data['param44'] = 0;
                $data['param5'] = 0;
                $data['param6'] = 0;
                $data['param7'] = 0;
                $data['param77'] = 0;
            } else if ($id == 2) {
                $data['param1'] = 0;
                $data['param3'] = 0;
                $data['param4'] = 0;
                $data['param44'] = 0;
                $data['param5'] = 0;
                $data['param6'] = 0;
                $data['param7'] = 0;
                $data['param77'] = 0;
            } else if ($id == 3) {
                $data['param1'] = 0;
                $data['param2'] = 0;
                $data['param4'] = 0;
                $data['param44'] = 0;
                $data['param5'] = 0;
                $data['param6'] = 0;
                $data['param7'] = 0;
                $data['param77'] = 0;
            } else if ($id == 4) {
                $data['param1'] = 0;
                $data['param2'] = 0;
                $data['param3'] = 0;
                $data['param44'] = 0;
                $data['param5'] = 0;
                $data['param6'] = 0;
                $data['param7'] = 0;
                $data['param77'] = 0;
            } else if ($id == 44) {
                $data['param1'] = 0;
                $data['param2'] = 0;
                $data['param3'] = 0;
                $data['param4'] = 0;
                $data['param5'] = 0;
                $data['param6'] = 0;
                $data['param7'] = 0;
                $data['param77'] = 0;
            } else if ($id == 5) {
                $data['param1'] = 0;
                $data['param2'] = 0;
                $data['param3'] = 0;
                $data['param4'] = 0;
                $data['param44'] = 0;
                $data['param6'] = 0;
                $data['param7'] = 0;
                $data['param77'] = 0;
            } else if ($id == 6) {
                $data['param1'] = 0;
                $data['param2'] = 0;
                $data['param3'] = 0;
                $data['param4'] = 0;
                $data['param44'] = 0;
                $data['param5'] = 0;
                $data['param7'] = 0;
                $data['param77'] = 0;
            } else if ($id == 7) {
                $data['param1'] = 0;
                $data['param2'] = 0;
                $data['param3'] = 0;
                $data['param4'] = 0;
                $data['param44'] = 0;
                $data['param5'] = 0;
                $data['param6'] = 0;
                $data['param77'] = 0;
            } else if ($id == 77) {
                $data['param1'] = 0;
                $data['param2'] = 0;
                $data['param3'] = 0;
                $data['param4'] = 0;
                $data['param44'] = 0;
                $data['param5'] = 0;
                $data['param6'] = 0;
                $data['param7'] = 0;
            }
            $this->load->model('saft_model', 'saft');
            $this->load->model('plugins_model', 'plugins');
            $this->load->model('accounts_model');
            $this->load->library("Common");

            $this->db->select('*');
            $this->db->from('geopos_warehouse');
            if ($this->aauth->get_user()->loc) {
                $this->db->where('loc', $this->aauth->get_user()->loc);
            }
            $query = $this->db->get();
            $data['warehouses'] = $query->result_array();

            $data['prazos_vencimento'] = $this->common->sprazovencimento();
            $data['expeditions'] = $this->common->sexpeditions();
            $data['metodos_pagamentos'] = $this->common->smetopagamento();

            $data['expeditions'] = $this->common->sexpeditions();
            $data['company_permiss'] = $this->saft->getpermissionsystem(0);
            $data['irs_typ'] = $this->common->irs_typ_combo();
            $data['acclist'] = $this->accounts_model->accountslist($this->aauth->get_user()->loc);
            $data['countrys'] = $this->common->countrys();
            $data['activation'] = $this->saft->getsaftautenticationloc(0);
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['docs_copy_ini'] = $this->common->default_typ_pref_doc_list($this->aauth->get_user()->loc);
            $head['title'] = $this->lang->line('company_settings');
            $data['company'] = $this->settings->company_details(1);
            $data['online_pay'] = $this->settings->online_pay_settings_main();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/company', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function autority_pt()
    {
        $this->li_a = 'company';
        if ($this->input->post()) {
            $this->load->model('saft_model', 'saft');
            $bill_doc = 0;
            $trans_doc = 0;

            if (filter_has_var(INPUT_POST, 'billing_doc')) {
                $bill_doc = 1;
            } else {
                $bill_doc = 0;
            }

            if (filter_has_var(INPUT_POST, 'transport_doc')) {
                $trans_doc = 1;
            } else {
                $trans_doc = 0;
            }

            $databddocs = "";
            if ($bill_doc == 1) {
                if ($this->input->post('date_docs') == "") {
                    $databddocs = date('d-m-Y');
                } else {
                    $databddocs = $this->input->post('date_docs');
                }
            }

            $databdtrans = "";
            if ($trans_doc == 1) {
                if ($this->input->post('date_docs_guide') == "") {
                    $databdtrans = date('d-m-Y');
                } else {
                    $databdtrans = $this->input->post('date_docs_guide');
                }
            }

            $username = $this->input->post('username');
            $password = $this->input->post('password');

            if ($username == "") {
                echo json_encode(array('status' => 'Error', 'message' => 'Por favor inserir o seu Utilizador.'));
                return;
            }

            if ($password == "") {
                echo json_encode(array('status' => 'Error', 'message' => 'Por favor inserir a sua Senha.'));
                return;
            }

            if ($this->saft->editat(1, $bill_doc, $databddocs, $trans_doc, $databdtrans, $username, $password)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . ' Por favor Faça SHIFT+F5 para verificar as Alterações.'));
            } else {
                echo json_encode(array('status' => 'Success', 'message' => 'Erro a guardar informações AT.'));
            }
        }
    }

    public function reg_iva()
    {
        $this->load->model('saft_model', 'saft');
        if ($this->input->post()) {
            $caixa_1 = 0;
            $caixa_2 = 0;
            $caixa_3 = 0;
            $caixa_4 = 0;

            if (filter_has_var(INPUT_POST, 'caixa_1')) {
                $caixa_1 = 1;
            }

            if (filter_has_var(INPUT_POST, 'caixa_2')) {
                $caixa_2 = 1;
            }

            if (filter_has_var(INPUT_POST, 'caixa_3')) {
                $caixa_3 = 1;
            }

            if (filter_has_var(INPUT_POST, 'caixa_4')) {
                $caixa_4 = 1;
            }

            $dateActiv = "";
            if ($caixa_1 == 1 && $caixa_2 == 1 && $caixa_3 == 1) {
                if ($caixa_4 == 1) {
                    if ($this->input->post('caixa_doc_date') == "") {
                        $dateActiv = date('d-m-Y');
                    } else {
                        $dateActiv = $this->input->post('caixa_doc_date');
                    }
                }
            }
            if ($this->saft->editcaixa(1, $caixa_1, $caixa_2, $caixa_3, $caixa_4, $dateActiv)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . ' Por favor Faça SHIFT+F5 para verificar as Alterações.'));
            } else {
                echo json_encode(array('status' => 'Success', 'message' => 'Erro a guardar informações Caixa IVA.'));
            }
        }
    }

    public function currency()
    {
        $this->li_a = 'localisation';
        if ($this->input->post()) {
            $currency = $this->input->post('currency', true);
            $thous_sep = $this->input->post('thous_sep');
            $deci_sep = $this->input->post('deci_sep');
            $decimal = $this->input->post('decimal');
            $spost = $this->input->post('spos');
            $roundoff = $this->input->post('roundoff');
            $r_precision = $this->input->post('r_precision');

            $this->settings->update_currency(1, $currency, $thous_sep, $deci_sep, $decimal, $spost, $roundoff, $r_precision);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('Currency Settings');
            $data['currency'] = $this->settings->currency();

            $this->load->view('fixed/header', $head);
            $this->load->view('settings/currency', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function dtformat()
    {
        $this->li_a = 'localisation';
        if ($this->input->post()) {
            $tzone = $this->input->post('tzone');
            $dateformat = $this->input->post('dateformat');
            $this->settings->update_dtformat(1, $tzone, $dateformat);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('Date Time Settings');
            $data['company'] = $this->settings->company_details(1);
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/timeformat', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function companylogo()
    {
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/company/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->settings->companylogo($id, $img);
        }
    }

    //tax


    public function email()
    {
        $this->li_a = 'misc_settings';
        if ($this->input->post()) {
            $host = $this->input->post('host');
            $port = $this->input->post('port');
            $auth = $this->input->post('auth');
            $auth_type = $this->input->post('auth_type');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $sender = $username;

            $this->load->library('ultimatemailer');

            $test = $this->ultimatemailer->bin_send($host, $port, $auth, $auth_type, $username, $password, $sender, ' Test', $sender, ' Test', ' SMTP Test', 'Hi, This is a  SMTP Test! Working Perfectly', false, '');

            if ($test) {
                $this->settings->update_smtp($host, $port, $auth, $auth_type, $username, $password);
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('smtperrorport')));
            }

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('SMTP Config');
            $data['email'] = $this->settings->email_smtp();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/email', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function billing_terms()
    {
        $this->li_a = 'billing';
        $this->load->library("Common");
        $data['terms'] = $this->common->stermos();
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/terms', $data);
        $this->load->view('fixed/footer');
    }

    public function about()
    {
        $this->li_a = 'misc_settings';
        $head['title'] = $this->lang->line('About');

        $this->load->view('fixed/header', $head);
        $this->load->view('settings/about');
        $this->load->view('fixed/footer');
    }

    public function add_term()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $title = $this->input->post('title', true);
            $type = $this->input->post('type');
            $term = $this->input->post('terms');

            $this->settings->add_term($title, $type, $term);

        } else {
            $this->load->library("Common");
            $head['title'] = $this->lang->line('Add Billing Term');
            $head['terms'] = $this->common->stermos();
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/add_terms');
            $this->load->view('fixed/footer');
        }
    }


    public function edit_term()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $title = $this->input->post('title', true);
            $type = $this->input->post('type');
            $term = $this->input->post('terms');
            $this->settings->edit_term($id, $title, $type, $term);
        } else {
            $id = $this->input->get('id');
            $this->load->library("Common");
            $data['term'] = $this->settings->terms_details($id);
            $data['terms'] = $this->common->stermos();
            $head['title'] = $this->lang->line('Edit Billing Term');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/edit_terms', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete_terms()
    {

        if ($this->input->post()) {
            $id = $this->input->post('deleteid');


            if ($this->settings->delete_terms($id)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }

        }
    }

    public function activate()
    {
        if ($this->input->post()) {
            $email = $this->input->post('email', true);
            $code = $this->input->post('code', true);
            $this->settings->update_atformat($email, $code);
        } else {
            $head['title'] = $this->lang->line('Software Activation');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/active');
            $this->load->view('fixed/footer');
        }
    }

    public function theme()
    {
        $this->li_a = 'localisation';
        if ($this->input->post()) {
            $tdirection = $this->input->post('tdirection', true);
            $menu = $this->input->post('menu', true);
            $this->settings->theme($tdirection, $menu);
        } else {
            $head['title'] = $this->lang->line('Theme Settings');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/theme');
            $this->load->view('fixed/footer');
        }
    }

    public function themelogo()
    {
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(png)$/i', 'upload_dir' => FCPATH . 'userfiles/theme/', 'name' => 'logo-header.png'
        ));
    }

    public function tickets()
    {
        $this->load->model('plugins_model', 'plugins');
        if ($this->input->post()) {
            $service = $this->input->post('service', true);
            $email = $this->input->post('email', true);
            $support = $this->input->post('support', true);
            $sign = $this->input->post('signature');
            $this->plugins->update_api(3, $service, $email, 1, $support, $sign);
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('Support Ticket Settings');
            $data['support'] = $this->plugins->universal_api(3);
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/ticket', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function language()
    {
        $this->li_a = 'localisation';
        $this->load->library("Common");
        if ($this->input->post()) {
            $lang = $this->input->post('language', true);
            $this->settings->update_language(1, $lang);
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('Billing & TAX Settings');
            $data['company'] = $this->settings->company_details(1);
            $data['langs'] = $this->common->languages();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/billing', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function automail()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $sms = $this->input->post('sms');
            $this->settings->update_automail($email, $sms);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('Auto Email SMS Settings');
            $data['auto'] = $this->settings->automail();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/automail', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function taxslabs()
    {
        $this->li_a = 'tax';
        $data['catlist'] = $this->settings->slabs();
        $head['title'] = $this->lang->line('TAX Slabs');
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/slabs', $data);
        $this->load->view('fixed/footer');
    }

    public function taxslabs_new()
    {
        $this->li_a = 'tax';
        if ($this->input->post()) {
            $tname = $this->input->post('tname', true);
            $tcode = $this->input->post('taxcode', true);
            $tregion = $this->input->post('taxcountryregion', true);
            $tdesc = $this->input->post('taxdescription');
            $trate = $this->input->post('trate');
            $ttype = "yes";
            $ttype2 = "yes";
            //$ttype = $this->input->post('ttype');
            //$ttype2 = $this->input->post('ttype2');
            $this->settings->add_slab($tname, $trate, $ttype, $ttype2, $tcode, $tregion, $tdesc);

        } else {
            $this->load->library("Common");
            $data['countrys'] = $this->common->countrys();
            $data['catlist'] = $this->settings->slabs();
            $head['title'] = $this->lang->line('Add TAX Slabs');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/tax_create', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function caes()
    {
        $this->li_a = 'company';
        $data['caes'] = $this->settings->scaes();
        $head['title'] = 'C.A.E s da Empresa';
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/cae_list', $data);
        $this->load->view('fixed/footer');
    }

    public function caes_new()
    {
        $this->li_a = 'company';
        if ($this->input->post()) {
            $tname = $this->input->post('tname', true);
            $tcode = $this->input->post('tcod', true);
            $this->settings->add_caes($tname, $tcode);
        } else {
            $head['title'] = 'Adicionar novo C.A.E';
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/cae_create');
            $this->load->view('fixed/footer');
        }
    }

    public function caes_edit()
    {
        $this->li_a = 'company';
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $tname = $this->input->post('tname', true);
            $tcode = $this->input->post('tcod', true);
            $this->settings->edit_caes($id, $tname, $tcode);

        } else {
            $caeid = $this->input->get('id');
            $data['caes'] = $this->settings->caesget($caeid);
            $head['title'] = 'Alteração do C.A.E - ' . $data['caes']['cod'];
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/cae_edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function caes_delete()
    {
        if ($this->input->post()) {
            $id = $this->input->post('deleteid');
            $data = array(
                'status' => 1
            );
            $this->db->set($data);
            $this->db->where('id', $id);
            if ($this->db->update('geopos_caes', $data)) {
                echo json_encode(array('status' => 'Success', 'message' => 'O C.A.E foi inactivado.'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        }
    }


    public function taxslabs_edit()
    {
        $this->li_a = 'tax';
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $tname = $this->input->post('tname', true);
            $tcode = $this->input->post('taxcode', true);
            $tregion = $this->input->post('taxcountryregion', true);
            $tdesc = $this->input->post('taxdescription');
            $trate = $this->input->post('trate');
            $ttype = "yes";
            $ttype2 = "yes";
            //$ttype = $this->input->post('ttype');
            //$ttype2 = $this->input->post('ttype2');
            $this->settings->edit_slab($id, $tname, $trate, $ttype, $ttype2, $tcode, $tregion, $tdesc);

        } else {
            $catid = $this->input->get('id');
            $this->load->library("Common");
            $data['countrys'] = $this->common->countrys();
            $data['slabs'] = $this->settings->slabsget($catid);
            $data['catlist'] = $this->settings->slabs();
            $head['title'] = $this->lang->line('Edit TAX Slabs');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/tax_edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function taxslabs_delete()
    {
        if ($this->input->post()) {
            $id = $this->input->post('deleteid');
            if ($this->settings->delete_slab($id)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        }
    }

    public function withholdingsoptions()
    {
        //$pid = $this->input->post('pid', true);
        $query = $this->db->query("SELECT geopos_config.* FROM geopos_config WHERE geopos_config.type = 3");
        $out = array();
        $result = array();
        $result = $query->result_array();
        foreach ($result as $row) {
            $name = array($row['id'], $row['val2'], $row['taxcode'], $row['taxregion'], $row['val1']);
            array_push($out, $name);
        }
        echo json_encode($out);
    }


    public function withholding()
    {
        $this->li_a = 'tax';
        $data['catlist'] = $this->settings->withholdings();
        $head['title'] = $this->lang->line('Withholding');
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/withholdings', $data);
        $this->load->view('fixed/footer');
    }

    public function taxwithholdings_new()
    {
        $this->li_a = 'tax';
        if ($this->input->post()) {
            $tname = $this->input->post('tname', true);
            $trate = $this->input->post('trate', true);
            $ttype = $this->input->post('ttype', true);
            $tother = $this->input->post('tcodesend', true);
            $ttaxcode = $this->input->post('tcode', true);
            $tdiscription = $this->input->post('tdiscription', true);
            $this->settings->add_withholdings($tname, $trate, $ttype, $tdiscription, $tother, $ttaxcode);

        } else {

            $data['catlist'] = $this->settings->withholdings();
            $head['title'] = $this->lang->line('Add') . ' ' . $this->lang->line('Withholding');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/withholdings_create', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function taxwithholdings_edit()
    {
        $this->li_a = 'tax';
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $tname = $this->input->post('tname', true);
            $trate = $this->input->post('trate', true);
            $ttype = $this->input->post('ttype', true);
            $tother = $this->input->post('tcodesend', true);
            $ttaxcode = $this->input->post('tcode', true);
            $tdiscription = $this->input->post('tdiscription', true);
            $this->settings->edit_withholdings($id, $tname, $trate, $ttype, $tdiscription, $tother, $ttaxcode);
        } else {
            $catid = $this->input->get('id');
            $query = $this->db->query("SELECT * FROM geopos_config where id=" . $catid . " and type=3");
            $data['slabs'] = $query->row_array();
            $head['title'] = $this->lang->line('Withholding') . ' ' . $this->lang->line('Edit');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/withholdings_edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function taxwithholdings_delete()
    {
        if ($this->input->post()) {
            $id = $this->input->post('deleteid');
            if ($this->settings->delete_withholdings($id)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }

        }
    }


    public function reasons_notes()
    {
        $this->li_a = 'tax';
        $data['catlist'] = $this->settings->reasons_notes();
        $head['title'] = 'Razões Notas de Clientes';
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/reasons_notes', $data);
        $this->load->view('fixed/footer');
    }

    public function reasons_notes_new()
    {
        $this->li_a = 'tax';
        if ($this->input->post()) {
            $tname = $this->input->post('tname', true);
            $tcod = $this->input->post('tcode', true);
            $this->settings->add_reasons_notes($tname, $tcod);
        } else {
            $head['title'] = $this->lang->line('Add') . ' Razão da Nota para o Cliente';
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/reasons_notes_create');
            $this->load->view('fixed/footer');
        }
    }


    public function reasons_notes_edit()
    {
        $this->li_a = 'tax';
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $tname = $this->input->post('tname', true);
            $tcod = $this->input->post('tcode', true);
            $this->settings->edit_reasons_notes($id, $tname, $tcod);
        } else {
            $catid = $this->input->get('id');
            $query = $this->db->query("SELECT * FROM geopos_config where id=" . $catid . " and type=11");
            $data['slabs'] = $query->row_array();
            $head['title'] = 'Razão da Nota ' . $this->lang->line('Edit');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/reasons_notes_edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function reasons_notes_delete()
    {
        if ($this->input->post()) {
            $id = $this->input->post('deleteid');
            if ($this->settings->delete_reasons_notes($id)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }

        }
    }


    public function method_payments()
    {
        $this->li_a = 'payments';
        $data['catlist'] = $this->settings->method_payment();
        $head['title'] = 'Métodos de Pagamentos';
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/method_payments', $data);
        $this->load->view('fixed/footer');
    }

    public function method_payments_new()
    {
        $this->li_a = 'payments';
        if ($this->input->post()) {
            $tcode = $this->input->post('tcode', true);
            $tname = $this->input->post('tname', true);
            $this->settings->add_method_payments($tcode, $tname);

        } else {
            $head['title'] = $this->lang->line('Add') . 'Métodos de Pagamentos';
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/method_payments_create', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function method_payments_edit()
    {
        $this->li_a = 'payments';
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $tcode = $this->input->post('tcode', true);
            $tname = $this->input->post('tname', true);
            $this->settings->edit_method_payments($id, $tcode, $tname);
        } else {
            $catid = $this->input->get('id');
            $query = $this->db->query("SELECT * FROM geopos_config where id=" . $catid . " and type=9");
            $data['slabs'] = $query->row_array();
            $head['title'] = 'Métodos de Pagamentos ' . $this->lang->line('Edit');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/method_payments_edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function method_payments_delete()
    {
        if ($this->input->post()) {
            $id = $this->input->post('deleteid');
            if ($this->settings->delete_method_payments($id)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        }
    }


    public function method_expeditions()
    {
        $this->li_a = 'payments';
        $data['catlist'] = $this->settings->method_expedition();
        $head['title'] = 'Métodos de Expedição';
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/method_expeditions', $data);
        $this->load->view('fixed/footer');
    }

    public function method_expeditions_new()
    {
        $this->li_a = 'payments';
        if ($this->input->post()) {
            $tcode = $this->input->post('tcode', true);
            $tname = $this->input->post('tname', true);
            $this->settings->add_method_expeditions($tcode, $tname);

        } else {
            $head['title'] = $this->lang->line('Add') . 'Métodos de Expedição';
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/method_expeditions_create', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function method_expeditions_edit()
    {
        $this->li_a = 'payments';
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $tcode = $this->input->post('tcode', true);
            $tname = $this->input->post('tname', true);
            $this->settings->edit_method_expeditions($id, $tcode, $tname);
        } else {
            $catid = $this->input->get('id');
            $query = $this->db->query("SELECT * FROM geopos_config where id=" . $catid . " and type=6");
            $data['slabs'] = $query->row_array();
            $head['title'] = 'Métodos de Expedição ' . $this->lang->line('Edit');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/method_expeditions_edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function method_expeditions_delete()
    {
        if ($this->input->post()) {
            $id = $this->input->post('deleteid');
            if ($this->settings->delete_method_expeditions($id)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        }
    }


    public function numb_copys()
    {
        $this->li_a = 'payments';
        $data['catlist'] = $this->settings->numb_copy();
        $head['title'] = 'Número de Cópias';
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/numb_copys', $data);
        $this->load->view('fixed/footer');
    }

    public function numb_copys_new()
    {
        $this->li_a = 'payments';
        if ($this->input->post()) {
            $tcode = $this->input->post('tcode', true);
            $tname = $this->input->post('tname', true);
            $this->settings->add_numb_copys($tcode, $tname);
        } else {
            $head['title'] = $this->lang->line('Add') . ' Número de Cópias';
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/numb_copys_create', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function numb_copys_edit()
    {
        $this->li_a = 'payments';
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $tcode = $this->input->post('tcode', true);
            $tname = $this->input->post('tname', true);
            $this->settings->edit_numb_copys($id, $tcode, $tname);
        } else {
            $catid = $this->input->get('id');
            $query = $this->db->query("SELECT * FROM geopos_config where id=" . $catid . " and type=8");
            $data['slabs'] = $query->row_array();
            $head['title'] = 'Número de Cópias ' . $this->lang->line('Edit');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/numb_copys_edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function numb_copys_delete()
    {
        if ($this->input->post()) {
            $id = $this->input->post('deleteid');
            if ($this->settings->delete_numb_copys($id)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        }
    }

    public function praz_vencs()
    {
        $this->li_a = 'payments';
        $data['catlist'] = $this->settings->praz_venc();
        $head['title'] = 'Prazo de Vencimento';
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/praz_vencs', $data);
        $this->load->view('fixed/footer');
    }

    public function praz_vencs_new()
    {
        $this->li_a = 'payments';
        if ($this->input->post()) {
            $tcode = $this->input->post('tcode', true);
            $tname = $this->input->post('tname', true);
            $this->settings->add_praz_vencs($tcode, $tname);
        } else {
            $head['title'] = $this->lang->line('Add') . ' Prazo de Vencimento';
            $data['title'] = $this->lang->line('Add') . ' Prazo de Vencimento';
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/praz_vencs_create', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function praz_vencs_edit()
    {
        $this->li_a = 'payments';
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $tcode = $this->input->post('tcode', true);
            $tname = $this->input->post('tname', true);
            $this->settings->edit_praz_vencs($id, $tcode, $tname);
        } else {
            $catid = $this->input->get('id');
            $query = $this->db->query("SELECT * FROM geopos_config where id=" . $catid . " and type=7");
            $data['slabs'] = $query->row_array();
            $head['title'] = 'Prazo de Vencimento ' . $this->lang->line('Edit');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/praz_vencs_edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function praz_vencs_delete()
    {
        if ($this->input->post()) {
            $id = $this->input->post('deleteid');
            if ($this->settings->delete_praz_vencs($id)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        }
    }


    function smetopagamento($id = 0)
    {
        $query = "";
        $this->db->select('*');
        $this->db->from('geopos_config');
        $this->db->where('geopos_config.type', 9);
        $query = $this->db->get();
        $out = array();
        $result = array();
        $result = $query->result_array();
        foreach ($result as $row) {
            $name = array($row['id'], $row['val2'], $row['val1']);
            array_push($out, $name);
        }
        echo json_encode($out);
    }

    public function logdata()
    {
        $this->li_a = 'advance';
        $data['acts'] = $this->settings->logs();
        $head['title'] = $this->lang->line('App Log');
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/logs', $data);
        $this->load->view('fixed/footer');
    }

    public function discship()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';
        $this->load->library("Common");
        $data['discship'] = $this->plugins->universal_api(61);
        if ($this->input->post()) {
            $discstatus = $this->input->post('discstatus');
            $shiptax_type = $this->input->post('shiptax_type');
            $shiptax_rate = $this->input->post('shiptax_rate');
            switch ($discstatus) {


                case 'flat' :
                    $discstatus_name = $this->lang->line('Flat Discount') . ' ' . $this->lang->line('After TAX');
                    break;
                case 'b_p' :
                    $discstatus_name = $this->lang->line('% Discount') . ' ' . $this->lang->line('Before TAX');
                    break;
                case 'bflat' :
                    $discstatus_name = $this->lang->line('Flat Discount') . ' ' . $this->lang->line('Before TAX');
                    break;
                default :
                    $discstatus_name = $this->lang->line('% Discount') . ' ' . $this->lang->line('After TAX');
                    break;
            }
            $this->plugins->update_api(61, $discstatus, $shiptax_rate, 0, $shiptax_type, $discstatus_name);


        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $this->lang->line('Discount & Shipping Settings');
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/discship', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function geral_emails()
    {
        if ($this->input->post()) {
            $emails_notifica = $this->input->post('emails_notifica', true);
            $emailo_remet = $this->input->post('emailo_remet', true);
            $email_stock = $this->input->post('email_stock', true);

            $docs_email = 0;
            if (filter_has_var(INPUT_POST, 'docs_email')) {
                $docs_email = 1;
            } else {
                $docs_email = 0;
            }

            $docs_del_email = 0;
            if (filter_has_var(INPUT_POST, 'docs_del_email')) {
                $docs_del_email = 1;
            } else {
                $docs_del_email = 0;
            }

            $trans_email = 0;
            if (filter_has_var(INPUT_POST, 'trans_email')) {
                $trans_email = 1;
            } else {
                $trans_email = 0;
            }

            $trans_del_email = 0;
            if (filter_has_var(INPUT_POST, 'trans_del_email')) {
                $trans_del_email = 1;
            } else {
                $trans_del_email = 0;
            }

            $stock_min = 0;
            if (filter_has_var(INPUT_POST, 'stock_min')) {
                $stock_min = 1;
            } else {
                $stock_min = 0;
            }

            $stock_sem = 0;
            if (filter_has_var(INPUT_POST, 'stock_sem')) {
                $stock_sem = 1;
            } else {
                $stock_sem = 0;
            }

            $data = array(
                'email_app' => $emails_notifica,
                'emailo_remet' => $emailo_remet,
                'email_stock' => $email_stock,
                'docs_email' => $docs_email,
                'docs_del_email' => $docs_del_email,
                'trans_email' => $trans_email,
                'trans_del_email' => $trans_del_email,
                'stock_min' => $stock_min,
                'stock_sem' => $stock_sem
            );
            $this->db->set($data);
            $this->db->where('loc', 0);
            $this->db->update('geopos_system_permiss');
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . ' Por favor Faça SHIFT+F5 para verificar as Alterações.'));
        }
    }

    public function geral_configs()
    {
        if ($this->input->post()) {
            $grafic = 0;
            if (filter_has_var(INPUT_POST, 'grafic_show')) {
                $grafic = 1;
            } else {
                $grafic = 0;
            }

            $products = 0;
            if (filter_has_var(INPUT_POST, 'products_show')) {
                $products = 1;
            } else {
                $products = 0;
            }

            $clients = 0;
            if (filter_has_var(INPUT_POST, 'clients_show')) {
                $clients = 1;
            } else {
                $clients = 0;
            }

            $data2 = array(
                'grafics' => $grafic,
                'products_inactiv_show' => $products,
                'clients_inactiv_show' => $clients
            );
            $this->db->set($data2);
            $this->db->where('id', 1);
            $this->db->update('geopos_system_permiss');

            $wid = $this->input->post('wid', true);
            $pstyle = $this->input->post('pstyle', true);
            $assign = $this->input->post('assign', true);
            $pos_list = $this->input->post('pos_list', true);
            $pos_type_doc = $this->input->post('pos_type_doc', true);
            $account_o = $this->input->post('account_o', true);
            $account_d = $this->input->post('account_d', true);
            $account_f = $this->input->post('account_f', true);
            $dual_entry = $this->input->post('dual_entry', true);

            $n_met_exp = $this->input->post('n_met_exp', true);
            $n_met_pag = $this->input->post('n_met_pag', true);
            $n_praz_venc = $this->input->post('n_praz_venc', true);


            $config_file_path = APPPATH . "config/constants.php";
            $config_file = file_get_contents($config_file_path);
            $config_file = str_replace("('PAC', '" . PAC . "')", "('PAC', '$pos_list')", $config_file);
            $config_file = str_replace("('POSV', '" . POSV . "')", "('POSV', '$pstyle')", $config_file);
            $config_file = str_replace("('WARHOUSE', '" . WARHOUSE . "')", "('WARHOUSE', '$wid')", $config_file);
            $config_file = str_replace("('DOCDEFAULT', '" . DOCDEFAULT . "')", "('DOCDEFAULT', '$pos_type_doc')", $config_file);
            $config_file = str_replace("('POSACCOUNT', '" . POSACCOUNT . "')", "('POSACCOUNT', '$account_d')", $config_file);
            $config_file = str_replace("('DUALENTRY', '" . DUALENTRY . "')", "('DUALENTRY', '$dual_entry')", $config_file);
            $config_file = str_replace("('DOCSACCOUNT', '" . DOCSACCOUNT . "')", "('DOCSACCOUNT', '$account_o')", $config_file);
            $config_file = str_replace("('DOCSFACCOUNT', '" . DOCSFACCOUNT . "')", "('DOCSFACCOUNT', '$account_f')", $config_file);
            $config_file = str_replace("('EMPS', '" . EMPS . "')", "('EMPS', '$assign')", $config_file);
            $config_file = str_replace("('PRAZOVE', '" . PRAZOVE . "')", "('PRAZOVE', '$n_praz_venc')", $config_file);
            $config_file = str_replace("('METODEXP', '" . METODEXP . "')", "('METODEXP', '$n_met_exp')", $config_file);
            $config_file = str_replace("('METODPAG', '" . METODPAG . "')", "('METODPAG', '$n_met_pag')", $config_file);
            file_put_contents($config_file_path, $config_file);
            clearstatcache();
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . ' Por favor Faça SHIFT+F5 para verificar as Alterações.'));
        }
    }

    public function zero_stock()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';

        if ($this->input->post()) {
            $tdirection = $this->input->post('stock', true);
            $expired = $this->input->post('expired', true);
            $this->settings->zerostock($tdirection);
        } else {
            $data['current'] = $this->plugins->universal_api(63);
            $head['title'] = $this->lang->line('Product As Service Settings');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/zerostock', $data);
            $this->load->view('fixed/footer');


        }
    }

    public function registration()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';

        if ($this->input->post()) {
            $register = $this->input->post('register', true);
            $email_confrim = $this->input->post('email_conf', true);
            $auto_mail = $this->input->post('automail', true);
            $this->plugins->m_update_api(64, $register, 0, $email_confrim, 0, $auto_mail);
        } else {
            $data['current'] = $this->plugins->universal_api(64);
            $head['title'] = $this->lang->line('CRMSettings');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/selfregistration', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function custom_fields()
    {
        $this->li_a = 'advance';
        $data['customfields'] = $this->settings->custom_fields();
        $head['title'] = $this->lang->line('Custom Form Fields Settings');
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/custom_field', $data);
        $this->load->view('fixed/footer');
    }

    public function add_custom_field()
    {
        $this->li_a = 'advance';
        if ($this->input->post()) {
            $f_name = $this->input->post('f_name', true);
            $f_type = $this->input->post('f_type', true);
            $f_module = $this->input->post('f_module', true);
            $f_view = $this->input->post('f_view', true);
            $f_required = $this->input->post('f_required', true);
            $f_placeholder = $this->input->post('f_placeholder', true);
            $f_description = $this->input->post('f_description', true);
            $this->settings->custom_field_add($f_name, $f_type, $f_module, $f_view, $f_required, $f_placeholder, $f_description);
        } else {
            $head['title'] = $this->lang->line('Add Custom Form Fields Settings');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/field_add');
            $this->load->view('fixed/footer');
        }
    }

    public function edit_custom_field()
    {
        $this->li_a = 'advance';
        if ($this->input->post()) {
            $f_type = $this->input->post('f_type', true);
            $f_module = $this->input->post('f_module', true);
            $f_name = $this->input->post('f_name', true);
            $f_view = $this->input->post('f_view', true);
            $f_required = $this->input->post('f_required', true);
            $f_placeholder = $this->input->post('f_placeholder', true);
            $f_description = $this->input->post('f_description', true);
            $id = $this->input->post('fid');
            $this->settings->custom_field_edit($id, $f_name, $f_type, $f_module, $f_view, $f_required, $f_placeholder, $f_description);
        } else {
            $id = $this->input->get('id');
            $data['customfields'] = $this->settings->custom_fields($id);
            $head['title'] = $this->lang->line('Edit Custom Form Fields Settings');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/field_edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function delete_custom_field()
    {
        $id = $this->input->post('deleteid');

        if ($this->db->delete('geopos_custom_fields', array('id' => $id))) {
            $this->db->delete('geopos_custom_data', array('field_id' => $id));
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function print_invoice()
    {
        $this->li_a = 'templates';
        if ($this->input->post()) {
            $tdirection = $this->input->post('pstyle', true);
            $this->settings->printinvoice($tdirection);
        } else {
            $head['title'] = $this->lang->line('Print Invoice Style Settings');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/printinvoice');
            $this->load->view('fixed/footer');
        }
    }

    public function allow_custom()
    {
        $enable = $this->input->post('enable');
        if ($enable != CUSTOM) {
            $config_file_path = APPPATH . "config/constants.php";
            $config_file = file_get_contents($config_file_path);
            $config_file = str_replace("('CUSTOM', '" . CUSTOM . "')", "('CUSTOM', '$enable')", $config_file);
            file_put_contents($config_file_path, $config_file);
        }
    }

    public function debug()
    {
        $this->li_a = 'billing';
        if ($this->input->post()) {
            $debug = $this->input->post('debug', true);
            $this->settings->debug($debug);
        } else {
            $head['title'] = $this->lang->line('App Debug Settings');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/debug');
            $this->load->view('fixed/footer');
        }
    }

    public function server()
    {
        phpinfo();
    }

    public function db_error()
    {
        $query = $this->db->query("SELECT i.id, SUM(i.total) AS total,i.status,i.i_class,c.name,c.picture,i.csd
FROM geopos_invoices AS i LEFT JOIN geopos_customers AS c ON i.csd=c.id GROUP BY  i.csd ORDER BY  i.id  LIMIT 10");
        $error = $this->db->error();
        if (@$error['code']) {
            echo $this->lang->line('errosql1');
            print_r($error);
        } else {
            echo $this->lang->line('errosql2');
        }
        $result = $query->result_array();
    }

    public function switch_location()
    {
        $id = $this->input->get('id', true);
        $data = array(
            'loc' => $id
        );
        $this->db->set($data);
        $this->db->where('id', $this->aauth->get_user()->id);
        $this->db->update('geopos_users');
        redirect(base_url('dashboard'));
    }

    public function billing_settings()
    {
        $this->load->model('plugins_model', 'plugins');
        $this->li_a = 'billing';

        if ($this->input->post()) {
            $stock = $this->input->post('stock', true);
            $serial = $this->input->post('serial', true);
            $expired = $this->input->post('expired', true);
            $this->settings->billing_settings($stock, $serial, $expired);
        } else {
            $data['zero_stock'] = $this->plugins->universal_api(63);
            $data['billing_settings'] = $this->plugins->universal_api(67);
            $head['title'] = $this->lang->line('BillingSettings');
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/billing_settings', $data);
            $this->load->view('fixed/footer');


        }
    }

    /*
        Series for documents
    */

    public function series()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Series';
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/serie_list');
        $this->load->view('fixed/footer');
    }

    public function serie()
    {
        if ($this->input->post()) {
            $this->load->library("form_validation");
            $rules = array(
                array(
                    'field' => 'serie',
                    'label' => 'Nome da Série',
                    'rules' => 'required',
                    'errors' => array('required' => 'Por favor Insira um %s.')
                ),
                array(
                    'field' => 'cae',
                    'label' => 'C.A.E',
                    'rules' => 'required',
                    'errors' => array('required' => 'Por favor Selecione pelo menos um %s.')
                ),
                array(
                    'field' => 'startdate',
                    'label' => 'Data Início',
                    'rules' => 'required',
                    'errors' => array('required' => 'Por favor insira uma %s.')
                ),
                array(
                    'field' => 'serie_class',
                    'label' => $this->lang->line('Class Ativ'),
                    'rules' => 'required',
                    'errors' => array('required' => 'Por favor selecione uma %s.')
                ),
                array(
                    'field' => 'serie_wareh',
                    'label' => 'Localização',
                    'rules' => 'required',
                    'errors' => array('required' => 'Por favor selecione uma %s.')
                ),
                array(
                    'field' => 'serie_type_com',
                    'label' => $this->lang->line('Type Com'),
                    'rules' => 'required',
                    'errors' => array('required' => 'Por favor selecione um %s.')
                )
            );

            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run()) {
                $serie = $this->input->post('serie', true);
                $cae = $this->input->post('cae');
                $startdate = datefordatabase($this->input->post('startdate'));
                $enddate = datefordatabase($this->input->post('enddate'));
                $exclued = $this->input->post('exclued');
                $serie_class = $this->input->post('serie_class');
                $serie_wareh = $this->input->post('serie_wareh');
                $serie_pred = $this->input->post('serie_pred');
                $serie_type_com = $this->input->post('serie_type_com');
                $serie_iva_caixa = $this->input->post('serie_iva_caixa');

                if ($this->settings->addserie($serie, $cae, $startdate, $enddate, $exclued, $serie_class, $serie_wareh, $serie_pred, $serie_type_com, $serie_iva_caixa)) {
                    $seriid = $this->db->insert_id();
                    $typs_id = $this->input->post('pid');
                    $start_doc = $this->input->post('start_doc', true);
                    $typslist = array();
                    $prodindex = 0;
                    foreach ($typs_id as $key => $value) {
                        $data = array(
                            'serie' => $seriid,
                            'typ_doc' => $typs_id[$key],
                            'start' => $start_doc[$key]);
                        $typslist[$prodindex] = $data;
                        $prodindex++;
                    }
                    $this->db->insert_batch('geopos_series_ini_typs', $typslist);
                    echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='serie' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='series' class='btn btn-grey btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
                } else {
                    echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
                }
            } else {
                echo json_encode(array('status' => 'Dados de Formulário', 'message' => $this->form_validation->error_string()));
            }
        } else {
            $this->load->library("Common");
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['caes'] = $this->settings->scaescombo();
            $data['docs_ini'] = $this->common->default_typ_doc_list_ini();
            $data['classes'] = $this->common->get_all_class();
            $data['localizacoes'] = $this->common->get_all_Localizacoes();

            $head['title'] = 'New Serie';
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/serie', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function sre_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->settings->serie_datatables($cid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $obj) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->serie;
            $row[] = $obj->cae_name;
            $row[] = $obj->namecla;
            $row[] = $obj->nameloc;
            $row[] = dateformat($obj->startdate);
            if ($obj->enddate == null) {
                $row[] = "Sem Data Fim";
            } else {
                $row[] = dateformat($obj->enddate);
            }
            $row[] = "<div class='action-btn'><a href='" . base_url("settings/edserie?id=$obj->id") . "' class='btn btn-outline-primary btn-sm' title='" . $this->lang->line('Edit') . "'><i class='bi bi-pencil'></i> </a> " . '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-outline-danger btn-sm delete-object" title=' . $this->lang->line('Delete') . '><span class="bi bi-trash"></span></a></div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->settings->serie_count_all($cid),
            "recordsFiltered" => $this->settings->serie_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete_serie()
    {
        if (!$this->aauth->premission(11)) {
            exit($this->lang->line('translate19'));
        }
        $this->aauth->applog("[Delete] Serie-$id" . $id, $this->aauth->get_user()->username);

        $id = $this->input->post('deleteid');
        $data = array(
            'status' => 1
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_series', $data)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


    public function edserie()
    {
        if ($this->input->post()) {
            $id = $this->input->post('did');

            $serie = $this->input->post('serie', true);
            $cae = $this->input->post('cae');
            $startdate = datefordatabase($this->input->post('startdate'));
            $enddate = null;
            if ($this->input->post('enddate') != '') {
                $enddate = datefordatabase($this->input->post('enddate'));
            }
            $exclued = $this->input->post('exclued');
            $serie_class = $this->input->post('serie_class');
            $serie_wareh = $this->input->post('serie_wareh');
            $serie_pred = $this->input->post('serie_pred');
            $serie_iva_caixa = $this->input->post('serie_iva_caixa');
            $serie_type_com = $this->input->post('serie_type_com');
            if ($this->settings->edithserie($id, $serie, $cae, $startdate, $enddate, $exclued, $serie_class, $serie_wareh, $serie_pred, $serie_type_com, $serie_iva_caixa)) {
                $this->db->delete('geopos_series_ini_typs', array('serie' => $id));
                $typs_id = $this->input->post('pid');
                $start_doc = $this->input->post('start_doc', true);
                $typslist = array();
                $prodindex = 0;
                foreach ($typs_id as $key => $value) {
                    $data = array(
                        'serie' => $id,
                        'typ_doc' => $typs_id[$key],
                        'start' => $start_doc[$key]);
                    $typslist[$prodindex] = $data;
                    $prodindex++;
                }

                $this->db->insert_batch('geopos_series_ini_typs', $typslist);
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . "  <a href='serie' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='series' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $this->load->library("Common");
            $data['id'] = $this->input->get('id');
            $data['serie'] = $this->settings->serie_view($data['id']);
            $data['docs_ini'] = $this->common->default_typ_doc_list($data['id']);
            $data['classes'] = $this->common->get_all_class();
            $data['localizacoes'] = $this->common->get_all_Localizacoes();
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['caes'] = $this->settings->scaescombo();
            $head['title'] = 'Edit Serie';
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/editserie', $data);
            $this->load->view('fixed/footer');
        }
    }

    /*
        Countrys
    */

    public function countrys()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Countrys';
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/country_list');
        $this->load->view('fixed/footer');
    }

    public function country()
    {
        if ($this->input->post()) {
            $name = $this->input->post('name', true);
            $prefix = $this->input->post('prefix', true);
            $cultur = $this->input->post('culturs', true);
            $indicat = $this->input->post('indicat');
            $memberue = $this->input->post('memberue');

            if ($this->settings->addcountry($name, $prefix, $cultur, $indicat, $memberue)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='country' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='countrys' class='btn btn-grey btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['culturs'] = $this->settings->list_culturs();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'New Country';
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/country', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function terms_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->settings->terms_datatables($cid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $obj) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->title;
            $row[] = $obj->nameterm;
            $row[] = "<div class='action-btn'><a href='" . base_url("settings/edit_term?id=$obj->id") . "' class='btn btn-outline-primary btn-sm' title='" . $this->lang->line('Edit') . "'><i class='bi bi-pencil'></i> </a> " . '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-outline-danger btn-sm 
delete-object" title=' . $this->lang->line('Delete') . '><span class="bi bi-trash"></span></a></div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->settings->terms_count_all($cid),
            "recordsFiltered" => $this->settings->terms_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function ctr_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->settings->country_datatables($cid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $obj) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->name;
            $row[] = $obj->prefix;
            $row[] = $obj->indicat;
            $row[] = "<div class='action-btn'> <a href='" . base_url("settings/edcountry?id=$obj->id") . "' class='btn btn-outline-primary btn-sm' title='" . $this->lang->line('Edit') . "'><i class='bi bi-pencil'></i> </a> " . '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-outline-danger btn-sm delete-object" title=' . $this->lang->line('Delete') . '><span class="bi bi-trash"></span></a></div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->settings->country_count_all($cid),
            "recordsFiltered" => $this->settings->country_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete_country()
    {
        if (!$this->aauth->premission(11)) {
            exit($this->lang->line('translate19'));
        }

        $id = $this->input->post('deleteid');

        if ($this->settings->deletecountry($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }

    }


    public function edcountry()
    {
        if ($this->input->post()) {
            $id = $this->input->post('did');
            $name = $this->input->post('name', true);
            $prefix = $this->input->post('prefix', true);
            $cultur = $this->input->post('culturs', true);
            $indicat = $this->input->post('indicat');
            $memberue = $this->input->post('memberue');

            if ($this->settings->edithcountry($id, $name, $prefix, $cultur, $indicat, $memberue)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . "  <a href='country' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='countrys' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $data['country'] = $this->settings->country_view($data['id']);
            $data['culturs'] = $this->settings->list_culturs();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Country';
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/editcountry', $data);
            $this->load->view('fixed/footer');
        }
    }


    /*
        Culturs
    */

    public function culturs()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Culturs';
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/cultur_list');
        $this->load->view('fixed/footer');
    }

    public function cultur()
    {
        if ($this->input->post()) {
            $name = $this->input->post('name', true);
            $prefix = $this->input->post('prefix', true);
            if ($this->settings->addcultur($name, $prefix)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='cultur' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='culturs' class='btn btn-grey btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'New Cultur';
            $this->load->view('fixed/header', $head);
//            $this->load->view('settings/cultur', $data);
            $this->load->view('settings/cultur');
            $this->load->view('fixed/footer');
        }
    }


    public function cltu_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->settings->cultur_datatables($cid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $obj) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->name;
            $row[] = $obj->prefix;
            $row[] = "<div class='action-btn'><a href='" . base_url("settings/edcultur?id=$obj->id") . "' class='btn btn-outline-primary btn-sm' title='" . $this->lang->line('Edit') . "'><i class='bi bi-pencil'></i> </a> " . '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-outline-danger btn-sm delete-object" title=' . $this->lang->line('Delete') . '><span class="bi bi-trash"></span></a></div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->settings->cultur_count_all($cid),
            "recordsFiltered" => $this->settings->cultur_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete_cultur()
    {
        if (!$this->aauth->premission(11)) {
            exit($this->lang->line('translate19'));
        }

        $id = $this->input->post('deleteid');

        if ($this->settings->deletecultur($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }

    }


    public function edcultur()
    {
        if ($this->input->post()) {
            $id = $this->input->post('did');
            $name = $this->input->post('name', true);
            $prefix = $this->input->post('prefix', true);

            if ($this->settings->edithcultur($id, $name, $prefix)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . "  <a href='cultur' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='culturs' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $data['cultur'] = $this->settings->cultur_view($data['id']);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Cultur';
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/editcultur', $data);
            $this->load->view('fixed/footer');
        }
    }

    /*
        Type Documents TAX
    */

    public function irs_typ_docs()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Types Docs Tax';
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/irs_typ_doc_list');
        $this->load->view('fixed/footer');
    }

    public function irs_typ_doc()
    {
        if ($this->input->post()) {
            $type = $this->input->post('type', true);
            $description = $this->input->post('description', true);
            $used = $this->input->post('used', true);
            if ($this->settings->addirs_typ_doc($type, $description, $used)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='irs_typ_doc' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='irs_typ_docs' class='btn btn-grey btn-lg'><span class='fa fa-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'New Type Doc Tax';
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/irs_typ_doc', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function sirs_typ_doc_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->settings->irs_typ_doc_datatables($cid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $obj) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->type;
            $row[] = $obj->description;
            $row[] = $obj->nameused;
            $row[] = "<div class='action-btn'><a href='" . base_url("settings/edirs_typ_doc?id=$obj->id") . "' class='btn btn-outline-primary btn-sm' title='" . $this->lang->line('Edit') . "'><i class='bi bi-pencil'></i></a></div>";
            //$row[] = "<a href='" . base_url("settings/edirs_typ_doc?id=$obj->id") . "' class='btn btn-blue'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a> " . '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-danger delete-object"><span class="fa fa-trash"></span></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->settings->irs_typ_doc_count_all($cid),
            "recordsFiltered" => $this->settings->irs_typ_doc_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete_irs_typ_doc()
    {
        if (!$this->aauth->premission(11)) {
            exit($this->lang->line('translate19'));
        }

        $id = $this->input->post('deleteid');

        if ($this->settings->deleteirs_typ_doc($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }

    }


    public function edirs_typ_doc()
    {
        if ($this->input->post()) {
            $id = $this->input->post('did');
            $type = $this->input->post('type', true);
            $description = $this->input->post('description', true);
            $used = $this->input->post('used', true);

            if ($this->settings->edithirs_typ_doc($id, $type, $description, $used)) {
                $this->db->delete('geopos_invoice_items', array('irs_type' => $id));

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . "  <a href='irs_typ_doc' class='btn btn-blue btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a> <a href='irs_typ_docs' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $data['irs_typ_doc'] = $this->settings->irs_typ_doc_view($data['id']);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Type Doc Tax';
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/editirs_typ_doc', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function search_copys()
    {
        $out = array();
        $result = $this->settings->list_numcopys();
        foreach ($result as $row) {
            $name = array($row['val1'], $row['id']);
            array_push($out, $name);
        }
        echo json_encode($out);
    }

    public function search_wareh()
    {
        $out = array();
        $result = $this->invocies->warehouses();
        foreach ($result as $row) {
            $name = array($row['title'], $row['id']);
            array_push($out, $name);
        }
        echo json_encode($out);
    }

    public function search_activi()
    {
        $out = array();
        $result = $this->products->proclasses();
        foreach ($result as $row) {
            $name = array($row['title'], $row['id']);
            array_push($out, $name);
        }
        echo json_encode($out);
    }

    public function search_series()
    {
        $out = array();
        $result = $this->settings->list_series();
        foreach ($result as $row) {
            $name = array($row['cae_name'], $row['id']);
            array_push($out, $name);
        }
        echo json_encode($out);
    }


    public function search_tax()
    {
        $out = array();
        $result = $this->settings->slabs();
        foreach ($result as $row) {
            $name = array($row['val1'], $row['taxcode'], $row['val2'], $row['id']);
            array_push($out, $name);
        }
        echo json_encode($out);
    }
}