<?php //plugin for verious time-related functions

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

function time12to24($time) {
    $time = trim($time);
    if(!$time) return false;
    
    $matches = array();
    $re = '/^([012]?[0-9])[:. -]([0-5][0-9])([ :.0-9-]*)([aApP][mM]?)?$/';
    $result = preg_match($re, $time, $matches);
    
    if(!$result) return false;
    $h = $matches[1];
    $m = $matches[2];
    $ap = (isset($matches[4])) ? $matches[4] : 'am';
    $pm = (strpos(strtolower($ap), 'p') === false) ? false : true;
    if($pm) $h += 12;
    if($h == 24) $h = 0;
    elseif($h > 24) return false;
    
    return sprintf('%02u:%02u', $h, $m);
}

function time24to12($time) {
    $time = trim($time);
    if(!$time) return false;
    $matches = array();
    $re = '/^([012]?[0-9])[:. -]([0-5][0-9])[ :.0-9-]*([aApP][mM]?)?$/';
    $result = preg_match($re, $time, $matches);
    if(!$result) return false;
    
    $h = $matches[1];
    $m = $matches[2];
    $ap = (isset($matches[3])) ? $matches[3] : 'AM';
    if($h >= 12) {
        $h -= 12;
        $ap = 'PM';
    }
    if($h == 0) $h = 12;
    
    return sprintf('%u:%02u %s', $h, $m, $ap);
}

function iso_date($date) {
    // parses about any date string into an ISO 8601 time
    
    $timestamp = strtotime($date);
    if($timestamp === false || $timestamp < 100) return false;
    return date('Y-m-d', $timestamp);
}