# BadgeEntry
BadgeEntry attendance and access control system for children's activities.  Twitter Bootstrap based layout, updated to CodeIgniter optimized for WAMP installation.

## Origin
While looking for an open source project that I could modify to use as a controlled access system I came across [BadgeEntry](http://badgeentry.sourceforge.net/) by Scott Severance on Sourceforge.  Unfortunately this project was based on version 1.5.4 of [CodeIgniter](http://www.codeigniter.com).  Out of the box it caused all kinds of problems on recent versions of PHP due to deprecated code.

I have updated the code to work with CodeIgniter framework version 2.1.3 and added a Twitter Bootstrap templating feature.

***

## Features
- Monitor entry to events or meetings
- Up-to-date snapshot of current attendance during the meeting
- Record of attendance for all events, complete with the time everyone entered and exited
- Scan and print ID badges
- Twitter Bootstrap responsive layout
- Templating Engine
	- Twitter Bootstrap and Bootswatch Themes
	- Build your own themes
- Client Side Form Validation using CodeIgniter's Server Side rules.

***

## Configuration
The database configuration is found in `application/config/database.php`. You should change these settings to match your MySQL database.

The default configuration assumes that you will be installing this on a WAMP server on localhost under a parent directory called "badgeentry".  If this does not apply to your situation, the "base_url" will need to be changed in  `application/config/config.php`

	/*
	|--------------------------------------------------------------------------
	| Base Site URL
	|--------------------------------------------------------------------------
	|
	| URL to your CodeIgniter root. Typically this will be your base URL,
	| WITH a trailing slash:
	|
	|	http://example.com/
	|
	| If this is not set then CodeIgniter will guess the protocol, domain and
	| path to your installation.
	|
	*/
	$config['base_url']	= 'http://localhost/badgeentry/';

***

## Installation
BadgeEntry requires several prerequisites before it can be installed. They are
listed in doc/badgeentry/prerequisites.html. Please read the file
doc/badgeentry/install.html for installation instructions.



***

## Licence
BadgeEntry is provided in the hope that it will be useful, but without any
warranty, not even an implied warranty. See the relevant license for details.
Most of BadgeEntry is released under the terms of the GNU General Public
License, version 2 or any later version. BadgeEntry is built on the CodeIgniter
framework, which has its own license. A copy of each license is available in
/doc/badgeentry/licenses.

***



### Acknowledgments
[Scott Severance](http://www.scottseverance.us).
Scott was the originator of BadgeEntry.  My apologies if I mangled your code!

joshmoody / codeigniter-starter
Thanks to Josh Moody for contributing the Twitter Bootstrap and Bootswatch enabled CodeIgniter skeleton to which this version of BadgeEntry was ported.

CodeIgniter 2.1.3
CodeIgniter is a proven, agile & open PHP web application framework with a small footprint.

Twitter Bootstap
A sleek, intuitive, and powerful front-end framework for faster and easier web development.  Includes a grid based scaffolding system with HTML, CSS, and JS for responsive-capable layouts.  Generously made available by Twitter and authors Mark Otto and Jacob Thornton.

The following third-party libraries are included in this package:

- https://github.com/appleboy/CodeIgniter-Native-Session