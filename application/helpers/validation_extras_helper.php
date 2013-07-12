<?php
// Extra functions for form validation


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

function alpha_punc($str) {
    $pattern = '^[]a-z0-9 `~!@#$%^&*()_+=[{}\\|?;:\'",./-]+$';
    if(eregi($pattern, $str) || strlen($str) === 0) return true;
    else {
        $this->form_validation->set_message('alpha_punc','The %s field contains invalid characters');
        return false;
    }
}

function numeric_dash($str) {
    $pattern = '^[0-9-]+$';
    if(eregi($pattern, $str) || strlen($str) === 0) return true;
    else {
        $this->form_validation->set_message('numeric_dash','The %s field may only contain numbers and hyphens (-)');
        return false;
    }
}

function optional_min_length($str,$len) {
    if(strlen($str) == 0 || strlen($str) >= $len) return true;
    else {
        $this->form_validation->set_message('optional_min_length','The %s field must either be blank or contain at least $len characters');
    }
}

/*function optional_max_length($str, $len) {
    return (strlen($str) == 0 || strlen($str) <= $len) ? true : false;
}*/