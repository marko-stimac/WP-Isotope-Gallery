# Isotope gallery

Isotope gallery is a WordPress plugin for showing images in masonry, filtering them by tags and a bigger image is shown as Lightbox gallery when user clicks on thumbnail.

Requirements: ACF PRO plugin

### How to use: 

- Import ACF file which you can find inside acf folder
- Open a page and for each repeater field add image and its tag
- use the code `[isotope-gallery]` in position where you want the gallery to show up. If you need to place the same Isotope on multiple pages just pass the ID of page origin `[isotope-gallery id="10"]`


#### Optionally
- under ACF open field group for Isotope gallery and set different location if you want groups to show somewhere else other than on regular pages
- plugins registers two additional image sizes, if you have big website with lots of images it would be good idea to disable that and use image sizes which your theme supports