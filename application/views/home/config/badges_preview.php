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
<h2><?=$title?></h2>

<p>Please verify that these images are the correct badge templates. Click on each image to view it full size. If they're incorrect, use the back button to review the instructions, then correct the problem.
<table class="table-striped table-bordered table-condensed">
    <tr>
        <th>Type</th>
        <th>Template</th>
    </tr>
    <tr>
        <td>Kid</td>
        <td><a href="<?=base_url()?>images/badges/kid.png"><img src="<?=base_url()?>images/badges/kid.png" width="550" /></a></td> 
    </tr>
    <tr>
        <td>Staff</td>
        <td><a href="<?=base_url()?>images/badges/staff.png"><img src="<?=base_url()?>images/badges/staff.png" width="550" /></a></td> 
    </tr>
    <tr>
        <td>Parent</td>
        <td><a href="<?=base_url()?>images/badges/parent.png"><img src="<?=base_url()?>images/badges/parent.png" width="550" /></a></td> 
    </tr>
    <tr>
        <td>Guest</td>
        <td><a href="<?=base_url()?>images/badges/guest.png"><img src="<?=base_url()?>images/badges/guest.png" width="550" /></a></td> 
    </tr>
</table>

<form method="post" action="<?=base_url()?>index.php/configuration/badges/confirm">
    <input type="hidden" name="been_here" value="2" />
    <input type="submit" value="The templates are correct. Continue &raquo;" />
</form>