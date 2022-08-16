<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function index()
    {
        $data['title'] = "Home |  SaharDirectory - Get a Personal Visiting Card";

        $data['companycate'] = $this->CommonModal->getRowByIdWithLimit('company_category', 'premium', '0', 7);
        $data['category'] = $this->CommonModal->getAllRowsWithLimit('company_category', '12', 'cate_id');
        $data['blogs'] = $this->CommonModal->getAllRows('blog');

        $this->load->view('home', $data);
    }

    public function search()
    {
        $searchname = $this->input->get('listing-name');
        $searchlocation = $this->input->get('listing-location');

        $serch_sql = "SELECT website_subservice.id, website_subservice.name, website_subservice.description, website_subservice.featured FROM website_subservice
            LEFT JOIN company_subcategory ON website_subservice.service_id = company_subcategory.category_id
            WHERE website_subservice.name LIKE '%{$searchname}%' OR website_subservice.description LIKE '%{$searchname}%'";

        $data['search_data'] = $this->CommonModal->runQuery($serch_sql);
        $data['category'] = $this->CommonModal->getAllRowsWithLimit('company_category', '12', 'cate_id');

        $data['title'] = "Search |  SaharDirectory - Get a Personal Visiting Card";

        $this->load->view('search', $data);
    }



    public function login()
    {
        if ($this->session->has_userdata('login_user_id')) {
            redirect(base_url('dashboard'));
        }
        $data['logo'] = 'assets/logo.png';

        $data['title'] = "Login | SaharDirectory - Get a Personal Visiting Card";
        if (count($_POST) > 0) {
            extract($this->input->post());
            $table = "tbl_registration";
            $login_data = $this->CommonModal->getRowByOr($table, array('email' => $email), array('mobile' => $mobile));

            if (!empty($login_data)) {
                if ($login_data[0]['password'] == $password) {
                    $this->session->set_userdata(array('login_user_id' => $login_data[0]['rgid'], 'login_user_name' => $login_data[0]['name'], 'login_user_emailid' => $login_data[0]['email'], 'login_user_contact' => $login_data[0]['mobile'], 'login_user_profile' => $login_data[0]['profile']));

                    $profile = $this->CommonModal->getRowById('company', 'rgid', $login_data[0]['rgid']);
                    if ($profile[0]['company_type'] == '' || $profile[0]['company_name'] == '' || $profile[0]['company_person'] == '' || $profile[0]['company_designation'] == '' || $profile[0]['company_category'] == '' || $profile[0]['company_subcategory'] == '' || $profile[0]['company_tagline'] == '' || $profile[0]['company_address'] == '' || $profile[0]['company_city'] == '' || $profile[0]['company_state'] == '' || $profile[0]['pin_code'] == '' || $profile[0]['company_email'] == '' || $profile[0]['company_contact'] == '' || $profile[0]['company_whatsapp'] == '') {
                        redirect(base_url('my-profile'));
                    } else {
                        redirect(base_url('dashboard'));
                    }
                } else {
                    $this->session->set_userdata('msg', '<h6 class="alert alert-danger">The <b>password</b> you entered is <b>incorrect</b> Please try again.</h6>');
                    redirect(base_url('login'));
                }
            } else {
                $this->session->set_flashdata('loginError', '<h6 class="alert alert-warning">Username or password doesnt match</h6>');
                redirect(base_url('login'));
            }
        } else {
            $this->load->view('login', $data);
        }
    }

    public function register()
    {
        if ($this->session->has_userdata('login_user_id')) {
            redirect(base_url('dashboard'));
        }

        $data['title'] = 'Register | SaharDirectory - Get a Personal Visiting Card';
        if (count($_POST) > 0) {
            $count = $this->CommonModal->getNumRows('tbl_registration', array('mobile' => $this->input->post('mobile'), 'email' => $this->input->post('email')));
            $company_count = $this->CommonModal->getNumRows('company', array('company_contact' => $this->input->post('mobile'), 'company_email' => $this->input->post('email')));


            if ($count > 0 || $company_count > 0) {
                $this->session->set_userdata('msg', '<h6 class="alert alert-danger">You have already registered with this email id or contact no.</h6>');
                redirect(base_url('signup'));
            } else {
                $post = $this->input->post();
                if ($post['password'] !=  $post['cpassword']) {
                    $this->session->set_userdata('msg', '<h6 class="alert alert-warning">Your Password and Confirm Password are not match .</h6>');
                    redirect(base_url('signup'));
                } else {

                    $rgid = $this->CommonModal->insertRowReturnId('tbl_registration', $post);
                    $lastid = $this->CommonModal->getRowById('tbl_registration', 'rgid', $rgid);
                    // $profileid = $this->CommonModal->insertRowReturnId('company', array('rgid' => $rgid, 'company_contact' => $lastid[0]['mobile']));

                    $session = $this->session->set_userdata(array(
                        'login_user_id' => $lastid[0]['rgid'], 'login_user_name' => $lastid[0]['name'],
                        'login_user_emailid' => $lastid[0]['email'], 'login_user_contact' => $lastid[0]['mobile'], 'login_user_profile' => $lastid[0]['profile']
                    ));

                    $profile = $this->CommonModal->getRowById('company', 'rgid', $rgid);
                    if ($profile != '') {
                        if ($profile[0]['company_type'] == '' || $profile[0]['company_name'] == '' || $profile[0]['company_person'] == '' || $profile[0]['company_designation'] == '' || $profile[0]['company_category'] == '' || $profile[0]['company_subcategory'] == '' || $profile[0]['company_tagline'] == '' || $profile[0]['company_address'] == '' || $profile[0]['company_city'] == '' || $profile[0]['company_state'] == '' || $profile[0]['pin_code'] == '' || $profile[0]['company_email'] == '' || $profile[0]['company_contact'] == '' || $profile[0]['company_whatsapp'] == '') {
                            redirect(base_url('my-profile'));
                        } else {
                            redirect(base_url('dashboard'));
                        }
                    } else {
                        redirect(base_url('my-profile'));
                    }

                    if (!empty($rgid)) {
                        $this->session->set_userdata('msg', '<h6 class="alert alert-success">You have Registered Successfully. Login to continue.</h6>');
                        redirect(base_url('my-profile'));
                    } else {
                        $this->session->set_userdata('msg', '<h6 class="alert alert-danger">Server error</h6>');
                    }
                }
            }
        } else {
        }
        $this->load->view('signup', $data);
    }

    public function my_profile()
    {
        if (!$this->session->has_userdata('login_user_id')) {
            redirect(base_url('login'));
        }

        if (count($_POST) > 0) {


            $post = $this->input->post();

            $uid = sessionId('login_user_id');
            $datarow = $this->CommonModal->getRowByMoreId('company', array('rgid' => $uid));
            if ($datarow != '') {
                $company_logo = $post['company_logo'];
                if ($_FILES['company_logo_temp']['name'] != '') {
                    $img = imageUpload('company_logo_temp', 'uploads/company/');
                    $post['company_logo'] = $img;
                    if ($company_logo != "") {
                        unlink('uploads/product/' . $company_logo);
                    }
                }

                $company_banner = $post['company_banner'];
                if ($_FILES['company_banner_temp']['name'] != '') {
                    $img = imageUpload('company_banner_temp', 'uploads/company/');
                    $post['company_banner'] = $img;
                    if ($company_banner != "") {
                        unlink('uploads/product/' . $company_banner);
                    }
                }

                $insert = $this->CommonModal->updateRowById('company', 'rgid', $uid, $post);

                redirect(base_url() . 'my-profile');
            } else {

                $post['company_logo'] = imageUpload('company_logo', 'uploads/company/');
                $post['company_banner'] = imageUpload('company_banner', 'uploads/company/');
                $insert = $this->CommonModal->insertRowReturnId('company', $post);
                redirect(base_url('choose-vcard'));
            }

            if ($insert) {
                $this->session->set_flashdata('msg', 'Profile Update  successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            } else {
                $this->session->set_flashdata('msg', 'Profile Update  successfull');
                $this->session->set_flashdata('msg_class', 'alert-success');
            }
            redirect(base_url() . 'my-profile');
        } else {

            $data['title'] = "Complete Your Profile | SaharDirectory - Get a Personal Visiting Card";
            $data['login_user'] = $this->session->userdata();

            $data['profiledata'] = $this->CommonModal->getRowById('tbl_registration', 'rgid', $this->session->userdata('login_user_id'));

            $data['datacomrow'] = $this->CommonModal->getRowById('company', 'rgid', $this->session->userdata('login_user_id'));
            $data['category'] = $this->CommonModal->getAllRows('company_category');
            $data['state_list'] = $this->CommonModal->getAllRows('tbl_state');
            $this->load->view('my-profile', $data);
        }
    }

    public function product_list()
    {
        $data['title'] = "Product Add | SaharDirectory - Get a Personal Visiting Card";
        $data['login_user'] = $this->session->userdata();
        $data['profiledata'] = $this->CommonModal->getRowById('tbl_registration', 'rgid', $this->session->userdata('login_user_id'));
        $data['productdata'] = $this->CommonModal->getRowById('product', 'company_id', $this->session->userdata('login_user_id'));

        $BdID = $this->input->get('BdID');

        if ($BdID != '') {
            $data = $this->CommonModal->getRowById('product', 'product_id', $BdID);


            unlink('uploads/product/' .  $data[0]['product_image']);

            $delete = $this->CommonModal->deleteRowById('product', array('product_id' => $BdID));
            if ($delete) {
                $this->session->set_flashdata('msg', 'Product Delete Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            } else {
                $this->session->set_flashdata('msg', 'Somethig Went Wrong try again later');
                $this->session->set_flashdata('msg_class', 'alert-danger');
            }
            redirect(base_url('product-list'));
            exit;
        }
        $this->load->view('product-list', $data);
    }
    public function product_add()
    {
        $data['title'] = "Product Add | SaharDirectory - Get a Personal Visiting Card";
        $data['login_user'] = $this->session->userdata();
        $data['profiledata'] = $this->CommonModal->getRowById('tbl_registration', 'rgid', $this->session->userdata('login_user_id'));
        $data['subcate'] = $this->CommonModal->getAllRows('company_subcategory');

        $data['tag'] = 'Add';
        if (count($_POST) > 0) {
            $post = $this->input->post();
            $post['company_id'] = sessionId('login_user_id');
            $post['product_image'] = imageUpload('product_image', 'uploads/product/');

            $insert = $this->CommonModal->insertRowReturnId('product', $post);
            if ($insert) {
                $this->session->set_flashdata('msg', 'Product Uploaded Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            } else {
                $this->session->set_flashdata('msg', 'Somethig Went Wrong try again later');
                $this->session->set_flashdata('msg_class', 'alert-danger');
            }
            redirect(base_url('product-list'));
        } else {
            $this->load->view('product-add', $data);
        }
    }
    public function update_product($pid)
    {
        $data['title'] = "Product Edit | SaharDirectory - Get a Personal Visiting Card";
        $data['login_user'] = $this->session->userdata();
        $data['profiledata'] = $this->CommonModal->getRowById('tbl_registration', 'rgid', $this->session->userdata('login_user_id'));
        $data['subcate'] = $this->CommonModal->getAllRows('company_subcategory');

        $get_id = decryptId($pid);
        $data['tag'] = 'Edit';
        $data['product_list'] = $this->CommonModal->getRowById('product', 'product_id', $get_id);

        if (count($_POST) > 0) {
            $post = $this->input->post();
            $product_image = $post['product_image'];
            if ($_FILES['product_image_temp']['name'] != '') {
                $img = imageUpload('product_image_temp', 'uploads/product/');
                $post['product_image'] = $img;
                if ($product_image != "") {
                    unlink('uploads/product/' . $product_image);
                }
            }
            $update = $this->CommonModal->updateRowById('product', 'product_id', $get_id, $post);
            if ($update) {
                $this->session->set_flashdata('msg', 'Product Uploaded Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            } else {
                $this->session->set_flashdata('msg', 'Product Uploaded Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            }
            redirect(base_url('product-list'));
        } else {
            $this->load->view('product-add', $data);
        }
    }



    public function getcity()
    {
        $state = $this->input->post('state');
        $data['city'] = $this->CommonModal->getRowByIdInOrder('tbl_cities', array('state_id' => $state), 'name', 'asc');
        $this->load->view('select_city', $data);
    }
    public function searchcontact()
    {
        $contact = $this->input->post('mobile');
        $data['contact'] = runQuery("SELECT * FROM `tbl_registration` WHERE `mobile`='" . $contact . "' ");
        $this->load->view('select_contact', $data);
    }

    public function select_subcat()
    {
        $cate = $this->input->post('company_category');
        $data['subcat'] = $this->CommonModal->getRowByIdInOrder('company_subcategory', array('category_id' => $cate), 'subcategory', 'asc');
        $this->load->view('select_subcategory', $data);
    }

    public function dashboard()
    {
        if (!$this->session->has_userdata('login_user_id')) {
            redirect(base_url('login'));
        }

        $data['title'] = "Dashboard | SaharDirectory - Get a Personal Visiting Card";
        $data['login_user'] = $this->session->userdata();
        $data['profiledata'] = $this->CommonModal->getRowById('tbl_registration', 'rgid', $this->session->userdata('login_user_id'));
        $data['enquiry'] = $this->CommonModal->getRowByIdInOrder('inquiry', array('company_id' => sessionId('login_user_id')), 'id', 'DESC');
        $this->load->view('dashboard', $data);
    }
    public function choose_vcard()
    {
        if (!$this->session->has_userdata('login_user_id')) {
            redirect(base_url('login'));
        }
        if (count($_POST) > 0) {
            $post = $this->input->post();
            $uid = sessionId('login_user_id');
            $add = $this->CommonModal->updateRowById('company', 'rgid', $uid, $post);
            redirect(base_url('dashboard'));
            if ($add) {
                $this->session->set_flashdata('msg', 'Vcard Updated Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            } else {
                $this->session->set_flashdata('msg', 'No Changes in Vcard');
                $this->session->set_flashdata('msg_class', 'alert-success');
            }
        }

        $data['title'] = "Choose Vcard | SaharDirectory - Get a Personal Visiting Card";
        $data['login_user'] = $this->session->userdata();
        $data['profiledata'] = $this->CommonModal->getRowById('tbl_registration', 'rgid', $this->session->userdata('login_user_id'));

        $data['vcard'] = $this->CommonModal->getAllRows('vcard_design');
        $data['getcard'] = $this->CommonModal->getRowByMoreId('company', array('rgid' => sessionId('login_user_id')));

        $this->load->view('choose-vcard', $data);
    }

    public function changePassword()
    {
        if (!$this->session->has_userdata('login_user_id')) {
            redirect(base_url('login'));
        }

        if (count($_POST) > 0) {


            $oldpassword = $this->input->post('oldpassword');
            $password = $this->input->post('password');
            $confirmpassword = $this->input->post('confirmpassword');
            $profile = $this->CommonModal->getsingleRowById('tbl_registration', array('rgid' => $this->session->userdata('login_user_id')));

            if ($profile['password'] == $oldpassword) {
                if ($password == $confirmpassword) {
                    $update = $this->CommonModal->updateRowById('tbl_registration', 'rgid', $this->session->userdata('login_user_id'), array('password' => $password));
                    if ($update) {
                        $this->session->set_flashdata('cmsg', 'Password Changed Successfully');
                        $this->session->set_flashdata('cmsg_class', 'alert-success');
                    } else {
                        $this->session->set_flashdata('cmsg', 'Password not changed , try again later');
                        $this->session->set_flashdata('cmsg_class', 'alert-danger');
                    }
                } else {
                    $this->session->set_flashdata('cmsg', 'Password and confirm password doesnt matched.');
                    $this->session->set_flashdata('cmsg_class', 'alert-danger');
                }
            } else {
                $this->session->set_flashdata('cmsg', 'Old password doesnt matched');
                $this->session->set_flashdata('cmsg_class', 'alert-danger');
            }
            redirect(base_url('changePassword'));
        } else {
            $data['title'] = "Change Passowrd | SaharDirectory - Get a Personal Visiting Card";
            $data['login_user'] = $this->session->userdata();
            $data['profiledata'] = $this->CommonModal->getRowById('tbl_registration', 'rgid', $this->session->userdata('login_user_id'));
            $this->load->view('change_password', $data);
        }
    }

    public function enquiry()
    {
        if (!$this->session->has_userdata('login_user_id')) {
            redirect(base_url('login'));
        }

        $BdID = $this->input->get('BdID');

        if ($BdID != '') {
            $delete = $this->CommonModal->deleteRowById('inquiry', array('id' => $BdID));
            if ($delete) {
                $this->session->set_flashdata('msg', 'Enquiry Delete Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            } else {
                $this->session->set_flashdata('msg', 'Somethig Went Wrong try again later');
                $this->session->set_flashdata('msg_class', 'alert-danger');
            }
            redirect(base_url('enquiry'));
            exit;
        }
        $data['title'] = "Enquiry | SaharDirectory - Get a Personal Visiting Card";
        $data['login_user'] = $this->session->userdata();
        $data['profiledata'] = $this->CommonModal->getRowById('tbl_registration', 'rgid', $this->session->userdata('login_user_id'));

        $data['enquiry'] = $this->CommonModal->getRowByIdInOrder('inquiry', array('company_id' => sessionId('login_user_id')), 'id', 'DESC');


        $this->load->view('enquiry', $data);
    }



    public function reviews()
    {
        if (!$this->session->has_userdata('login_user_id')) {
            redirect(base_url('login'));
        }

        $BdID = $this->input->get('BdID');

        if ($BdID != '') {
            $delete = $this->CommonModal->deleteRowById('feedback', array('id' => $BdID));
            if ($delete) {
                $this->session->set_flashdata('msg', 'Reviews Delete Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            } else {
                $this->session->set_flashdata('msg', 'Somethig Went Wrong try again later');
                $this->session->set_flashdata('msg_class', 'alert-danger');
            }
            redirect(base_url('reviews'));
            exit;
        }
        $data['title'] = "Reviews | SaharDirectory - Get a Personal Visiting Card";
        $data['login_user'] = $this->session->userdata();
        $data['profiledata'] = $this->CommonModal->getRowById('tbl_registration', 'rgid', $this->session->userdata('login_user_id'));

        $data['reviews'] = $this->CommonModal->getRowByIdInOrder('feedback', array('company_id' => sessionId('login_user_id')), 'id', 'DESC');


        $this->load->view('reviews', $data);
    }


    public function gallery()
    {
        if (!$this->session->has_userdata('login_user_id')) {
            redirect(base_url('login'));
        }

        $BdID = $this->input->get('BdID');


        if ($BdID != '') {
            $data = $this->CommonModal->getRowById('company_gallery', 'gallery_id', $BdID);


            unlink('uploads/gallery/' .  $data[0]['image']);

            $delete = $this->CommonModal->deleteRowById('company_gallery', array('gallery_id' => $BdID));
            if ($delete) {
                $this->session->set_flashdata('msg', 'Gallery Delete Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            } else {
                $this->session->set_flashdata('msg', 'Somethig Went Wrong try again later');
                $this->session->set_flashdata('msg_class', 'alert-danger');
            }
            redirect(base_url('gallery'));
            exit;
        }

        if (count($_POST) > 0) {
            $post = $this->input->post();
            $post['company_id'] = sessionId('login_user_id');
            $post['image'] = imageUpload('image', 'uploads/gallery/');

            $insert = $this->CommonModal->insertRowReturnId('company_gallery', $post);
            if ($insert) {
                $this->session->set_flashdata('msg', 'Gallery Uploaded Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            } else {
                $this->session->set_flashdata('msg', 'Somethig Went Wrong try again later');
                $this->session->set_flashdata('msg_class', 'alert-danger');
            }
            redirect(base_url('gallery'));
        }

        $data['title'] = "Gallery | SaharDirectory - Get a Personal Visiting Card";
        $data['login_user'] = $this->session->userdata();
        $data['profiledata'] = $this->CommonModal->getRowById('tbl_registration', 'rgid', $this->session->userdata('login_user_id'));

        $data['gallery'] = $this->CommonModal->getRowByIdInOrder('company_gallery', array('company_id' => sessionId('login_user_id')), 'gallery_id', 'DESC');


        $this->load->view('gallery', $data);
    }

    public function video()
    {
        if (!$this->session->has_userdata('login_user_id')) {
            redirect(base_url('login'));
        }

        $BdID = $this->input->get('BdID');


        if ($BdID != '') {
            $data = $this->CommonModal->getRowById('company_video', 'video_id', $BdID);


            unlink('uploads/video/' .  $data[0]['image']);

            $delete = $this->CommonModal->deleteRowById('company_video', array('video_id' => $BdID));
            if ($delete) {
                $this->session->set_flashdata('msg', 'video Delete Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            } else {
                $this->session->set_flashdata('msg', 'Somethig Went Wrong try again later');
                $this->session->set_flashdata('msg_class', 'alert-danger');
            }
            redirect(base_url('video'));
            exit;
        }

        if (count($_POST) > 0) {
            $post = $this->input->post();
            $post['company_id'] = sessionId('login_user_id');
            $video_path =  $_POST['video_path'];

            $video_path = preg_replace("#.*youtube\.com/watch\?v=#", "", $video_path);
            $video_path = preg_replace("#.*https://youtu.be/#", "", $video_path);


            $insert = $this->CommonModal->insertRowReturnId('company_video', $post);
            if ($insert) {
                $this->session->set_flashdata('msg', 'video Uploaded Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            } else {
                $this->session->set_flashdata('msg', 'Somethig Went Wrong try again later');
                $this->session->set_flashdata('msg_class', 'alert-danger');
            }
            redirect(base_url('video'));
        }

        $data['title'] = "video | SaharDirectory - Get a Personal Visiting Card";
        $data['login_user'] = $this->session->userdata();
        $data['profiledata'] = $this->CommonModal->getRowById('tbl_registration', 'rgid', $this->session->userdata('login_user_id'));

        $data['video'] = $this->CommonModal->getRowByIdInOrder('company_video', array('company_id' => sessionId('login_user_id')), 'video_id', 'DESC');


        $this->load->view('video', $data);
    }

    public function about()
    {
        if (!$this->session->has_userdata('login_user_id')) {
            redirect(base_url('login'));
        }

        if (count($_POST) > 0) {
            $post = $this->input->post();
            $post['company_id'] = sessionId('login_user_id');

            $insert = $this->CommonModal->updateRowByIdwithoutxss('company', 'rgid', sessionId('login_user_id'), $post);
            if ($insert) {
                $this->session->set_flashdata('msg', 'about Uploaded Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            } else {
                $this->session->set_flashdata('msg', 'No changes on current');
                $this->session->set_flashdata('msg_class', 'alert-danger');
            }
            redirect(base_url('about'));
        }

        $data['title'] = "About | SaharDirectory - Get a Personal Visiting Card";
        $data['login_user'] = $this->session->userdata();
        $data['profiledata'] = $this->CommonModal->getRowById('tbl_registration', 'rgid', $this->session->userdata('login_user_id'));

        $data['about'] = $this->CommonModal->getRowByIdInOrder('company', array('rgid' => sessionId('login_user_id')), 'company_id', 'DESC');
        $this->load->view('about', $data);
    }


    public function section_category()
    {
        $data['title'] = "Section Category Add | SaharDirectory - Get a Personal Visiting Card";
        $data['login_user'] = $this->session->userdata();
        $data['profiledata'] = $this->CommonModal->getRowById('tbl_registration', 'rgid', $this->session->userdata('login_user_id'));
        $data['section'] = $this->CommonModal->getRowByIdInOrder('section_category', array('company_id' => sessionId('login_user_id')), 'sec_id', 'DESC');

        $BdID = $this->input->get('BdID');
        if ($BdID != '') {
            $delete = $this->CommonModal->deleteRowById('section_category', array('sec_id' => $BdID));
            if ($delete) {
                $this->session->set_flashdata('msg', 'Section Category Delete Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            } else {
                $this->session->set_flashdata('msg', 'Somethig Went Wrong try again later');
                $this->session->set_flashdata('msg_class', 'alert-danger');
            }
            redirect(base_url('section-category'));
            exit;
        }
        $data['tag'] = 'Add';
        if (count($_POST) > 0) {
            $post = $this->input->post();
            $post['company_id'] = sessionId('login_user_id');

            $insert = $this->CommonModal->insertRowReturnId('section_category', $post);
            if ($insert) {
                $this->session->set_flashdata('msg', 'Section Category Uploaded Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            } else {
                $this->session->set_flashdata('msg', 'Somethig Went Wrong try again later');
                $this->session->set_flashdata('msg_class', 'alert-danger');
            }
            redirect(base_url('section-category'));
        } else {
            $this->load->view('section-category', $data);
        }
    }

    public function update_section_category($pid)
    {
        $data['title'] = "section Category Edit | SaharDirectory - Get a Personal Visiting Card";
        $data['login_user'] = $this->session->userdata();
        $data['profiledata'] = $this->CommonModal->getRowById('tbl_registration', 'rgid', $this->session->userdata('login_user_id'));
        $data['section'] = $this->CommonModal->getRowByIdInOrder('section_category', array('company_id' => sessionId('login_user_id')), 'sec_id', 'DESC');

        $get_id = decryptId($pid);
        $data['tag'] = 'Edit';
        $data['section_category_list'] = $this->CommonModal->getRowById('section_category', 'sec_id', $get_id);

        if (count($_POST) > 0) {
            $post = $this->input->post();
            $update = $this->CommonModal->updateRowById('section_category', 'sec_id', $get_id, $post);
            if ($update) {
                $this->session->set_flashdata('msg', 'Section category Updated Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            } else {
                $this->session->set_flashdata('msg', 'Sction_category Updated Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            }
            redirect(base_url('section-category'));
        } else {
            $this->load->view('section-category', $data);
        }
    }

    public function getvalue()
    {
        $data = $this->input->post('nm');
        $sal = $this->CommonModal->getQuery("SELECT * FROM `company` WHERE `company_web_title` IN ('" . $data . "')");
    }

    public function section_list()
    {
        $data['title'] = "section | SaharDirectory - Get a Personal Visiting Card";
        $data['login_user'] = $this->session->userdata();
        $data['profiledata'] = $this->CommonModal->getRowById('tbl_registration', 'rgid', $this->session->userdata('login_user_id'));
        $data['sectiondata'] = $this->CommonModal->getRowById('section', 'company_id', $this->session->userdata('login_user_id'));

        $BdID = $this->input->get('BdID');

        if ($BdID != '') {
            $data = $this->CommonModal->getRowById('section', 'section_id', $BdID);


            unlink('uploads/section/' .  $data[0]['section_image']);

            $delete = $this->CommonModal->deleteRowById('section', array('section_id' => $BdID));
            if ($delete) {
                $this->session->set_flashdata('msg', 'Section Delete Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            } else {
                $this->session->set_flashdata('msg', 'Somethig Went Wrong try again later');
                $this->session->set_flashdata('msg_class', 'alert-danger');
            }
            redirect(base_url('section-list'));
            exit;
        }
        $this->load->view('section-list', $data);
    }
    public function section_add()
    {
        $data['title'] = "section Add | SaharDirectory - Get a Personal Visiting Card";
        $data['login_user'] = $this->session->userdata();
        $data['profiledata'] = $this->CommonModal->getRowById('tbl_registration', 'rgid', $this->session->userdata('login_user_id'));
        $data['subcate'] = $this->CommonModal->getRowById('section_category', 'company_id', $this->session->userdata('login_user_id'));

        $data['tag'] = 'Add';
        if (count($_POST) > 0) {
            $post = $this->input->post();
            $post['company_id'] = sessionId('login_user_id');
            $post['section_image'] = imageUpload('section_image', 'uploads/section/');

            $insert = $this->CommonModal->insertRowReturnId('section', $post);
            if ($insert) {
                $this->session->set_flashdata('msg', 'Section Uploaded Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            } else {
                $this->session->set_flashdata('msg', 'Somethig Went Wrong try again later');
                $this->session->set_flashdata('msg_class', 'alert-danger');
            }
            redirect(base_url('section-list'));
        } else {
            $this->load->view('section-add', $data);
        }
    }
    public function update_section($pid)
    {
        $data['title'] = "section Edit | SaharDirectory - Get a Personal Visiting Card";
        $data['login_user'] = $this->session->userdata();
        $data['profiledata'] = $this->CommonModal->getRowById('tbl_registration', 'rgid', $this->session->userdata('login_user_id'));
        $data['subcate'] = $this->CommonModal->getRowById('section_category', 'company_id', $this->session->userdata('login_user_id'));

        $get_id = decryptId($pid);
        $data['tag'] = 'Edit';
        $data['section_list'] = $this->CommonModal->getRowById('section', 'section_id', $get_id);

        if (count($_POST) > 0) {
            $post = $this->input->post();
            $section_image = $post['section_image'];
            if ($_FILES['section_image_temp']['name'] != '') {
                $img = imageUpload('section_image_temp', 'uploads/section/');
                $post['section_image'] = $img;
                if ($section_image != "") {
                    unlink('uploads/section/' . $section_image);
                }
            }
            $update = $this->CommonModal->updateRowById('section', 'section_id', $get_id, $post);
            if ($update) {
                $this->session->set_flashdata('msg', 'Section Uploaded Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            } else {
                $this->session->set_flashdata('msg', 'Section Uploaded Successfully');
                $this->session->set_flashdata('msg_class', 'alert-success');
            }
            redirect(base_url('section-list'));
        } else {
            $this->load->view('section-add', $data);
        }
    }


    public function logout()
    {
        $this->session->unset_userdata('login_user_id');
        $this->session->unset_userdata('login_user_name');
        $this->session->unset_userdata('login_user_emailid');
        $this->session->unset_userdata('login_user_contact');
        redirect(base_url());
    }
}
