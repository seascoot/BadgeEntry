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
    <tr>
        <th>Photo</th>
        <th>Name</th>
        <th>Type</th>
        <th>Registration Time</th>
        <th>Last Activity</th>
    </tr>
    <?php $i = 1; foreach($list as $person): ?> 
    <tr<?php if($i%2 == 0) echo ' class="alternate"'?>>
        <td><?=($person['hasPhoto']) ? '<img src="'.base_url().'images/photos/small/'.$person['id'].'.jpg" alt="" />' : '&nbsp;' ?></td>
        <td><?=anchor('reports/people/'.$person['id'],$person['lastName'].', '.$person['firstName'])?></td>
        <td><?=$person['type']?></td>
        <td><?=$person['timeAdded']?></td>
        <td><?=$person['lastModified']?></td>
    </tr>
    <?php $i++; endforeach ?> 
</table>
