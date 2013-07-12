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
<div class="well sidebar-nav span3">
				<ul class="nav nav-list">
					<li><?=anchor("people/edit", "Add new person")?></li>
					<li>Show
					
				<ul><?php if($this->uri->segment(2)): ?>
					<li><?=anchor('people', 'All')?></li> 
					<?php endif;
					if( $this->uri->segment(2) != 'kids'): ?><li><?=anchor('people/kids', 'Kids')?></li> 
					<?php endif;
					if( $this->uri->segment(2) != 'staff'): ?><li><?=anchor('people/staff', 'Staff')?></li>
					<?php endif;
					if( $this->uri->segment(2) != 'parents'): ?><li><?=anchor('people/parents', "Parents")?></li>
					<?php endif;
					if( $this->uri->segment(2) != 'guests'): ?><li><?=anchor('people/guests', "Guests")?></li>
					<?php endif; ?></ul></li>
					<?php if(isset($meetingInProgress) && $meetingInProgress): ?>
					<li><?=anchor('attendance', 'Current attendance')?></li>
					<?php endif; ?>
				</ul>
				</ul>
</div>
<!--/.well -->
<!--/span-->
<div class="span"> 
			<?php if($list === false): ?>
			<p>There are no people to show in this view.</p>
			<?php else: ?>
			<?php $this->table->set_template(array(
			'table_open' => '<table class="table-striped table-bordered table-condensed">',
			'row_alt_start' => '<tr class="alternate">'
			)); ?>
			<?php $this->table->set_heading($heading); ?>
			<?=$this->table->generate($list)?>
			<?php endif; ?>
</div>
