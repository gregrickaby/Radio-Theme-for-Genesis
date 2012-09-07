<h3>RADIO THEME v1.3</h3>
<a href="http://radio.gregrickaby.com">http://radio.gregrickaby.com</a>

<h3>REQUIREMENTS</h3>
1. <a href="http://wordpress.org">WordPress</a> 3.3 or above.
2. <a href="http://gregrickaby.com/go/genesis-theme">Genesis Framework</a> v1.8 or above.
3. Read/Write permissions (775) on the /radio/<strong>custom/</strong> folder.

<h3>INSTALL</h3>
1. Upload the theme folder via FTP to your wp-content/themes/ directory.
2. Go to your WordPress dashboard and select <a href="/wp-admin/themes.php">Appearance</a>.
3. Activate the Radio Child Theme.
4. Inside your WordPress dashboard, go to Genesis > <a href="/wp-admin/admin.php?page=radio-theme-settings">Radio Settings</a> to configure.
5. Rename /custom-sample/ to /custom/

<h3>IMAGES</h3>
- <strong>Nivo slider 960x300 pixels.</strong> TimThumb will automatically crop and resize.
- <strong>Featured images 370x150 pixels.</strong> WordPress will automatically crop and resize.

<h3>WIDGET AREAS</h3>
- <strong>Primary Sidebar</strong> - This is the primary sidebar.
- <strong>Header Right</strong> - This is the widgeted area that appears at the top right of the header.
- <strong>Home Middle</strong> - This is the widgeted area that appears on the middle of the hompage.
- <strong>Footer 1</strong> - This is a widgeted area that appears on the bottom of every page.
- <strong>Footer 2</strong> - This is a widgeted area that appears on the bottom of every page.
- <strong>Footer 3</strong> - This is a widgeted area that appears on the bottom of every page.

<h3>RECOMMENDED PLUG-INS</h3>
- <a href="http://wordpress.org/extend/plugins/dj-rotator-for-wordpress/" target="_blank">DJ Rotator For WordPress</a>
- <a href="http://wordpress.org/extend/plugins/nextgen-gallery/" target="_blank">NextGen Gallery</a>
- <a href="http://www.gravityforms.com/" target="_blank">Gravity Forms</a>
- <a href="http://wordpress.org/extend/plugins/genesis-simple-edits/" target="_blank">Genesis Simple Edits</a>
- <a href="http://wordpress.org/extend/plugins/disqus-comment-system/" target="_blank">Disqus Comment System</a>
- <a href="http://wordpress.org/extend/plugins/simple-social-icons/" target="_blank">Simple Social Icons</a>

<h3>PHOTO GALLERY</h3>
1. Add new <a href="/wp-admin/post-new.php?post_type=page">PAGE</a> and name it "Photos"
2. Select "Photos" from the template dropdown and publish
3. Add a new <a href="/wp-admin/edit-tags.php?taxonomy=category">Post Category</a> called, "Photos"
4. <a href="/wp-admin/admin.php?page=nggallery-add-gallery">Upload images</a> to NextGen Gallery
5. Add new <a href="/wp-admin/post-new.php">POST</a>
6. Using the NextGen Gallery shortcode, embed the shortcode into your post body
7. Publish the post in the "Photos" category

Now visit your photos PAGE and you'll see your photo gallery!

<h3>SUPPORT</h3>
Please visit <a href="http://radio.gregrickaby.com/support">http://radio.gregrickaby.com/support</a> for theme support.

<h3>CREDITS</h3>
I'd like personally thank the following people for their help and contributions to the code:
- <a href="http://garyjones.co.uk/">Gary Jones</a>
- <a href="http://wpsmith.net/">Travis Smith</a>
- <a href="http://about.me/jtsternberg">Justin Sternberg</a>
- <a href="http://billerickson.net/">Bill Erickson</a>

<h3>CHANGE LOG</h3>

<strong>v1.3.1</strong>
- Fixed theme update rename error
- Cleaned up automatic update code
- Moved PSD folder to /custom-sample/

<strong>v1.3</strong>
- Add support for Soliloquy Slider
- Add support for Mail Chimp naked forms
- Add Option to turn Social Media Icons on/off pages
- Renamed /custom/ to /custom-sample/
- Check to see if /custom/ exsists and is writeable
- Moved favicon.ico to /custom/
- Exclude category from Radio Latest News widget
- Styled bylines, gravatar, read-more text for Radio Latest News widget
- Set Radio Latest News widget default to show_content_limit
- Auto re-size of emded videos on Radio Latest News widget
- Remove "Featured Image" cabalities from Radio Latest News widget (too wonky)
- Radio Latest News widget now grabs the content verbatim and displays it (unless showing excerpt)
- Fixed RSS visited link

<strong> v1.2</strong>
- Add support for automatic updates
- Option to turn Nivo Slider on/off
- Add support for Facebook page and Facebook APP ID Option
- Add support for Facebook OpenGraph Metadata
- Better javascript managment
- Move TimThumb cache directory to /custom/
- Changed TimThumb cache clean-up to every 12-hours
- Remove B/W photo effect jQuery
- Complete redesign and recode of photos.php
- Styled Breadcrumbs

<strong>v1.1</strong>
- Misc. code clean ups
- Updated TimThumb to v2.8.10

<strong>v1.0</strong>
- Initial release

<h3>PLANNED</h3>
- DJ bio pages with social media streams
- Widget navigation drop-downs
- Add support for Woo Flex Slider and WP-Cycle