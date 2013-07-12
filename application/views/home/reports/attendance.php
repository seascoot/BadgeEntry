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
<table class="table-striped table-bordered table-condensed">
    <?php $i=1;foreach($list as $meeting): ?> 
        <tr<?php if($i % 2 == 0) echo ' class="alternate"' ?>>
            <td><?=($isMeeting) ? $meeting['meetingTitle'] : anchor("reports/attendance/".$meeting['id'], $meeting['meetingTitle'])?><br />
                <?=$meeting['date']?> <?=$meeting['startTime']?>&nbsp;- <?=$meeting['endTime']?></td>
            <td>
                <ul class="compact">
                    <li><?=$meeting['mode']?></li>
                    <?php if($meeting['started']):?><li>Sign in began: <?=$meeting['started']?></li><?php endif ?> 
                    <?php if($meeting['ended']):?><li>Meeting closed out: <?=$meeting['ended']?></li><?php endif ?> 
                </ul>
            </td>
            <?php if($isMeeting && isset($meeting['people'])): ?> 
        </tr>
        <tr>
            <td colspan="2">Attendance
                <table width="100%">
                    <?php $j = 0; foreach($meeting['people'] as $id => $person): 
                    $person = array_merge($person); ?> 
                        <tr<?php if($j % 2 == 0) echo ' class="alternate"'?>>
                            <th><?=anchor("reports/people/$id",$person[0]['name'])?></th>
                            <?php foreach($person as $v): ?>
                            <td><?=$v['type']?> <?=$v['time']?></td> 
                            <?php endforeach ?> 
                        </tr>
                    <?php $j++; endforeach ?>
                </table>
            </td>
            <?php elseif($isMeeting && (!isset($meeting['people']))): ?>
        </tr>
        <tr>
            <td>No one has been to this meeting yet.</td>
            <?php endif ?> 
        </tr>
    <?php $i++; endforeach ?>
</table>
