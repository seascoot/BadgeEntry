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

 /*$extraHeadData = '<link href="'.base_url().'css/badge.css" rel="stylesheet" media="print" />'*/
?>
<h2><?=$title?></h2>
<div class="well sidebar-nav span3">
				<ul class="nav nav-list">
					<li><?=anchor("people/edit", "Add new person")?></li>
				</ul>
</div><!--/.well -->
<!--/span-->
<div class="span">
	<h3><?=$firstName.' '.$lastName?></h3>
		<div>
			<form method="post" action="<?=site_url()?>/attendance/dosigninout/<?=$mode?>"<?php if(!$mode) echo ' onsubmit="return false"'?>>
			<?=anchor("people/view/$id/badge.pdf", '<img src="'.base_url().'images/web/page_white_acrobat.png"  alt="PDF document" /> Generate badge', array('class' => 'btn btn-primary'))?>
			<?=anchor("reports/people/$id","Attendance report", array("class" => "btn btn-primary"))?>
			<button class="btn btn-primary" onclick="window.location = '<?=site_url()?>/people/edit/<?=$id?>';return false;">Edit person</button>
			<?php if($mode): ?>
			<input type="hidden" name="person_id" value="<?=$id?>" />
			<input type="hidden" name="name" value="<?="$firstName $lastName"?>" />
			<input type="hidden" name="redirect" value="/people/view/<?=$id?>" />
			<input type="submit" class="btn btn-primary" value="<?=($mode == "signin") ? "Sign in" : "Sign out"?>" />
			<?php endif ?>
			
			</form>
		</div>
			<?php if($hasPhoto): ?>
				<div class="large-photo">
					<img src="<?=base_url()?>images/photos/medium/<?=$id?>.jpg" alt="" class="photo" />
				</div>
				<?php else: ?>
				<div class="large-photo">No Photo</div>
				<?php endif ?>
				<table class="table">
					<tr>
						<th class="text-right">Type</th>
						<td><?=ucfirst($type)?></td>
					</tr>
					<tr>
						<th>Parents' Names</th>
						<td><?=$parentsNames?></td>
					</tr>
					<tr>
						<th>Address</th>
						<td><?=$address?><br /><?="$city, $state $zip"?></td>
					</tr>
					<tr>
						<th>E-mail Address</th>
						<td><a href="mailto:<?=$email?>"><?=$email?></a></td>
					</tr>
					<tr>
						<th>Date of Birth</th>
						<td><?=$dateOfBirth?></td>
					</tr>
					<tr>
						<th>Parents Must Check Out</th>
						<td><?=($parentsMustCheckOut === 'true') ? 'Yes' : 'No'?></td?
					</tr>
					<tr>
						<th>Time Added</th>
						<td><?=$timeAdded?></td>
					</tr>
					<tr>
						<th>Last Modified</th>
						<td><?=$lastModified?></td>
					</tr>
				</table>
</div><!--/span-->
<!--/row-->

<!-- div class="print">
    <?php $idFull = sprintf('%04d',$id) ?>
    <?php if($hasPhoto): ?><div class="photo"><img src="<?=base_url()?>images/photos/small/<?=$id?>.jpg" /></div><?php endif ?>
    <div class="name"><span class="firstName"><?=$firstName?></span> <span class="lastName"><?=$lastName?></span></div>
    <div class="barcode"><img src="<?=base_url()?>images/barcodes-39/rotated/<?=$idFull?>.png" /></div>
</div -->