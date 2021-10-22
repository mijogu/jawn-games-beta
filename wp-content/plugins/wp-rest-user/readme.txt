=== WP REST User ===
Contributors: jack50n9, sk8tech
Donate link: https://sk8.tech/donate?utm_source=plugin&utm_medium=forum&utm_campaign=wp-rest-user
Tags: wp, rest, api, rest api, user, acf, cpt, json
Requires at least: 4.7.0
Tested up to: 5.5
Requires PHP: 5.2.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
WP REST User adds in the 'User Registration' or 'Retrieve Password' function for REST API.
 
== Description ==

If you wish to 'Register User' or 'Retrieve Password' using REST API, *without* exposing Administrator credentials to the Front End application, you are at the right place. Since WordPress 4.7, REST API was natively included in WordPress. 

In order to 'Register User' or 'Retrieve Password', the authentication for a user with 'Administrator' role is required. While this is a delibrately done for security reasons, such implementation makes it very hard for Front End applications to implement a simple 'Register' or 'Sign Up' function.

This plugin fullfills such requirement by extending the existing WordPress REST API endpoints. 

= Usage =

== Register a User ==

To Register a User using REST API, send a `POST` request to `/wp-json/wp/v2/users/register`, with a **JSON body** (Set header: content-type: application/json):
`
{
	"username": "your-username",
	"email": "username@test.com",
	"password": "0000",
}
`
If successful, you should receive the following response
`
{
    "code": 200,
    "id": 13,
    "message": "User 'your-username' Registration was Successful"
}
`

To perform further actions after user is registered, write and add_action:

`
add_action('wp_rest_user_user_register', 'user_registered');
function user_registered($user) {
	// Do Something
}
`

== Reset Password ==

To Retrieve Password using REST API, send a `POST` request to ``/wp-json/wp/v2/users/lost-password`, including a **JSON body** (Set header: content-type: application/json):
`
{
    "user_login": "username@test.com"
}
`

`user_login` can be either user's username or email.

If successful, you should receive the following response
`
{
    "code": 200,
    "message": "Reset Password link has been sent to your email."
}
`

See the Screenshot below for POSTMAN demo:

= Technical Support =

**SK8Tech - Customer Success Specialist** offers **Technical Support** to configure or install ***WP REST User***.

= Our Services =
 * [SK8Tech Sydney Web Design](https://sk8.tech/web-design/?utm_source=plugin&utm_medium=forum&utm_campaign=wp-rest-user)
 * [SK8Tech Enterprise Email Hosting](https://sk8.tech/services/enterprise/email-hosting/?utm_source=plugin&utm_medium=forum&utm_campaign=wp-rest-user)
 * [SK8Tech Emergency IT Support](https://sk8.tech/services/enterprise/it-support/emergency-support/?utm_source=plugin&utm_medium=forum&utm_campaign=wp-rest-user)
 * [SK8Tech WeChat Advertising](https://sk8.tech/services/wechat/?utm_source=plugin&utm_medium=forum&utm_campaign=wp-rest-user)
 
== Installation ==
  
1. Upload `wp-rest-user` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
 
== Frequently Asked Questions ==
 
= Why do I need WP REST User? =
 
If you're planning on using your WordPress website as a Backend, and you're consuming RESTful api, you'll most probably need to Register User via REST API. This is precisely what this plugin does.

= Is it secure? =

Great question! For the time being, this plugin only allows registering user as 'subscriber' or 'contributor' role. 'Subscriber' role has very limited capability in terms what WordPress allows him/her to do. From our perspective, subscribers are quite harmless.

= Does it work with WooCommerce? =

Another great question! By default, WordPress registers new user as 'subscriber', while WooCommerce registers new user as 'customer'. 
If you have WooCommerce installed and activated on your WordPress website, this plugin will automatically register user as 'customer' as well.
 
= There's a bug, what do I do? =

Please create a ticket on the [support forum](https://wordpress.org/support/plugin/wp-rest-user/). We'll get back to you ASAP.
 
== Screenshots ==
 
1. An sample REST API POST request using [WP REST User](https://wordpress.org/plugins/wp-rest-user/).
 
== Changelog ==

= 1.4.3 =

* Tested up to WordPress 5.5
* Added `id` to register user response.
* Updated README
* Bug fixes

= 1.4.2 = 

* Fixed README.md
* Security Fix

= 1.4.1 = 

* Added an action hook when user is registered.

= 1.3.0 = 

* Added an end point for retrieve password email.

= 1.2.1 = 

* Changed success status code from 123 to 200

= 1.2.0 = 

* Now supports more roles, including
	1. subscriber
	1. customer
	1. contributor
	1. custom roles
 
= 1.1.0 =
* Now supports 'Customer' role to be registered, if WooCommerce plugin is installed 
* Restructured Plugin for future development.
 
= 1.0.1 =
* Initial Release. 
* Only user with 'Subscriber' role can be created.
* Only 'username', 'email', 'password' fields are accepted.

== Upgrade Notice ==

Nothing to worry! Install away!
 
== Contact Us ==

Based in Sydney, [SK8Tech](https://sk8.tech?utm_source=plugin&utm_medium=forum&utm_campaign=wp-rest-user) is a innovative company providing IT services to SMEs, including [Web Design](https://sk8.tech/web-design?utm_source=plugin&utm_medium=forum&utm_campaign=wp-rest-user), App Development and more.