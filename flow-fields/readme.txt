=== Flow Fields ===
Contributors: Wojciech Borowicz
Tags: custom fields, meta boxes, ACF, 
Requires at least: 5.0
Tested up to: 6.1.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Flow Fields is a WordPress plugin that allows you to easily add custom fields to your posts, pages, and other custom post types. It is designed to be lightweight and intuitive, while providing a robust set of features for managing custom fields.

With Flow Fields, you can create custom meta boxes with fields such as text, number, date, file, image, textarea, repeater, and more. You can also set default values, specify required fields, and add instructions for each field.

In the near future, we plan to add support for custom post type management, taxonomies, and shortcodes.

== Installation ==

    Upload the flow-fields folder to the /wp-content/plugins/ directory.
    Activate the plugin through the 'Plugins' menu in WordPress.

== Usage ==

To create a custom meta box with fields, go to the "Flow Boxes" menu in the WordPress dashboard and click "Add New Box". Give your meta box a title and select the post types that it should apply to. Submit the box, then click "Fields & Options" Then, click "Add Field" to add a field to your meta box.

There are many different field types to choose from, including text, number, date, file, image, textarea, repeater, and more.

Once you've added all of your fields, click "Save Meta Box" to save your changes. Your custom meta box will now be displayed on the edit screen for your selected post types.

To get the value of a custom field in your code, you can use the get_field() function. This function takes three parameters: the field's key and the post ID and format (sanitizes data on true/false). It will return the value of the field for the given post.

== Frequently Asked Questions ==

= What post types does Flow Fields support? =

Flow Fields supports all post types, including posts, pages, and custom post types.

= Is Flow Fields a stable release? What can I expect in future updates? = 

Flow Fields is currently in alpha release, which means that while it's fully functional, it's still being actively developed and tested. In future updates, we plan to add many more options and features to make it a more robust and powerful tool for managing custom fields in WordPress. We'll be adding support for custom post types, taxonomies, and shortcodes, as well as improving the overall user experience and adding more flexibility to the fields themselves. Keep an eye out for updates and feel free to contact us with any feedback or feature requests.


== Changelog ==

= 1.0.0 =

    Initial release of Flow Fields.

== Upgrade Notice ==

= 1.0.0 =
Initial release of Flow Fields. No upgrade required.