<?php

// template
// array(
//             'field' => '',
//             'label' => '',
//             'rules' => 'trim|required|max_length[10]',
//             'errors' => array(
//                 'max_length' => '%s must not be greater than 10 characters.'),
//         ),

$config = array(
    'course' => array(
        array(
            'field' => 'course_name',
            'label' => 'Course Name',
            'rules' => 'trim|required|max_length[99]',
            'errors' => array(
                'max_length' => '%s must not be greater than 99 characters.'),
        ),
        array(
            'field' => 'category',
            'label' => 'Category',
            'rules' => 'trim|required|max_length[99]',
            'errors' => array(
                'max_length' => '%s must not be greater than 99 characters.'),
        ),
        array(
            'field' => 'description',
            'label' => 'Course Description',
            'rules' => 'trim|required|max_length[16384]',
            'errors' => array(
                'max_length' => '%s must not be greater than 16384 characters.'),
        ),
    ),

    'credentials' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required|max_length[10]|callback_check_username', // calls the check_username method on the calling controller
            'errors' => array(
                'max_length' => '%s must not be greater than 10 characters.'),
        ),
        array(
            'field' => 'old_password',
            'label' => 'Old Password',
            'rules' => 'trim|required',
        ),
        array(
            'field' => '_password',
            'label' => 'Password',
            'rules' => 'trim|required',
        ),
        array(
            'field' => 'confirm_password',
            'label' => 'Password Confirmation',
            'rules' => 'trim|required|matches[_password]',
        ),
    ),
    'memberInfo' => array(
        array(
            'field' => 'last_name',
            'label' => 'Last Name',
            'rules' => 'trim|required|max_length[15]',
            'errors' => array(
                'max_length' => '%s must not be greater than 15 characters.'),
        ),
        array(
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'trim|required|max_length[30]',
            'errors' => array(
                'max_length' => '%s must not be greater than 30 characters.'),
        ),
        array(
            'field' => 'middle_name',
            'label' => 'Middle Name',
            'rules' => 'trim|max_length[15]',
            'errors' => array(
                'max_length' => '%s must not be greater than 15 characters.'),
        ),
        array(
            'field' => 'street',
            'label' => 'Street',
            'rules' => 'trim|required|max_length[30]',
            'errors' => array(
                'max_length' => '%s must not be greater than 30 characters.'),
        ),
        array(
            'field' => 'barangay',
            'label' => 'Barangay',
            'rules' => 'trim|required|max_length[25]',
            'errors' => array(
                'max_length' => '%s must not be greater than 25 characters.'),
        ),
        array(
            'field' => 'municipality',
            'label' => 'Municipality',
            'rules' => 'trim|required|max_length[30]',
            'errors' => array(
                'max_length' => '%s must not be greater than 30 characters.'),
        ),
        array(
            'field' => 'province',
            'label' => 'Province',
            'rules' => 'trim|required|max_length[30]',
            'errors' => array(
                'max_length' => '%s must not be greater than 30 characters.'),
        ),
        array(
            'field' => 'contact_number',
            'label' => 'Contact Number',
            'rules' => 'trim|required|numeric|min_length[11]|max_length[20]',
            'errors' => array(
                'min_length' => '%s must at least 11 characters.',
                'max_length' => '%s must not be greater than 20 characters.'),
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|max_length[50]',
            'errors' => array(
                'max_length' => '%s must not be greater than 50 characters.'),
        ),
        array(
            'field' => 'birthdate',
            'label' => 'Birthdate',
            'rules' => 'trim|required',
        )
        ,
    ),

// =========== GROUPS ==========

    'login' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required|max_length[10]',
            'errors' => array(
                'required' => 'You must provide a %s.',
                'max_length' => '%s must not be greater than 10 characters.'),
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required|max_length[1024]',
            'errors' => array(
                'required' => 'You must provide a %s.'),
        ),
    ),

);
$config['memberInfo_all'] = array_merge($config['credentials'], $config['memberInfo']);
