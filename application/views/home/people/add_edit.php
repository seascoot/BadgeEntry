<?php 

/*
 * BadgeEntry
 *
 * Copyright (C) 2007 Scott Severance <http://badgeentry.sourceforge.net>
 * Copyright (C) 2013 Clive S. Woodhouse
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
 *  Clive S. Woodhouse
 */

?>
 
<h2><?=$title?></h2>
<?=messages();?>
<div class="span3">
	<div class="well sidebar-nav">
	</div><!--/.well -->
</div><!--/span-->
<div class="span9">
		<p>Please complete the form below. Required fields are marked with "<span class="required">*</span>".</p>
		<?php echo form_open_multipart('people/edit',$attributes_form);?>
		<? if(isset($id)) echo form_hidden("id",$id); ?>
		<?php echo validation_errors(); ?> 
		<fieldset>
			<legend>ID Type</legend>
				
			<div class="control-group">
				<label for="type" class="control-label">
				<span class="required">*</span>Select type</label>
				<div class="controls">
					<?=form_dropdown('type',$person_type,(isset($type)) ? $type :'Please select a category...','id="type"');?>
					<?=form_error('');?>
				</div>
			</div>

		</fieldset>
		<fieldset>
			<legend>Personal Information</legend>
			<div class="control-group">
				<label for="firstName" class="control-label">
					<span class="required">*</span>First name</label>
				<div class="controls">
					<input type="text" id="firstName" name="firstName" required="required" value="<?=set_value('firstName', $firstName);?>" />
				<?=form_error('firstName');?>
				</div>
			</div>
		
			<div class="control-group">
				<label for="lastName" class="control-label">
					<span class="required">*</span>Last name</label>
				<div class="controls">
					<input type="text" id="lastName" name="lastName" required="required" value="<?=set_value('lastName', $lastName);?>" />
				<?=form_error('lastName');?>
				</div>
			</div>
				
			<div class="control-group">
				<label for="dateOfBirth" class="control-label">
					<span class="required">*</span>Date of birth</label>
				<div class="controls">
					<input type="text" id="dateOfBirth" name="dateOfBirth" placeholder="YYYY-MM-DD" required="required" value="<?=set_value('dateOfBirth', $dateOfBirth);?>" />
				<?=form_error('dateOfBirth');?>
				</div>
			</div>
			

					
			<div class="control-group">
				<label for="address" class="control-label">
					<span class="required">*</span>Street address</label>
				<div class="controls">
					<input class="input-large" type="text" id="address" name="address" placeholder="Street" required="required" value="<?=set_value('address', $address);?>" />
				<?=form_error('address');?>
				</div>	
			</div>
					
			<div class="control-group">
				<label for="city" class="control-label">
					<span class="required">*</span>City</label>
				<div class="controls">
					<input class="input-large" type="text" id="city" name="city" placeholder="City" required="required" value="<?=set_value('city', $city);?>" />
				<?=form_error('city');?>
				</div>
			</div>
			
			<div class="control-group">
				<label for="state" class="control-label">
					<span class="required">*</span>State</label>
				<div class="controls">
				<?=form_dropdown('state',$stateList,(isset($state)) ? $state :'Please select a state...',$state_id)?>
				<?=form_error('state');?>
				</div>
			</div>		
			
			<div class="control-group">
				<label for="city" class="control-label">
					<span class="required">*</span>ZIP code</label>
				<div class="controls">
					<input class="input-large" type="text" id="zip" name="zip" placeholder="XXXXX-XXXX" required="" value="<?=set_value('zip', $zip);?>" />
				<?=form_error('zip');?>
				</div>
			</div>

			<div class="control-group">
				<label for="city" class="control-label">
					<span class="required">*</span>Telephone</label>
				<div class="controls">
					<input class="input-large" type="text" id="phone" name="phone" placeholder="(123) 456-7890" required="required" value="<?=set_value('phone', $phone);?>" />
				<?=form_error('phone');?>
				</div>
			</div>

			<div class="control-group">
				<label for="city" class="control-label">
					<span class="required">*</span>Email address</label>
				<div class="controls">
					<input class="input-large" type="text" id="email" name="email" placeholder="xxxx@xxxx.xxx" required="" value="<?=set_value('email', $email);?>" />
				<?=form_error('email');?>
				</div>
			</div>		

			
				<?/*=$this->form_builder->multi(
					array('firstName', 'lastName'), 
					'* First / Last names', 
					array(Form_builder::$TYPES->TEXT, Form_builder::$TYPES->TEXT), 
					array('', ''), 
					array('span3', 'span7'),
					array('First', 'Last')
					);
				?>
				<?=$this->form_builder->date('', '', '', '', '');
					$this->form_builder->text('', '', '', 'input-large', '');
					$this->form_builder->text('', '', '', 'input-large', '');
					$this->form_builder->option('', '', $stateList, '');
					$this->form_builder->text('zip', 'ZIP code', '', 'input-large', '');
					$this->form_builder->text('email', 'email address', '', 'input-large', 'who@where.com');
				*/?>
		</fieldset>
		<fieldset>
			<legend>Photo</legend>
				<? if(isset($id) && $hasPhoto == 'true'): ?>
							<p><img src="<?=base_url()?>images/photos/small/<?=$id?>.jpg" alt="Photo" class="photo" /></p>
							Upload a new photo: 
						<? endif; ?>
					<div class="form-actions">
						<?=form_upload("photo",'','class="btn btn-primary"') /*field will never be pre-populated*/?>
					</div>
		</fieldset>
			<fieldset>
			<legend>Parent Information</legend>
				<div class="control-group">
					<label for="parentsNames" class="control-label">Parents' names</label>
					<div class="controls">
						<input class="input-large" type="text" id="parentsNames" name="parentsNames" placeholder="Full Names" required="required" value="<?=set_value('parentsNames', $parentsNames);?>" />
						<?=form_error('parentsNames');?>
					</div>
					
					<label class="checkbox">
					<input type="checkbox" value="<?=set_checkbox('parentsMustCheckOut');?>"> Parent must sign out the person
					</label>
				</div>
				
				<?/*=$this->form_builder->text('parentsNames', 'Parents\' names', '', 'input-large');
					$this->form_builder->checkbox('Parents must sign kid out', 'parentsMustCheckOut', 'true', 0);*/
				?>
		</fieldset>

		<div class="form-actions">
		<?=form_submit('','Save changes','class="btn btn-primary"'); ?>
		</div>

	</form>
</div>
<?=jquery_validate('people/edit');?>