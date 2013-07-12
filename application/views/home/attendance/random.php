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
<div class="container-fluid">
	<div class="row-fluid">
		<h2><?=$title?></h2>
		<p><big><b><?=$firstName?> <?=$lastName?></b></big></p>
		<p><?=anchor(
        'attendance/random/'.$who,
        'Pick another',
        array(
            'class' => 'button',
            'onclick' => "this.style.cursor = 'wait';
                          document.getElementsByTagName('BODY')[0].style.cursor = 'wait';
                          return true"
        )
		)?>
	</div>
</div>