<?=messages();?>

<p>Please complete the form below. Required fields are marked with "<span class="required">*</span>".</p>

<form method="POST" action="<?=site_url('home/demoform');?>" class="form-horizontal validate">

	<?php echo validation_errors(); ?>

	<fieldset>

	<div class="control-group">
		<label for="name" class="control-label">Name</label>
		<div class="controls">
			<input type="text" id="name" name="name" required="required" value="<?=set_value('name', $name);?>" />
			<?=form_error('name');?>
		</div>
	</div>

	<div class="control-group">
		<label for="address" class="control-label">Address</label>
		<div class="controls">
			<input type="text" id="address" name="address" class="address" value="<?=set_value('address', $address);?>" />
			<?=form_error('address');?>
		</div>
	</div>

	<div class="control-group">
		<label for="city" class="control-label">City</label>
		<div class="controls">
			<input type="text" id="city" name="city" value="<?=set_value('city', $city);?>" />
			<?=form_error('city');?>
		</div>
	</div>

	<div class="control-group">
		<label for="state" class="control-label">State</label>
		<div class="controls">
			<select id="state" name="state">
				<option value="">Choose State</option>
				<option value="AL">Alabama</option>
				<option value="AK">Alaska</option>
				<option value="AZ">Arizona</option>
				<option selected="selected" value="AR">Arkansas</option>
				<option value="CA">California</option>
				<option value="CO">Colorado</option>
				<option value="CT">Connecticut</option>
				<option value="DE">Delaware</option>
				<option value="DC">District of Columbia</option>
				<option value="FL">Florida</option>
				<option value="GA">Georgia</option>
				<option value="HI">Hawaii</option>
				<option value="ID">Idaho</option>
				<option value="IL">Illinois</option>
				<option value="IN">Indiana</option>
				<option value="IA">Iowa</option>
				<option value="KS">Kansas</option>
				<option value="KY">Kentucky</option>
				<option value="LA">Louisiana</option>
				<option value="ME">Maine</option>
				<option value="MD">Maryland</option>
				<option value="MA">Massachusetts</option>
				<option value="MI">Michigan</option>
				<option value="MN">Minnesota</option>
				<option value="MS">Mississippi</option>
				<option value="MO">Missouri</option>
				<option value="MT">Montana</option>
				<option value="NC">North Carolina</option>
				<option value="ND">North Dakota</option>
				<option value="NE">Nebraska</option>
				<option value="NH">New Hampshire</option>
				<option value="NJ">New Jersey</option>
				<option value="NM">New Mexico</option>
				<option value="NV">Nevada</option>
				<option value="NY">New York</option>
				<option value="OH">Ohio</option>
				<option value="OK">Oklahoma</option>
				<option value="OR">Oregon</option>
				<option value="PA">Pennsylvania</option>
				<option value="RI">Rhode Island</option>
				<option value="SC">South Carolina</option>
				<option value="SD">South Dakota</option>
				<option value="TN">Tennessee</option>
				<option value="TX">Texas</option>
				<option value="UT">Utah</option>
				<option value="VT">Vermont</option>
				<option value="VA">Virginia</option>
				<option value="WA">Washington</option>
				<option value="WI">Wisconsin</option>
				<option value="WV">West Virginia</option>
				<option value="WY">Wyoming</option>
			</select>
			<?=form_error('state');?>
		</div>
	</div>

	<div class="control-group">
		<label for="zip" class="control-label">Zip Code</label>
		<div class="controls">
			<input type="text" id="zip" name="zip" class="zip" value="<?=set_value('zip', $zip);?>" />
			<?=form_error('zip');?>
		</div>
	</div>

	<div class="control-group">
		<label for="phone" class="control-label">Phone</label>
		<div class="controls">
			<input type="tel" id="phone" name="phone" value="<?=set_value('phone', $phone);?>" />
			<?=form_error('phone');?>
		</div>
	</div>

	<div class="control-group">
		<label for="email" class="control-label">Email</label>
		<div class="controls">
			<input type="email" id="email" name="email" value="<?=set_value('email', $email);?>" />
			<?=form_error('email');?>
		</div>
	</div>
	
	<div class="control-group">
		<label for="url" class="control-label">Website</label>
		<div class="controls">
			<input type="url" id="url" name="url" value="<?=set_value('url', $url);?>" />
			<?=form_error('url');?>
		</div>
	</div>

	<div class="form-actions">
		<input type="submit" class="btn btn-primary" value="Submit" />
	</div>								

</form>

<?=jquery_validate('home/demoform');?>