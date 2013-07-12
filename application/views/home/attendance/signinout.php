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

$baseURL = base_url();
$extraHeadData = "";

?>
<h2><?=$title?></h2>
<p>Current meeting: <?=$meetingTitle?> on <?=$meetingDate?>.</p>
<?=form_open("attendance/dosigninout/$mode", array('id' => "signInOutForm",'class' => "form-horizontal validate"))?>
<input type="hidden" name="person_id" id="person_id">
<?php echo validation_errors(); ?>
		<fieldset>
		<legend>Whom do you want to sign <?=($mode == "signin") ? 'in' : 'out'?>?</legend>
		<div class="control-group">
			<div class="controls">
                        <input type="text" placeholder="person's full name" name="person_name" id="person_name" class="person-typeahead">
			</div>
		</div>
		</fieldset>
		<div class="form-actions">
			<?=form_submit('','Save changes','class="btn btn-primary"'); ?>
		</div>
</form>   
<script>
    var person_url="<?php echo site_url('attendance/get_people')."/".$mode;?>";
   $(function($) {    
      _.compile = function(templ) {
         var compiled = this.template(templ);
         compiled.render = function(ctx) {
            return this(ctx);
         }
         return compiled;
      }
      $('.person-typeahead').typeahead({
         template: '<p><strong><%= name %></strong>:&nbsp;<%= id %></p>',
         name: 'people',
         valueKey: 'name',
         engine: _,
         remote: (person_url),
         dataType: 'json'
      }).on('typeahead:selected typeahead:autocompleted', function(event, datum) {
         $('#person_id').val(datum.id);
         $('#person_name').val(datum.name);


        });
   });
</script>
<?=jquery_validate('attendance/signout');?>