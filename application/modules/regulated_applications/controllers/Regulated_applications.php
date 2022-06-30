<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . "libraries/pusher/vendor/autoload.php";

class Regulated_applications extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'date', 'download'));
        $this->load->library(array('session', 'form_validation', 'upload', 'phpmailer_library'));
        $this->load->module('users');
        $this->load->model('Regulated_applications_model');
    }

    public function clear_apost()
    {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = str_replace("'", "&apos;", $value);
        }
    }

    public function index()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $data['external_page'] = 0;
        $data['active_page'] = "regulated_applications";
        $data['active_url'] = "regulated_applications";
        $data['page_view'] = 'regulated_applications/regulated_applications_v';

        $data['user_id'] = $this->session->userdata('user_id');

        $q_user_details = $this->Regulated_applications_model->fetch_users_by_id($data['user_id']);
        $user_details = $q_user_details->row();

        if ($user_details->user_level == 1 || $user_details->user_level == 2) {
            $q_all_regulated_applications = $this->Regulated_applications_model->fetch_all_regulated_applications();
            $data['regulated_applications'] = $q_all_regulated_applications->result();
        } else {
            $q_all_regulated_applications = $this->Regulated_applications_model->fetch_all_regulated_applications_by_assigned_admin_id($data['user_id']);
            $data['regulated_applications'] = $q_all_regulated_applications->result();
        }

        $q_all_admins = $this->Regulated_applications_model->fetch_all_admins();
        $data['admins'] = $q_all_admins->result();

        $q_all_admins_no_super = $this->Regulated_applications_model->fetch_all_admins_no_super();
        $data['admins_no_super'] = $q_all_admins_no_super->result();

        $this->load->view('page', $data);
    }

    public function upload_lab_test()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $data['external_page'] = 0;
        $data['active_page'] = "regulated_applications";
        $data['active_url'] = "regulated_applications";
        $data['page_view'] = 'regulated_applications/upload_lab_test';

        $data['regulated_application_id'] = $this->uri->segment(3);

        $upload_path_file = 'uploads/regulated_applications/' . $data['regulated_application_id'];
        if (isset($_POST['upload_lab_test_files'])) {
            // var_dump($_POST['upload_num_id']);
            $upload_num_arr = explode(',', $_POST['upload_num_id']);
            if (!file_exists($upload_path_file)) {
                mkdir($upload_path_file, 0777, true);
            }

            $upload_path_file = $upload_path_file . '/lab_testing';
            if (!file_exists($upload_path_file)) {
                mkdir($upload_path_file, 0777, true);
            }
            $cntupload = 0;
            $created_by = $this->session->userdata('user_id');
            $created_at = date('Y-m-d H:i:s');
            foreach ($upload_num_arr as $key => $value) {
                # code...
                // echo $value . "<br>";
                $cntupload++;
                sleep(1);
                $current_timestamp = now();
                $config['upload_path'] = $upload_path_file;
                $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                $config['max_size'] = 5000000;
                $config['file_name'] = 'lab_testing_' . $data['regulated_application_id'] . '_' . $current_timestamp;

                $this->upload->initialize($config);
                if (!$this->upload->do_upload('con_file_' . $value)) {
                    $errors = $this->upload->display_errors();
                    $this->load->view('page', $data);
                } else {
                    $result = $this->Regulated_applications_model->insert_lab_testing_details($config['file_name'] . $this->upload->data('file_ext'), $data['regulated_application_id'], $created_by, $created_at);
                    if ($cntupload == count($upload_num_arr)) {
                        $this->session->set_flashdata('success', 'Congratulations! Successfully uploaded Product Lab Test Results.');
                        redirect('regulated-applications/upload-lab-test/' . $data['regulated_application_id'], 'refresh');
                    }
                }
            }
        } else {
            $this->load->view('page', $data);
        }
    }

    public function update_assigned_admin()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $regulated_application_id = $this->input->post('regulated_application_id');
        $assigned_admin_id = $this->input->post('assigned_admin_id');
        $assignor = $this->input->post('assignor');
        $updated_by = $this->session->userdata('user_id');
        $updated_at = date('Y-m-d H:i:s');

        $result = $this->Regulated_applications_model->update_assigned_admin($regulated_application_id, $assigned_admin_id, $updated_by, $updated_at);

        if ($result == 1) {

            $q_regulated_application_details = $this->Regulated_applications_model->fetch_regulated_application($regulated_application_id);
            $regulated_application = $q_regulated_application_details->row();

            $q_user_details = $this->Regulated_applications_model->fetch_users_by_id($assigned_admin_id);
            $user_details = $q_user_details->row();

            $q_user_details2 = $this->Regulated_applications_model->fetch_users_by_id($assignor);
            $user_details2 = $q_user_details2->row();

            $subject = 'Assigned Regulated Application';
            $template = 'email/assigned_admin.php';
            $this->send_mail4($user_details->email, $template, $subject, $user_details2->contact_person, $user_details->contact_person, $regulated_application->regulated_application_id, $regulated_application->user_company_name);

            echo $result;
        }
    }

    public function tracking_details()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $this->clear_apost();

        $appid = $this->uri->segment(3);
        $data['external_page'] = 0;
        $data['active_page'] = "regulated_applications";
        $data['active_url'] = "regulated_applications";
        $data['page_view'] = 'regulated_applications/tracking_details';

        $data['regulated_application_id'] = $this->uri->segment(3);
        $data['user_id'] = $this->session->userdata('user_id');

        $q_user_details = $this->Regulated_applications_model->fetch_users_by_id($data['user_id']);
        $data['user_details'] = $q_user_details->row();

        $q_regulated_application_details = $this->Regulated_applications_model->fetch_regulated_application($data['regulated_application_id']);
        $data['regulated_application'] = $q_regulated_application_details->row();

        $q_all_regulated_status_a = $this->Regulated_applications_model->fetch_regulated_track_status_a($data['regulated_application_id']);
        $data['regulated_status_list'] = $q_all_regulated_status_a->result();

        /** GET regulated_status_a  */
        $q_regulated_status_a = $this->Regulated_applications_model->fetch_regulated_status_a($data['regulated_application_id']);
        $data['regulated_status_a'] = $q_regulated_status_a->result();

        $data['reg_products_revisions_cnt'] = $this->Regulated_applications_model->reg_products_revisions_count($appid);
        $data['reg_products_declined_cnt'] = $this->Regulated_applications_model->reg_products_declined_count($appid);

        $q_fetch_reg_products = $this->Regulated_applications_model->fetch_regulated_products_revisions($data['regulated_application_id']);
        $data['reg_products_revisions'] = $q_fetch_reg_products->result();

        if (isset($_POST['send_notification'])) {
            $user_id = stripslashes($this->input->post('user_id'));
            $regulated_application_id = stripslashes($this->input->post('regulated_application_id'));
            $tracking_status = stripslashes($this->input->post('tracking_status'));
            $remarks = stripslashes($this->input->post('remarks'));
            $date = date('Y-m-d');
            $updated_by = $this->session->userdata('user_id');
            $updated_at = date('Y-m-d H:i:s');
            $stepcount = $this->input->post('stepcount');
            $new_tracking_id = $this->Regulated_applications_model->update_regulated_application_status($data['regulated_application']->product_category_id, $regulated_application_id, $tracking_status, $stepcount, $date, $updated_at, $updated_by);
            $this->Regulated_applications_model->update_regulated_application_remarks($regulated_application_id, $remarks, $tracking_status, $updated_at);

            if (!empty($new_tracking_id)) {
                $q_regulated_application_details = $this->Regulated_applications_model->fetch_regulated_application($data['regulated_application_id']);
                $reg_application = $q_regulated_application_details->row();

                $subject = 'Regulated Application Status';
                $template = 'email/tracking_status_email.php';
               $this->send_mail($subject, $template, $data['regulated_application']->tracking_status_name, $reg_application->tracking_status_name, $data['regulated_application']->user_contact_person, $remarks, $data['regulated_application']->user_email);
            } else {

                $q_regulated_application_details = $this->Regulated_applications_model->fetch_regulated_application($data['regulated_application_id']);
                $reg_application = $q_regulated_application_details->row();

                $subject = 'Regulated Application Status';
                $template = 'email/tracking_status_email.php';
                $this->send_mail($subject, $template, $reg_application->tracking_status_name, '', $data['regulated_application']->user_contact_person, $remarks, $data['regulated_application']->user_email);
            }

            // $options = array(
            //     'cluster' => 'ap1',
            //     'useTLS' => true
            // );
            // $pusher = new Pusher\Pusher(
            //     'd9fa3c2060a75841885a',
            //     'cffa0be668632feb20d2',
            //     '1195507',
            //     $options
            // );

            // $remark['message'] = "New Tracking Status";
            // $remark['id'] = $regulated_application_id;
            // $pusher->trigger('my-channel', 'my-event' . $user_id, $remark);

            $this->session->set_flashdata('success', 'Successfully set the stage to completed!');
            redirect('regulated-applications/tracking-details/' . $regulated_application_id, 'refresh');
        }
        if (isset($_POST['confirm_status'])) {
            $id = stripslashes($this->input->post('regulated_application_id'));
            $tracking_status = stripslashes($this->input->post('tracking_status_a'));
            $stepcount = stripslashes($this->input->post('stepcount'));
            $date = date('Y-m-d');
            $updated_at = date('Y-m-d H:i:s');
            $updated_by = $this->session->userdata('user_id');
            $this->Regulated_applications_model->insert_confirm_status($id, $tracking_status, $stepcount, $date, $updated_at, $updated_by);
            redirect('regulated-applications/tracking-details/' . $id, 'refresh');
        }
        if (isset($_POST['cance_status'])) {
            $id = stripslashes($this->input->post('regulated_application_id'));
            $tracking_status = stripslashes($this->input->post('tracking_status'));
            $this->Regulated_applications_model->cancel_tracking_status($id, $tracking_status);
            $this->session->set_flashdata('cancelled', 'Successfully set the stage to cancel!');
            redirect('regulated-applications/tracking-details/' . $id, 'refresh');
        };

        $this->load->view('page', $data);
    }

    public function view_product_labels()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $this->clear_apost();

        $data['external_page'] = 0;
        $data['active_page'] = "regulated_applications";
        $data['active_url'] = "regulated_applications";
        $data['page_view'] = 'regulated_applications/edit_regulated_products';

        $data['regulated_product_id'] = $this->uri->segment(3);
        $data['user_id'] = $this->session->userdata('user_id');

        $q_user_details = $this->Regulated_applications_model->fetch_users_by_id($data['user_id']);
        $data['user_details'] = $q_user_details->row();

        $q_fetch_reg_product_by_id = $this->Regulated_applications_model->fetch_reg_product_by_id($data['regulated_product_id']);
        $data['reg_product'] = $q_fetch_reg_product_by_id->row();

        $data['page_view'] = 'regulated_applications/view_product_labels';
        $this->load->view('page', $data);
    }

    public function upload_product_labels()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $data['external_page'] = 0;
        $data['active_page'] = "regulated_applications";
        $data['active_url'] = "regulated_applications";
        $data['page_view'] = 'regulated_applications/upload_product_labels';

        $data['regulated_application_id'] = $this->uri->segment(3);
        $data['user_id'] = $this->session->userdata('user_id');

        $q_user_details = $this->Regulated_applications_model->fetch_users_by_id($data['user_id']);
        $data['user_details'] = $q_user_details->row();

        $q_fetch_reg_application = $this->Regulated_applications_model->fetch_reg_application($data['regulated_application_id']);
        $data['reg_application'] = $q_fetch_reg_application->row();

        $q_fetch_reg_products = $this->Regulated_applications_model->fetch_approved_regulated_products($data['regulated_application_id']);
        $data['reg_products'] = $q_fetch_reg_products->result();

        $current_timestamp = now();
        $upload_path_file = 'uploads/product_labels/' . $data['reg_application']->created_by;

        if (isset($_POST['upload_product_label'])) {
            if (!file_exists($upload_path_file)) {
                mkdir($upload_path_file, 0777, true);
            }

            $config['upload_path'] = $upload_path_file;
            $config['allowed_types'] = 'pdf|jpg|jpeg|png';
            $config['max_size'] = 5000000;
            $config['file_name'] = 'product_label_' . $current_timestamp;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('product_label')) {
                $data['errors'] = 2;
                $data['error_msgs'] = $this->upload->display_errors();
                $data['page_view'] = 'regulated_applications/upload_product_labels';
                $this->load->view('page', $data);
            } else {
                $product_label_filename = $config['file_name'] . $this->upload->data('file_ext');
                $created_by = $this->session->userdata('user_id');
                $created_at = date('Y-m-d H:i:s');

                $result = $this->Regulated_applications_model->insert_product_label($_POST['regulated_product_id'], $config['file_name'] . $this->upload->data('file_ext'), $created_by, $created_at);

                if ($result == 1) {
                    $this->session->set_flashdata('success', 'Successfully added product label!');
                    redirect('/regulated_applications/upload_product_labels/' . $data['regulated_application_id'], 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Sorry for the inconvenience! Some errors found. Please contact our administrator through livechat or email.');
                    redirect('/regulated_applications/upload_product_labels/' . $data['regulated_application_id'], 'refresh');
                }
            }
        } else if (isset($_POST['remove_product_label'])) {
            $updated_at = date('Y-m-d H:i:s');
            $regulated_product_id = stripslashes($this->input->post('regulated_product_id'));
            $updated_by = $this->session->userdata('user_id');

            $result = $this->Regulated_applications_model->remove_product_label($regulated_product_id, $updated_at, $updated_by);
            if ($result == 1) {
                $this->session->set_flashdata('success', 'Successfully added product label!');
                redirect('/regulated_applications/upload_product_labels/' . $data['regulated_application_id'], 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Sorry for the inconvenience! Some errors found. Please contact our administrator through livechat or email.');
                redirect('/regulated_applications/upload_product_labels/' . $data['regulated_application_id'], 'refresh');
            }
        } else if (isset($_POST['download_ingredients_formula'])) {

            $q_fetch_reg_product_by_id = $this->Regulated_applications_model->fetch_regulated_product_by_id($_POST['id']);
            $reg_products = $q_fetch_reg_product_by_id->result();

            $file = 'uploads/regulated_applications/' . $reg_products[0]->regulated_application_id . '/' . $reg_products[0]->ingredients_formula;
            try {
                force_download($file, NULL);
            } catch (Exception $e) {
            }
        } else if (isset($_POST['download_lab_result'])) {

            $q_fetch_reg_product_by_id = $this->Regulated_applications_model->fetch_regulated_product_by_id($_POST['id']);
            $reg_products = $q_fetch_reg_product_by_id->result();

            $file = 'uploads/regulated_applications/' . $reg_products[0]->regulated_application_id . '/' . $reg_products[0]->lab_result;
            try {
                force_download($file, NULL);
            } catch (Exception $e) {
            }
        } else if (isset($_POST['download_product_label'])) {

            $q_fetch_reg_product_by_id = $this->Regulated_applications_model->fetch_regulated_product_by_id($_POST['id']);
            $reg_products = $q_fetch_reg_product_by_id->result();

            $phpWord = new \PhpOffice\PhpWord\PhpWord();

            $sectionStyle = array(
                'orientation' => 'landscape'
            );

            // Adding an empty Section to the document...
            $section = $phpWord->addSection($sectionStyle);


            $section->addText(
                $reg_products[0]->product_name,
                array('name' => 'Tahoma', 'size' => 27, 'bold' => true)
            );

            $section->addText(
                '',
                array('name' => 'Tahoma', 'size' => 14)
            );


            $section->addText(
                '',
                array('name' => 'Tahoma', 'size' => 14)
            );

            $table1 = $section->addTable();
            $table1->addRow();

            $table1->addCell(5000)->addText(
                'HS Code',
                array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
            );
            $table1->addCell(5000)->addText(
                'Volume/Weight',
                array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
            );
            $table1->addCell(5000)->addText(
                'Approximately Package Size',
                array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
            );

            $table1->addRow();
            $table1->addCell(5000)->addText(
                $reg_products[0]->sku,
                array('name' => 'Tahoma', 'size' => 12)
            );
            $table1->addCell(5000)->addText(
                $reg_products[0]->volume_weight,
                array('name' => 'Tahoma', 'size' => 12)
            );
            $table1->addCell(5000)->addText(
                $reg_products[0]->approx_size_of_package,
                array('name' => 'Tahoma', 'size' => 12)
            );


            $section->addText(
                '',
                array('name' => 'Tahoma', 'size' => 14)
            );

            $section->addText(
                '',
                array('name' => 'Tahoma', 'size' => 14)
            );

            $table1 = $section->addTable();
            $table1->addRow();

            $table1->addCell(15000)->addText(
                'Product Use And Info',
                array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
            );


            $table1->addRow();
            $table1->addCell(15000)->addText(
                $reg_products[0]->product_use_and_info,
                array('name' => 'Tahoma', 'size' => 12)
            );





            $section->addPageBreak();


            $rows = 1;
            $cols = 2;

            $table = $section->addTable();
            $table->addRow();

            $table->addCell(7000)->addText(
                'Product Image',
                array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
            );
            $table->addCell(1000)->addText(
                ' ',
                array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
            );
            $table->addCell(7000)->addText(
                'Consumer Product Packaging',
                array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
            );

            $table->addRow();

            try {
                $table->addCell(7000)->addImage(
                    'uploads/product_qualification/' . $reg_products[0]->user_id . '/' . $reg_products[0]->product_img,
                    array(
                        'width'         => 340,
                        // 'height'        => 100,
                        'marginTop'     => -1,
                        'marginLeft'    => -1,
                        'wrappingStyle' => 'behind',
                        'size'          => 12
                    )
                );
            } catch (Exception $e) {
            }


            $table->addCell(1000)->addText(
                '',
                array('name' => 'Tahoma', 'size' => 14)
            );
            try {
                $table->addCell(7000)->addImage(
                    'uploads/regulated_applications/' . $reg_products[0]->regulated_application_id . '/' . $reg_products[0]->consumer_product_packaging_img,
                    array(
                        'width'         => 340,
                        // 'height'        => 100,
                        'marginTop'     => -1,
                        'marginLeft'    => -1,
                        'wrappingStyle' => 'behind',
                        'size'          => 12
                    )
                );
            } catch (Exception $e) {
            }



            $section->addPageBreak();

            $table = $section->addTable();
            $table->addRow();

            $table->addCell(7000)->addText(
                'Finished Product Image',
                array('name' => 'Tahoma', 'size' => 14, 'bold' => true)
            );


            $table->addRow();

            try {
                $table->addCell(7000)->addImage(
                    'uploads/regulated_applications/' . $reg_products[0]->regulated_application_id . '/' . $reg_products[0]->finished_product_img,
                    array(
                        'width'         => 340,
                        // 'height'        => 100,
                        'marginTop'     => -1,
                        'marginLeft'    => -1,
                        'wrappingStyle' => 'behind',
                        'size'          => 12
                    )
                );
            } catch (Exception $e) {
            }




            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007', $download = true);
            header("Content-Disposition: attachment; filename=Product label for Product ID - " . $_POST['id'] . ".docx");

            $objWriter->save('php://output');

            // redirect('/regulated_applications/upload_product_labels/' . $data['regulated_application_id'].'/'.$_POST['id'].'/1');


        } else if (isset($_POST['bulk_upload_product_label'])) {
            $output = '';
            $read_error = 0;
            $error_arr = array();
            if ($_FILES['product_label']['name'] != '') {
                $file_name = $_FILES['product_label']['name'];
                $array = explode(".", $file_name);
                $name = $array[0];
                $ext = $array[1];

                if (!is_dir($upload_path_file)) {
                    mkdir($upload_path_file, 0777);
                }
                if ($ext == 'zip')  // CHECK IF FILE EXT IS ZIP FORMAT
                {
                    $path = $upload_path_file . "/";
                    $location = $path . $name;
                    if (move_uploaded_file($_FILES['product_label']['tmp_name'], $location)) {
                        $zip = new ZipArchive;
                        if ($zip->open($location)) {
                            $zip->extractTo($path);
                            $zip->close();
                        }
                        $files = scandir($path);
                        foreach ($files as $file) {

                            $file_ext = explode(".", $file);
                            $file_extension = end($file_ext);
                            $allowed_ext = array('jpg', 'png', 'pdf', 'csv');
                            if (in_array($file_extension, $allowed_ext)) {
                                if ($file_extension == 'csv') { // CHECK IF EXT IS CSV FILE
                                    $row = 1;
                                    if (($handle = fopen($path . $file, "r")) !== FALSE) {
                                        while (($datas = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                            $num = count($datas);

                                            for ($i = 0; $i < $num; $i++) {
                                                # code...
                                                if ($datas[$i] == '') {
                                                    $error_arr_row = array(
                                                        'row' => $row,
                                                        'column' => $i + 1,
                                                        'msg' => 'Data must not null',
                                                    );
                                                    array_push($error_arr, $error_arr_row);
                                                    $read_error++;
                                                }

                                                if ($i == 1) {
                                                    if (!is_file($path . $datas[$i])) {
                                                        $error_arr_row = array(
                                                            'row' => $row,
                                                            'column' => $i + 1,
                                                            'msg' => 'file ' . $datas[$i] . ' does not exist',
                                                        );
                                                        array_push($error_arr, $error_arr_row);
                                                        $read_error++;
                                                    }
                                                }
                                            }

                                            $row++;
                                        }
                                        fclose($handle);
                                    }
                                }
                            }
                        }

                        if ($read_error == 0) {
                            foreach ($files as $file) {

                                $file_ext = explode(".", $file);
                                $file_extension = end($file_ext);
                                $allowed_ext = array('jpg', 'png', 'pdf', 'csv');
                                if (in_array($file_extension, $allowed_ext)) {
                                    if ($file_extension == 'csv') { // CHECK IF EXT IS CSV FILE
                                        if (($handle = fopen($path . $file, "r")) !== FALSE) {
                                            while (($datas = fgetcsv($handle, 1000, ",")) !== FALSE) {

                                                $created_by = $this->session->userdata('user_id');
                                                $created_at = date('Y-m-d H:i:s');




                                                $result = $this->Regulated_applications_model->insert_product_label($datas[0], $datas[1], $created_by, $created_at);
                                            }
                                            fclose($handle);
                                        }
                                        unlink($path . $file);
                                    }
                                }
                            }
                            $this->session->set_flashdata('success', 'Successfully submitted regulated bulk product details!');
                            redirect('/regulated_applications/upload_product_labels/' . $data['regulated_application_id'], 'refresh');
                        } else {
                            $this->session->set_flashdata('error', 'ERROR <br>' . json_encode($error_arr) . '<br>UPLOAD FAILED');
                            redirect('/regulated_applications/upload_product_labels/' . $data['regulated_application_id'], 'refresh');
                        }
                    }
                } else {
                    $this->session->set_flashdata('error', 'File must be a zip format!');
                    redirect('/regulated_applications/upload_product_labels/' . $data['regulated_application_id'], 'refresh');
                }
            }
        } else {
            $this->load->view('page', $data);
        }
    }

    public function regulated_products_list()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $data['external_page'] = 0;
        $data['active_page'] = "regulated_applications";
        $data['active_url'] = "regulated_applications";
        $data['page_view'] = 'regulated_applications/regulated_products_list';

        $data['regulated_application_id'] = $this->uri->segment(3);
        $data['user_id'] = $this->session->userdata('user_id');

        $q_user_details = $this->Regulated_applications_model->fetch_users_by_id($data['user_id']);
        $data['user_details'] = $q_user_details->row();

        $q_regulated_application_details = $this->Regulated_applications_model->fetch_regulated_application($data['regulated_application_id']);
        $data['regulated_application'] = $q_regulated_application_details->row();

        $q_fetch_manufacturer_details = $this->Regulated_applications_model->fetch_manufacturer_details($data['regulated_application_id']);
        $data['manufacturer_details'] = $q_fetch_manufacturer_details->row();

        $q_fetch_reg_application = $this->Regulated_applications_model->fetch_reg_application($data['regulated_application_id']);
        $data['reg_application'] = $q_fetch_reg_application->row();

        $q_fetch_reg_products = $this->Regulated_applications_model->fetch_regulated_products($data['regulated_application_id']);
        $data['reg_products'] = $q_fetch_reg_products->result();

        $q_fetch_countries = $this->Regulated_applications_model->fetch_countries();
        $data['countries'] = $q_fetch_countries->result();
        $data['admin'] = $this->session->userdata('admin');

        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('manufacturer_name', 'Company Name', 'trim|required');
            $this->form_validation->set_rules('manufacturer_address', 'Company Address', 'trim|required');
            $this->form_validation->set_rules('manufacturer_city', 'City', 'trim|required');
            $this->form_validation->set_rules('manufacturer_country', 'Country', 'trim|required');
            $this->form_validation->set_rules('manufacturer_zipcode', 'Zip Code', 'trim|required');
            $this->form_validation->set_rules('manufacturer_contact', 'Company Contact', 'trim|required');
            $current_timestamp = now();

            if ($this->input->post('manuaction') == 'add') {
                if ($data['reg_application']->product_category_id != 4) {
                    if (empty($_FILES['manufacturer_flow_process']['name'])) {
                        $this->form_validation->set_rules('manufacturer_flow_process', 'Manufacturing Flow Process', 'required');
                    }
                }

                if ($this->form_validation->run() == FALSE) {
                    $data['page_view'] = 'regulated_applications/regulated_products_list';
                    $this->load->view('page', $data);
                } else {
                    if (!empty($_FILES['manufacturer_flow_process']['name'])) {
                        $upload_path_file = 'uploads/regulated_applications/' . $data['regulated_application_id'];

                        if (!file_exists($upload_path_file)) {
                            mkdir($upload_path_file, 0777, true);
                        }

                        $config['upload_path'] = $upload_path_file;
                        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                        $config['max_size'] = 5000000;
                        $config['file_name'] = 'manufacturer_flow_process_' . $data['regulated_application_id'] . '_' . $current_timestamp;

                        $this->upload->initialize($config);

                        if (!$this->upload->do_upload('manufacturer_flow_process')) {

                            $data['errors'] = 2;
                            $data['error_msgs'] = $this->upload->display_errors();

                            $this->load->view('page', $data);
                        } else {
                            $manufacturer_name = stripslashes($this->input->post('manufacturer_name'));
                            $manufacturer_address = stripslashes($this->input->post('manufacturer_address'));
                            $manufacturer_city = stripslashes($this->input->post('manufacturer_city'));
                            $manufacturer_country = stripslashes($this->input->post('manufacturer_country'));
                            $manufacturer_zipcode = stripslashes($this->input->post('manufacturer_zipcode'));
                            $manufacturer_contact = stripslashes($this->input->post('manufacturer_contact'));
                            $manufacturer_website = stripslashes($this->input->post('manufacturer_website'));
                            $created_by = $this->session->userdata('user_id');
                            $created_at = date('Y-m-d H:i:s');

                            $result = $this->Regulated_applications_model->insert_manufacturer_details($data['regulated_application_id'], $config['file_name'] . $this->upload->data('file_ext'), $manufacturer_name, $manufacturer_address, $manufacturer_city, $manufacturer_country, $manufacturer_zipcode, $manufacturer_contact, $manufacturer_website, $created_by, $created_at);

                            if ($result == 1) {
                                $this->session->set_flashdata('success', 'Successfully updated manufacturer details!');
                                redirect('/regulated-applications/regulated-products-list/' . $data['regulated_application_id'], 'refresh');
                            } else {
                                $this->session->set_flashdata('error', 'Sorry for the inconvenience! Some errors found. Please contact our administrator through livechat or email.');
                                redirect('/regulated-applications/regulated-products-list/' . $data['regulated_application_id'], 'refresh');
                            }
                        }
                    } else {
                        $manufacturer_name = stripslashes($this->input->post('manufacturer_name'));
                        $manufacturer_address = stripslashes($this->input->post('manufacturer_address'));
                        $manufacturer_city = stripslashes($this->input->post('manufacturer_city'));
                        $manufacturer_country = stripslashes($this->input->post('manufacturer_country'));
                        $manufacturer_zipcode = stripslashes($this->input->post('manufacturer_zipcode'));
                        $manufacturer_contact = stripslashes($this->input->post('manufacturer_contact'));
                        $manufacturer_website = stripslashes($this->input->post('manufacturer_website'));
                        $created_by = $this->session->userdata('user_id');
                        $created_at = date('Y-m-d H:i:s');

                        $result = $this->Regulated_applications_model->insert_manufacturer_details($data['regulated_application_id'], '', $manufacturer_name, $manufacturer_address, $manufacturer_city, $manufacturer_country, $manufacturer_zipcode, $manufacturer_contact, $manufacturer_website, $created_by, $created_at);

                        if ($result == 1) {
                            $this->session->set_flashdata('success', 'Successfully updated manufacturer details!');
                            redirect('/regulated-applications/regulated-products-list/' . $data['regulated_application_id'], 'refresh');
                        } else {
                            $this->session->set_flashdata('error', 'Sorry for the inconvenience! Some errors found. Please contact our administrator through livechat or email.');
                            redirect('/regulated-applications/regulated-products-list/' . $data['regulated_application_id'], 'refresh');
                        }
                    }
                }
            } else {
                $upload_path_file = 'uploads/regulated_applications/' . $data['regulated_application_id'];
                if ($this->form_validation->run() == FALSE) {
                    $data['page_view'] = 'regulated_applications/regulated-products-list';
                    $this->load->view('page', $data);
                } else {
                    if (!empty($_FILES['manufacturer_flow_process']['name'])) {

                        $config1['upload_path'] = $upload_path_file;
                        $config1['allowed_types'] = 'pdf|jpg|jpeg|png';
                        $config1['max_size'] = 5000000;
                        $config1['file_name'] = 'manufacturer_flow_process_' . $data['regulated_application_id'] . '_' . $current_timestamp;
                        $this->upload->initialize($config1);
                        if (!$this->upload->do_upload('manufacturer_flow_process')) {
                            $data['errors'] = 2;
                            $data['error_msgs'] = $this->upload->display_errors();
                            $data['page_view'] = 'regulated_applications/regulated-products-list';
                            $this->load->view('page', $data);
                        } else {
                            $manufacturer_flow_process_filename = $config1['file_name'] . $this->upload->data('file_ext');
                        }
                    } else {
                        $manufacturer_flow_process_filename = '';
                    }

                    $manufacturer_name = stripslashes($this->input->post('manufacturer_name'));
                    $manufacturer_address = stripslashes($this->input->post('manufacturer_address'));
                    $manufacturer_city = stripslashes($this->input->post('manufacturer_city'));
                    $manufacturer_country = stripslashes($this->input->post('manufacturer_country'));
                    $manufacturer_zipcode = stripslashes($this->input->post('manufacturer_zipcode'));
                    $manufacturer_contact = stripslashes($this->input->post('manufacturer_contact'));
                    $manufacturer_website = stripslashes($this->input->post('manufacturer_website'));

                    $created_by = $this->session->userdata('user_id');
                    $created_at = date('Y-m-d H:i:s');

                    $result = $this->Regulated_applications_model->update_manufacturer_details($data['regulated_application_id'], $manufacturer_flow_process_filename, $manufacturer_name, $manufacturer_address, $manufacturer_city, $manufacturer_country, $manufacturer_zipcode, $manufacturer_contact, $manufacturer_website, $created_by, $created_at);

                    if ($result == 1) {
                        $this->session->set_flashdata('success', 'Successfully updated manufacturer details!');
                        redirect('/regulated-applications/regulated-products-list/' . $data['regulated_application_id'], 'refresh');
                    } else {
                        $this->session->set_flashdata('error', 'Sorry for the inconvenience! Some errors found or no data to be changed. Please contact our administrator through livechat or email.');
                        redirect('/regulated-applications/regulated-products-list/' . $data['regulated_application_id'], 'refresh');
                    }
                }
            }
        } else {
            $this->load->view('page', $data);
        }
    }

    public function product_sampling()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $id = $this->input->post('id');

        $q_fetch_regulated_products_sampling = $this->Regulated_applications_model->fetch_regulated_products_sampling($id);
        $data['reg_product_sampling'] = $q_fetch_regulated_products_sampling->result();

        $product_sampling_data = '';

        if ($q_fetch_regulated_products_sampling->num_rows() > 0) {
            foreach ($data['reg_product_sampling'] as $reg_product_sampling) {
                $product_sampling_data .= '<ul>';
                $product_sampling_data .=  '<li>Product Sampling Invoice ID - '.$reg_product_sampling->shipping_invoice_id.'</li>';
                $product_sampling_data .= '</ul>';
            }

            echo $product_sampling_data;
        } else {
            echo '<h5 class="text-danger">Product Sample is not yet sent!</h5>';
        }
    }

    public function delete_regulated_product()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $id = $this->input->post('id');
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = $this->session->userdata('user_id');

        $result = $this->Regulated_applications_model->delete_regulated_product($id, $updated_at, $updated_by);

        if ($result == 1) {
            echo $result;
        }
    }

    public function edit_regulated_products()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $this->clear_apost();

        $data['external_page'] = 0;
        $data['active_page'] = "regulated_applications";
        $data['active_url'] = "regulated_applications";
        $data['page_view'] = 'regulated_applications/edit_regulated_products';

        $data['regulated_product_id'] = $this->uri->segment(3);
        $data['user_id'] = $this->session->userdata('user_id');

        $q_user_details = $this->Regulated_applications_model->fetch_users_by_id($data['user_id']);
        $data['user_details'] = $q_user_details->row();

        $q_fetch_reg_product_by_id = $this->Regulated_applications_model->fetch_reg_product_by_id($data['regulated_product_id']);
        $data['reg_product'] = $q_fetch_reg_product_by_id->row();

        $q_fetch_reg_product_cust_by_id = $this->Regulated_applications_model->fetch_reg_product_cust_by_id($data['reg_product']->id);
        $data['reg_product_cust'] = $q_fetch_reg_product_cust_by_id->result();

        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('sku', 'HS Code', 'trim|required');
            $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
            $this->form_validation->set_rules('product_use_and_info', 'Product Use and Information', 'trim|required');
            $this->form_validation->set_rules('volume_weight', 'Volume/Weight', 'trim|required');
            // $this->form_validation->set_rules('approx_size_of_package', 'Approximately Size of Package', 'trim|required');
            $regulated_application_id = stripslashes($this->input->post('regulated_application_id'));

            if ($this->form_validation->run() == FALSE) {
                $data['page_view'] = 'regulated_applications/edit_regulated_products';
                $this->load->view('page', $data);
            } else {
                $current_timestamp = now();
                $upload_path_file1 = 'uploads/product_qualification/' . $data['reg_product']->user_id;
                $upload_path_file2 = 'uploads/regulated_applications/' . $regulated_application_id;
                if (!empty($_FILES['product_img']['name'])) {

                    $config1['upload_path'] = $upload_path_file1;
                    $config1['allowed_types'] = 'pdf|jpg|jpeg|png';
                    $config1['max_size'] = 5000000;
                    $config1['file_name'] = 'product_qualification_' . $current_timestamp;
                    $this->upload->initialize($config1);
                    if (!$this->upload->do_upload('product_img')) {
                        $data['errors'] = 2;
                        $data['error_msgs'] = $this->upload->display_errors();
                        $data['page_view'] = 'regulated_applications/edit_regulated_products';
                        $this->load->view('page', $data);
                    } else {
                        $product_img_filename = $config1['file_name'] . $this->upload->data('file_ext');
                    }
                } else {
                    $product_img_filename = '';
                }

                if (!empty($_FILES['ingredients_formula']['name'])) {
                    $config2['upload_path'] = $upload_path_file2;
                    $config2['allowed_types'] = 'pdf|jpg|jpeg|png';
                    $config2['max_size'] = 5000000;
                    $config2['file_name'] = 'ingredients_formula_' . $current_timestamp;
                    $this->upload->initialize($config2);
                    if (!$this->upload->do_upload('ingredients_formula')) {
                        $data['errors'] = 2;
                        $data['error_msgs'] = $this->upload->display_errors();
                        $data['page_view'] = 'regulated_applications/edit_regulated_products';
                        $this->load->view('page', $data);
                    } else {
                        $ingredients_formula_filename = $config2['file_name'] . $this->upload->data('file_ext');
                    }
                } else {
                    $ingredients_formula_filename = '';
                }

                if (!empty($_FILES['consumer_product_packaging_img']['name'])) {
                    $config4['upload_path'] = $upload_path_file2;
                    $config4['allowed_types'] = 'pdf|jpg|jpeg|png';
                    $config4['max_size'] = 5000000;
                    $config4['file_name'] = 'consumer_product_packaging_img_' . $current_timestamp;
                    $this->upload->initialize($config4);
                    if (!$this->upload->do_upload('consumer_product_packaging_img')) {
                        $data['errors'] = 2;
                        $data['error_msgs'] = $this->upload->display_errors();
                        $data['page_view'] = 'regulated_applications/edit_regulated_products';
                        $this->load->view('page', $data);
                    } else {
                        $consumer_product_packaging_img_filename = $config4['file_name'] . $this->upload->data('file_ext');
                    }
                } else {
                    $consumer_product_packaging_img_filename = '';
                }

                if (!empty($_FILES['outerbox_frontside']['name'])) {
                    $config4['upload_path'] = $upload_path_file2;
                    $config4['allowed_types'] = 'pdf|jpg|jpeg|png';
                    $config4['max_size'] = 5000000;
                    $config4['file_name'] = 'outerbox_frontside_' . $current_timestamp;
                    $this->upload->initialize($config4);
                    if (!$this->upload->do_upload('outerbox_frontside')) {
                        $data['errors'] = 2;
                        $data['error_msgs'] = $this->upload->display_errors();
                        $data['page_view'] = 'regulated_applications/edit_regulated_products';
                        $this->load->view('page', $data);
                    } else {
                        $outerbox_frontside_filename = $config4['file_name'] . $this->upload->data('file_ext');
                    }
                } else {
                    $outerbox_frontside_filename = '';
                }

                if (!empty($_FILES['outerbox_backside']['name'])) {
                    $config4['upload_path'] = $upload_path_file2;
                    $config4['allowed_types'] = 'pdf|jpg|jpeg|png';
                    $config4['max_size'] = 5000000;
                    $config4['file_name'] = 'outerbox_backside_' . $current_timestamp;
                    $this->upload->initialize($config4);
                    if (!$this->upload->do_upload('outerbox_backside')) {
                        $data['errors'] = 2;
                        $data['error_msgs'] = $this->upload->display_errors();
                        $data['page_view'] = 'regulated_applications/edit_regulated_products';
                        $this->load->view('page', $data);
                    } else {
                        $outerbox_backside_filename = $config4['file_name'] . $this->upload->data('file_ext');
                    }
                } else {
                    $outerbox_backside_filename = '';
                }


                $sku = stripslashes($this->input->post('sku'));
                $product_name = stripslashes($this->input->post('product_name'));

                $updated_by = $this->session->userdata('user_id');
                $updated_at = date('Y-m-d H:i:s');

                $this->Regulated_applications_model->update_regulated_product($data['regulated_product_id'],  $sku, $product_name, $product_img_filename, $updated_by, $updated_at);

                $product_use_and_info = stripslashes($this->input->post('product_use_and_info'));
                $volume_weight = stripslashes($this->input->post('volume_weight'));
                $approx_size_of_package = stripslashes($this->input->post('approx_size_of_package'));

                $this->Regulated_applications_model->update_regulated_product_one($data['regulated_product_id'], $ingredients_formula_filename,  $product_use_and_info,  $outerbox_frontside_filename,  $outerbox_backside_filename, $volume_weight, $consumer_product_packaging_img_filename, $approx_size_of_package);

                foreach ($data['reg_product_cust'] as $key => $value) {

                    $name_arr = explode(" ", ucwords($value->detail_name));
                    $cust_id = '';
                    $loop_cnt = 0;
                    foreach ($name_arr as $value1) {
                        # code...
                        if ($loop_cnt > 0) {
                            $cust_id = $cust_id . '_' . $value1;
                        } else {
                            $cust_id = $value1;
                        }

                        $loop_cnt++;
                    }

                    if ($value->detail_type == 'input') {
                        if ($this->input->post(strtolower($cust_id)) != '') {
                            $this->Regulated_applications_model->update_regulated_product_one_cust($value->id, $this->input->post(strtolower($cust_id)));
                        }
                    } else if ($value->detail_type == 'file') {
                        if (!empty($_FILES[strtolower($cust_id)]['name'])) {
                            $config2['upload_path'] = $upload_path_file2;
                            $config2['allowed_types'] = 'pdf|jpg|jpeg|png';
                            $config2['max_size'] = 5000000;
                            $config2['file_name'] = strtolower($cust_id) . '_' . $current_timestamp;
                            $this->upload->initialize($config2);
                            if (!$this->upload->do_upload(strtolower($cust_id))) {
                                $data['errors'] = 2;
                                $data['error_msgs'] = $this->upload->display_errors();
                                $data['page_view'] = 'regulated_applications/edit_regulated_products';
                                $this->load->view('page', $data);
                            } else {
                                $cust_file = $config2['file_name'] . $this->upload->data('file_ext');
                                $this->Regulated_applications_model->update_regulated_product_one_cust($value->id, $cust_file);
                            }
                        }
                    }


                    # code...
                }

                $this->session->set_flashdata('success', 'Congratulations! You successfully updated the regulated product.');
                redirect('regulated_applications/edit_regulated_products/' . $data['regulated_product_id'], 'refresh');
            }
        } else {
            $data['page_view'] = 'regulated_applications/edit_regulated_products';
            $this->load->view('page', $data);
        }
    }

    public function product_approve()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $subject = 'Product Registration Status';
        $template = 'emails/notification_approved.php';

        $id = $this->input->post('reg_prod_id');

        $updated_at = date('Y-m-d H:i:s');
        $updated_by = $this->session->userdata('user_id');

        $q_product_data = $this->Regulated_applications_model->fetch_product_registration($id);
        $product_data = $q_product_data->row();

        $result = $this->Regulated_applications_model->product_approve($id, $updated_at, $updated_by);

        // if ($result == 1) {
        //   $this->send_mail2($product_data->email, $template, $product_data->id, '', $subject, $product_data->contact_person);
        //   echo $result;
        // }
        echo $result;
    }

    public function product_decline()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $subject = 'Product Registration Status';
        $template = 'emails/notification_declined.php';

        $id = $this->input->post('reg_prod_id');
        $declined_msg = $this->input->post('declined_msg');


        $updated_at = date('Y-m-d H:i:s');
        $updated_by = $this->session->userdata('user_id');

        $q_product_data = $this->Regulated_applications_model->fetch_product_registration($id);
        $product_data = $q_product_data->row();

        $result = $this->Regulated_applications_model->product_decline($id, $declined_msg, $updated_at, $updated_by);

        // if ($result == 1) {
        //   $this->send_mail($product_data->email, $template, $product_data->id, $declined_msg, $subject, $product_data->contact_person);
        //   echo $result;
        // }
        echo $result;
    }

    public function product_revisions()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $this->users->clear_apost();

        $subject = 'Product Registration Status';
        $template = 'emails/notification_revision.php';

        $id = $this->input->post('reg_prod_id');
        $revisions_msg = $this->input->post('revisions_msg');

        $updated_at = date('Y-m-d H:i:s');
        $updated_by = $this->session->userdata('user_id');

        $q_product_data = $this->Regulated_applications_model->fetch_product_registration($id);
        $product_data = $q_product_data->row();

        $result = $this->Regulated_applications_model->product_revisions($id, $revisions_msg, $updated_at, $updated_by);

        // if ($result == 1) {
        //   $this->send_mail($product_data->email, $template, $product_data->id, $revisions_msg, $subject, $product_data->contact_person);
        //   echo $result;
        // }
        echo $result;
    }

    public function product_delete()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $id = $this->input->post('id');

        $updated_at = date('Y-m-d H:i:s');
        $updated_by = $this->session->userdata('user_id');

        $result = $this->Product_registration_model->product_delete($id, $updated_at, $updated_by);

        if ($result == 1) {
            echo $result;
        }
    }

    public function approve_pre_import()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $id = $this->input->post('id');
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = $this->session->userdata('user_id');

        $approved_reg_prod = $this->Regulated_applications_model->check_approved_reg_prod($id);

        $q_regulated_application_details = $this->Regulated_applications_model->fetch_regulated_application($id);
        $reg_application = $q_regulated_application_details->row();

        if ($approved_reg_prod == 0) {
            $result = 0;
        } else {
            $result = $this->Regulated_applications_model->approve_pre_import($id, $updated_at, $updated_by);

            if ($result == 1) {

                $q_regulated_application_details = $this->Regulated_applications_model->fetch_regulated_application($id);
                $regulated_application = $q_regulated_application_details->row();

                $subject = 'Regulated Application Status';
                $template = 'email/tracking_status_email.php';
                $this->send_mail($subject, $template, $reg_application->tracking_status_name, $regulated_application->tracking_status_name, $regulated_application->user_contact_person, '', $regulated_application->user_email);

                echo $result;
            }
        }
    }

    public function decline_pre_import()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $id = $this->input->post('id');
        $remarks = $this->input->post('remarks');
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = $this->session->userdata('user_id');

        $result = $this->Regulated_applications_model->decline_pre_import($id, $remarks, $updated_at, $updated_by);

        if ($result == 1) {

            $q_regulated_application_details = $this->Regulated_applications_model->fetch_regulated_application($id);
            $regulated_application = $q_regulated_application_details->row();

            $subject = 'Regulated Application Status';
            $template = 'email/regulated_pre_import.php';
            $this->send_mail3($regulated_application->user_email, $template, $subject, $regulated_application->user_contact_person, 'Declined', $remarks);

            echo $result;
        }
    }

    public function revision_pre_import()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $id = $this->input->post('id');
        $remarks = $this->input->post('remarks');
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = $this->session->userdata('user_id');

        $result = $this->Regulated_applications_model->revision_pre_import($id, $remarks, $updated_at, $updated_by);

        if ($result == 1) {

            $q_regulated_application_details = $this->Regulated_applications_model->fetch_regulated_application($id);
            $regulated_application = $q_regulated_application_details->row();

            $subject = 'Regulated Application Status';
            $template = 'email/regulated_pre_import.php';
            $this->send_mail3($regulated_application->user_email, $template, $subject, $regulated_application->user_contact_person, 'Needs Revisions', $remarks);

            echo $result;
        }
    }

    public function cancel_pre_import()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $id = $this->input->post('id');
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = $this->session->userdata('user_id');

        $result = $this->Regulated_applications_model->cancel_pre_import($id, $updated_at, $updated_by);

        if ($result == 1) {

            $q_regulated_application_details = $this->Regulated_applications_model->fetch_regulated_application($id);
            $regulated_application = $q_regulated_application_details->row();

            $subject = 'Regulated Application Status';
            $template = 'email/regulated_pre_import.php';
            $this->send_mail3($regulated_application->user_email, $template, $subject, $regulated_application->user_contact_person, 'Cancelled', '');

            echo $result;
        }
    }

    public function view_product_lab()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $this->clear_apost();

        $data['external_page'] = 0;
        $data['active_page'] = "regulated_applications";
        $data['active_url'] = "regulated_applications";
        $data['page_view'] = 'regulated_applications/edit_regulated_products';

        $data['regulated_product_id'] = $this->uri->segment(3);
        $data['user_id'] = $this->session->userdata('user_id');

        $q_user_details = $this->Regulated_applications_model->fetch_users_by_id($data['user_id']);
        $data['user_details'] = $q_user_details->row();

        $q_fetch_reg_product_by_id = $this->Regulated_applications_model->fetch_reg_product_by_id($data['regulated_product_id']);
        $data['reg_product'] = $q_fetch_reg_product_by_id->row();

        $data['page_view'] = 'regulated_applications/view_product_lab';
        $this->load->view('page', $data);
    }

    public function upload_test_results()
    {
        if (!$this->users->logged_in()) {
            $this->session->set_flashdata('noaccess', 'Login failed, no authorized access.');
            redirect('/users/admin');
        }

        $data['external_page'] = 0;
        $data['active_page'] = "regulated_applications";
        $data['active_url'] = "regulated_applications";
        $data['page_view'] = 'regulated_applications/upload_test_results';

        $data['regulated_application_id'] = $this->uri->segment(3);
        $data['user_id'] = $this->session->userdata('user_id');

        $q_user_details = $this->Regulated_applications_model->fetch_users_by_id($data['user_id']);
        $data['user_details'] = $q_user_details->row();

        $q_fetch_reg_application = $this->Regulated_applications_model->fetch_reg_application($data['regulated_application_id']);
        $data['reg_application'] = $q_fetch_reg_application->row();

        $q_fetch_reg_products = $this->Regulated_applications_model->fetch_approved_regulated_products($data['regulated_application_id']);
        $data['reg_products'] = $q_fetch_reg_products->result();

        $current_timestamp = now();
        $upload_path_file = 'uploads/regulated_applications/' . $data['reg_application']->regulated_application_id;

        if (isset($_POST['upload_test_result'])) {
            if (!file_exists($upload_path_file)) {
                mkdir($upload_path_file, 0777, true);
            }

            $config['upload_path'] = $upload_path_file;
            $config['allowed_types'] = 'pdf|jpg|jpeg|png';
            $config['max_size'] = 5000000;
            $config['file_name'] = 'test_result_' . $current_timestamp;

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('test_result')) {
                $data['errors'] = 2;
                $data['error_msgs'] = $this->upload->display_errors();
                $data['page_view'] = 'regulated_applications/upload_test_results';
                $this->load->view('page', $data);
            } else {
                $product_registration_id_upload = stripslashes($this->input->post('product_registration_id_upload'));
                $test_result_filename = $config['file_name'] . $this->upload->data('file_ext');
                $updated_by = $this->session->userdata('user_id');
                $updated_at = date('Y-m-d H:i:s');

                $result = $this->Regulated_applications_model->insert_test_result($product_registration_id_upload, $test_result_filename, $updated_by, $updated_at);

                if ($result == 1) {
                    $this->session->set_flashdata('success', 'Successfully added Lab/Product Test Result!');
                    redirect('/regulated_applications/upload_test_results/' . $data['regulated_application_id'], 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Sorry for the inconvenience! Some errors found. Please contact our administrator through livechat or email.');
                    redirect('/regulated_applications/upload_test_results/' . $data['regulated_application_id'], 'refresh');
                }
            }
        } else if (isset($_POST['delete_test_result'])) {
            $product_registration_id_delete = stripslashes($this->input->post('product_registration_id_delete'));
            $updated_by = $this->session->userdata('user_id');
            $updated_at = date('Y-m-d H:i:s');

            $result = $this->Regulated_applications_model->remove_test_result($product_registration_id_delete, $updated_by, $updated_at);

            if ($result == 1) {
                $this->session->set_flashdata('success', 'Successfully deleted Lab/Product Test Result!');
                redirect('/regulated_applications/upload_test_results/' . $data['regulated_application_id'], 'refresh');
            } else {
                $this->session->set_flashdata('error', 'Sorry for the inconvenience! Some errors found. Please contact our administrator through livechat or email.');
                redirect('/regulated_applications/upload_test_results/' . $data['regulated_application_id'], 'refresh');
            }
        } else {
            $this->load->view('page', $data);
        }
    }

    public function product_label_bulk_guide()
    {
        $data['external_page'] = 0;
        $data['active_page'] = "regulated_applications";
        $data['active_url'] = "regulated_applications";
        $data['page_view'] = 'regulated_applications/product_label_bulk_guide';

        $this->load->view('page', $data);
    }

    public function send_mail($subject, $template, $updated_status, $new_tracking_status, $contact_person, $remarks, $email)
    {
        $mail = $this->phpmailer_library->load();
        // $mail->SMTPDebug = 1;
        $mail->isSMTP();
        $mail->Host     = 'mail.covueior.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@covueior.com';
        $mail->Password = 'Y.=Sa3hZxq+>@6';
        // $mail->SMTPSecure = 'ssl'; // tls
        $mail->Port     = 26; // 587
        $mail->setFrom('admin@covueior.com', 'COVUE IOR Japan');
        $mail->addAddress($email);
        $mail->addBCC('mikecoros05@gmail.com');
        $mail->Subject = $subject;
        $mail->isHTML(true);

        $data['updated_status'] = $updated_status;
        $data['new_tracking_status'] = $new_tracking_status;
        $data['contact_person'] = $contact_person;
        $data['remarks'] = $remarks;
        $mailContent = $this->load->view($template, $data, true);

        $mail->Body = $mailContent;

        if ($mail->send()) {
            $message = 'success';
        } else {
            $message = 'failed';
        }

        return $message;
    }

    public function send_mail2($to_email, $template, $id, $custom, $subject, $contact_person)
    {
        $mail = $this->phpmailer_library->load();
        // $mail->SMTPDebug = 1;
        $mail->isSMTP();
        $mail->Host     = 'mail.covueior.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@covueior.com';
        $mail->Password = 'Y.=Sa3hZxq+>@6';
        // $mail->SMTPSecure = 'ssl'; // tls
        $mail->Port     = 26; // 587
        $mail->setFrom('admin@covueior.com', 'COVUE IOR Japan');
        $mail->addAddress($to_email);
        $mail->addBCC('mikecoros05@gmail.com');
        $mail->Subject = $subject;
        $mail->isHTML(true);

        $data['product_qualification_id'] = $id;
        $data['custom'] = $custom;
        $data['contact_person'] = $contact_person;
        $mailContent = $this->load->view($template, $data, true);

        $mail->Body = $mailContent;

        if ($mail->send()) {
            $message = 'success';
        } else {
            $message = 'failed';
        }

        return $message;
    }

    public function send_mail3($to_email, $template, $subject, $contact_person, $status, $remarks)
    {
        $mail = $this->phpmailer_library->load();
        // $mail->SMTPDebug = 1;
        $mail->isSMTP();
        $mail->Host     = 'mail.covueior.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@covueior.com';
        $mail->Password = 'Y.=Sa3hZxq+>@6';
        // $mail->SMTPSecure = 'ssl'; // tls
        $mail->Port     = 26; // 587
        $mail->setFrom('admin@covueior.com', 'COVUE IOR Japan');
        $mail->addAddress($to_email);
        $mail->addBCC('mikecoros05@gmail.com');
        $mail->Subject = $subject;
        $mail->isHTML(true);

        $data['contact_person'] = $contact_person;
        $data['status'] = $status;
        $data['remarks'] = $remarks;
        $mailContent = $this->load->view($template, $data, true);

        $mail->Body = $mailContent;

        if ($mail->send()) {
            $message = 'success';
        } else {
            $message = 'failed';
        }

        return $message;
    }

    public function send_mail4($to_email, $template, $subject, $assignor, $assignee, $regulated_application_id, $company_name)
    {
        $mail = $this->phpmailer_library->load();
        // $mail->SMTPDebug = 1;
        $mail->isSMTP();
        $mail->Host     = 'mail.covueior.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@covueior.com';
        $mail->Password = 'Y.=Sa3hZxq+>@6';
        // $mail->SMTPSecure = 'ssl'; // tls
        $mail->Port     = 26; // 587
        $mail->setFrom('admin@covueior.com', 'COVUE IOR Japan');
        $mail->addAddress($to_email);
        $mail->addBCC('mikecoros05@gmail.com');
        $mail->Subject = $subject;
        $mail->isHTML(true);

        $data['assignor'] = $assignor;
        $data['assignee'] = $assignee;
        $data['regulated_application_id'] = $regulated_application_id;
        $data['company_name'] = $company_name;
        $mailContent = $this->load->view($template, $data, true);

        $mail->Body = $mailContent;

        if ($mail->send()) {
            $message = 'success';
        } else {
            $message = 'failed';
        }

        return $message;
    }

    public function add_details()
    {
        $result = $this->Regulated_applications_model->add_custom_field($_POST);
        // echo json_encode($_POST);
    }

    public function remove_details()
    {
        $result = $this->Regulated_applications_model->remove_custom_field($_POST);
        // echo json_encode($_POST);
    }
}
