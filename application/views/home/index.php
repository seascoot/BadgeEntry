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
<h2><?=$page_title?></h2>
<p>Welcome to BadgeEntry. Please select a function:</p>
<ul>
  <li><?=anchor('people','Add or modify people')?></li>
  <li><?=anchor('meetings','Edit meetings, and select check in or check out mode')?></li>
  <li><?=anchor('attendance','Check or modify attendance, and choose random kids')?></li>
  <li><?=anchor("reports","Generate reports")?></li>
  <hr />
  <li><?=anchor('kiosk','Enter kiosk mode')?></li>
  <hr />
  <li><?=anchor('configuration','Configure BadgeEntry')?></li>
</ul>
