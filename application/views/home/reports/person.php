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

$extraHeadData = '<link href="'.base_url().'css/print_report.css" rel="stylesheet" media="print" />';
?>
<h2 class="screen"><?=$title?></h2>
<? /*
$title
$name
$id
*/ ?>
<?=anchor("people/view/$id", "$name&rsquo;s Details", array('class' => 'button'))?>
<table>
    <tr>
        <th>Meeting</th>
        <th>Attendance</th>
    </tr>
    <? $i=1; foreach($list as $mtg): ?> 
    <tr<? if($i%2 == 0) echo ' class="alternate"' ?>>
        <td><?=anchor('reports/attendance/'.$mtg[0]['meeting_id'],$mtg[0]['meetingTitle']).'<br />'.$mtg[0]['date']?></td>
        <td>
            <ul class="compact">
                <? foreach($mtg as $event): ?> 
                <li><?=$event['time']?>: <?=$event['type']?></li>
                <? endforeach ?> 
            </ul>
        </td>
    </tr>
    <? $i++; endforeach ?> 
</table>
<? /*echo "<pre>" . print_r($list, true) . "</pre>";*/ ?>