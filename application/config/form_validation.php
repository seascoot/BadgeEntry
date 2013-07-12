<?php
# See http://ellislab.com/codeigniter/user-guide/libraries/form_validation.html#rulereference for available rules.

$config = array(
	'people/edit' => array(


		array(
			'field' => 'firstName',
			'label' => 'First name',
			'rules' => 'trim|required|alpha|min_length[3]|max_length[25]|xss_clean',
		),
		
		array(
			'field' => 'lastName',
			'label' => 'Last name',
			'rules' => 'trim|required|alpha|min_length[3]|max_length[25]|xss_clean',
		),

		array(
			'field' => 'dateOfBirth',
			'label' => 'Date of birth',
			'rules' => 'trim|numeric_dash|xss_clean',
		),
		
		array(
			'field' => 'address',
			'label' => 'Address',
			'rules' => 'trim|address|xss_clean',
		),

		array(
			'field' => 'city',
			'label' => 'City',
			'rules' => 'trim|required|alpha_punc|xss_clean',
		),
		
		array(
			'field' => 'state',
			'label' => 'State',
			'rules' => 'xss_clean',
		),

		array(
			'field' => 'zip',
			'label' => 'ZIP code',
			'rules' => 'valid_zip|xss_clean',
		),

		array(
			'field' => 'photo',
			'label' => 'photo',
			'rules' => 'check_filesize[1M]',
		),
		
		array(
			'field' => 'phone',
			'label' => 'Telephone',
			'rules' => 'valid_phone',
		),

		array(
			'field' => 'email',
			'label' => 'Email address',
			'rules' => 'trim|valid_email',
		),

		array(
			'field' => 'parentsNames',
			'label' => 'parents\' names',
			'rules' => 'trim|alpha_punc|xss_clean',
		),
	
	),
		
	'meetings/edit' => array(
	
		array(
			'field' => 'meetingTitle',
			'label' => 'Meeting title',
			'rules' => 'trim|required|alpha_punc|xss_clean',
		),

		array(
			'field' => 'date',
			'label' => 'Meeting date',
			'rules' => 'trim|required|valid_date|iso_date|xss_clean',
		),

		array(
			'field' => 'startTime',
			'label' => 'Starting time',
			'rules' => 'trim|required|time12to24|xss_clean',
		),

		array(
			'field' => 'endTime',
			'label' => 'Ending time',
			'rules' => 'trim|required|time12to24|xss_clean',
		),		
	),

        'attendance/signout' => array(
	
		array(
			'field' => 'person_name',
			'label' => 'Person\'s name:',
			'rules' => 'trim|required|alpha|xss_clean',
		),

		array(
			'field' => 'person_id',
			'label' => 'Person\'s ID:',
			'rules' => 'trim|required|is_natural|xss_clean',
		),
            ),
);

