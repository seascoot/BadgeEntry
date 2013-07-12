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
			<ul><?php if($showAll): ?>
				<li><?=anchor("meetings", "Hide past meetings")?></li>
				<?php else: ?>
				<li><?=anchor("meetings/all", "Show all meetings")?></li> 
				<?php endif; ?>
				<li><?=anchor("meetings/add", "Add new meeting")?></li>
			</ul>
<!--/.well -->
</div><!--/span-->
<div class="span">
	<?php if($list === false): ?>
		<p>There are no meetings to show in this view.</p>
	<?php else: ?>
		<?php $this->table->set_template(array(
        'table_open' => '<table class="table table-striped table-bordered">',
        'row_alt_start' => '<tr class="alternate">'
		)); ?>
		<?php $this->table->set_heading($heading); ?>
		<?=$this->table->generate($list)?>
	<?php endif; ?>
<!--/row-->
</div><!--/span-->