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

class Photo_upload {
    var $CI;
    
    function Photo_upload(&$instance) {
        $this->CI = $instance;
        $this->CI->load->library("image_lib");
        $this->CI->load->helper('file');
    }
    
    function upload_photo($filename, $id) {
        $opts["small"] = array(125,94);
        $opts["medium"] = array(200, 150);
        $opts["large"] = array(400, 300);
        foreach($opts as $size => $dimensions) {
            $this->resize_image($filename, "images/photos/${size}/${id}.jpg",$dimensions[0],$dimensions[1]);
        }
        unlink($filename);
        //print_r(array("upload_photo",$filename, $id));
        return true;
    }
    
    function resize_image($source_filename, $destination_filename, $height, $width, $keep_ratio = true) {
        //resize the image        
        $opt["image_library"] = 'GD2';
        $opt["source_image"] = $source_filename;
        $opt["new_image"] = $destination_filename;
        $opt["maintain_ratio"] = $keep_ratio;
        $opt["height"] = $height;
        $opt["width"] = $width;
        $this->CI->image_lib->clear();
        $this->CI->image_lib->initialize($opt);
        $this->CI->image_lib->resize();
        
        //rotate the image, if necessary
        $s = getimagesize($destination_filename);
        $w = $s[0];
        $h = $s[1];
        if($w > $h) {
            unset($opt);
            $opt["image_library"] = 'GD2';
            $opt["source_image"] = $destination_filename;
            $opt['rotation_angle'] = 270;
            //$opt['dynamic_output'] = true;
            //$opt['new_image'] = $destination_filename;
            $this->CI->image_lib->clear();
            $this->CI->image_lib->initialize($opt);
            if(!$this->CI->image_lib->rotate()) $this->CI->image_lib->display_errors('<pre>','</pre>');
        }
    }
}

//adapted from PHP manual comment on function imagerotate dated 23-Feb-2007
if(! function_exists("imagerotate")) {
    function imagerotate($src_img, $angle) {
        $src_x = imagesx($src_img);
        $src_y = imagesy($src_img);
        if ($angle == 180) {
            $dest_x = $src_x;
            $dest_y = $src_y;
        }
        elseif ($src_x <= $src_y) {
            $dest_x = $src_y;
            $dest_y = $src_x;
        }
        elseif ($src_x >= $src_y) {
            $dest_x = $src_y;
            $dest_y = $src_x;
        }
        
        $rotate=imagecreatetruecolor($dest_x,$dest_y);
        imagealphablending($rotate, false);
        
        switch ($angle) {
            case 270:
                for ($y = 0; $y < ($src_y); $y++) {
                    for ($x = 0; $x < ($src_x); $x++) {
                        $color = imagecolorat($src_img, $x, $y);
                        imagesetpixel($rotate, $dest_x - $y - 1, $x, $color);
                    }
                }
                break;
            case 90:
                for ($y = 0; $y < ($src_y); $y++) {
                    for ($x = 0; $x < ($src_x); $x++) {
                        $color = imagecolorat($src_img, $x, $y);
                        imagesetpixel($rotate, $y, $dest_y - $x - 1, $color);
                    }
                }
                break;
            case 180:
                for ($y = 0; $y < ($src_y); $y++) {
                    for ($x = 0; $x < ($src_x); $x++) {
                        $color = imagecolorat($src_img, $x, $y);
                        imagesetpixel($rotate, $dest_x - $x - 1, $dest_y - $y - 1, $color);
                    }
                }
                break;
            default: $rotate = $src_img;
        }
        return $rotate;
    }
}