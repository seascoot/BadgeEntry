#!/bin/bash
##
## BadgeEntry
##
## Copyright (C) 2007 Scott Severance <http://badgeentry.sourceforge.net>
##
## This program is free software; you can redistribute it and/or
## modify it under the terms of the GNU General Public License as
## published by the Free Software Foundation; either version 2 of the
## License, or (at your option) any later version.
##
## This program is distributed in the hope that it will be useful, but
## WITHOUT ANY WARRANTY; without even the implied warranty of
## MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
## General Public License for more details.
##
## You should have received a copy of the GNU General Public License
## along with this program; if not, write to the Free Software
## Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA
## 02111-1307, USA.
##
## Author:
##  Scott Severance <http://www.scottseverance.us>
##

# Barcode generation script. Requires GNU Barcode and ImageMagick, along
# with the Bash shell. Linux and Mac users already have Bash; Windows
# users will need to install Cygwin or something similar. I don't know
# whether either GNU Barcode or ImageMagick is available for any system
# other than Linux.

###############################################################################
##  Usage instructions: run this script with no arguments for instructions.  ##
###############################################################################

# Change the variable below to select the type of barcodes you want. Refer
# to the GNU Barcode documentation for a list of supported types. The default,
# Code 39, is adequate for most situations.
barcodeType="code39"



###############################################################################
## Don't change anything below here unless you know what you're doing.
prog="$0"

function usage {
    echo "Usage:"
    echo "    $prog [--rotate] start-number end-number pad-digits output-directory"
    echo
    echo "        --rotate:         If specified, then barcodes will be oriented"
    echo "                          vertically instead of horizontally. This flag is"
    echo "                          optional."
    echo
    echo "        start-number:     Provide the number of the first barcode. E.g., 0"
    echo
    echo "        end-number:       Provide the number for the last barcode. E.g., 9999"
    echo
    echo "        pad-digits:       How many digits are in the barcode? If you use some"
    echo "                          other than 4, you'll need to modify BadgeEntry"
    echo "                          accordingly."
    echo
    echo "        output-directory: In which folder should the barcodes be saved?"
    echo "                          If you type a dot (.), they will be saved in the"
    echo "                          current directory, $(pwd)."
    exit 0
}

function makeBarcodes {
    if [ "$1" = '--rotate' ]; then
        local rotate=' -rotate 90'
        shift
    else local rotate=
    fi
    local start="$1"
    local end="$2"
    local digits="$3"
    local dir="$4"

    [ "$dir" = '.' ] && dir="$(pwd)"
    builtin cd "$dir"

    for i in $(seq "$start" "$end"); do
        local j="$(printf "%0${digits}d" "$i")"
        echo -n "$j "
        barcode -b "$j" -e "$barcodeType" -E -n -u mm -g 100x30+0+0 | convert - -quality 100$rotate "${j}.png"
    done
    echo
}

function main {
    [ "$#" -lt 4 -o "$1" = "--help" ] && usage
    makeBarcodes "$@"
}

main "$@"
