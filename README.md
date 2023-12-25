# Wordpress shortcode for Creative Commons-link with icons 

This wordpress plugin adds ahortcodes for showing that images (or other content) is used with a Creative Commons-license.
It's useful if you use images with such licenses often on your webpage. 

It's add the following shortcodes [CC-BY], [CC-BY-SA], [CC-BY-ND], [CC-BY-NC], [CC-BY-NC-ND] and [CC-BY-NC-SA]. 

Each shortcode will add a link to the appriopate license and icons to represent each license element. 

The icons are meant to be used with image captions, with the copyright statement. For instance like this:

> Photo by <a href="link to image file">(photographer)</a>, [CC-BY-SA] via Wikimedia Commons

To install, download all files as .zip-file and install the .zip-file. 

## Notes

If you add this with the shortcode block the icons won't be wrapped in any html, so put in group block first. 

The plugin can be translated so that the aria-labels, link title and the license text you link to is in your preferred language. 

To style the icons, add CCS to target the `.cc-icons` class (for the whole row of icons and link) or the `.cc-icon` class (for the svg icon). You can also add a class to the shortcode like this [CC-BY class="your-class"].
