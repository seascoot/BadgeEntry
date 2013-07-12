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

$pwd = getcwd();
?>
<h2><?=$title?></h2>

<h3 class="text">Information</h3>
<p>Now it's time to create your badge templates. If you want to use the default badges, scroll to the bottom of the page. Otherwise, you need to create the following badges:
<ul>
    <li><code><?=$pwd?>/images/badges/kid.png</code> (for kids)</li>
    <li><code><?=$pwd?>/images/badges/staff.png</code> (for staff members)</li>
    <li><code><?=$pwd?>/images/badges/parent.png</code> (for parents)</li>
    <li><code><?=$pwd?>/images/badges/guest.png</code> (for for guests or other people)</li>
    <li><code><?=$pwd?>/images/badges/oneTime.png</code> (optional; for hand writing badges in case you don't immediately have time to print them)</li>
</ul>
You can omit one of these badges if you won't be using that particular category.</p>
<p>The badge templates need to meet these specifications:</p>
<ul>
    <li>They must be PNG images. <i>Due to limitations in the library that generates the badges, your PNG images cannot have an alpha channel (used for transparency).</i></li>
    <li>They must be 2017 pixels wide by 1206 pixels high.</li>
    <li>Be sure to leave room for printer margins.</li>
    <li>All types of badge will have the photo (optional), name, and barcode in the same position. Be sure to leave room for them.</li>
    <li>If you want to change the position of the photo, name, or barcode (horizontal barcodes are also included with BadgeEntry), you can make the settings in the function <code>_generatePDF()</code> found in <code><?=APPPATH?>controllers/people.php</code>. This, however, is not for the faint of heart.</li>
</ul>
<img src="<?=base_url()?>images/web/sample_badge.png" class="photo" style="float:left" />
<p>Here's a sample badge template that shows where the photo, name, and barcode go. A full-sized sample is located in the folder <code><?=$pwd?>/<wbr>images/<wbr>badges</code>. There is both a PNG image and an XCF image. XCF is <a href="http://www.gimp.org">The GIMP's</a> native file format, and it's a good place to start when you're ready to design your own templates. (The GIMP is a free image editor available for <a href="http://www.gimp.org/unix/">Linux</a>, <a href="http://www.gimp.org/windows/">Windows</a>, and <a href="http://www.gimp.org/macintosh/">MacOS X</a>. Of course, you're free to use a different editor if you want.)</p>
<h2 class="text" style="clear:both">To Continue...</h2>
<p>Once you've made your templates, save them in the locations given above. When that's done, or if you want to use the default templates, click the continue button below.</p>
<form method="post" action="<?=base_url()?>index.php/configuration/badges/confirm">
    <input type="hidden" name="been_here" value="1" />
    <input type="submit" value="Continue &raquo;" />
</form>