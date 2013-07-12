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

$extraHeadData = <<<END
<style type="text/css">
    input[type=text] {
        width: 80%;
    }
</style>
END;
?>
<h2><?=$title?></h2>

<?php if (isset($message) && $message): ?>
<div class="message"><?=$message?></div>
<?php endif; ?>

<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
    <table class="form">
        <tbody>
            <tr>
                <th>Base URL</th>
                <td>
                    <p>This is the address of your BadgeEntry installation. By default, it uses your server's IP address, <?=$_SERVER['SERVER_ADDR']?>. If your server is known by some other name (e.g., if you typed something different into your web browser's address bar), change it here. Also, if you're installing BadgeEntry into a subfolder below your server's root (in other words, if you have to type "http://your-server/some_folder"), be sure to include that here, as well.</p>
                    <p>WARNING: If you use the IP address 127.0.0.1, BadgeEntry will not work across the network. That's because 127.0.0.1 is a special address that always refers to the local machine, never to a remote server.</p>
                    <input type="text" name="baseURL" value="<?=$baseURL?>" />
                </td>
            </tr>
            <tr class="alternate">
                <th>Event Name</th>
                <td>
                    <p>What is the name of this event? For example: <?=date('Y')?> South Church VBS</p>
                    <input type="text" name="event_name" value="<?=$event_name?>" />
                </td>
            </tr>
            <tr>
                <th>Profiling</th>
                <td>
                    <p>Should BadgeEntry print timing and query statistics? This is mainly of interest to developers.</p>
                    <input type="radio" name="profiling" value="yes"<?php if($profiling) echo ' checked="checked"'?> /> Yes
                    <br /><input type="radio" name="profiling" value="no"<?php if(!$profiling) echo ' checked="checked"'?> /> No
                </td>
            </tr>
            <tr class="alternate">
                <th>&nbsp;</th>
                <td><?=form_submit("","Save")?> <input type="reset" value="Start over" /></td>
            </tr>
        </tbody>
    </table>
</form>