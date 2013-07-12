<?php

/*
 * BadgeEntry
 *
 * Copyright (C) 2007 Scott Severance <http://badgeentry.sourceforge.net>
 * Copyright (C) 2013 Clive S. Woodhouse <http://www.clivewoodhouse.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA
 * 02111-1307, USA.
 *
 * Authors:
 *  Scott Severance <http://www.scottseverance.us>
 *  Clive S. Woodhouse <http://www.clivewoodhouse.com> 
 *
 */

class Welcome extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->template->set('site_title', 'My Aweseome Site');
		$this->template->set('page_title', 'My Aweseome Site');

    }
	
	function index()
	{
        $configured = (isset($this->conf->option['config_level'])) ? $this->conf->option['config_level'] : -1;
        if($configured < 2) {
            header("Location: http://".$_SERVER['HTTP_HOST']."/badgeentry/index.php/configuration");
            exit;
        }
        if(
            (!isset($this->conf->option['version'])) ||
            (BADGEENTRY_VERSION != $this->conf->option['version'])
        ) redirect('configuration/upgrade');
		$data = array('title' => 'Control Panel');
		$this->load->view('home/welcome', $data);
	}
}
?>
