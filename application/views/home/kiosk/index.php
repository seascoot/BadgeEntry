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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Kiosk Mode - BadgeEntry</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <link rel="stylesheet" href="<?=base_url()?>assets/css/kiosk.css" />
        <script type="text/javascript" src="<?=base_url()?>assets/js/kiosk.js"></script>
        <script type="text/javascript" src="<?=base_url()?>assets/js/prototype.js"></script>
        <script type="text/javascript">
            var currentMode = '<?=$modeRaw?>';
            var base_url = '<?=base_url()?>';
        </script>
    </head>
    <body>
        <h2>West Seattle Food Bank Access Control Station</h2>
        <div id="meeting">
            <p>Current Meeting: <b><?=$meetingTitle?></b></p>
            <p>Current Mode: <b><?=$mode?></b></p>
        </div>
        <div id="welcome">
            <div class="event"><?=$event?></div>
            <div class="warning" id="warning">Security Checkpoint<p>Security Clearance Required!</p></div>
            <div class="instructions" id="instructions">Please scan your badge to continue.</div>
        </div>
        <form method="post" action="<?=site_url()?>/kiosk/process" id="idForm">
            <input type="hidden" name="mode" value="<?=$modeRaw?>" />
            <input type="text" name="id" id="idBox" />
        </form>
        <div id="newMode"><?=$modeRaw?></div>
    </body>
</html>