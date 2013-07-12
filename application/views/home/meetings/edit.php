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
<?=messages();?>
<?=$this->form_validation->error_string?>
<?=form_open('meetings/edit',$attributes_form)?>
<?
//echo "<pre>" . print_r($GLOBALS, true) . "</pre>";
?>
<?php if(isset($id)) echo form_hidden("id",$id); ?>
	<?php echo validation_errors(); ?> 
	<fieldset>
		<div class="control-group">
			<label for="meetingTitle" class="control-label">
				<span class="required">*</span>Meeting title</label>
			<div class="controls">
				<input type="text" id="meetingTitle" name="meetingTitle" required="required" value="<?=set_value('meetingTitle', $meetingTitle);?>" />
			<?=form_error('meetingTitle');?>
			</div>
		</div>
		
		<div class="control-group">
			<label for="date" class="control-label">
				<span class="required">*</span>Date</label>
			<div class="controls">
				<input type="text" id="date" name="date" required="required" value="<?=set_value('date', $date);?>" />
			<?=form_error('date');?>
			</div>
		</div>		

		<div class="control-group">
			<label for="startTime" class="control-label">
				<span class="required">*</span>Start time</label>
			<div class="controls">
				<input type="text" id="startTime" name="startTime" required="required" value="<?=set_value('startTime', $startTime);?>" />
			<?=form_error('startTime');?>
			</div>
		</div>

		<div class="control-group">
			<label for="endTime" class="control-label">
				<span class="required">*</span>End time</label>
			<div class="controls">
				<input type="text" id="endTime" name="endTime" required="required" value="<?=set_value('endTime', $endTime);?>" />
			<?=form_error('endTime');?>
			</div>
		</div>
	<div class="form-actions">
	<?=form_submit('','Save changes','class="btn btn-primary"'); ?>
	</div>
</fieldset>
</form>
<?=jquery_validate('meetings/edit');?>