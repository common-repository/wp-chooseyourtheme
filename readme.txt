 === WP CHOOSE YOUR THEME ===
Contributors: Giovambattista Fazioli
Donate link: http://labs.saidmade.com
Tags: Theme, Manager,
Requires at least: 2.7.1
Tested up to: 2.7.1
Stable tag: 0.6

WP CHOOSE YOUR THEME, let to select an avaiable theme to your visitors.

== Description ==

WP CHOOSE YOUR THEME, let to select an avaiable theme to your visitors. In your template, for example in sidebar.php, insert: `<?php wp_chooseyourtheme(); ?>` and a combo menu list shows the themes avaiable. When a your visitor click on item, the theme is changed.
For defautl all themes are shows. Use Admin configuration `Appearance -> WP Choose Your Theme` to hidden some themes.

= Arguments =

You can set args `mode` in:

*COMBO MENU*

`<?php wp_chooseyourtheme(); ?>` for combo menu or
`<?php wp_chooseyourtheme("mode=menu"); ?>`

`
<select class="wpcyt_combo">
 <option>Theme name 1</option>
 <option>Theme name 2</option>
 <option>Theme name ...</option>
</select>
`

*LIST*

`<?php wp_chooseyourtheme("mode=list"); ?>` for list. 

`
<ul class="wpcyt_list">
 <li class="theme-name-1"><a href="..."><span>Theme name 1</span></a></li>
 <li class="theme-name-2 selected"><a href="..."><span>Theme name 2</span></a></li>
 <li class="theme-name-..."><a href="..."><span>Theme name ...</span></a></li>
</ul>
`

*ROLL*

`<?php wp_chooseyourtheme("mode=roll"); ?>` for roll.

`
<div class="wpcyt_roll">
 <a class="next-theme" href="#"><span>Next Theme</span></a>
</div>
`

= Related Links =

* [Saidmade](http://www.saidmade.com/ "Creazione siti Web")
* [Undolog](http://www.undolog.com/ "Author's Web")

== Screenshots ==

== Installation ==

1. Upload the entire content of plugin archive to your `/wp-content/plugins/` directory, 
   so that everything will remain in a `/wp-content/plugins/wp-chooseyourtheme/` folder
2. Activate the plugin through the 'Plugins' menu in WordPress (deactivate and reactivate if you're upgrading).
3. Open the plugin configuration page, which is located under `Appearance -> WP Choose Your Theme`
4. Select the Themes you want to make hidden
5. Insert in your template php `<?php wp-chooseyourtheme(); ?>` function
6. Done. Enjoy.

== Thanks ==

== Frequently Asked Questions == 

== Changelog ==

History release:

`
* 0.6     Rev HTML output for list and roll mode: add slug theme name class
* 0.5     Add Admin in backend under Appearance. Rev code and avoid Javascript.
* 0.2     Rev
* 0.1     First release
`
